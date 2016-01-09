<?php

class Book extends Eloquent{

	protected $table = 'books';

	public function course(){
		return $this->belongsTo('Course', 'course_id');
	}
}