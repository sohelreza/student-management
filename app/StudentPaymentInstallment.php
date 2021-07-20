<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPaymentInstallment extends Model
{
     protected $fillable = [
        
        'student_payment_id',
        'amount',
        'payment_date',
       
        

    ];

    public function payment(){
        return $this->belongsTo('App\StudentPayment','student_payment_id');
    }
}
