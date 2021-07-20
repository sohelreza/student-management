<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CqExam extends Model
{
    protected $fillable=[
       
       'name',
       'description',
       'teacher_id',
       'student_type',
       'branch_id',
       'class_id',
       'batch_id',
       'subject_id',
       'exam_date',
       'start_time',
       'end_time',
       
       'total_exam_duration',
       'total_exam_marks',
       'passing_percentage',
       
       'status',
       'publish_rank',
       'solve_sheet'
      
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
      return $this->hasMany('App\CqQuestion','exam_id');
    }

    public function teacher(){
        return $this->belongsTo('App\Admin','teacher_id');
    }
}
