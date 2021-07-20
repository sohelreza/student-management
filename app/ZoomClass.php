<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomClass extends Model
{
    protected $fillable=[
       
       'meeting_id',
       'password',
       'topic',
       'description',
       'when',
       'duration',
       'teacher_id',
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
}
