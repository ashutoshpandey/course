<?php

class ComplaintUpdate extends Eloquent{

	protected $table = 'complaint_updates';

	public function complaint(){
		return $this->belongsTo('Complaint', 'complaint_id');
	}
}