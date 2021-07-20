<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentHomework extends Model
{
    protected $fillable = [
        
        'student_id',
        'teacher_id',
        'branch_id',
        'class_id',
        'batch_id',
        'subject_id',
        'title',
        'submission_date',
        'evaluation_date',
        'score',
        'status'
    ];

    public function student(){
    	return $this->belongsTo('App\User');
    }
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
    public function images(){
        return $this->hasMany('App\StudentHomeworkImage');
    }

    public function teacher(){
        return $this->belongsTo('App\Admin');
    }
}
