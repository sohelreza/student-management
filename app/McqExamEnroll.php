<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class McqExamEnroll extends Model
{
    protected $fillable=[
       
       'student_id',
       'branch_id',
       'class_id',
       'batch_id',
       'subject_id',
       'exam_id',
       'score',
       'negative_marking'
      
    ];

     public function student(){
      return $this->belongsTo('App\User','student_id');
    }

     public function exam(){
      return $this->belongsTo('App\McqExam','exam_id');
    }
}
