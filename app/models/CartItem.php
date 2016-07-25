<?php

class CartItem extends Eloquent
{
    protected $table = 'cart_items';
    public function cart()
    {
        return $this->belongsTo('Cart');
    }

    public function book()
    {
        return $this->belongsTo('Book');
    }

}