<?php

class User extends Eloquent{

	protected $table = 'users';

	protected $hidden = array('password');

    public function orders(){
        return $this->hasMany('orders', 'user_id');
    }
}