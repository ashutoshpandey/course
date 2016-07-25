<?php

class Accessory extends Eloquent{

    protected $table = 'accessories';

    public function course(){
        return $this->belongsTo('Course', 'course_id');
    }

}