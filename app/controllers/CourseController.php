<?php

class CourseController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function courses($id){

        if(isset($id)) {

            $institute = Institute::find($id);

            if(isset($institute)){
                $courses = Course::where('status','=','active')->where('institute_id','=',$id)->get();

                Session::put('course_id', $id);

                if(isset($courses) && count($courses)>0)
                    return View::make('course.list')->with('found', true)->with('courses', $courses)->with('institute', $institute);
                else
                    return View::make('course.list')->with('found', false);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
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

        $instituteId = Session::get('institute_id');
        if(!isset($instituteId))
            return json_encode(array('message' => 'invalid'));

        $course = new Course();

        $course->institute_id = $instituteId;
        $course->name = Input::get('name');
        $course->description = Input::get('description');

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

                $course->status = 'removed';
                $course->save();

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

                $course->name = Input::get('name');
                $course->description = Input::get('description');

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