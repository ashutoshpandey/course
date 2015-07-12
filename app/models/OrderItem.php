<?php

class OrderItem extends Eloquent{

	protected $table = 'order_items';

    public function order(){
        return $this->belongsTo('order', 'order_id');
    }
}