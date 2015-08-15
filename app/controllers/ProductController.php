<?php

class ProductController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
        View::share('currency', 'Rs.');
    }

    public function products($courseId){

        if(isset($courseId)) {

            $products = Product::where('status','=','active')->where('course_id', $courseId)->get();

            if(isset($products)){

                $cart = Session::get('cart');
                if($cart) {
                    $arProducts = array();
                    foreach ($products as $product) {

                        $product->added = 'n';

                        foreach($cart as $cartItem){

                            if($cartItem['productId']==$product->id) {
                                $product->added = 'y';
                                break;
                            }
                        }
                    }
                }
                else{
                    $arProducts = array();
                    foreach ($products as $product) {
                        $product->added = 'n';
                        $arProducts[] = $product;
                    }
                }

                $course = Course::where('id', $courseId)->with('institute')->first();

                if(isset($course)){

                    $subjects = Product::where('course_id', $courseId)->select('subject')->groupBy('subject')->get();

                    if(isset($subjects) && count($subjects)>0){

                        return View::make('product.list')
                                        ->with('found', true)
                                        ->with('products', $products)
                                        ->with('subjects', $subjects->toArray())
                                        ->with('course', $course);
                    }
                    else
                        return View::make('product.list')->with('found', false)->with('course', $course);
                }
                else
                    return Redirect::to('/');
            }
            else
                return View::make('product.list')->with('found', false)->with('course', $course);
        }
        else
            return Redirect::to('/');
    }

    public function add()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('product.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $courseId = Session::get('course_id');
        if(!isset($courseId))
            return json_encode(array('message' => 'invalid'));

        $product = new Product();

        $product->course_id = $courseId;
        $product->name = Input::get('name');
        $product->subject = Input::get('subject');
        $product->author = Input::get('author');
        $product->price = Input::get('price');
        $product->discounted_price = Input::get('discounted_price');
        $product->product_type = Input::get('product_type');

        $product->status = 'active';
        $product->created_at = date('Y-m-d h:i:s');

        $product->save();

        if (Input::hasFile('picture_1')) {

            $imageName = Input::file('picture_1')->getClientOriginalName();

            $destinationPath = "public/product-images/" . $product->id . "/";

            $directoryPath = base_path() . '/' . $destinationPath;

            if (!file_exists($directoryPath))
                mkdir($directoryPath);

            Input::file('picture_1')->move($destinationPath, $imageName);

            $product->picture_1 = $imageName;

            $product->save();
        }
        if (Input::hasFile('picture_2')) {

            $imageName = Input::file('picture_2')->getClientOriginalName();
            $extension = Input::file('picture_2')->getClientOriginalExtension();

            $fileName = $imageName . '.' . $extension;
            $destinationPath = "public/product-images/" . $product->id . "/";

            $directoryPath = base_path() . '/' . $destinationPath;

            if (!file_exists($directoryPath))
                mkdir($directoryPath);

            Input::file('picture_2')->move($destinationPath, $fileName);

            $product->picture_2 = $fileName;

            $product->save();
        }

        return json_encode(array('message'=>'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $product = Product::find($id);

            if(isset($product)){

                Session::put('product_id', $id);

                return View::make('product.edit')->with('product', $product);
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

            $product = Product::find($id);

            if(isset($product)){

                $product->status = 'removed';
                $product->save();

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

        $id = Session::get('product_id');

        if(isset($id)){
            $product = Product::find($id);

            if(isset($product)){

                $product->name = Input::get('name');
                $product->publish_date = date('Y-m-d', strtotime(Input::get('publish_date')));
                $product->subject = Input::get('subject');
                $product->author = Input::get('author');
                $product->price = Input::get('price');
                $product->discounted_price = Input::get('discounted_price');
                $product->product_type = Input::get('product_type');

                $product->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getProduct($id)
    {
        if(isset($id)){

            $product = Product::find($id);

            if(isset($product)){

                return json_encode(array('message'=>'found', 'product' => $product));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getProducts()
    {
        $courseId = Session::get('course_id');

        if(isset($courseId)){

            $subjectString = $_REQUEST['subjectString'];

            if(isset($subjectString) && strlen($subjectString)>0){

                $subjects = explode(',', $subjectString);

                if(isset($subjects) && count($subjects)>0)
                    $products = Product::where('course_id','=', $courseId)->whereIn('subject', $subjects)->get();
            }
            else
                $products = Product::where('course_id','=', $courseId)->get();

            if(isset($products))
                return json_encode(array('message'=>'found', 'currency' => 'Rs.', 'products' => $products->toArray()));
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSearchProducts($key)
    {
        if(isset($key)){

            $products = Product::where('name','like', '%'. $key . '%')->get();

            if(isset($products)){

                return json_encode(array('message'=>'found', 'products' => $products->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}