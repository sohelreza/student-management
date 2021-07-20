<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamEnroll extends Model
{
    protected $fillable=[
       
       'exam_id',
       'student_id',
       
       'roll_no',
       'name',
       'phone',
       
       'total_marks',
       'obtained_marks',
       'height_marks',
       'merit_position'
      
    ];

     public function student(){
      return $this->belongsTo('App\User','student_id');
    }

     public function exam(){
      return $this->belongsTo('App\Exam','exam_id');
    }
}
