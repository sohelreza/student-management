<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = [
    	
        'student_id',
    	'date_of_birth',
        'gender',
        'institution',
        'zoom_id',
        'father_name', 
        'father_phone',
        'mother_name', 
        'mother_phone',
        'present_address',
        'permanent_address',
        'gaurdian_name',
        'gaurdian_relation',
        'gaurdian_phone',
        'gaurdian_address',
        // 'image'
    
    ];

    public function student(){
    	return $this->belongsTo('App\User');
    }
}
