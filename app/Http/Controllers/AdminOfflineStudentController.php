<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StudentPayment;
use App\StudentPaymentInstallment;
use App\Branch;
use Illuminate\Support\Facades\Hash;
use Str;
use DB;
use Nexmo\Laravel\Facade\Nexmo;
use App\StudentSubject;
use Carbon\Carbon;
use App\ClassName;
use PDF;
use Auth;

class AdminOfflineStudentController extends Controller
{
    public function list()
    {
        $students=User::where('student_type', 0)
                       ->with(['subjects' => function ($query) {
                           $query->where('status', '=', '1');
                       }])
                       ->get();
        
       
       
        return view('admin.offline.studentList', compact('students'));
    }

    public function listSearch(Request $request)
    {
        $request_student_type=$request->student_type;
        $request_branch=$request->branch_id;
        $request_class=$request->class_id;
        $request_batch=$request->batch_id;

        $students=User::where('student_type', 0)
                       ->with(['subjects' => function ($query) {
                           $query->where('status', '=', '1');
                       }])
                       ->where('student_type', $request_student_type)
                       ->where('branch_id', $request_branch)
                       ->where('class_id', $request_class)
                       ->where('batch_id', $request_batch)
                       ->get();

        return view('admin.offline.studentListSearch', compact('students', 'request_student_type', 'request_branch', 'request_class', 'request_batch'));
    }

    public function listSearchPdf(Request $request)
    {
        $request_student_type=$request->request_student_type;
        $request_branch=$request->request_branch_id;
        $request_class=$request->request_class_id;
        $request_batch=$request->request_batch_id;

        $students=User::where('student_type', 0)
                       ->with(['subjects' => function ($query) {
                           $query->where('status', '=', '1');
                       }])
                       ->where('student_type', $request_student_type)
                       ->where('branch_id', $request_branch)
                       ->where('class_id', $request_class)
                       ->where('batch_id', $request_batch)
                       ->get();
        
        // dd($students);

        $pdf = PDF::loadView('admin.offline.studentPdf', compact('students', 'request_student_type', 'request_branch', 'request_class', 'request_batch'));
        return $pdf->stream('StudentList.pdf');
    }


    public function add_student()
    {
        $branches=Branch::where('student_type', 0)
                            ->orWhere('student_type', 2)
                            ->get();
       
        return view('admin.offline.addStudent', compact('branches'));
    }

    public function create_student(Request $request)
    {

        // return $request->all();

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|min:11|numeric|unique:users',
            'class_id' => 'required',
            'branch_id' => 'required',
            'batch_id' => 'required',
            'subject_id'=>'required|filled',
            'total_amount' => 'required|gt:0',
            'paid_amount' => 'required',
            'next_payment_date' => 'required|date',
        ]);

        $lastStudent = DB::table('users')->orderBy('created_at', 'desc')->first();
        $year=date('y');
        $class=ClassName::find($request->class_id);
        $hsc_year=$class->year;
        if ($lastStudent  == null) {
            $registration_id=$hsc_year.$year.'0001';
        } else {
            $student=DB::table('users')
                        ->where('registration_id', 'LIKE', $hsc_year.'%')
                        ->orderBy('created_at', 'desc')
                        ->first();

            if (empty($student)) {
                $registration_id=$hsc_year.$year.'0001';
            } else {
                $number = substr($student->registration_id, 4);
                $registration_id= $hsc_year.$year.sprintf('%04d', intval($number) + 1);
            }
        }


        $request['registration_id']=$registration_id;

        $password=Str::random(8);
        
        // $password='12345678';
        $hashed_random_password = Hash::make($password);
        $request['password']=$hashed_random_password;

        $date_of_addmission = Carbon::now();
        $request['date_of_addmission']=$date_of_addmission;
        $request['current_payment_date']=$date_of_addmission;
        $request['next_payment_date']=$request->next_payment_date;
        $request['student_type']=0;

        $admin=Auth::guard('admin')->user();
        $request['admin_id']=$admin->id;
        
        $day = Carbon::now()->day;
        $month = Carbon::now()->month;
        $year = Carbon::now()->format('y');
        $prefix=$day.$month.$year;
        $request['form_number']=$prefix.mt_rand(000001, 999999);

        
        // POST Method example

        $url = "http://66.45.237.70/api.php";
        $number=$request->phone;
        $text='Registration ID:'.$registration_id.' Password: '.$password;
        $username="01918184015";
        $password="FB72C69Z";
        $data= array(
                'username'=>$username,
                'password'=>$password,
                'number'=>"$number",
                'message'=>"$text"
                );

        $ch = curl_init(); // Initialize cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);
        $p = explode("|", $smsresult);
        $sendstatus = $p[0];

        $user=User::create($request->all());
        session(['user_id'=>$user->id]);
        $user_id=session('user_id');


        $student_payment=new StudentPayment;
        $student_payment->student_id=$user_id;
        $student_payment->branch_id=$request->branch_id;
        $student_payment->batch_id=$request->batch_id;
        $student_payment->class_id=$request->class_id;
        $student_payment->student_type=0;
        $student_payment->total_amount=$request->total_amount;
        $student_payment->paid_amount=$request->paid_amount;
        $student_payment->due_amount=$request->total_amount-$request->paid_amount;
        $student_payment->payment_date=$date_of_addmission;
        $student_payment->transaction_id=0;
        $student_payment->admin_transaction_id=0;
        $student_payment->save();


        session(['student_payment_id'=>$student_payment->id]);
        $student_payment_id=session('student_payment_id');


        $student_payment_installment=new StudentPaymentInstallment;
        $student_payment_installment->student_payment_id=$student_payment_id;
        $student_payment_installment->amount=$request->paid_amount;
        $student_payment_installment->payment_date=$date_of_addmission;
        $student_payment_installment->save();


        foreach ($request->subject_id as $key => $value) {
            StudentSubject::create(
                [
                         'student_id'=>$user_id,
                         'class_id'=>$request->class_id,
                         'batch_id'=>$request->batch_id,
                         'branch_id'=>$request->branch_id,
                         'student_type'=>$request->student_type,
                         'subject_id'=>$request->subject_id[$key],
                         'start_date'=>$date_of_addmission,
                         'end_date'=>$request->next_payment_date,
                         'status'=>'1',
                        ]
            );
        }

        return redirect('/admin/offline_students');
    }

    public function edit_student($id)
    {
        $branches=Branch::where('student_type', 0)
                            ->orWhere('student_type', 2)
                            ->get();

        $student=User::where('id', $id)
                       ->with(['subjects'=>function ($query) {
                           $query->where('status', '=', '1');
                       }])
                       ->first();
         
        return view('admin.offline.editStudent', compact('branches', 'student'));
    }

    public function update_offline_student(Request $request, $id)
    {
        $student=User::find($id);
        
        $request->validate([

            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|min:11|numeric|unique:users,phone,'.$student->id,
            'class_id' => 'required',
            'branch_id' => 'required',
            'batch_id' => 'required',
            'subject_id'=>'required|filled',
            'total_amount' => 'required|gt:0',
            // 'paid_amount' => 'required',
            'next_payment_date' => 'required|date',
        ]);


        

        $user=User::find($id);

        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->phone=$request->phone;
        
        $user->batch_id=$request->batch_id;
        $user->branch_id=$request->branch_id;
        $user->class_id=$request->class_id;
        // $user->current_payment_date=$current_payment_date;
        $user->next_payment_date=$request->next_payment_date;
        $user->save();


        $student_payment=StudentPayment::where('student_id', $user->id)->orderBy('id', 'desc')->first();

        $student_payment->branch_id=$request->branch_id;
        $student_payment->batch_id=$request->batch_id;
        $student_payment->class_id=$user->class_id;

        if ($student_payment->total_amount==$request->total_amount) {
            # code...
        } elseif ($request->total_amount > $student_payment->total_amount) {
            $student_payment->due_amount=$student_payment->due_amount+($request->total_amount - $student_payment->total_amount);
            $student_payment->total_amount=$student_payment->total_amount+($request->total_amount - $student_payment->total_amount);
        } elseif ($request->total_amount < $student_payment->total_amount) {
            $student_payment->due_amount=$student_payment->due_amount+($request->total_amount - $student_payment->total_amount);
            $student_payment->total_amount=$student_payment->total_amount+($request->total_amount - $student_payment->total_amount);
        }

        $student_payment->save();
        
       
        // $student_payment->total_amount=$request->total_amount;
        // $student_payment->due_amount=$request->total_amount-$request->paid_amount;
              
        // $student_payment->payment_date=$current_payment_date;
        // $student_payment->transaction_id=0;
        



        // $student_payment=new StudentPayment;
        // $student_payment->student_id=$user->id;
        // $student_payment->branch_id=$request->branch_id;
        // $student_payment->batch_id=$request->batch_id;
        // $student_payment->class_id=$user->class_id;
        // $student_payment->student_type=$user->student_type;
              
        // $student_payment->total_amount=$request->total_amount;
        // $student_payment->paid_amount=$request->paid_amount;
        // $student_payment->due_amount=$request->total_amount-$request->paid_amount;
              
        // $student_payment->payment_date=$current_payment_date;
        // $student_payment->transaction_id=0;
        // $student_payment->save();


        // session(['student_payment_id'=>$student_payment->id]);
        // $student_payment_id=session('student_payment_id');


        // $student_payment_installment=new StudentPaymentInstallment;
        // $student_payment_installment->student_payment_id=$student_payment_id;
        // $student_payment_installment->amount=$request->paid_amount;
        // $student_payment_installment->payment_date=$current_payment_date;
        // $student_payment_installment->save();


        $student_subject=StudentSubject::where('student_id', $user->id)->where('status', 1)->delete();
        foreach ($request->subject_id as $key => $value) {
            StudentSubject::create(
                [
                         'student_id'=>$user->id,
                         'class_id'=>$request->class_id,
                         'batch_id'=>$request->batch_id,
                         'branch_id'=>$request->branch_id,
                         'student_type'=>$user->student_type,
                         'subject_id'=>$request->subject_id[$key],
                         // 'start_date'=>$current_payment_date,
                         'end_date'=>$request->next_payment_date,
                         'status'=>'1',
                        ]
            );
        }


        return redirect('/admin/offline_students');
    }



    public function offline_payments($id)
    {
        $payments=StudentPayment::where('student_id', $id)->get();

        return view('admin.offline.offlinePayment', compact('payments'));
    }

    public function add_student_course($id)
    {
        $branches=Branch::where('student_type', 0)
                            ->orWhere('student_type', 2)
                            ->get();

        $student=User::where('id', $id)
                       ->with(['subjects'=>function ($query) {
                           $query->where('status', '=', '1');
                       }])
                       ->first();
         
        // return $student;
       
        return view('admin.offline.addStudentPayment', compact('branches', 'student'));
    }

    public function create_offline_student_course(Request $request, $id)
    {
        $request->validate([
                   
            'class_id' => 'required',
            'branch_id' => 'required',
            'batch_id' => 'required',
            'subject_id'=>'required|filled',
            'total_amount' => 'required|gt:0',
            'paid_amount' => 'required',
            'next_payment_date' => 'required|date',
        ]);


        $current_payment_date = Carbon::now();

        $user=User::find($id);
        $user->batch_id=$request->batch_id;
        $user->branch_id=$request->branch_id;
        $user->class_id=$request->class_id;
        $user->current_payment_date=$current_payment_date;
        $user->next_payment_date=$request->next_payment_date;
        $user->save();


        $student_payment=new StudentPayment;
        $student_payment->student_id=$user->id;
        $student_payment->branch_id=$request->branch_id;
        $student_payment->batch_id=$request->batch_id;
        $student_payment->class_id=$user->class_id;
        $student_payment->student_type=$user->student_type;
              
        $student_payment->total_amount=$request->total_amount;
        $student_payment->paid_amount=$request->paid_amount;
        $student_payment->due_amount=$request->total_amount-$request->paid_amount;
              
        $student_payment->payment_date=$current_payment_date;
        $student_payment->transaction_id=0;
        $student_payment->admin_transaction_id=0;
        $student_payment->save();


        session(['student_payment_id'=>$student_payment->id]);
        $student_payment_id=session('student_payment_id');


        $student_payment_installment=new StudentPaymentInstallment;
        $student_payment_installment->student_payment_id=$student_payment_id;
        $student_payment_installment->amount=$request->paid_amount;
        $student_payment_installment->payment_date=$current_payment_date;
        $student_payment_installment->save();


        $student_subject=StudentSubject::where('student_id', $user->id)->where('status', 1)->update(['status' => 0]);
        foreach ($request->subject_id as $key => $value) {
            StudentSubject::create(
                [
                         'student_id'=>$user->id,
                         'class_id'=>$request->class_id,
                         'batch_id'=>$request->batch_id,
                         'branch_id'=>$request->branch_id,
                         'student_type'=>$user->student_type,
                         'subject_id'=>$request->subject_id[$key],
                         'start_date'=>$current_payment_date,
                         'end_date'=>$request->next_payment_date,
                         'status'=>'1',
                        ]
            );
        }


        return redirect('/admin/offline_students');
    }


    public function offline_payment_installments($id)
    {
        $installments=StudentPaymentInstallment::where('student_payment_id', $id)->get();

        return view('admin.offline.offlinePaymentInstallment', compact('installments'));
    }

    public function add_offline_payment_installment($id)
    {
        $payment=StudentPayment::where('id', $id)->first();
        $student=User::where('id', $payment->student_id)->first();

        return view('admin.offline.addOfflinePaymentInstallment', compact('payment', 'student'));
    }


    public function create_offline_payment_installment(Request $request, $id)
    {
        $request->validate([
                   
            'paid_amount' => 'required',
            'next_payment_date' => 'required|date',
        ]);

        $payment=StudentPayment::where('id', $id)->first();
        $student=User::where('id', $payment->student_id)->first();

        //Edit Student
        $current_payment_date = Carbon::now();
        $student->current_payment_date=$current_payment_date;
        $student->next_payment_date=$request->next_payment_date;
        $student->save();


        //Edit Subject
        $student_subjects=StudentSubject::where('student_id', $student->id)->where('status', 1)->get();

        foreach ($student_subjects as  $subject) {
            $subject->update([

                
                'end_date'=>$request->next_payment_date
                            
            ]);
        }

        //Edit Payment

        $student_payment=StudentPayment::find($id);
        $student_payment->paid_amount=$student_payment->paid_amount+$request->paid_amount;
        $student_payment->due_amount=$student_payment->due_amount-$request->paid_amount;
        $student_payment->payment_date=$current_payment_date;
        $student_payment->save();


        // Add installment
        $student_payment_installment=new StudentPaymentInstallment;
        $student_payment_installment->student_payment_id=$id;
        $student_payment_installment->amount=$request->paid_amount;
        $student_payment_installment->payment_date=$current_payment_date;
        $student_payment_installment->save();


        return redirect('/admin/offline_students');
    }

    public function edit_offline_payment_installment($id)
    {
        $payment_installment=StudentPaymentInstallment::where('id', $id)->first();
        $payment=StudentPayment::where('id', $payment_installment->student_payment_id)->first();
        $student=User::where('id', $payment->student_id)->first();

        return view('admin.offline.editOfflinePaymentInstallment', compact('payment_installment', 'payment', 'student'));
    }

    public function update_offline_payment_installment(Request $request, $id)
    {
        $request->validate([
                   
            'paid_amount' => 'required',
        ]);

        $student_payment_installment=StudentPaymentInstallment::where('id', $id)->first();
        
        $payment=StudentPayment::where('id', $student_payment_installment->student_payment_id)->first();

        
        if ($request->paid_amount == $student_payment_installment->amount) {
        } elseif ($request->paid_amount > $student_payment_installment->amount) {
            $payment->due_amount=$payment->due_amount-($request->paid_amount - $student_payment_installment->amount);
            $payment->paid_amount=$payment->paid_amount+($request->paid_amount - $student_payment_installment->amount);
            $payment->save();
        } elseif ($request->paid_amount < $student_payment_installment->amount) {
            $payment->due_amount=$payment->due_amount-($request->paid_amount - $student_payment_installment->amount);
            $payment->paid_amount=$payment->paid_amount+($request->paid_amount - $student_payment_installment->amount);
            $payment->save();
        }

        $student_payment_installment->amount=$request->paid_amount;
        $student_payment_installment->save();

        return redirect('/admin/offline_students');
    }


    public function offline_payment_list()
    {
        $payments=StudentPaymentInstallment::with('payment')->orderBy('id', 'desc')->get();
        return view('admin.payment.offlinePaymentList', compact('payments'));
    }

    public function offline_student_registration_pdf($id)
    {
        $student=User::find($id);
        $student_subjects=StudentSubject::where('student_id', $id)->where('status', 1)->get();
        $student_payment=StudentPayment::where('student_id', $id)->first();

        $pdf = PDF::loadView('admin.offline.pdfRegistration', compact('student', 'student_subjects', 'student_payment'));
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('Registartion.pdf');
    }

    public function offline_payment_invoice($id)
    {
        $student_payment = StudentPayment::find($id);
        $student_payment_installments = StudentPaymentInstallment::where('student_payment_id', $id)->get();
        $student = User::find($student_payment->student_id);
        $student_subjects = StudentSubject::where('student_id', $student->id)->where('status', 1)->get();
        // dd($student_payment_installments);

        $pdf = PDF::loadView('admin.offline.pdfPaymentInvoice', compact('student', 'student_subjects', 'student_payment', 'student_payment_installments'));

        return $pdf->stream('Payment Invoice.pdf');
    }


    // public function offline_due_sms()
    // {
    //     $students=User::where('student_type', 0)
    //                 ->with('paymentLast')
    //                 ->whereDate('next_payment_date', '<=', Carbon::now()->addDays(1))
    //                 ->get();

    //     return $students;
    // }
}
