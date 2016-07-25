<?php

class Book extends Eloquent{

	protected $table = 'books';

	public function course(){
		return $this->belongsTo('Course', 'course_id');
	}

	/*public function cartItems()
	{
		return $this->hasMany('CartItem');
	}*/

	public function orderItems(){
		return $this->hasMany('OrderItem', 'book_id');
	}
}