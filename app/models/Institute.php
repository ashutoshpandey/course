<?php

class Institute extends Eloquent{

	protected $table = 'institutes';

    public function institutes(){
        return $this->hasMany('Institute', 'institute_id');
    }

	public function location(){
		return $this->belongsTo('Location', 'location_id');
	}
}