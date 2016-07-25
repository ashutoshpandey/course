<?php

class CartController extends BaseController
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

    public function addToBag($bookId, $quantity = 1)
    {

        $user_id = Session::get('user_id');

        if (is_null($user_id))
            return json_encode(array('message' => 'not logged'));


        $cart = Session::get('cart');


        if (isset($cart)) {
            foreach ($cart as $key => $cartItem) {
                if (isset($cartItem['bookId'])) {
                    if ($bookId == $cartItem['bookId']) {
                        echo json_encode(array('message' => 'duplicate'));
                        return;
                    }
                } /*else {
                    echo json_encode(array('message' => 'invalid'));
                    return;
                }*/
            }

        } else {
            $cart = array();
        }

//        $book = Book::find($bookId);
        $book = Product::find($bookId);

        if (isset($book)) {

            $uniqueId = date('Ymdhis');

            $cart[] = array('id' => $uniqueId, 'bookId' => $bookId, 'quantity' => $quantity, 'name' => $book->name, 'price' => $book->price, 'discounted_price' => $book->discounted_price);


            Session::put('cart', $cart);


            echo json_encode(array('message' => 'done', 'cart' => $cart, 'count' => count($cart)));
        } else
            echo json_encode(array('message' => 'invalid'));

    }

    public function bag()
    {


        $cart = Session::get('cart');

        if (isset($cart) && count($cart) > 0)
            return View::make('cart.list')->with('found', true)->with('cart', $cart);
        else
            return View::make('cart.list')->with('found', false);
    }

    public function getBag()
    {

        $cart = Session::get('cart');

        if (isset($cart) && count($cart) > 0)
            echo json_encode(array('message' => 'found', 'cart' => $cart, 'count' => count($cart)));
        else
            echo json_encode(array('message' => 'empty'));
    }

    public function removeFromBag($id)
    {

        $cart = Session::get('cart');

        if (isset($cart)) {

            $newCart = array();

            foreach ($cart as $cartItem) {

                if ($id == $cartItem['id'])
                    ;
                else
                    $newCart[] = $cartItem;
            }

            if (count($newCart) > 0)
                Session::put('cart', $newCart);
            else
                Session::forget('cart');

            echo json_encode(array('message' => 'done', 'cart' => $newCart, 'count' => count($newCart)));
        } else
            echo json_encode(array('message' => 'invalid'));
    }

    public function saveOrder()
    {

        $user_id = Session::get('user_id');
        $cart = Session::get('cart');

        if (isset($cart)) {

            $orderId = Session::get('order_id');

            $exists = false;
            if (isset($orderId)) {
                $order = Order::find($orderId);

                if (isset($order))
                    $exists = true;
            }

            if (!$exists) {

                $order = new Order();

                $total = 0;
                foreach ($cart as $cartItem) {
                    $discounted_price = $cartItem['discounted_price'] * $cartItem['quantity'];
                    $total += $discounted_price;
                }

                $discount_on_total = 0;
                $net_total = $total - $discount_on_total;

                $order->amount = $total;
                $order->user_id = $user_id;   //2/7/16   userid added first it was not there
                $order->discount = 0;
                $order->discount_details = '';
                $order->net_amount = $net_total;

                $order->status = 'inactive';                // let us complete order items first
                $order->created_at = date('Y-m-d h:i:s');

                $order->save();

                foreach ($cart as $cartItem) {

                    $orderItem = new OrderItem();


                    $orderItem->order_id = $order->id;

                    if (isset($cartItem['bookId'])) {
                        $orderItem->product_id = $cartItem['bookId'];

                    }

                    if (isset($cartItem['accessoryId'])) {
                        $orderItem->product_id = $cartItem['accessoryId'];
                    }

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
            } else
                echo json_encode(array('message' => 'exists'));
        } else
            echo json_encode(array('message' => 'invalid'));
    }


//    02/07/16
    public function addAllToBag($bookId, $quantity = 1)
    {
        $arIds = explode(',', $bookId);

        $user_id = Session::get('user_id');

        if (is_null($user_id))
            return json_encode(array('message' => 'not logged'));

        $cart = Session::get('cart');

        if (isset($cart)) {
            foreach ($cart as $cartItem) {
                if (isset($cartItem['bookId'])) {
                    foreach ($arIds as $bookId) {
                        if ($bookId == $cartItem['bookId']) {
                            echo json_encode(array('message' => 'duplicate'));
                            return;
                        }
                    }
                } else {
                    echo json_encode(array('message' => 'invalid'));
                    return;
                }
            }
        } else {
            $cart = array();
        }

        $allBooks = array();

        foreach ($arIds as $bookId) {
            $allBooks[] = Book::find($bookId);
        }

        if (isset($allBooks)) {

            foreach ($allBooks as $bookValues) {

                $uniqueId = date('Ymdhis');
                $cart[] = array('id' => $uniqueId, 'bookId' => $bookValues->id, 'quantity' => $quantity, 'name' => $bookValues->name, 'price' => $bookValues->price, 'discounted_price' => $bookValues->discounted_price);
            }

            Session::put('cart', $cart);

            echo json_encode(array('message' => 'done', 'cart' => $cart, 'count' => count($cart)));
        } else
            echo json_encode(array('message' => 'invalid'));

    }

    public function updateQuantity()
    {
        $qty = Input::get('qty');
        $id = Input::get('id');
        $cart = Session::get('cart');


        if (isset($qty) && isset($id) && isset($cart)) {
            foreach ($cart as $key => $cartItem) {

                    if (isset($cartItem['bookId'])) {
                        if ($id == $cartItem['bookId']) {
                            $cart[$key]['quantity'] = $qty;
                            Session::put('cart', $cart);
                            echo json_encode(array('message' => 'done'));
                            return;
                        }
                    }elseif (isset($cartItem['accessoryId'])) {
                        if ($id == $cartItem['accessoryId']) {
                            $cart[$key]['quantity'] = $qty;
                            Session::put('cart', $cart);
                            echo json_encode(array('message' => 'done'));
                            return;
                        }
                    }else{
                        echo json_encode(array('message' => 'invalid'));
                        return;
                    }
            }

        } else {
            echo json_encode(array('message' => 'invalid'));
            return;
        }

    }

//    19/07/16

    public function addAccessoryToBag($id, $quantity = 1)
    {

        $user_id = Session::get('user_id');

        if (is_null($user_id))
            return json_encode(array('message' => 'not logged'));


        $cart = Session::get('cart');

        if (isset($cart)) {
            foreach ($cart as $key => $cartItem) {
                if (isset($cartItem['accessoryId'])) {
                    if ($id == $cartItem['accessoryId']) {
                        echo json_encode(array('message' => 'duplicate'));
                        return;
                    }
                }/* else {
                    echo json_encode(array('message' => 'invalid'));
                    return;
                }*/
            }

        } else {
            $cart = array();
        }

//        $accessory = Accessory::find($id);
        $accessory = Product::find($id);

        if (isset($accessory)) {

            $uniqueId = date('Ymdhis');

            $cart[] = array('id' => $uniqueId, 'accessoryId' => $id, 'quantity' => $quantity, 'name' => $accessory->name, 'price' => $accessory->price, 'discounted_price' => $accessory->discounted_price);


            Session::put('cart', $cart);


            echo json_encode(array('message' => 'done', 'cart' => $cart, 'count' => count($cart)));
        } else
            echo json_encode(array('message' => 'invalid'));

    }
}