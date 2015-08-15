<?php

class SearchController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function searchCities($key)
    {
        //$key = $_REQUEST['term'];

        if(isset($key)){

            $locations = Location::where('city','like', '%'. $key . '%')->get();

            if(isset($locations) && count($locations)>0){

                return json_encode(array('message'=>'found', 'locations' => $locations->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function searchByKeyword($key, $cityId=null)
    {
        return $this->getSearchInstitutes($key, $cityId);
//        if(isset($type) && $type=='i')
//            return $this->getSearchInstitutes($key);
//        else if(isset($type) && $type=='b')
//            return $this->getSearchBooks($key);
//        else
//            return json_encode(array('message'=>'invalid'));
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

    public function getSearchInstitutes($key, $cityId)
    {
        if(isset($key)){

            if(isset($cityId))
                $institutes = Institute::where('name','like', '%'. $key . '%')->where('location_id', '=', $cityId)->get();
            else
                $institutes = Institute::where('name','like', '%'. $key . '%')->get();

            if(isset($institutes) && count($institutes)>0){

                return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function institutes(){

        $key = Input::get('keyword');
        $cityId = Input::get('c');          // city id

        if(isset($key)){

            if(isset($cityId) && strlen($cityId)>0)
                $institutes = Institute::where('name','like', '%'. $key . '%')->where('location_id', '=', $cityId)->with('location')->get();
            else
                $institutes = Institute::where('name','like', '%'. $key . '%')->with('location')->get();

            if(isset($institutes) && count($institutes)>0)
                return View::make('institute.institutes')->with('institutes', $institutes);
            else
                return View::make('institute.institutes');
        }
    }
}