<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashierController extends Controller
{

    public function index()
    {

        $order = DB::table('pesanans')->latest()->first();

        if(!$order){
            return view('kasir');
        }

        $details = json_decode($order->detail,true);

        return view('kasir',compact('order','details'));
    }

}