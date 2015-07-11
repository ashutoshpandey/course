<?php

class OrderController extends BaseController {

    function __construct(){
        View::share('root', URL::to('/'));
        View::share('name', Session::get('name'));
    }

    function userOrders(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        return View::make('user.orders');
    }

    function getUserOrders($startDate=null, $endDate=null){

        $userId = Session::get('user_id');

        if(isset($userId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $orders = Order::where('user_id', '=', $userId)->get();

            if(isset($orders))
                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function cancelOrder($id){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $order = Order::find($id);

        if(isset($order)){
            $order->status = 'user-cancelled';
            $order->cancel_date = date('Y-m-d h:i:s');
            $order->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function saveOrder(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $order = new Order();

        $order->status = 'active';
        $order->user_id = Session::get('user_id');
        $order->created_at = date('Y-m-d h:i:s');

        $order->save();

        $orderId = $order->id;

        $cart = Session::get('cart');

        if(isset($cart) && count($cart)>0){

            foreach($cart as $item){

                $orderItem = new OrderItem();

                $order->item_id = $item['item_id'];
                $order->item_type = $item['item_type'];
                $order->quantity = $item['quantity'];

                $order->status = 'active';
                $orderItem->order_id = $orderId;
                $orderItem->created_at = date('Y-m-d h:i:s');

                $orderItem->save();
            }

            Session::forget('cart');

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'empty'));
    }
}