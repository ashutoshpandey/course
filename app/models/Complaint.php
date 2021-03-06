<?php

class Complaint extends Eloquent{

	protected $table = 'complaints';

	public function orderDispatch(){
		return $this->belongsTo('OrderDispatch', 'order_dispatch_id');
	}

	public function order(){
		return $this->belongsTo('Order', 'order_id');
	}

    public function softwareUser(){
        return $this->belongsTo('SoftwareUser', 'software_user_id');
    }

	public function complaintUpdates(){
		return $this->hasMany('ComplaintUpdate', 'complaint_id');
	}
}