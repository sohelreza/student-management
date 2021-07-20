<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class McqExamEnrollAnswer extends Model
{
    protected $fillable=[
       
       'mcq_exam_enroll_id',
       'student_id',
       'exam_id',
       'question_id',
       'option_id',
       'correct_answer'
      
    ];
}
