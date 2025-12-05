<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class TransactionController extends Controller
{
 public function createTransaction(Request $request)
    {
        $user = Auth::user();
        $book = Book::findOrFail($request->book_id);
        $amount = max(10000, (int) $book->price);

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'price' => $amount,
            'status' => 'PENDING',
            'invoice_id' => 'INV-' . uniqid(),
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->invoice_id,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08123456789',
            ],
            'item_details' => [
                [
                    'id' => $book->id,
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => $book->title,
                ]
            ],
            'enabled_payments' => ['bank_transfer'],
            'bank_transfer' => [
                'bank' => 'bca', 
            ],
            'callbacks' => [
                'finish' => route('transactions.success'),
            ],
        ];

        try {
            $snap = Snap::createTransaction($params);
            $transaction->update(['snap_token' => $snap->token]);
            return redirect($snap->redirect_url);
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Creation Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat transaksi Midtrans. Coba lagi nanti.');
        }
    }

    public function notification(Request $request)
    {
        Log::info('Midtrans Notification received.');
        
        // 1. Inisialisasi Midtrans Config
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        
        try {
            // 2. Dapatkan objek notifikasi dari library Midtrans
            $notif = new Notification();
        } catch (\Exception $e) {
            // Jika ada error saat inisialisasi notifikasi (misal masalah payload)
            Log::error('Midtrans Notification Initialization Error: ' . $e->getMessage());
            return response('Error', 500); // Harus cepat merespon
        }


        $orderId = $notif->order_id;
        $transactionStatus = $notif->transaction_status; 
        $fraudStatus = $notif->fraud_status;

        // 3. Cari Transaksi
        $transaction = Transaction::where('invoice_id', $orderId)->first();

        if (!$transaction) {
            Log::warning("Transaction not found for order ID: {$orderId}");
            // Midtrans tidak perlu mencoba lagi jika order ID tidak ditemukan
            return response('Transaction not found', 404); 
        }

        // 4. Logika Update Status
        try {
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $transaction->status = 'PAID';
                }
            } else if ($transactionStatus == 'settlement') {
                $transaction->status = 'PAID';
            } else if ($transactionStatus == 'pending') {
                $transaction->status = 'PENDING';
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $transaction->status = 'FAILED';
            }
            
            // Simpan perubahan ke database
            $transaction->save();
            Log::info("Transaction {$orderId} status updated to: {$transaction->status}");

        } catch (\Exception $e) {
            Log::error("Database Update Error for Order ID {$orderId}: " . $e->getMessage());
            // Jika ada error database, Midtrans akan mencoba lagi (retry)
            return response('Database Error', 500);
        }

        // 5. Respon WAJIB 200 OK
        return response('OK', 200);
    }


    public function success(Request $request)
    {
        return view('transactions.success');
    }
}