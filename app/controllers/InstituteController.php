<?php

class InstituteController extends BaseController
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

        return View::make('institutes.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute = new Institute();

        $institute->name = Input::get('name');
        $institute->establish_date = date('Y-m-d', strtotime(Input::get('establish_date')));
        $institute->address = Input::get('address');
        $institute->land_mark = Input::get('land_mark');
        $institute->location_id = Input::get('city');
        $institute->zip = Input::get('zip');
        $institute->latitude = Input::get('latitude');
        $institute->longitude = Input::get('longitude');
        $institute->contact_number_1 = Input::get('contact_number_1');
        $institute->contact_number_2 = Input::get('contact_number_2');

        $institute->status = 'active';
        $institute->created_at = date('Y-m-d h:i:s');

        $institute->save();

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

                Session::put('institute_id', $id);

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

            $institute = Institute::find($id);

            if(isset($institute)){

                $institute->status = 'removed';
                $institute->save();

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

        $id = Session::get('institute_id');

        if(isset($id)){
            $institute = Institute::find($id);

            if(isset($institute)){

                $institute->name = Input::get('name');
                $institute->establish_date = date('Y-m-d', strtotime(Input::get('establish_date')));
                $institute->address = Input::get('address');
                $institute->city = Input::get('city');
                $institute->state = Input::get('state');
                $institute->country = Input::get('country');
                $institute->land_mark = Input::get('land_mark');
                $institute->zip = Input::get('zip');
                $institute->latitude = Input::get('latitude');
                $institute->longitude = Input::get('longitude');
                $institute->contact_number_1 = Input::get('contact_number_1');
                $institute->contact_number_2 = Input::get('contact_number_2');

                $institute->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getInstitute($id)
    {
        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                return json_encode(array('message'=>'found', 'institute' => $institute));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}