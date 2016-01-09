<?php

class StaticController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));

        $user_id = Session::get('user_id');
        if(isset($user_id)){
            $name = Session::get('name');

            View::share('name', $name);
            View::share('logged', true);
        }
        else
            View::share('logged', false);
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
}