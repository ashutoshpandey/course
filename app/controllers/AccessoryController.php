<?php

class AccessoryController extends BaseController
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


    public function listAccessories($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $course_id = Session::get('course_id');

        if (isset($course_id)) {

//            $accessories=Accessory::where('course_id', $course_id)->where('status', $status)->get();
            $accessories=Product::where('course_id', $course_id)->where('category','accessory')->where('status', $status)->get();

            if (isset($accessories) && count($accessories) > 0) {
                return json_encode(array('message' => 'found', 'accessories' => $accessories->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
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

            $destinationPath = "public/uploads/accessory/" . $courseId . "/";

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

            $destinationPath = "public/uploads/accessory/" . $courseId . "/";

            $directoryPath = base_path() . '/' . $destinationPath;

            if (!file_exists($directoryPath))
                mkdir($directoryPath);

            Input::file('picture_2')->move($destinationPath, $imageName);

            $picture_2 = $imageName;

        } else {
            $picture_2 = "";
        }

/*        $accessory=new Accessory();


        $accessory->course_id = $courseId;
        $accessory->name = Input::get('name');
        $accessory->description = Input::get('description');

        $accessory->cost_price = Input::get('cost_price');
        $accessory->sale_price = Input::get('sale_price');

        $accessory->accessories_type = Input::get('accessory_type');
        $accessory->picture_1 = $picture_1;
        $accessory->picture_2 = $picture_2;

        $accessory->status = 'active';
        $accessory->created_at = date('Y-m-d h:i:s');

        $accessory->save();*/

        $product = new Product();

        $product->course_id = $courseId;
        $product->category = 'accessory';
        $product->name = Input::get('name');
        $product->price = Input::get('price');
        $product->discounted_price = Input::get('discounted_price');
        $product->product_type = Input::get('accessory_type');
        $product->picture_1 = $picture_1;
        $product->picture_2 = $picture_2;

        $product->status = 'active';
        $product->created_at = date('Y-m-d h:i:s');

        $product->save();

        return json_encode(array('message' => 'done'));
    }



    public function viewAccessory($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

//            $accessory=Accessory::find($id);
            $accessory=Product::find($id);
            if (isset($accessory)) {

                Session::put('accessory_id', $id);

                return View::make('admin.view-accessory')->with('accessory', $accessory);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }




    public function update()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $id = Session::get('accessory_id');

        if (isset($id)) {
//            $accessory=Accessory::find($id);
            $accessory=Product::find($id);

            $picture_1 = Input::file('picture_1');
            $picture_2 = Input::file('picture_2');


            if (isset($accessory)) {

                if (isset($picture_1)) {

                    $imageName = Input::file('picture_1')->getClientOriginalName();

                    $destinationPath = "public/uploads/accessory/" . $accessory->course_id . "/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if (!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('picture_1')->move($destinationPath, $imageName);

                    $picture_1 = $imageName;
                    $accessory->picture_1 = $picture_1;

                }


                if (isset($picture_2)) {

                    $imageName = Input::file('picture_2')->getClientOriginalName();

                    $destinationPath = "public/uploads/accessory/" . $accessory->course_id . "/";

                    $directoryPath = base_path() . '/' . $destinationPath;

                    if (!file_exists($directoryPath))
                        mkdir($directoryPath);

                    Input::file('picture_2')->move($destinationPath, $imageName);

                    $picture_2 = $imageName;
                    $accessory->picture_2 = $picture_2;

                }

                $accessory->name = Input::get('name');
                $accessory->price = Input::get('price');
                $accessory->discounted_price = Input::get('discounted_price');
                $accessory->product_type = Input::get('accessory_type');

                $accessory->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }


    public function remove($id)
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($id)) {

//            $accessory=Accessory::find($id);
            $accessory=Product::find($id);
            if (isset($accessory)) {

                $accessory->status = 'removed';
                $accessory->save();

                return json_encode(array('message' => 'done'));
            } else
                return json_encode(array('message' => 'invalid'));
        } else
            return json_encode(array('message' => 'invalid'));
    }


    public function accessory($id)
    {

        if (isset($id)) {

            $course = Course::find($id);

            if (isset($course)) {
//                $accessories=Accessory::where('status', 'active')->where('course_id', $id)->get();
                $accessories=Product::where('status', 'active')->where('category','accessory')->where('course_id', $id)->get();

                Session::put('course_id', $id);
                $cart = Session::get('cart');

                if (isset($accessories) && count($accessories) > 0)
                    return View::make('accessory.list')->with('found', true)->with('accessories', $accessories)->with('course', $course)->with('cart', $cart);
                else
                    return View::make('accessory.list')->with('found', false)->with('course', $course);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

}