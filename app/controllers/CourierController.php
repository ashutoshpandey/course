<?php

class CourierController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function add()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('couriers.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $courier = new Courier();

        $courier->name = Input::get('name');
        $courier->contact_person = Input::get('contact_person');
        $courier->address = Input::get('address');
        $courier->city = Input::get('city');
        $courier->state = Input::get('state');
        $courier->country = Input::get('country');
        $courier->land_mark = Input::get('land_mark');
        $courier->zip = Input::get('zip');
        $courier->contact_number_1 = Input::get('contact_number_1');
        $courier->contact_number_2 = Input::get('contact_number_2');
        $courier->email = Input::get('email');

        $courier->status = 'active';
        $courier->created_at = date('Y-m-d h:i:s');

        $courier->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $course = Course::find($id);

            if(isset($course)){

                Session::put('courier_id', $id);

                return View::make('course.edit')->with('course', $course);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function remove($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)){

            $courier = Courier::find($id);

            if(isset($courier)){

                $courier->status = 'removed';
                $courier->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function update()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('courier_id');

        if(isset($id)){
            $courier = Courier::find($id);

            if(isset($courier)){

                $courier->name = Input::get('name');
                $courier->contact_person = Input::get('contact_person');
                $courier->address = Input::get('address');
                $courier->city = Input::get('city');
                $courier->state = Input::get('state');
                $courier->country = Input::get('country');
                $courier->land_mark = Input::get('land_mark');
                $courier->zip = Input::get('zip');
                $courier->contact_number_1 = Input::get('contact_number_1');
                $courier->contact_number_2 = Input::get('contact_number_2');
                $courier->email = Input::get('email');

                $courier->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getCourier($id)
    {
        if(isset($id)){

            $courier = Courier::find($id);

            if(isset($courier)){

                return json_encode(array('message'=>'found', 'courier' => $courier));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listCouriers()
    {
        $key = Input::get('key');

        $couriers = Courier::where('city','like', '%' . $key . '%')->orWhere('city','like', '%' . $key . '%')->orWhere('country','like', '%' . $key . '%')->get();

        if(isset($couriers)){

            return json_encode(array('message'=>'found', 'couriers' => $couriers->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function getSearchCouriers($key)
    {
        if(isset($key)){

            $couriers = Courier::where('name','like', '%'. $key . '%')->get();

            if(isset($couriers)){

                return json_encode(array('message'=>'found', 'couriers' => $couriers->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}