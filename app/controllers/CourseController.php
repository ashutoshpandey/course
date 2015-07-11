<?php

class CourseController extends BaseController
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

        return View::make('course.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $course = new Course();

        $course->status = 'active';
        $course->created_at = date('Y-m-d h:i:s');

        $course->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $course = Course::find($id);

            if(isset($course)){

                Session::put('course_id', $id);

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

            $course = Course::find($id);

            if(isset($course)){

                $course->remove();

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

        $id = Session::get('course_id');

        if(isset($id)){
            $course = Course::find($id);

            if(isset($course)){

                $course->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getCourse($id)
    {
        if(isset($id)){

            $course = Course::find($id);

            if(isset($course)){

                return json_encode(array('message'=>'found', 'course' => $course));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getCourses($id)
    {
        if(isset($id)){

            $courses = Course::where('institute_id','=', $id)->get();

            if(isset($courses)){

                return json_encode(array('message'=>'found', 'courses' => $courses->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSearchCourses($key)
    {
        if(isset($key)){

            $courses = Course::where('name','like', '%'. $key . '%')->get();

            if(isset($courses)){

                return json_encode(array('message'=>'found', 'courses' => $courses->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}