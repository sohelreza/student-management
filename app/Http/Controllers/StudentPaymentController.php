<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StudentPayment;
use App\StudentSubject;
use Carbon\Carbon;
use JWTAuth;


class StudentPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user_payments=$user->payments;
       
        return response()->json([$user,$user_payments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->student_type == 1) {
              
              $request->validate([
                
                'class_id' => 'required',
                'branch_id' => 'required',
                'batch_id' => 'required',
                'subject_id'=>'required|filled'
              
              ]); 

              $user = User::find($request->id);
              
              $current_payment_date = Carbon::now();
              $date = new Carbon($user->next_payment_date);
              $next_payment_date = $date->day(10)->addMonth(1);

              // date_add($date, date_interval_create_from_date_string('1 month'));
              // $next_payment_date = date_format($date, 'Y-m-d');
              // $next_payment_date = $user->next_payment_date->addMonth(1);

              // $current_payment_date = Carbon::now()->day(8)->addMonth(1);
              // $next_payment_date = Carbon::now()->day(10)->addMonth(2);
              
              $user = User::find($request->id);

              // if ($user->class_id != $request->class_id) {


              $student_subject=StudentSubject::where('student_id',$user->id)->where('status',1)->update(['status' => 0]); 

              foreach ($request->subject_id as $key => $value) {
                  
                    StudentSubject::Create([

                          'student_id'=>$user->id,
                          'branch_id'=>$request->branch_id,
                          'class_id'=>$request->class_id,
                          'batch_id'=>$request->batch_id,
                          'subject_id'=>$request->subject_id[$key],
                          'student_type'=>$request->student_type,
                          'start_date'=>null,
                          'end_date'=>null,
                          'status'=>1

                    ]);
                }
              
              // } else {

                  
                  // foreach ($request->subject_id as $key => $value) {
                   
                  // $student_subject=StudentSubject::where('student_id',$user->id)->where('subject_id',$request->subject_id[$key])->where('status',1)->first();  
                   
                  // if($student_subject){                                      
                               

                  //     $student_subject->update([

                  //       'class_id'=>$request->class_id,
                  //       'branch_id'=>$request->branch_id,
                  //       'batch_id'=>$request->batch_id,
                  //       'start_date'=>$current_payment_date,
                  //       'end_date'=>$next_payment_date,
                            
                  //     ]);
                  
                  // }else{

                  //     StudentSubject::Create([

                  //       'student_id'=>$user->id,
                  //       'branch_id'=>$request->branch_id,
                  //       'class_id'=>$request->class_id,
                  //       'batch_id'=>$request->batch_id,
                  //       'subject_id'=>$request->subject_id[$key],
                  //       'student_type'=>$request->student_type,
                  //       'start_date'=>$current_payment_date,
                  //       'end_date'=>$next_payment_date,
                  //       'status'=>1

                  //     ]);

                  // }             
              // }                   
                
              // }
              


              $user->class_id=$request->class_id;                     
              $user->batch_id=$request->batch_id;                     
              $user->branch_id=$request->branch_id;                     
              // $user->current_payment_date=$current_payment_date;                     
              // $user->next_payment_date=$next_payment_date; 
              $user->save(); 


              
              $student_payment=new StudentPayment;
              $student_payment->student_id=$user->id;
              $student_payment->branch_id=$request->branch_id;
              $student_payment->batch_id=$request->batch_id;
              $student_payment->class_id=$request->class_id;
              $student_payment->student_type=$user->student_type;
              $student_payment->total_amount=$request->total_amount;
              $student_payment->paid_amount=0;
              $student_payment->due_amount=$request->total_amount;
              $student_payment->payment_date=null;
              $student_payment->transaction_id=null;
              $student_payment->save();


      } elseif($request->student_type == 0) {
                $request->validate([
                   
                    'branch_id' => 'required',
                    'batch_id' => 'required',
                    'next_payment_date'=>'required|date'
                ]);

                $current_payment_date = Carbon::now();

                $user = JWTAuth::parseToken()->authenticate();
                
                $user=User::find($user->id);                    
                $user->batch_id=$request->batch_id;                     
                $user->branch_id=$request->branch_id;                     
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
              $student_payment->save();  


              foreach ($request->subject_id as $key => $value) {
                   
                  $student_subject=StudentSubject::where('student_id',$user->id)->where('subject_id',$request->subject_id[$key])->where('status',1)->first();  
                   
                      $student_subject->update([

                        'branch_id'=>$request->branch_id,
                        'batch_id'=>$request->batch_id,
                        'start_date'=>$current_payment_date,
                        'end_date'=>$request->next_payment_date,
                            
                      ]);
                  
                              
              } 


          }
    
        return response($request->subject_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addTransactionId(Request $request)
    {
       $student=User::find($request->student_id);

       // return response($request->all());
       $student_payment=StudentPayment::where('student_id',$request->student_id)->latest('id')->first();

       $student_payment->transaction_id=$request->transaction_id;
       $student_payment->save();

       return response($request->all());
    }
}
