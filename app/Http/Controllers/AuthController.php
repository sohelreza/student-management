<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Str;
use DB;
use Nexmo\Laravel\Facade\Nexmo;
use App\StudentPayment;
use App\StudentSubject;
use Carbon\Carbon;
use App\ClassName;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','registration','forgotpassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function registration(Request $request){


        // return response($request->all());

    	$request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|min:11|numeric|unique:users',
            'class_id' => 'required',
            'branch_id' => 'required',
            'batch_id' => 'required',
            'student_type' => 'required',
            'subject_id'=>'required|filled'
        ]);



        $lastStudent = DB::table('users')->orderBy('created_at', 'desc')->first();
        // $year=date('Y');
        $year=date('y');
        $class=ClassName::find($request->class_id);
        $hsc_year=$class->year;
            if($lastStudent  == null){
            	
                $registration_id=$hsc_year.$year.'0001';
                
            }else{

                $student=DB::table('users')
                        ->where('registration_id','LIKE',$hsc_year.'%')
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
        $next_payment_date = Carbon::now()->day(10)->addMonth(1);
        $request['date_of_addmission']=$date_of_addmission;
        $request['current_payment_date']=null;

        $day = Carbon::now()->day;
        $month = Carbon::now()->month;
        $year = Carbon::now()->format('y');
        $prefix=$day.$month.$year;
        $request['form_number']=$prefix.mt_rand(000001,999999);

        if ($request->student_type == 1) {
             $request['next_payment_date']=null;
        } elseif($request->student_type == 0) {
            $request['next_payment_date']=$request->next_payment_date;
        }
        
        //POST Method example

                $url = "http://66.45.237.70/api.php";
                $number=$request->phone;
                $text='Your Registration ID:'.$registration_id.' Password: '.$password;
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

        // $request['password']=$password;

        $user=User::create($request->all());
        session(['user_id'=>$user->id]);
        $user_id=session('user_id');

        if($request->student_type == 1){

          $student_payment=new StudentPayment;
          $student_payment->student_id=$user_id;
          $student_payment->branch_id=$request->branch_id;
          $student_payment->batch_id=$request->batch_id;
          $student_payment->class_id=$request->class_id;
          $student_payment->student_type=$request->student_type;
          $student_payment->total_amount=$request->total_amount;
          $student_payment->paid_amount=0;
          $student_payment->due_amount=$request->total_amount;
          $student_payment->payment_date=null;
          $student_payment->transaction_id=null;
          
          $student_payment->save();

        }elseif($request->student_type == 0){

          $student_payment=new StudentPayment;
          $student_payment->student_id=$user_id;
          $student_payment->branch_id=$request->branch_id;
          $student_payment->batch_id=$request->batch_id;
          $student_payment->class_id=$request->class_id;
          $student_payment->student_type=$request->student_type;
          $student_payment->total_amount=$request->total_amount;
          $student_payment->paid_amount=$request->paid_amount;
          $student_payment->due_amount=$request->total_amount-$request->paid_amount;
          $student_payment->payment_date=$date_of_addmission;
          $student_payment->transaction_id=0;
          $student_payment->save();
        }


        foreach ($request->subject_id as $key => $value) {

                if ($request->student_type == 1) {
                    StudentSubject::create(
                        [
                         'student_id'=>$user_id,
                         'class_id'=>$request->class_id,
                         'batch_id'=>$request->batch_id,
                         'branch_id'=>$request->branch_id,
                         'student_type'=>$request->student_type,
                         'subject_id'=>$request->subject_id[$key],
                         'start_date'=>null,
                         'end_date'=>null,
                         'status'=>'1',
                        ]
                                
                    );
                } elseif($request->student_type == 0) {
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
        }
        
        return response()->json('Done');
    }

    public function login()
    {
    	// return response()->json($request->all());
        $credentials = request(['registration_id', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Registration or Password Invalid'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            
        ]);
    }


    public function payload(){

    	return auth()->payload();
    }

    public function forgotpassword(Request $request)
    {

        $request->validate([
            
            'phone' => 'required|min:11|numeric',
          
        ]);
       
        $phone=$request->phone;

        $student=User::where('phone',$phone)->first();

        if($student){
              
              $password=Str::random(8);
              $hashed_random_password = Hash::make($password);
              $student->update(['password'=>$hashed_random_password]);


              $url = "http://66.45.237.70/api.php";
              $number=$phone;
              
              $text='Hello '.$student->first_name.' '.$student->last_name.' Your Registration ID: '.$student->registration_id.' Password: '.$password;
              
              $username="01918184015";
              $password="FB72C69Z";
              $data= array(
                'username'=>$username,
                'password'=>$password,
                'number'=>"$number",
                'message'=>"$text"
              );

              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,$url);
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $smsresult = curl_exec($ch);
              $p = explode("|",$smsresult);
              $sendstatus = $p[0];

              return response('Your Password Has Been Sent');

        }else{
             return response()->json(['error' => 'Your Mobile Number Not Registered'], 401);
        }
        
    }

    
}