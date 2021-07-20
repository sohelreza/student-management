<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class AdminDueSMSController extends Controller
{
    public function index()
    {
        return view('admin.dueSms.addSMS');
    }


    public function store(Request $request)
    {
    	$request->validate([
            
            'student_type' => 'required',
            'branch' => 'required',
            'class' => 'required',
            'batch' => 'required',
                
        ]);

        // $students=User::with('paymentLast')
        //                 ->where('student_type',$request->student_type)
        //                 ->where('class_id',$request->class)
        //                 ->where('branch_id',$request->branch)
        //                 ->where('batch_id',$request->batch)
        //                 // ->where('payment_last.due_amount','>',0 )
        //                 // ->limit(1)
        //                 ->count();

        $students=DB::table('users')
                     // ->join('student_payments', 'student_payments.student_id', '=', 'users.id')
                      ->leftJoin('student_payments', function ($query) {
                            $query->on('student_payments.student_id', '=', 'users.id')
                                 // ->orderBy('student_payments.id','DESC');
                                   // ->on('student_payments.student_id','=',DB::raw("(SELECT max(student_id) from student_payments WHERE student_payments.student_id = users.id)"));
                            ->whereRaw('student_payments.id IN (select MAX(a2.id) from student_payments as a2 join users as u2 on u2.id = a2.student_id group by u2.id)');
                                 
                      })
                     ->where('users.student_type',$request->student_type)
                     ->where('users.class_id',$request->class)
                     ->where('users.branch_id',$request->branch)
                     ->where('users.batch_id',$request->batch)
                     ->where('due_amount','>',0)
                     // ->limit(1)
                     ->get();

        foreach ($students as $student) {
            
            $url = "http://66.45.237.70/api.php";
            $number=$student->phone;
            
            $text=$student->first_name.' '.$student->last_name.' Registration No: '.$student->registration_id.' Total Amount: '.$student->total_amount.' Paid Amount: '.$student->paid_amount.' Due Amount: '.$student->due_amount.' '.$request->message.' - Shadow Aide And Life Line';
            
            $username="01918184015";
            $password="FB72C69Z";
            $data= array(
            'username'=>$username,
            'password'=>$password,
            'number'=>"$number",
            'message'=>"$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|",$smsresult);
            $sendstatus = $p[0];
        }


        $request->session()->flash('success', 'SMS Sent Successfully');
        return redirect('admin/dueSms/');
       
            

                     
    }
}
