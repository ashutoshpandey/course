<?php

class OrderDispatchItem extends Eloquent{

	protected $table = 'order_dispatch_items';

    public function orderDispatch(){
        return $this->belongsTo('OrderDispatch', 'order_dispatch_id');
    }
}