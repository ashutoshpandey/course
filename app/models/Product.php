<?php

class Product extends Eloquent{

	protected $table = 'products';

	public function course(){
		return $this->belongsTo('Course', 'course_id');
	}
}