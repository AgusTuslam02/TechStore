<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Cart;
use App\Transaction;
use App\TransactionDetail;

use Exception;


use Midtrans\Snap;
use Midtrans\Config;


class CheckoutController extends Controller
{
    public function process(Request $request){
        //save data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        //proses checkout
        $code = 'STORE-'. mt_rand(000000,999999);
        $carts = Cart::with(['product','user'])
                ->where('users_id', Auth::user()->id)
                ->get();
                
        //transaction create       
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code
        ]);

        // transaction details
        foreach ($carts as $cart){
            $trx = 'TRX-' . mt_rand(000000,999999);

            
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx
            ]);
        }
        //return dd($transaction);

        //delete cart data
        Cart::with('users_id' , Auth::user()->id)->delete();
        
        
        //konfigurasi midtrans
        Config::$serverKey = Config('services.midtrans.serverKey');
        Config::$clientKey = Config('services.midtrans.clientKey');
        Config::$isProduction = Config('services.midtrans.isProduction');
        Config::$isSanitized = Config('services.midtrans.isSanitized');
        Config::$is3ds =  Config('services.midtrans.is3ds');

        // $servertKey =  Config::$serverKey = config('services.midtrans.serverKey');
        // var_dump($servertKey); die;

       // $clientKey = Config::$clientKey = config('services.midtrans.clientKey');
        
        //var_dump($clientKey); die;

        // mengirin array ke midtrans
        $midtrans =[
            'transaction_details' => [
                'order_id' => $code ,
                'gross_amount' =>(int) $request->total_price,

            ],
            'customer_details' =>[
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
            'enabled_payments' =>[
                'gopay', 'indomaret','permata_va','bank_transfer'
            ],
            'vtweb' => []
        ];
        $midtrans = array(
            'transaction_details' => array(
            'order_id' => rand(),
            'gross_amount' => 10000,
            )
        );

        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
  
        // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    public function callback(Request $request){
        
    }
}
