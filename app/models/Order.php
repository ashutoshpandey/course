<?php

class Order extends Eloquent{

	protected $table = 'orders';

    public function orderItems(){
        return $this->hasMany('order_items', 'order_id');
    }

    public function user(){
        return $this->belongsTo('users', 'user_id');
    }
}