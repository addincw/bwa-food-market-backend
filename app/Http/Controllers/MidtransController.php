<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    private $_transactionPayload = [];

    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function setTransactionPayload($transaction, $user)
    {
        $this->_transactionPayload =  [
            'transaction_details' => [
                'order_id' =>  $transaction->id,
                'gross_amount' => (int) $transaction->total,
            ],
            'customer_details' => [
                'first_name'    => $user->name,
                'email'         => $user->email
            ],
            'enabled_payments' => ['gopay','bank_transfer'],
            'vtweb' => []
        ];
    }
    public function createSnapTransaction()
    {
        if($this->_transactionPayload) {
            return Snap::createTransaction($this->_transactionPayload)
                ->redirect_url;
        }

        throw new Exception("you have'nt set transaction payload.");
        
    }
}
