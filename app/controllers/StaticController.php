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

    public function addToBag($productId){

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

            $cart[] = array('id' => $uniqueId, 'productId' => $productId, 'name' => $product->name, 'price' => $product->price, 'price' => $product->discounted_price, 'type' => $product->book_type);

            Session::put('cart', $cart);

            echo json_encode(array('message' => 'done', 'cart' => $cart));
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

                if($id===$cartItem['id'])
                    ;
                else
                    $newCart[] = $cartItem;
            }

            Session::put('cart', $newCart);

            echo json_encode(array('message' => 'done', 'cart' => $newCart));
        }
        else
            echo json_encode(array('message' => 'invalid'));
    }
}