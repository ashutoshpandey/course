<?php

class OrderDispatch extends Eloquent{

	protected $table = 'order_dispatches';

    public function order(){
        return $this->belongsTo('Order', 'order_id');
    }

    public function dispatchedItems(){
        return $this->hasMany('OrderDispatchItem', 'order_dispatch_id');
    }
}