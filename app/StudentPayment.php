<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable = [
        
        'student_id',
        'branch_id',
        'class_id',
        'batch_id',
        'student_type',
        'total_amount',
        'paid_amount',
        'due_amount',
        'payment_date',
        'transaction_id',
        'admin_transaction_id'
        

    ];

    public function student(){
    	return $this->belongsTo('App\User');
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

     public function installments(){
        return $this->hasMany('App\StudentPaymentInstallment','student_payment_id');
    }
}
