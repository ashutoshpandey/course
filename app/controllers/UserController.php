<?php

class UserController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    function dashboard(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        return View::make('users.user-section');
    }

    function editUser(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        $user = User::find($userId);

        if(isset($user))
            return View::make('users.edit')->with('user', $user);
        else
            return Redirect::to('/');
    }

    function updateUser(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

            $email = Input::get('email');

            $userByEmail = user::where('email', '=', $email)->first();

            if(isset($userByEmail) && $userByEmail->id != $user->id)
                echo 'duplicate';
            else{
                $user->id = $userId;
                $user->email = $email;
                $user->name = Input::get('name');
                $user->password = Input::get('password');
                $user->user_type = Input::get('user_type');

                $user->save();

                return json_encode(array('message'=>'done'));
            }
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePassword(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

            $user->password = Input::get('password');

            $user->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function updatePicture(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $user = user::find($userId);

        if(isset($user)){

            if (Input::hasFile('image')){

                $file = array('image' => Input::file('image'));

                $rules = array('image' => 'required|max:10000|mimes:png,jpg,jpeg,bmp,gif');
                $validator = Validator::make($file, $rules);
                if ($validator->fails()) {
                    echo 'wrong';
                }
                else {
                    $imageNameSaved = date('Ymdhis');

                    $imageName = Input::file('image')->getClientOriginalName();
                    $extension = Input::file('image')->getClientOriginalExtension();

                    $fileName = $imageNameSaved . '.' . $extension;
                    $destinationPath = "public/user-images/$userId/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if(!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('image')->move($destinationPath, $fileName);

                    $user->image_name = $imageName;
                    $user->image_name_saved = $fileName;

                    $user->save();

                    return json_encode(array('message'=>'done'));
                }
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function removeAccount(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        if(isset($userId)) {

            $user = user::find($userId);

            if(isset($user)){
                $user->status = 'removed';

                $user->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function userOrders(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return Redirect::to('/');

        return View::make('user.orders');
    }

    function getUserOrders($startDate=null, $endDate=null){

        $userId = Session::get('user_id');

        if(isset($userId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Order::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $orders = Order::where('user_id', '=', $userId)->get();

            if(isset($orders))
                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function cancelOrder($id){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $order = Order::find($id);

        if(isset($order)){
            $order->status = 'user-cancelled';
            $order->cancel_date = date('Y-m-d h:i:s');
            $order->save();

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function saveOrder(){

        $userId = Session::get('user_id');

        if(!isset($userId))
            return json_encode(array('message'=>'not logged'));

        $order = new Order();

        $order->status = 'active';
        $order->user_id = Session::get('user_id');
        $order->created_at = date('Y-m-d h:i:s');

        $order->save();

        $orderId = $order->id;

        $cart = Session::get('cart');

        if(isset($cart) && count($cart)>0){
            foreach($cart as $item){

                $orderItem = new OrderItem();

                $order->item_id = $item['id'];
                $order->quantity = $item['quantity'];
                $order->item_type = $item['item_type'];

                $order->status = 'active';
                $orderItem->order_id = $orderId;
                $orderItem->created_at = date('Y-m-d h:i:s');

                $orderItem->save();
            }

            return json_encode(array('message'=>'done'));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function userDocuments(){

        $userId = Session::get('user_id');

        if(isset($userId)){
            $documents = UserDocument::where('user_id','=',$userId)->
                where('status','=','active')->get();

            if(isset($documents) && count($documents)>0)
                return json_encode(array('message'=>'found', 'documents' => $documents->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'not logged'));
    }

    /************** json methods ***************/
    function dataGetUser($id){

        $user = User::find($id);

        if(isset($user))
            return json_encode(array('message'=>'found', 'user' => $user));
        else
            return json_encode(array('message'=>'empty'));
    }

    function dataUserAppointments($userId, $startDate=null, $endDate=null){

        if(isset($userId)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Appointment::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Appointment::where('user_id', '=', $userId)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $orders = Appointment::where('user_id', '=', $userId)->get();

            if(isset($orders) && count($orders)>0)
                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    function dataUserAppointmentsByType($userId, $orderType, $startDate=null, $endDate=null){

        if(isset($userId) && isset($orderType)){

            if(isset($startDate) && isset($endDate)){

                $startDate = date('Y-m-d', strtotime($startDate));
                $endDate = date('Y-m-d', strtotime($endDate));

                $orders = Appointment::where('user_id', '=', $userId)
                    ->where('order_type', '>=', $orderType)
                    ->where('start_date', '>=', $startDate)
                    ->where('end_date', '<=', $endDate)->get();
            }
            else if(isset($startDate)){

                $startDate = date('Y-m-d', strtotime($startDate));

                $orders = Appointment::where('user_id', '=', $userId)
                    ->where('order_type', '>=', $orderType)
                    ->where('start_date', '>=', $startDate)->get();
            }
            else
                $orders = Appointment::where('user_id', '=', $userId)
                    ->where('order_type', '>=', $orderType);

            if(isset($orders) && count($orders)>0)
                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataCancelledAppointments($userId){

        if(isset($userId)){
            $orders = Appointment::where('user_id','=',$userId)->
                where('status','=','cancelled')->get();

            if(isset($orders) && count($orders)>0)
                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function dataUserDocuments($userId){

        if(isset($userId)){
            $documents = UserDocument::where('user_id','=',$userId)->
                where('status','=','active')->get();

            if(isset($documents) && count($documents)>0)
                return json_encode(array('message'=>'found', 'documents' => $documents->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}