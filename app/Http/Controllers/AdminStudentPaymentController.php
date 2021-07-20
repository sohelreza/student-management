<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StudentPayment;
use Carbon\Carbon;
use App\StudentSubject;

class AdminStudentPaymentController extends Controller
{
    public function list(){

        
        $payments=StudentPayment::orderBy('id','desc')->get();
        return view('admin.payment.paymentList',compact('payments'));


    }

    public function approvedOnlinelist(){

        
        $payments=StudentPayment::where('student_type',1)
                                  ->whereRaw('admin_transaction_id','transaction_id')
                                  ->orderBy('id','desc')
                                  ->get();
        return view('admin.payment.approvedPaymentList',compact('payments'));


    }


    
    public function pendingOnlineList(){

        
        $payments=StudentPayment::where('student_type',1)->where('admin_transaction_id',null)->orderBy('id','desc')->get();
        return view('admin.payment.pendingPaymentList',compact('payments'));


    }


    public function onlinePaymentApproval($id){

        
        $payment=StudentPayment::where('id',$id)->first();
        return view('admin.payment.onlinePaymentApproval',compact('payment'));


    }

    public function onlinePaymentApprovalCreate(Request $request){

        
         $request->validate([
           
            'transaction_id'=>'required',
            'admin_transaction_id'=> 'required',
            'confirm_admin_transaction_id' => 'required|same:admin_transaction_id',
        ]);

       
        $payment=StudentPayment::find($request->payment_id);
        $student=User::find($payment->student_id);
        $total_amount=$payment->total_amount;

        if ($student->next_payment_date  == null) {
             
             $current_payment_date = Carbon::now();
             $next_payment_date = Carbon::now()->day(10)->addMonth(1);
        	
        } else {

        	$current_payment_date = Carbon::now();
            $date = new Carbon($student->next_payment_date);
            $next_payment_date = $date->day(10)->addMonth(1);
        	
        }
        

       
       

        if ($payment->transaction_id == $request->admin_transaction_id) {
        	
            //Update payment
        	$payment->admin_transaction_id=$request->admin_transaction_id;
        	$payment->payment_date=$current_payment_date;
        	$payment->paid_amount=$total_amount;
        	$payment->due_amount=0;
        	$payment->save();

            //Update Subject

            $student_subjects=StudentSubject::where('student_id',$student->id)->where('status',1)->get(); 

            foreach ($student_subjects as $subject) {
                    
                $subject->update([

                    'start_date'=>$current_payment_date,
                    'end_date'=>$next_payment_date,
                                
                ]);
            } 
                   
            

            //Update Student

        	$student->current_payment_date=$current_payment_date;
        	$student->next_payment_date=$next_payment_date;
        	$student->save();

        	$request->session()->flash('success', 'Transaction Id Matched And Student Registration Approved');
            return redirect('admin/pending_online_student_payments');



        } else {
        	
           $request->session()->flash('success', 'Transaction ID Did not Match');
            return back();
        }
        


    }
}
