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

    public function addToBag($id){

        $cart = Session::get('cart');

        if(isset($cart))
            ;
        else
            $cart = array();

        $uniqueId = date('Ymdhis');

        $cart[] = array('id' => $uniqueId, 'productId' => $id);

        Session::put('cart', $cart);

        echo json_encode(array('message' => 'done', 'cart' => $cart));
    }

    public function getBag(){

        $cart = Session::get('cart');

        if(isset($cart))
            echo json_encode(array('message' => 'done', 'cart' => $cart));
        else
            echo json_encode(array('message' => 'done'));
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