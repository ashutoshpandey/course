<?php

class SoftwareUserController extends BaseController
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

        return View::make('softwareUser.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $courseId = Session::get('course_id');
        if(!isset($courseId))
            return json_encode(array('message' => 'invalid'));

        $softwareUser = new SoftwareUser();

        $softwareUser->course_id = $courseId;
        $softwareUser->name = Input::get('name');
        $softwareUser->publish_date = date('Y-m-d', strtotime(Input::get('publish_date')));
        $softwareUser->subject = Input::get('subject');
        $softwareUser->author = Input::get('author');
        $softwareUser->price = Input::get('price');
        $softwareUser->discounted_price = Input::get('discounted_price');
        $softwareUser->softwareUser_type = Input::get('softwareUser_type');

        $softwareUser->status = 'active';
        $softwareUser->created_at = date('Y-m-d h:i:s');

        $softwareUser->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                Session::put('softwareUser_id', $id);

                return View::make('softwareUser.edit')->with('softwareUser', $softwareUser);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function remove($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if(isset($id)){

            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                $softwareUser->status = 'removed';
                $softwareUser->save();

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
            return json_encode(array('message' => 'not logged'));

        $id = Session::get('softwareUser_id');

        if(isset($id)){
            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                $softwareUser->name = Input::get('name');
                $softwareUser->publish_date = date('Y-m-d', strtotime(Input::get('publish_date')));
                $softwareUser->subject = Input::get('subject');
                $softwareUser->author = Input::get('author');
                $softwareUser->price = Input::get('price');
                $softwareUser->discounted_price = Input::get('discounted_price');
                $softwareUser->softwareUser_type = Input::get('softwareUser_type');

                $softwareUser->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSoftwareUser($id)
    {
        if(isset($id)){

            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                return json_encode(array('message'=>'found', 'softwareUser' => $softwareUser));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSoftwareUsers($id)
    {
        if(isset($id)){

            $softwareUsers = SoftwareUser::where('course_id','=', $id)->get();

            if(isset($softwareUsers)){

                return json_encode(array('message'=>'found', 'softwareUsers' => $softwareUsers->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSearchSoftwareUsers($key)
    {
        if(isset($key)){

            $softwareUsers = SoftwareUser::where('name','like', '%'. $key . '%')->get();

            if(isset($softwareUsers)){

                return json_encode(array('message'=>'found', 'softwareUsers' => $softwareUsers->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}