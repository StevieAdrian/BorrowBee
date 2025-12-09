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

        $pendingStatus = Transaction::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'PENDING')
            ->first();

        if ($pendingStatus) {
            if (!empty($pendingStatus->snap_token)) {
                return redirect("https://app.sandbox.midtrans.com/snap/v4/vtweb/" . $pendingStatus->snap_token);
            }
            $pendingStatus->delete();
        }

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
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response('Error', 500); 
        }

        $orderId = $notif->order_id;
        $transactionStatus = $notif->transaction_status; 
        $fraudStatus = $notif->fraud_status;

        $transaction = Transaction::where('invoice_id', $orderId)->first();

        if (!$transaction) {
            return response('Transaction not found', 404); 
        }

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
            
            $transaction->save();

        } catch (\Exception $e) {
            return response('Database Error', 500);
        }
        return response('OK', 200);
    }


    public function success(Request $request)
    {
        return view('transactions.success');
    }
}