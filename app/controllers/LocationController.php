<?php

class LocationController extends BaseController
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

        return View::make('location.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message' => 'not logged'));

        $location = new Location();

        $location->city = Input::get('city');
        $location->state = Input::get('state');
        $location->pin = Input::get('pin');

        $location->status = 'active';
        $location->created_at = date('Y-m-d h:i:s');

        $location->save();

        return json_encode(array('message'=>'done'));
    }

    public function edit($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $location = Location::find($id);

            if(isset($location)){

                Session::put('location_id', $id);

                return View::make('location.edit')->with('location', $location);
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

            $location = Location::find($id);

            if(isset($location)){

                $location->status = 'removed';
                $location->save();

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

        $id = Session::get('location_id');

        if(isset($id)){
            $location = Location::find($id);

            if(isset($location)){

                $location->city = Input::get('city');
                $location->state = Input::get('state');
                $location->pin = Input::get('pin');

                $location->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getLocation($id)
    {
        if(isset($id)){

            $location = Location::find($id);

            if(isset($location)){

                return json_encode(array('message'=>'found', 'location' => $location));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getLocations($id)
    {
        if(isset($id)){

            $locations = Location::where('status','=', 'active')->get();

            if(isset($locations)){

                return json_encode(array('message'=>'found', 'locations' => $locations->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getSearchLocations($key)
    {
        if(isset($key)){

            $locations = Location::where('name','like', '%'. $key . '%')->get();

            if(isset($locations)){

                return json_encode(array('message'=>'found', 'locations' => $locations->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}