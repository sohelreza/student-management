<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomMeetingAttendance extends Model
{
    protected $fillable=[
       
       'meeting_id',
       'student_id',
       'duration',
       'status',
      
    ];


    public function student(){
    	return $this->belongsTo('App\User','student_id');
    }
}
