<?php

class CartController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));
    }

    public function addToBag($productId, $quantity=1){

        $cart = Session::get('cart');

        if(isset($cart)){
            foreach($cart as $cartItem){
                if($productId===$cartItem['productId']) {
                    echo json_encode(array('message' => 'duplicate'));
                    return;
                }
            }
        }
        else
            $cart = array();

        $product = Product::find($productId);

        if(isset($product)) {

            $uniqueId = date('Ymdhis');

            $cart[] = array('id' => $uniqueId, 'productId' => $productId, 'quantity' => $quantity, 'name' => $product->name, 'price' => $product->price, 'discounted_price' => $product->discounted_price, 'type' => $product->product_type);

            Session::put('cart', $cart);

            echo json_encode(array('message' => 'done', 'cart' => $cart, 'count' => count($cart)));
        }
        else
            echo json_encode(array('message' => 'invalid'));
    }

    public function bag(){

        $cart = Session::get('cart');

        if(isset($cart) && count($cart)>0)
            return View::make('cart.list')->with('found', true)->with('cart', $cart);
        else
            return View::make('cart.list')->with('found', false);
    }

    public function getBag(){

        $cart = Session::get('cart');

        if(isset($cart) && count($cart)>0)
            echo json_encode(array('message' => 'found', 'cart' => $cart, 'count' => count($cart)));
        else
            echo json_encode(array('message' => 'empty'));
    }

    public function removeFromBag($id){

        $cart = Session::get('cart');

        if(isset($cart)){

            $newCart = array();

            foreach($cart as $cartItem){

                if($id==$cartItem['id'])
                    ;
                else
                    $newCart[] = $cartItem;
            }

            if(count($newCart)>0)
                Session::put('cart', $newCart);
            else
                Session::forget('cart');

            echo json_encode(array('message' => 'done', 'cart' => $newCart, 'count' => count($newCart)));
        }
        else
            echo json_encode(array('message' => 'invalid'));
    }

    public function saveOrder(){

        $cart = Session::get('cart');

        if(isset($cart)) {

            $orderId = Session::get('order_id');
            $exists = false;
            if(isset($orderId)) {
                $order = Order::find($orderId);

                if(isset($order))
                   $exists = true;
            }

            if(!$exists){

                $order = new Order();

                $total = 0;
                foreach ($cart as $cartItem) {
                    $discounted_price = $cartItem['discounted_price'];
                    $total += $discounted_price;
                }

                $discount_on_total = 0;
                $net_total = $total - $discount_on_total;

                $order->amount = $total;
                $order->discount = 0;
                $order->discount_details = '';
                $order->net_amount = $net_total;

                $order->status = 'inactive';                // let us complete order items first
                $order->created_at = date('Y-m-d h:i:s');

                $order->save();

                foreach ($cart as $cartItem) {

                    $orderItem = new OrderItem();

                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $cartItem['productId'];
                    $orderItem->quantity = $cartItem['quantity'];
                    $orderItem->price = $cartItem['price'];
                    $orderItem->discounted_price = $cartItem['discounted_price'];

                    $orderItem->created_at = date('Y-m-d h:i:s');
                    $orderItem->status = 'active';

                    $orderItem->save();
                }

                $order->status = 'pending';
                $order->save();

                Session::put('order_id', $order->id);

                echo json_encode(array('message' => 'done'));
            }
            else
                echo json_encode(array('message' => 'exists'));
        }
        else
            echo json_encode(array('message' => 'invalid'));
    }
}