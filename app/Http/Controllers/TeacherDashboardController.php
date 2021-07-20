<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Admin;
use App\Expense;
use Carbon\Carbon;
use App\StudentPayment;
use App\StudentPaymentInstallment;

class TeacherDashboardController extends Controller
{
    public function index(){

    	$student=User::get()->count();
        $admin=Admin::where('role_id',1)->get()->count();
        $teacher=Admin::where('role_id',4)->get()->count();
        $expense_month=Expense::whereMonth('date', Carbon::now()->month)->sum('amount');
        $online_payment=StudentPayment::where('student_type',1)->whereMonth('payment_date', Carbon::now()->month)->sum('paid_amount');
        $offline_payment=StudentPaymentInstallment::whereMonth('payment_date', Carbon::now()->month)->sum('amount');

    
        return view('teacher.dashboard.dashboard',compact('student','admin','teacher','online_payment','offline_payment','expense_month'));

    }
}
