<?php

class BookController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function books($id){

        if(isset($id)) {

            $books = Book::where('status','=','active')->where('course_id','=',$id)->get();

            if(isset($books) && count($books)>0)
                return View::make('book.list')->with('found', true)->with('books', $books);
            else
                return View::make('book.list')->with('found', false);
        }
        else
            return Redirect::to('/');
    }

    public function add()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('book.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $courseId = Session::get('course_id');
        if(!isset($courseId))
            return json_encode(array('message' => 'invalid'));

        $book = new Book();

        $book->course_id = $courseId;
        $book->name = Input::get('name');
        $book->publish_date = date('Y-m-d', strtotime(Input::get('publish_date')));
        $book->subject = Input::get('subject');
        $book->author = Input::get('author');
        $book->price = Input::get('price');
        $book->discounted_price = Input::get('discounted_price');
        $book->book_type = Input::get('book_type');

        $book->status = 'active';
        $book->created_at = date('Y-m-d h:i:s');

        $book->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $book = Book::find($id);

            if(isset($book)){

                Session::put('book_id', $id);

                return View::make('book.edit')->with('book', $book);
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