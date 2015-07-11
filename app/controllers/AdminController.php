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
        return View::make('admin.admin-section');
    }

    public function institutes(){
        return View::make('admin.institutes');
    }

    public function courses($id){
        return View::make('admin.courses')->with('id', $id);
    }

    public function books($id){
        return View::make('admin.books')->with('id', $id);
    }

    public function orders(){
        return View::make('admin.orders');
    }

    public function listInstitutes($status, $page){

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

    public function listCourses($id, $status, $page){

        if(isset($id)){

            $courses = Course::where('institute_id','=', $id)->where('status', '=', $status)->get();

            if(isset($courses) && count($courses)>0){

                return json_encode(array('message'=>'found', 'courses' => $courses->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listBooks($id, $status, $page){

        if(isset($id)){

            $books = Book::where('course_id','=', $id)->where('status','=',$status)->get();

            if(isset($books) && count($books)>0){

                return json_encode(array('message'=>'found', 'books' => $books->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}