<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomMetting extends Model
{
    protected $fillable=[
       
       
       'meeting_id',
       'password',
       'topic',
       'description',
       'when',
       'duration',
       'branch',
       'class',
       'batch',
       'student_type',
       'subject',
       'host_video',
       'client_video',
       'meeting_type',
       'join_before_host',
       'mute_upon_entry',
       'enforece_login',
       'auto_recording',
       'join_url',
       'start_url',
       'live_status',
       'zoom_api'
      


    ];

    public function classname(){
        return $this->belongsTo('App\ClassName','class');
    }
    public function branchname(){
        return $this->belongsTo('App\Branch','branch');
    }
    public function batchname(){
        return $this->belongsTo('App\Batch','batch');
    }
    public function subjectname(){
        return $this->belongsTo('App\Subject','subject');
    }
    public function teacher(){
        return $this->belongsTo('App\Admin','teacher_id');
    }
     public function zoom(){
        return $this->belongsTo('App\ZoomApi','zoom_api');
    }
}
