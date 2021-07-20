<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable=[
       
       'title',
       'date',
       'message',
       'all_student',
       'student_type',
       'branch',
       'class',
       'batch',
      


    ];

     public function classname(){
        return $this->belongsTo('App\ClassName','class');
    }

     public function batchname(){
        return $this->belongsTo('App\Batch','batch');
    }

     public function branchname(){
        return $this->belongsTo('App\Branch','branch');
    }
}
