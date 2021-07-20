<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LectureSheet extends Model
{
    protected $fillable=[
       
       'name',
       'date',
       'description',
       'file',
       'student_type',
       'branch',
       'class',
       'batch',
       'subject',
      


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

    public function subjectname(){
        return $this->belongsTo('App\Subject','subject');
    }

}
