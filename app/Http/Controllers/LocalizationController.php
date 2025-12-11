<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalizationController extends Controller
{
    //
    public function localization($loc){
        if(in_array($loc, ['en', 'id'])){
            session(['locale' => $loc]);
            // app()->setLocale($loc);
        }
        return redirect()->back();
    }
}
