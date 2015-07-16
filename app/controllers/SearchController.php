<?php

class SearchController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function searchCities()
    {
        $key = $_REQUEST['term'];

        if(isset($key)){

            $locations = Location::where('city','like', '%'. $key . '%')->get();

            if(isset($locations)){

                return json_encode(array('message'=>'found', 'locations' => $locations->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function searchByKeyword($type)
    {
        $key = $_REQUEST['term'];

        if(isset($type) && $type=='i')
            return $this->getSearchInstitutes($key);
        else if(isset($type) && $type=='b')
            return $this->getSearchBooks($key);
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

    public function getSearchInstitutes($key)
    {
        if(isset($key)){

            $institutes = Institute::where('name','like', '%'. $key . '%')->get();

            if(isset($institutes)){

                return json_encode(array('message'=>'found', 'institutes' => $institutes->toArray()));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}