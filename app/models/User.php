<?php

class User extends Eloquent{

	protected $table = 'users';

	protected $hidden = array('password');

    public function orders(){
        return $this->hasMany('Order', 'user_id');
    }
}