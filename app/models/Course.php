<?php

class Course extends Eloquent{

	protected $table = 'courses';

	public function books(){
		return $this->hasMany('Book', 'course_id');
	}
}