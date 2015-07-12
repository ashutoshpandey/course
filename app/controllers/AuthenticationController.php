<?php

class AuthenticationController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function adminLogin(){
        return View::make('admin.login');
    }

    public function isValidUser()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        $user = User::where('email', '=', $email)
            ->where('password','=',$password)->first();

        if(is_null($user))
            return json_encode(array('message'=>'wrong'));
        else{
            Session::put('user_id', $user->id);
            Session::put('user_type', $user->user_type);
            Session::put('name', $user->name);

            return json_encode(array('message'=>'correct'));
        }
    }
    
    public function isValidAdmin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $admin = Admin::where('username', '=', $username)
            ->where('password','=',$password)->first();

        if(is_null($admin))
            return json_encode(array('message'=>'wrong'));
        else
        {
            Session::put('admin_id', $admin->id);
            Session::put('name', $admin->name);

            return json_encode(array('message'=>'correct'));
        }
    }

    public function isValidSoftwareUser()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $user = SoftwareUser::where('username', '=', $username)
            ->where('password','=',$password)->first();

        if(is_null($user))
            return json_encode(array('message'=>'wrong'));
        else
        {
            Session::put('softwareUserId', $user->id);
            Session::put('name', $user->name);

            return json_encode(array('message'=>'correct'));
        }
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return Redirect::to('/');
    }

    public function saveUser()
    {
        $email = Input::get('email');

        if($this->isDuplicateUser($email)==="no"){

            $user = new User;

            $user->email = Input::get('email');
            $user->password = Input::get('password');
            $user->first_name = Input::get('first_name');
            $user->last_name = Input::get('last_name');
            $user->country = Input::get('country');
            $user->status = 'active';
            $user->created_at = date('Y-m-d h:i:s');
            $user->updated_at = date('Y-m-d h:i:s');

            $user->save();

            Session::put('name', $user->first_name);
            Session::put('user_id', $user->id);

            return 'done';
        }
        else
            return 'duplicate';
    }

    public function isDuplicateUser($email)
    {
        $user = User::where('email', '=', $email)->first();

        return is_null($user) ? "no" : "yes";
    }

    public function sendUserPassword(){

        $email = Input::get('email');

        $user = User::where('User.email','=',$email)->first();

        $data = array('name'=>$user->name);

        Mail::send('emails.reset-password', $data, function($message)use ($user){

            $message->to($user->email, $user->name)->subject('You requested your password');
        });
    }
}