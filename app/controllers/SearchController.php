<?php

class SearchController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function book($id)
    {
        if(isset($id)){

            $book = Book::find($id);

            if(isset($book))
                return View::make('course.book')->with('book', $book);
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function course($id)
    {
        if(isset($id)){

            $course = Course::find($id);

            if(isset($book))
                return View::make('course.course')->with('course', $course);
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function institute($id)
    {
        if(isset($id)){

            $institute = Institute::find($id);

            if(isset($institute))
                return View::make('course.institute')->with('institute', $institute);
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

            $book = Book::find($id);

            if(isset($book)){

                $book->status = 'removed';
                $book->save();

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

        $id = Session::get('book_id');

        if(isset($id)){
            $book = Book::find($id);

            if(isset($book)){

                $book->name = Input::get('name');
                $book->publish_date = date('Y-m-d', strtotime(Input::get('publish_date')));
                $book->subject = Input::get('subject');
                $book->author = Input::get('author');
                $book->price = Input::get('price');
                $book->discounted_price = Input::get('discounted_price');
                $book->book_type = Input::get('book_type');

                $book->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getBook($id)
    {
        if(isset($id)){

            $book = Book::find($id);

            if(isset($book)){

                return json_encode(array('message'=>'found', 'book' => $book));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getBooks($id)
    {
        if(isset($id)){

            $books = Book::where('course_id','=', $id)->get();

            if(isset($books)){

                return json_encode(array('message'=>'found', 'books' => $books->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSearchBooks($key)
    {
        if(isset($key)){

            $books = Book::where('name','like', '%'. $key . '%')->get();

            if(isset($books)){

                return json_encode(array('message'=>'found', 'books' => $books->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}