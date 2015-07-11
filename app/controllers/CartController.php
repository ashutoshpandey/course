<?php

class CartController extends BaseController {

    public function addToCart(){

        $cart = Session::get('cart');
        if(!isset($cart))
            $cart = array();

        $cart[] = array(
            'id' => date('Ymdhis'),
            'item_id' => Input::get('item_id'),
            'item_type' => Input::get('item_type'),
            'quantity' => Input::get('quantity')
        );

        Session::put('cart', $cart);

        return json_encode(array('cart' => $cart->toArray(), 'message' => 'found'));
    }

    public function removeFromCart($id){

        $newCart = array();

        $cart = Session::get('cart');
        if(!isset($cart))
            $cart = array();

        foreach($cart as $item){

            if($item['id']==$id)
                continue;

            $newCart[] = $item;
        }

        Session::put('cart', $newCart);

        return json_encode(array('cart' => $newCart->toArray(), 'message' => 'found'));
    }

    public function getCart(){

        $cart = Session::get('cart');

        if(isset($cart))
            return json_encode(array('cart' => $cart->toArray(), 'message' => 'found'));
        else
            return json_encode(array('message' => 'empty'));
   }
}