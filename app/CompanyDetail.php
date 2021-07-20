<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    protected $fillable=[

        'name',
        'email',
        'phone',
        'address',
        'facebook',
        'establishDate',
        'logo',
        'favicon',
    ];
}
