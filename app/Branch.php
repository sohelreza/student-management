<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable=[
       
       'name',
       'address',
       'student_type',
   
      
   ];

    public function batches(){
    	return $this->hasMany('App\Batch');
    }

    public function classes(){
    	return $this->hasMany('App\ClassName','brnach_id');
    }


}
