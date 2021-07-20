<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
     protected $fillable = [
        
        'student_id',
        'branch_id',
        'class_id',
        'batch_id',
        'subject_id',
        'student_type',
        'start_date',
        'end_date',
        'status'
        

    ];

    public function student(){
    	return $this->belongsTo('App\User');
    }

    public function subject(){
        return $this->belongsTo('App\Subject','subject_id');
    }
}
