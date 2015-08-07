<?php

class CheckoutController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));
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



                return View::make('checkout.payment')->with('order', $order)->with('product_json', json_encode($product_array));
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
}