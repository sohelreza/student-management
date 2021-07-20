<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sms;
use Session;
use App\User;

class AdminSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=Sms::all();
        return view('admin.sms.smsList',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.sms.addSMS');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->all_student) {
                
                $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'all_student' => 'required',
            ]);

                $message=new Sms;
        
                $message->title=$request->title;
                $message->date=$request->date;
                $message->message=$request->message;
                $message->all_student=$request->all_student;
                $message->student_type=null;
                $message->branch=null;
                $message->class=null;
                $message->batch=null;
                $message->save();

                //POST Method example

                // $url = "http://66.45.237.70/api.php";
                // $number="8801939853091,01930312161";
                // $text=$request->message;
                // $username="01918184015";
                // $password="FB72C69Z";
                // $data= array(
                // 'username'=>$username,
                // 'password'=>$password,
                // 'number'=>"$number",
                // 'message'=>"$text"
                // );

                // $ch = curl_init(); // Initialize cURL
                // curl_setopt($ch, CURLOPT_URL,$url);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $smsresult = curl_exec($ch);
                // $p = explode("|",$smsresult);
                // $sendstatus = $p[0];


                //Send SMS  from your database using php

              

                $students=User::all();
                $x = '';

                foreach ($students as $student) {
                    
                    $numbers=$student->phone;
                    $x = $x.$number.","; //number separated by comma
                }

                
                $text=$request->message;
                $username="01918184015";
                $password="FB72C69Z";

                $url = "http://66.45.237.70/api.php";
                $data= array(
                'username'=>$username,
                'password'=>$password,
                'number'=>"$x",
                'message'=>"$text"
                );

                $ch = curl_init(); // Initialize cURL
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $smsresult = curl_exec($ch);
                $p = explode("|",$smsresult);
                $sendstatus = $p[0];
        

        } else {
            
            $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'student_type' => 'required',
                'branch' => 'required',
                'class' => 'required',
                'batch' => 'required',
                
            ]);

            $message=new Sms;
        
            $message->title=$request->title;
            $message->date=$request->date;
            $message->message=$request->message;
            $message->all_student=null;
            $message->student_type=$request->student_type;
            $message->branch=$request->branch;
            $message->class=$request->class;
            $message->batch=$request->batch;
            $message->save();

            $students=User::where('student_type',$request->student_type)
                           ->where('class_id',$request->class)
                           ->where('branch_id',$request->branch)
                           ->where('batch_id',$request->batch)
                           ->get();
                
                $x = '';

                foreach ($students as $student) {
                    
                    $number=$student->phone;
                    $x = $x.$number.","; //number separated by comma
                }

                
                $text=$request->message;
                $username="01918184015";
                $password="FB72C69Z";

                $url = "http://66.45.237.70/api.php";
                $data= array(
                'username'=>$username,
                'password'=>$password,
                'number'=>"$x",
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

        $request->session()->flash('success', 'Message Successfully Sent');
        return redirect('admin/sms');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
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
        $message = Sms::findOrFail($id);
        $message->delete();
        return redirect('admin/sms/');
    }
}
