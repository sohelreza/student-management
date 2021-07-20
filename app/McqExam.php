<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class McqExam extends Model
{
    protected $fillable=[
       
       'name',
       'description',
       'branch_id',
       'class_id',
       'batch_id',
       'subject_id',
       'student_type',
       'exam_date',
       'start_time',
       'end_time',
       
       'total_exam_duration',
       'total_exam_marks',
       'passing_percentage',
       
       'duration_per_question',
       'mark_per_question',
       
       'negative_marking',
       'negative_mark_per_question',
       'status'
      
    ];

    public function class(){
        return $this->belongsTo('App\ClassName');
    }
    public function branch(){
        return $this->belongsTo('App\Branch');
    }
    public function batch(){
        return $this->belongsTo('App\Batch');
    }
    public function subject(){
        return $this->belongsTo('App\Subject');
    }

     public function questions(){
      return $this->hasMany('App\McqQuestion','exam_id');
    }

    public function enroll(){
      return $this->hasOne('App\McqExamEnroll','exam_id');
    }

    
}
