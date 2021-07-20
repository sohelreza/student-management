<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
             'role_id','name','email', 'password',
    ];

    protected $hidden = [
            'password', 'remember_token',
    ];

     public function role(){
    	return $this->belongsTo('App\Role');
    }


}