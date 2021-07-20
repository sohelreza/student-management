<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{ 
    use Notifiable;


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
        'date_of_addmission',
        'current_payment_date',
        'next_payment_date',
        'form_number',
        'admin_id'

    ];

     public function subjects(){
        return $this->hasMany('App\StudentSubject','student_id');
    }

    public function payments(){
        return $this->hasMany('App\StudentPayment','student_id');
    }

     public function paymentLast(){
        return $this->hasOne('App\StudentPayment','student_id')->latest();
    }

    public function profile(){
        return $this->hasOne('App\StudentProfile','student_id');
    }

    public function classname(){
        return $this->belongsTo('App\ClassName','class_id');
    }

     public function batch(){
        return $this->belongsTo('App\Batch','batch_id');
    }

     public function branch(){
        return $this->belongsTo('App\Branch','branch_id');
    }

    public function admin(){
        return $this->belongsTo('App\Admin','admin_id');
    }

   


     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}
