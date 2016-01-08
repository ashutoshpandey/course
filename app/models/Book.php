<?php

class Book extends Eloquent{

	protected $table = 'courses';

	public function course(){
		return $this->belongsTo('Course', 'course_id');
	}
}