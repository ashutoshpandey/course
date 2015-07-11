<?php

class HomeController extends BaseController
{
    function __construct(){
        View::share('root', URL::to('/'));
    }

	public function showWelcome()
	{
		return View::make('hello');
	}

}