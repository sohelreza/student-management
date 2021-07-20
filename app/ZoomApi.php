<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoomApi extends Model
{
    protected $fillable=[

        'zoom_api_key',
        'zoom_api_secret',
     
    ];
}
