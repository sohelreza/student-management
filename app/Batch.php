<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable=[
       
       'class_id',
       'branch_id',
       'name',
       'time',
       'max_student_number',
       'student_number',
       'phase',
       'status',
       'student_type'
    ];

    public function classname(){
    	return $this->belongsTo('App\ClassName','class_id');
    }

    public function branch(){
    	return $this->belongsTo('App\Branch');
    }
}
