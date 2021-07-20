<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class McqOption extends Model
{

     protected $fillable=[
       
       'question_id',
       'option_number',
       'option_title',
       'right_answer'
     
    ];

    public function question(){
      return $this->belongsTo('App\McqQuestion');
    }
}
