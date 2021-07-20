<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CqExamEnroll extends Model
{
    protected $fillable=[
       
       'student_id',
       'branch_id',
       'class_id',
       'batch_id',
       'subject_id',
       'exam_id',
       'score',
      
    ];

     public function student(){
      return $this->belongsTo('App\User','student_id');
    }

     public function exam(){
      return $this->belongsTo('App\CqExam','exam_id');
    }
}
