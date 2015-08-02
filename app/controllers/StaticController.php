<?php

class StaticController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));
    }

	public function home()
	{
		return View::make('static.home');
	}

    public function contactUs(){
        return View::make('static.contact-us');
    }

    public function aboutUs(){
        return View::make('static.about-us');
    }

    public function privacyPolicy(){
        return View::make('static.privacy-policy');
    }

    public function termsAndConditions(){
        return View::make('static.terms-and-conditions');
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

        $product = Book::find($productId);

        if(isset($product)) {

            $uniqueId = date('Ymdhis');

            $cart[] = array('id' => $uniqueId, 'productId' => $productId, 'quantity' => $quantity, 'name' => $product->name, 'price' => $product->price, 'discounted_price' => $product->discounted_price, 'type' => $product->book_type);

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

            $order = new Order();

            $total = 0;
            foreach($cart as $cartItem){
                $discounted_price = $cartItem['discounted_price'];
                $total += $discounted_price;
            }

            $discount_on_total = 0;
            $net_total = $total-$discount_on_total;

            $order->amount = $total;
            $order->discount = 0;
            $order->discount_details = '';
            $order->net_amount = $net_total;
            $order->user_id = -1;
            $order->email = '';

            $order->billing_name = '';
            $order->billing_address = '';
            $order->billing_city = '';
            $order->billing_state = '';
            $order->billing_country = '';
            $order->billing_zip = '';
            $order->billing_land_mark = '';
            $order->billing_phone_number_1 = '';
            $order->billing_phone_number_2 = '';

            $order->shipping_name = '';
            $order->shipping_address = '';
            $order->shipping_city = '';
            $order->shipping_state = '';
            $order->shipping_country = '';
            $order->shipping_zip = '';
            $order->shipping_land_mark = '';
            $order->shipping_phone_number_1 = '';
            $order->shipping_phone_number_2 = '';

            $order->status = 'inactive';                // let us complete order items first
            $order->created_at = date('Y-m-d h:i:s');

            $order->save();

            foreach($cart as $cartItem){

                $orderItem = new OrderItem();

                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cartItem['product_id'];
                $orderItem->quantity = $cartItem['quantity'];
                $orderItem->price = $cartItem['price'];
                $orderItem->discounted_price = $cartItem['discounted_price'];

                $orderItem->created_at = date('Y-m-d h:i:s');
                $orderItem->status = 'active';

                $orderItem->save();
            }

            $order->status = 'pending';
            $order->save();
        }

    }
}