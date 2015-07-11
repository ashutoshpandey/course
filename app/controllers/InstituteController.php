<?php

class InstituteController extends BaseController
{

    public function showWelcome()
    {
    }

    public function add()
    {
        return View::make('institutes.add');
    }

    public function save()
    {
        $institute = new Institute();

        $institute->status = 'active';
        $institute->created_at = date('Y-m-d h:i:s');

        $institute->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit()
    {
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

    public function remove($id){

        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                $institute->remove();

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
        $id = Session::get('institute_id');

        if(isset($id)){
            $institute = Institute::find($id);

            if(isset($institute)){

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

    public function listInstitutes()
    {
        $key = Input::get('key');

        $institutes = Institute::where('city','like', '%' . $key . '%')->orWhere('city','like', '%' . $key . '%')->orWhere('country','like', '%' . $key . '%')->get();

        if(isset($institutes)){

            return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function getSearchInstitutes($key)
    {
        if(isset($key)){

            $institutes = Institute::where('name','like', '%'. $key . '%')->get();

            if(isset($institutes)){

                return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}