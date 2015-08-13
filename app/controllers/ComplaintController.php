<?php

class ComplaintController extends BaseController
{
    function __construct()
    {
        $name = Session::get('name');

        View::share('root', URL::to('/'));
        View::share('name', $name);
    }

    public function manage()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('complaint.manage');
    }

    public function view($id)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        if(isset($id)){

            $complaint = Complaint::find($id);

            if(isset($complaint)) {

                Session::put('complaint_update_id', $id);

                return View::make('complaint.view')->with('complaint', $complaint);
            }
            else
                return Redirect::to('/');
        }
        else
            return Redirect::to('/');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $complaint = new Complaint();

        $complaint->name = Input::get('name');
        $complaint->email = Input::get('email');
        $complaint->address = Input::get('address');
        $complaint->contact_number_1 = Input::get('contact_number_1');
        $complaint->contact_number_2 = Input::get('contact_number_2');
        $complaint->software_user_id = $adminId;
        $complaint->status = Input::get('status');
        $complaint->save();

        $complaintUpdate = new ComplaintUpdate();

        $complaintUpdate->complaint_id = $complaint->id;
        $complaintUpdate->software_user_id = $adminId;
        $complaintUpdate->description = Input::get('description');
        $complaintUpdate->status = $complaint->status;
        $complaintUpdate->save();

        return json_encode(array('message'=>'done'));
    }

    public function addComplaintUpdate(){

        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('complaint_update_id');
        if(isset($id)) {

            $complaint = Complaint::find($id);

            if(isset($complaint)) {

                $complaintUpdate = new ComplaintUpdate();

                $complaintUpdate->complaint_id = $id;
                $complaintUpdate->software_user_id = $adminId;
                $complaintUpdate->description = Input::get('description');
                $complaintUpdate->status = Input::get('status');
                $complaintUpdate->save();

                return json_encode(array('message' => 'done'));
            }
            else
                return json_encode(array('message' => 'invalid'));
        }
        else
            return json_encode(array('message' => 'invalid'));
    }

    public function updatePersonal()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $id = Session::get('complaint_id');

        if(isset($id)){
            $complaint = Complaint::find($id);

            if(isset($complaint)){

                $complaint->name = Input::get('name');
                $complaint->email = Input::get('email');
                $complaint->address = Input::get('address');
                $complaint->contact_number_1 = Input::get('contact_number_1');
                $complaint->contact_number_2 = Input::get('contact_number_2');

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

                Session::put('complaint_id', $id);

                return json_encode(array('message'=>'found', 'complaint' => $complaint));
            }
            else
                return json_encode(array('message'=>'empty'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function resolve($id)
    {
        if(isset($id)){

            $complaint = Complaint::find($id);

            if(isset($complaint)){

                $complaint->status = 'Resolved';

                $complaint->save();

                return json_encode(array('message'=>'done'));
            }
            else
                return json_encode(array('message'=>'invalid'));
        }
        else
            return json_encode(array('message'=>'invalid'));
    }

    public function pendingComplaints($page=1)
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $complaints = Complaint::whereIn('status', array('Problem', 'Complaint'))->get();

        $userType = Session::get('user_type');
        if(!$userType)
            $userType = '';

        if(isset($complaints) && count($complaints)>0){
            return json_encode(array('message'=>'found', 'userType' => $userType, 'complaints' => $complaints->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
    }

    public function complaintUpdates()
    {
        $id = Session::get('complaint_update_id');

        if(isset($id)) {
            $complaintUpdates = ComplaintUpdate::where('complaint_id', $id)->get();

            if (isset($complaintUpdates) && count($complaintUpdates) > 0) {
                return json_encode(array('message' => 'found', 'complaintUpdates' => $complaintUpdates->toArray()));
            } else
                return json_encode(array('message' => 'empty'));
        }
        else
            return json_encode(array('message' => 'empty'));
    }

    public function softwareUserComplaints($id)
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