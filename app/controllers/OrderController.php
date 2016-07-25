<?php

class OrderController extends BaseController
{
    function __construct()
    {

        View::share('root', URL::to('/'));
        $user_id = Session::get('user_id');
        if (isset($user_id)) {
            $name = Session::get('name');

            View::share('name', $name);
            View::share('logged', true);
        } else
            View::share('logged', false);
    }

    function userOrders()
    {

        $userId = Session::get('user_id');

        if (!isset($userId))
            return Redirect::to('/');

        return View::make('user.orders');
    }

    function getUserOrders($startDate = null, $endDate = null)
    {

        $userId = Session::get('user_id');

        if (isset($userId)) {

            if (isset($startDate) && isset($endDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            } else if (isset($startDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            } else
                $orders = Order::where('user_id', '=', $userId)->get();

            if (isset($orders))
                return json_encode(array('message' => 'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function getUserOrdersById($userId, $startDate = null, $endDate = null)
    {

        if (isset($userId)) {

            if (isset($startDate) && isset($endDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            } else if (isset($startDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            } else
                $orders = Order::where('user_id', '=', $userId)->get();

            if (isset($orders))
                return json_encode(array('message' => 'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function getOrders($status, $startDate = null, $endDate = null)
    {

        $userId = Session::get('user_id');

        if (isset($userId)) {

            if (isset($startDate) && isset($endDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Order::where('status', '=', $status)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            } else if (isset($startDate)) {

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Order::where('status', '=', $status)
                    ->where('start_date', '>=', $startDate)->get();
            } else
                $orders = Order::where('status', '=', $status)->get();

            if (isset($orders))
                return json_encode(array('message' => 'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function getOrder($id)
    {

        if (!isset($id))
            return json_encode(array('message' => 'invalid'));

        $order = Order::find($id);

        if (isset($order))
            return json_encode(array('message' => 'found', 'order' => $order));
        else
            return json_encode(array('message' => 'invalid'));
    }

    function getOrderItems($orderId)
    {

        if (!isset($orderId))
            return json_encode(array('message' => 'invalid'));

        $orderItems = OrderItem::where('order_id', '=', $orderId)->get();

        if (isset($orderItems))
            return json_encode(array('message' => 'found', 'order' => $orderItems->toArray()));
        else
            return json_encode(array('message' => 'invalid'));
    }

    function cancelOrder($id)
    {

        $userId = Session::get('user_id');

        if (!isset($userId))
            return json_encode(array('message' => 'not logged'));

        $order = Order::find($id);

        if (isset($order)) {
            $order->status = 'user-cancelled';
            $order->cancel_date = date('Y-m-d h:i:s');
            $order->save();

            return json_encode(array('message' => 'done'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    function saveOrder()
    {

        $userId = Session::get('user_id');

        if (!isset($userId))
            return json_encode(array('message' => 'not logged'));

        $order = new Order();

        $order->status = 'active';
        $order->user_id = Session::get('user_id');
        $order->created_at = date('Y-m-d h:i:s');

        $order->save();

        $orderId = $order->id;

        $cart = Session::get('cart');

        if (isset($cart) && count($cart) > 0) {

            foreach ($cart as $item) {

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

            return json_encode(array('message' => 'done'));
        } else
            return json_encode(array('message' => 'empty'));
    }


    //11/07/16

    public
    function orders()
    {
        $user_id = Session::get('user_id');

        if (is_null($user_id))
            return Redirect::to('/');

        $orders = Order::where('user_id', $user_id)->get();
        $orderItems = array();
        if (isset($orders) && count($orders) > 0) {
            foreach ($orders as $order) {
                $orderItems[] = OrderItem::where('order_id', $order->id)->get();

            }
        }

        if (isset($orderItems) && count($orderItems) > 0)
            return View::make('order.list')->with('found', true)->with('orders', $orders)->with('orderItems', $orderItems);
        else
            return View::make('order.list')->with('found', false);
    }

    public function viewOrder($id)
    {
        if(empty($id)){
            return Redirect::to('/');
        }

        $orderItem = OrderItem::find($id);



        if (isset($orderItem)) {
            $order = Order::where('id', $orderItem->order_id)->get();

            if (isset($orderItem) && count($orderItem) > 0)
                return View::make('order.viewOrder')->with('found', true)->with('order', $order)->with('orderItem', $orderItem);
            else
                return View::make('order.viewOrder')->with('found', false);

        }else{
            return Redirect::to('/');
        }

    }
}