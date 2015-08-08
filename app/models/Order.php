<?php

class Order extends Eloquent{

	protected $table = 'orders';

    public function orderItems(){
        return $this->hasMany('OrderItem', 'order_id');
    }

    public function user(){
        return $this->belongsTo('User', 'user_id');
    }
}