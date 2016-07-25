<?php

class OrderItem extends Eloquent{

	protected $table = 'order_items';

    public function order(){
        return $this->belongsTo('Order', 'order_id');
    }

    public function product(){
        return $this->belongsTo('Product', 'product_id');
    }

    /*public function book(){
        return $this->belongsTo('Book', 'book_id');
    }

    public function accessory(){
        return $this->belongsTo('Accessory', 'accessory_id');
    }*/
}