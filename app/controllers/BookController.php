<?php

class BookController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));

        $admin_id = Session::get('admin_id');
        if (isset($admin_id)) {
            $name = Session::get('name');

            View::share('name', $name);

            return;
        }

        $user_id = Session::get('user_id');
        if (isset($user_id)) {
            $name = Session::get('name');

            View::share('name', $name);
            View::share('logged', true);
        } else
            View::share('logged', false);
    }

    public function books($id)
    {

        if (isset($id)) {

            $course = Course::find($id);

            if (isset($course)) {
//                $books = Book::where('status', 'active')->where('course_id', $id)->get();
                $books = Product::where('status', 'active')->where('category','book')->where('course_id', $id)->get();

                Session::put('course_id', $id);
                $cart = Session::get('cart');

                if (isset($books) && count($books) > 0)
                    return View::make('book.list')->with('found', true)->with('books', $books)->with('course', $course)->with('cart', $cart);
                else
                    return View::make('book.list')->with('found', false)->with('course', $course);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function add()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('book.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $courseId = Session::get('course_id');
        if (!isset($courseId))
            return json_encode(array('message' => 'invalid'));

        $picture_1 = Input::file('picture_1');
        $picture_2 = Input::file('picture_2');

        if (isset($picture_1)) {

            $imageName = Input::file('picture_1')->getClientOriginalName();

            $destinationPath = "public/uploads/book-images/" . $courseId . "/";

            $directoryPath = base_path() . '/' . $destinationPath;

            if (!file_exists($directoryPath))
                mkdir($directoryPath);

            Input::file('picture_1')->move($destinationPath, $imageName);

            $picture_1 = $imageName;

        } else {
            $picture_1 = "";
        }


        if (isset($picture_2)) {

            $imageName = Input::file('picture_2')->getClientOriginalName();

            $destinationPath = "public/uploads/book-images/" . $courseId . "/";

            $directoryPath = base_path() . '/' . $destinationPath;

            if (!file_exists($directoryPath))
                mkdir($directoryPath);

            Input::file('picture_2')->move($destinationPath, $imageName);

            $picture_2 = $imageName;

        } else {
            $picture_2 = "";
        }


        /*        $book = new Book();

                $book->course_id = $courseId;
                $book->name = Input::get('name');
                $book->publication = Input::get('publication');
                $book->subject = Input::get('subject');
                $book->author = Input::get('author');
                $book->price = Input::get('price');
                $book->discounted_price = Input::get('discounted_price');
                $book->book_type = Input::get('book_type');
                $book->picture_1 = $picture_1;
                $book->picture_2 = $picture_2;

                $book->status = 'active';
                $book->created_at = date('Y-m-d h:i:s');

                $book->save();*/

        $product = new Product();

        $product->course_id = $courseId;
        $product->category = 'book';
        $product->name = Input::get('name');
        $product->publication = Input::get('publication');
        $product->subject = Input::get('subject');
        $product->author = Input::get('author');
        $product->price = Input::get('price');
        $product->discounted_price = Input::get('discounted_price');
        $product->product_type = Input::get('book_type');
        $product->picture_1 = $picture_1;
        $product->picture_2 = $picture_2;

        $product->status = 'active';
        $product->created_at = date('Y-m-d h:i:s');

        $product->save();

        return json_encode(array('message' => 'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $book = Book::find($id);

            if (isset($book)) {

                Session::put('book_id', $id);

                return View::make('book.edit')->with('book', $book);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function remove($id)
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($id)) {

//            $book = Book::find($id);
            $book = Product::find($id);

            if (isset($book)) {

                $book->status = 'removed';
                $book->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function update()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $id = Session::get('book_id');

        if (isset($id)) {
//            $book = Book::find($id);
            $book = Product::find($id);

            $picture_1 = Input::file('picture_1');
            $picture_2 = Input::file('picture_2');


            if (isset($book)) {

                if (isset($picture_1)) {

                    $imageName = Input::file('picture_1')->getClientOriginalName();

                    $destinationPath = "public/uploads/book-images/" . $book->course_id . "/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if (!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('picture_1')->move($destinationPath, $imageName);

                    $picture_1 = $imageName;
                    $book->picture_1 = $picture_1;

                }


                if (isset($picture_2)) {

                    $imageName = Input::file('picture_2')->getClientOriginalName();

                    $destinationPath = "public/uploads/book-images/" . $book->course_id . "/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if (!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('picture_2')->move($destinationPath, $imageName);

                    $picture_2 = $imageName;
                    $book->picture_2 = $picture_2;

                }

                $book->name = Input::get('name');
                $book->publication = Input::get('publication');
                $book->subject = Input::get('subject');
                $book->author = Input::get('author');
                $book->price = Input::get('price');
                $book->discounted_price = Input::get('discounted_price');
                $book->product_type = Input::get('book_type');

                $book->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function getBook($id)
    {

        if (isset($id)) {

            $book = Book::find($id);

            if (isset($book)) {

                return json_encode(array('message' => 'found', 'book' => $book));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function getBooks($id)
    {
        if (isset($id)) {

            $books = Book::where('course_id', $id)->get();

            if (isset($books)) {

                return json_encode(array('message' => 'found', 'books' => $books->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function listBooks($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $course_id = Session::get('course_id');

        if (isset($course_id)) {

//            $books = Book::where('course_id', $course_id)->where('status', $status)->get();
            $books = Product::where('course_id', $course_id)->where('category', 'book')->where('status', $status)->get();
            if (isset($books) && count($books) > 0) {

                return json_encode(array('message' => 'found', 'books' => $books->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }
}