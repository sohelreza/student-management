<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
     protected $fillable=[
     
       'expense_head_id',
       'name',
       'date',
       'branch_id',
       'amount',
       'document'
    ];

    public function admin(){
        return $this->belongsTo('App\Admin','expense_head_id');
    }

    public function branch(){
        return $this->belongsTo('App\Branch','branch_id');
    }
}
