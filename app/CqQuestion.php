<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CqQuestion extends Model
{
    protected $fillable=[
       
       'exam_id',
       'question_number',
       'question_title',
       'mark',
       'image',
    ];
    
}
