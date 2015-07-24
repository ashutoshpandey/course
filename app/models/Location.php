<?php

class Location extends Eloquent{

	protected $table = 'locations';

	public function institutes(){
		return $this->belongsTo('Institute', 'location_id');
	}
}