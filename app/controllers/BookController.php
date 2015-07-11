<?php

class BookController extends BaseController
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

        return View::make('book.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $book = new Book();

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

                $book->remove();

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