<?php

class OrderItem extends Eloquent{

	protected $table = 'order_items';

    public function order(){
        return $this->belongsTo('Order', 'order_id');
    }
}