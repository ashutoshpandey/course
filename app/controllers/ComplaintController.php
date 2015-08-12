<?php

class ComplaintController extends BaseController
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

        return View::make('complaints.add');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $complaint = new Complaint();

        $complaint->name = Input::get('name');
        $complaint->contact_person = Input::get('contact_person');
        $complaint->address = Input::get('address');
        $complaint->location_id = Input::get('city');
        $complaint->country = 'India';
        $complaint->land_mark = Input::get('land_mark');
        $complaint->zip = Input::get('zip');
        $complaint->contact_number_1 = Input::get('contact_number_1');
        $complaint->contact_number_2 = Input::get('contact_number_2');
        $complaint->email = Input::get('email');

        $complaint->status = 'active';
        $complaint->created_at = date('Y-m-d h:i:s');

        $complaint->save();

        return json_encode(array('message'=>'done'));
    }

    public function remove($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        if(isset($id)){

            $complaint = Complaint::find($id);

            if(isset($complaint)){

                $complaint->status = 'removed';
                $complaint->save();

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
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('complaint_id');

        if(isset($id)){
            $complaint = Complaint::find($id);

            if(isset($complaint)){

                $complaint->name = Input::get('name');
                $complaint->contact_person = Input::get('contact_person');
                $complaint->address = Input::get('address');
                $complaint->city = Input::get('city');
                $complaint->state = Input::get('state');
                $complaint->country = Input::get('country');
                $complaint->land_mark = Input::get('land_mark');
                $complaint->zip = Input::get('zip');
                $complaint->contact_number_1 = Input::get('contact_number_1');
                $complaint->contact_number_2 = Input::get('contact_number_2');
                $complaint->email = Input::get('email');

                $complaint->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function getComplaint($id)
    {
        if(isset($id)){

            $complaint = Complaint::find($id);

            if(isset($complaint)){

                return json_encode(array('message'=>'found', 'complaint' => $complaint));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function listPendingComplaints()
    {
        $complaints = Complaint::where('status','pending');

        if(isset($complaints)){

            return json_encode(array('message'=>'found', 'complaints' => $complaints->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function getSoftwareUserComplaints($id)
    {
        if(isset($id)){

            $softwareUser = SoftwareUser::find($id);

            if(isset($softwareUser)) {
                $complaints = Complaint::where('software_user_id', $id)->get();

                if (isset($complaints)) {

                    return json_encode(array('message' => 'found', 'complaints' => $complaints->toArray()));
                } else
                    return json_encode(array('message' => 'empty'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }
}