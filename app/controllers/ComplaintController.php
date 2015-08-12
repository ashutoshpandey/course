<?php

class ComplaintController extends BaseController
{
    function __construct()
    {
        View::share('root', URL::to('/'));
    }

    public function manage()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return Redirect::to('/');

        return View::make('complaints.manage');
    }

    public function save()
    {
        $adminId = Session::get('admin_id');
        if(!isset($adminId))
            return json_encode(array('message'=>'not logged'));

        $complaint = new Complaint();

        $complaint->name = Input::get('name');
        $complaint->email = Input::get('email');
        $complaint->contact_number = Input::get('contact_number');
        $complaint->software_user_id = $adminId;
        $complaint->status = 'active';
        $complaint->save();

        $complaintUpdate = new ComplaintUpdate();

        $complaintUpdate->complaint_id = $complaint->id;
        $complaintUpdate->software_user_id = $adminId;
        $complaintUpdate->description = Input::get('description');
        $complaintUpdate->status = $complaint->status;
        $complaintUpdate->save();

        return json_encode(array('message'=>'done'));
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

    public function pendingComplaints()
    {
        $complaints = Complaint::where('status','pending');

        if(isset($complaints)){

            return json_encode(array('message'=>'found', 'complaints' => $complaints->toArray()));
        }
        else
            return json_encode(array('message'=>'empty'));
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