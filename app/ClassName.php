<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassName extends Model
{
    protected $fillable=[
       
       'name',
       'branch_id',
       'year',
       'status'

    ];


    public function subjects(){
    	return $this->hasMany('App\Subject','class_id');
    }

    public function batches(){
    	return $this->hasMany('App\Batch');
    }

    public function branch(){
        return $this->belongsTo('App\Branch','branch_id');
    }

    public function meetings(){
        return $this->hasMany('App\ZoomMetting','class');
    }

    

   
}
