<?php

class AdminController extends BaseController
{
    function __construct(){

        //$name = Session::get('name');

        $name = 'Ashutosh Pandey';

        View::share('root', URL::to('/'));
        View::share('name', $name);
    }

    public function adminSection(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.admin-section');
    }

    public function institutes(){
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.institutes');
    }

    public function viewInstitute($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                Session::put('institute_id', $id);

                return View::make('admin.view-institute')->with('institute', $institute);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function courses($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                Session::put('institute_id', $id);

                return View::make('admin.courses')->with('institute', $institute);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function viewCourse($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute)){

                Session::put('institute_id', $id);

                return View::make('admin.view-course')->with('institute', $institute);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function books($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $course = Course::find($id);

            if(isset($course)){

                Session::put('course_id', $id);

                return View::make('admin.books')->with('course', $course);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function viewBook($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $book = Book::find($id);

            if(isset($book)){

                Session::put('book_id', $id);

                return View::make('admin.view-book')->with('book', $book);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function orders(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.orders');
    }

    public function listInstitutes($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($status)){

            $institutes = Institute::where('status','=', $status)->get();

            if(isset($institutes) && count($institutes)>0){

                return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listOrders($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($status)){

            $orders = Order::where('status','=', $status)->get();

            if(isset($orders) && count($orders)>0){

                return json_encode(array('message'=>'found', 'orders' => $orders->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listCourses($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $institute_id = Session::get('institute_id');

        if(isset($institute_id)){

            $courses = Course::where('institute_id','=', $institute_id)->where('status', '=', $status)->get();

            if(isset($courses) && count($courses)>0){

                return json_encode(array('message'=>'found', 'courses' => $courses->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listBooks($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $course_id = Session::get('course_id');

        if(isset($course_id)){

            $books = Book::where('course_id','=', $course_id)->where('status','=',$status)->get();

            if(isset($books) && count($books)>0){

                return json_encode(array('message'=>'found', 'books' => $books->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function couriers(){
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.couriers');
    }

    public function viewCourier($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $courier = Courier::find($id);

            if(isset($courier)){

                Session::put('courier_id', $id);

                return View::make('admin.view-courier')->with('courier', $courier);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function listCouriers($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $couriers = Courier::where('status','=',$status)->get();

        if(isset($couriers) && count($couriers)>0){

            return json_encode(array('message'=>'found', 'couriers' => $couriers->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function softwareUsers(){
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.software-users');
    }

    public function viewSoftwareUser($id){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){
            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)){

                return View::make('admin.view-software-user')->with('softwareUser', $softwareUser);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function listSoftwareUsers($status, $page){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $softwareUsers = SoftwareUser::where('status','=',$status)->get();

        if(isset($softwareUsers) && count($softwareUsers)>0){

            return json_encode(array('message'=>'found', 'software_users' => $softwareUsers->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }
}