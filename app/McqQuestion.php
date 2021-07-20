<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class McqQuestion extends Model
{
    protected $fillable=[
       
       'exam_id',
       'question_number',
       'question_title',
       'answer_type',
       'mark',
       'time',
    ];

     public function options(){
      return $this->hasMany('App\McqOption','question_id');
    }

     public function mcq_right_answers(){
      return $this->hasMany('App\McqOption','question_id');
    }
    
     public function answers(){
      return $this->hasMany('App\McqExamEnrollAnswer','question_id');
    }

     public function exam_enroll_answers(){
      return $this->hasMany('App\McqExamEnrollAnswer','question_id');
    }
    
    

}
