<?php

class AdminController extends BaseController
{
    function __construct()
    {

        $name = Session::get('name');

        View::share('root', URL::to('/'));
        View::share('name', $name);
    }

    public function adminSection()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        $orderCount = Order::where('status', '=', 'pending')->count();
        $userCount = User::where('status', '=', 'active')->count();
        $softwareUserCount = SoftwareUser::where('status', '=', 'active')->count();
        $complaintCount = Complaint::whereIn('status', array('Complaint', 'Problem'))->count();

        return View::make('admin.admin-section')
            ->with('orderCount', $orderCount)
            ->with('userCount', $userCount)
            ->with('complaintCount', $complaintCount)
            ->with('softwareUserCount', $softwareUserCount);
    }

    public function institutes()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.institutes');
    }

    public function viewInstitute($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $institute = Institute::find($id);

            $location = Location::find($institute->location_id);

            if (isset($institute)) {

                Session::put('institute_id', $id);

                return View::make('admin.view-institute')->with('institute', $institute)->with('location', $location);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listInstitutes($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($status)) {

            $institutes = Institute::where('status', '=', $status)->with('location')->get();

            if (isset($institutes) && count($institutes) > 0) {

                return json_encode(array('message' => 'found', 'institutes' => $institutes->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function courses($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $institute = Institute::find($id);

            if (isset($institute)) {

                Session::put('institute_id', $id);

                return View::make('admin.courses')->with('institute', $institute);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listCourses($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $institute_id = Session::get('institute_id');

        if (isset($institute_id)) {

            $courses = Course::where('institute_id', '=', $institute_id)->where('status', '=', $status)->get();

            if (isset($courses) && count($courses) > 0) {

                return json_encode(array('message' => 'found', 'courses' => $courses->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function viewCourse($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $course = Course::find($id);


            if (isset($course)) {

                Session::put('course_id', $id);

                return View::make('admin.view-course')->with('course', $course);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function books($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $course = Course::find($id);

            if (isset($course)) {

                Session::put('course_id', $id);

                $instituteId = Session::get('institute_id');

                if (isset($instituteId)) {

                    $institute = Institute::find($instituteId);

                    if (isset($institute))
                        return View::make('admin.books')->with('course', $course)->with('institute', $institute);
                    else
                        return Redirect::to('/');
                } else
                    return Redirect::to('/');
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function viewBook($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

//            $book = Book::find($id);
            $book = Product::find($id);

            if (isset($book)) {

                Session::put('book_id', $id);

                return View::make('admin.view-book')->with('book', $book);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function viewOrder($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $order = Order::find($id);

            if (isset($order)) {

                Session::put('order_id', $id);

                $orderItems = OrderItem::where('order_id', $order->id)->get();
                $couriers = Courier::where('status', 'active')->get();

                return View::make('admin.view-order')->with('order', $order)->with('orderItems', $orderItems)->with('couriers', $couriers);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function orders()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.orders');
    }

    public function updateCourier()
    {
        $ids = Input::get('ids');
        $docket = Input::get('docket');
        $courier = Input::get('courier');

        if (isset($ids) && isset($docket) && isset($courier)) {

            $orderId = Session::get('order_id');

            if (isset($orderId)) {

                $order = Order::find($orderId);

                if (isset($order)) {

                    $arIds = explode(',', $ids);

                    if (isset($arIds) && count($arIds) > 0) {

                        $orderDispatch = new OrderDispatch();

                        $orderDispatch->order_id = $orderId;
                        $orderDispatch->docket = $docket;
                        $orderDispatch->courier_id = $courier;
                        $orderDispatch->status = 'active';

                        $orderDispatch->save();

                        foreach ($arIds as $id) {

                            $orderItem = OrderItem::find($id);
                            if (isset($orderItem)) {

                                $orderDispatchItem = new OrderDispatchItem();

                                $orderDispatchItem->order_item_id = $id;
                                $orderDispatchItem->order_dispatch_id = $orderDispatch->id;
                                $orderDispatchItem->status = 'active';

                                $orderDispatchItem->save();
                                $orderItem->status = 'shipped';
                                $orderItem->save();
                            } else
                                return json_encode(array('message' => 'done'));
                        }

                        return json_encode(array('message' => 'done'));
                    } else
                        return json_encode(array('message' => 'done'));
                } else {
                    return json_encode(array('message' => 'invalid'));
                }
            } else
                return json_encode(array('message' => 'invalid'));
        }
    }

    public function listOrders($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($status)) {

            $orders = Order::with('user')->where('status', '=', $status)->get();

            if (isset($orders) && count($orders) > 0) {

                return json_encode(array('message' => 'found', 'orders' => $orders->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }

    public function couriers()
    {
        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.couriers');
    }

    public function viewCourier($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $courier = Courier::find($id);
            $location = Location::find($courier->location_id);

            if (isset($courier)) {

                Session::put('courier_id', $id);

                return View::make('admin.view-courier')->with('courier', $courier)->with('location', $location);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listCouriers($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $couriers = Courier::where('status', '=', $status)->get();

        if (isset($couriers) && count($couriers) > 0) {

            return json_encode(array('message' => 'found', 'couriers' => $couriers->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function softwareUsers()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.software-users');
    }

    public function viewSoftwareUser($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {
            $softwareUser = SoftwareUser::find($id);

            if (isset($softwareUser)) {

                Session::put('software_user_id', $id);

                if ($softwareUser->gender == 'male') {
                    $male_checked = 'checked="checked"';
                    $female_checked = '';
                } else {
                    $female_checked = 'checked="checked"';
                    $male_checked = '';
                }

                return View::make('admin.view-software-user')
                    ->with('softwareUser', $softwareUser)
                    ->with('male_checked', $male_checked)
                    ->with('female_checked', $female_checked);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listSoftwareUsers($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $softwareUsers = SoftwareUser::where('status', '=', $status)->get();

        if (isset($softwareUsers) && count($softwareUsers) > 0) {

            return json_encode(array('message' => 'found', 'software_users' => $softwareUsers->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function users()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.users');
    }

    public function viewUser($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {
            $user = User::find($id);

            if (isset($user)) {

                Session::put('user_id', $id);

                if ($user->gender == 'male') {
                    $male_checked = 'checked="checked"';
                    $female_checked = '';
                } else {
                    $female_checked = 'checked="checked"';
                    $male_checked = '';
                }

                return View::make('admin.view-user')
                    ->with('user', $user)
                    ->with('male_checked', $male_checked)
                    ->with('female_checked', $female_checked);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listUsers($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $users = User::where('status', '=', $status)->get();

        if (isset($users) && count($users) > 0) {

            return json_encode(array('message' => 'found', 'users' => $users->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function locations()
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        return View::make('admin.locations');
    }

    public function viewLocation($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {
            $location = Location::find($id);

            if (isset($location)) {

                Session::put('location_id', $id);

                return View::make('admin.view-location')
                    ->with('location', $location);
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

    public function listLocations($status, $page)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $locations = Location::where('status', '=', $status)->get();

        if (isset($locations) && count($locations) > 0) {

            return json_encode(array('message' => 'found', 'locations' => $locations->toArray()));
        } else
            return json_encode(array('message' => 'empty'));
    }

    public function getCities($state)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        if (isset($state)) {

            $locations = Location::where('state', '=', $state)->where('status', '=', 'active')->get();

            if (isset($locations) && count($locations) > 0)
                return json_encode(array('message' => 'found', 'locations' => $locations->toArray()));
            else
                return json_encode(array('message' => 'empty'));
        } else
            return json_encode(array('message' => 'invalid'));
    }


//    18/07/16
    public function accessories($id)
    {

        $adminId = Session::get('admin_id');
        if (!isset($adminId))
            return Redirect::to('/');

        if (isset($id)) {

            $course = Course::find($id);

            if (isset($course)) {

                Session::put('course_id', $id);

                $instituteId = Session::get('institute_id');

                if (isset($instituteId)) {

                    $institute = Institute::find($instituteId);

                    if (isset($institute))
                        return View::make('admin.accessories')->with('course', $course)->with('institute', $institute);
                    else
                        return Redirect::to('/');
                } else
                    return Redirect::to('/');
            } else
                return Redirect::to('/');
        } else
            return Redirect::to('/');
    }

}