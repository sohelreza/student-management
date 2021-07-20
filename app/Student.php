<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
   protected $fillable = [
        
        'first_name', 
        'last_name',
        'phone', 
        'class_id',
        'branch_id',
        'batch_id',
        'student_type',
        'registration_id',
        'password',
        'current_payment_date',
        'next_payment_date',
    ];

     public function subjects(){
    	return $this->hasMany('App\StudentSubject','student_id');
    }

    public function payments(){
    	return $this->hasMany('App\StudentPayment','student_id');
    }

    public function profile(){
        return $this->hasOne('App\StudentProfile','student_id');
    }
}
