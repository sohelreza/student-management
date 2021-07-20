<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable=[
       
       'name',
       'code',
       'branch_id',
       'class_id',
       'batch_id',
       'subject_id',
       'student_type',
       
       'total_marks',
       'height_marks',
      
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

    public function enroll(){
      return $this->hasOne('App\ExamEnroll','exam_id');
    }

}
