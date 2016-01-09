<?php

class CheckoutController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));

        $user_id = Session::get('user_id');
        if(isset($user_id)){
            $name = Session::get('name');

            View::share('name', $name);
            View::share('logged', true);
        }
        else
            View::share('logged', false);
    }

    public function login(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)){

                $userId = Session::get('user_id');

                if(isset($userId))
                    return Redirect::to('/checkout-address');
                else
                    return View::make('checkout.login')->with('order', $order);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function guest(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)) {

                $email = Input::get('email');

                $order->user_id = null;
                $order->email = $email;

                $order->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'session'));
        }
        else
            return json_encode(array('message'=>'session'));
    }

    public function address(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)) {

                $userId = Session::get('user_id');

                if(isset($user))
                    $user = User::find($userId)->with('UserAddress');

                if(isset($user))
                    return View::make('checkout.address')->with('order', $order)->with('user', $user);
                else
                    return View::make('checkout.address')->with('order', $order);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function updateAddress(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)) {

                $billingSame = Input::get('chk-billing-same');

                $order->shipping_name = Input::get('shipping-name');
                $order->shipping_address = Input::get('shipping-address');
                $order->shipping_city = Input::get('shipping-city');
                $order->shipping_state = Input::get('shipping-state');
                $order->shipping_country = 'India';
                $order->shipping_zip = Input::get('shipping-zip');
                $order->shipping_land_mark = Input::get('shipping-land-mark');
                $order->shipping_contact_number_1 = Input::get('shipping-contact-number-1');
                $order->shipping_contact_number_2 = Input::get('shipping-contact-number-2');

                if(isset($billingSame) && $billingSame=="yes"){
                    $order->billing_name = Input::get('shipping-name');
                    $order->billing_address = Input::get('shipping-address');
                    $order->billing_city = Input::get('shipping-city');
                    $order->billing_state = Input::get('shipping-state');
                    $order->billing_country = 'India';
                    $order->billing_zip = Input::get('shipping-zip');
                    $order->billing_land_mark = Input::get('shipping-land-mark');
                    $order->billing_contact_number_1 = Input::get('shipping-contact-number-1');
                    $order->billing_contact_number_2 = Input::get('shipping-contact-number-2');
                }
                else {
                    $order->billing_name = Input::get('billing-name');
                    $order->billing_address = Input::get('billing-address');
                    $order->billing_city = Input::get('billing-city');
                    $order->billing_state = Input::get('billing-state');
                    $order->billing_country = 'India';
                    $order->billing_zip = Input::get('billing-zip');
                    $order->billing_land_mark = Input::get('billing-land-mark');
                    $order->billing_contact_number_1 = Input::get('billing-contact-number-1');
                    $order->billing_contact_number_2 = Input::get('billing-contact-number-2');
                }

                $order->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'session'));
        }
        else
            return json_encode(array('message'=>'session'));
    }

    public function payment(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::with('orderItems')->find($orderId);

            if(isset($order)) {

                $product_array = array();

                foreach($order->orderItems as $orderItem){

                    $product = Product::find($orderItem->product_id);

                    if(isset($product)) {
                        $product_array[] = array(
                            "name" => $product->name,
                            "value" => $product->discounted_price,
                            "description" => ""
                        );
                    }
                }

                $transactionId = microtime(true);

                Session::put('transactionId', $transactionId);

                $order->transaction_id = $transactionId;
                $order->save();

                return View::make('checkout.payment')->with('order', $order)
                                                     ->with('product_json', json_encode($product_array))
                                                     ->with('transactionId', $transactionId);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function isValidUser()
    {
        $orderId = Session::get('order_id');

        if(isset($orderId)) {

            $order = Order::find($orderId);

            if(isset($order)) {
                $email = Input::get('email');
                $password = Input::get('password');

                $user = User::where('email', '=', $email)
                    ->where('password', '=', $password)->first();

                if (is_null($user))
                    return json_encode(array('message' => 'wrong'));
                else {
                    Session::put('user_id', $user->id);
                    Session::put('name', $user->name);

                    $order->user_id = $user->id;
                    $order->email = $email;

                    $order->save();

                    return json_encode(array('message' => 'correct'));
                }
            }
            else
                return json_encode(array('message' => 'invalid'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function transactionSuccess(){

        $transactionId = Session::get('transactionId');

        if($transactionId){

            $status = Input::get('status');

            if($status=='success'){
                $payment_mode = Input::get('mode');
                $gateway_payment_id = Input::get('mihpayid');
                $net_amount_debit = Input::get('net_amount_debit');

                $order = Order::where('transaction_id', $transactionId)->first();

                if(isset($order)){
                    $order->payment_mode = $payment_mode;
                    $order->gateway_payment_id = $gateway_payment_id;
                    $order->net_amount_debit = $net_amount_debit;

                    $order->save();

                    return View::make('checkout.transaction-success')->with('order', $order);
                }
                else
                    return Redirect::to('/transaction-failure');
            }
            else
                return Redirect::to('/transaction-failure');
        }
        else
            return Redirect::to('/');
    }

    public function transactionFailure(){

        $transactionId = Session::get('transactionId');

        if($transactionId){
            return View::make('checkout.transaction-failure');
        }
        else
            return Redirect::to('/');
    }
}