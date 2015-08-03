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

            if(isset($order))
                return View::make('checkout.login')->with('order', $order);
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function address(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)) {

                $order->user_id = -1;
                $order->email = '';

                $order->save();

                return View::make('checkout.address')->with('order', $order);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function payment(){

        $orderId = Session::get('order_id');

        if(isset($orderId)){

            $order = Order::find($orderId);

            if(isset($order)) {

                $order->billing_name = Input::get('billing_name');
                $order->billing_address = Input::get('billing_address');
                $order->billing_city = Input::get('billing_city');
                $order->billing_state = Input::get('billing_state');
                $order->billing_country = Input::get('billing_country');
                $order->billing_zip = Input::get('billing_zip');
                $order->billing_land_mark = Input::get('billing_land_mark');
                $order->billing_phone_number_1 = Input::get('billing_phone_number_1');
                $order->billing_phone_number_2 = Input::get('billing_phone_number_2');

                $order->shipping_name = Input::get('shipping_name');
                $order->shipping_address = Input::get('shipping_address');
                $order->shipping_city = Input::get('shipping_city');
                $order->shipping_state = Input::get('shipping_state');
                $order->shipping_country = Input::get('shipping_country');
                $order->shipping_zip = Input::get('shipping_zip');
                $order->shipping_land_mark = Input::get('shipping_land_mark');
                $order->shipping_phone_number_1 = Input::get('shipping_phone_number_1');
                $order->shipping_phone_number_2 = Input::get('shipping_phone_number_2');

                $order->save();

                return View::make('order.payment')->with('order', $order);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }
}