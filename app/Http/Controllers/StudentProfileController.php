<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentProfile;
use JWTAuth;
use App\User;
use App\StudentPayment;
use App\StudentSubject;
use App\PaymentInstruction;
use Auth;
use Hash; 
use App\Admin;
use File;


class StudentProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUser()
    {

        $user = JWTAuth::parseToken()->authenticate();
        $user['user_profile']=$user->profile;
        $user['user_payments']=$user->payments;
        $user['user_subjects']=$user->subjects;
        
        return response()->json($user);
    
    }

    public function getInfo(Request $request)
    {

        $user = User::with('classname')
                     ->with('branch')
                     ->with('batch')
                     ->with('profile')

        ->where('id',$request->student_id)
        ->first();


        
        return response()->json($user);
    
    }


     public function getPayment(Request $request)
    {

        $user_payment = StudentPayment::with('classname')
                                        ->with('branch')
                                        ->with('batch')
                        ->where('student_id',$request->student_id)
        ->get();


        
        return response()->json($user_payment);
    
    }

    public function getSubject(Request $request)
    {

        $user = StudentSubject::with('subject')
                     

        ->where('student_id',$request->student_id)
        ->where('status',1)
        ->get();


        
        return response()->json($user);
    
    }

     public function getTeacher(Request $request)
    {

        $teacher = Admin::where('role_id',4)
                     ->get();


        
        return response()->json($teacher);
    
    }

    public function paymentInstruction()
    {

        $instruction=PaymentInstruction::first();


        
        return response()->json($instruction);
    
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
        $request->validate([

            
            'date_of_birth' => 'required',
            'gender' => 'required',
            'institution' => 'required',
            // 'zoom_id'=>'required',
            'father_name' => 'required',
            'father_phone' => 'required|min:11|numeric',
            'mother_name' => 'required',
            'mother_phone' => 'required|min:11|numeric',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'gaurdian_name' => 'required',
            'gaurdian_relation' => 'required',
            'gaurdian_phone' => 'required|min:11|numeric',
            'gaurdian_address' => 'required',

        ]);


        // $user = JWTAuth::parseToken()->authenticate();
        $request['student_id']=$request->student_id;

        if($file=$request->file('image')){
           
            $image=time().$file->getClientOriginalName();
            $file->move('studentImage',$image);
            $request['image']=$image;
        }

        StudentProfile::create($request->all());
        return response($request);
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
        $request->validate([

            
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'institution' => 'required',
            'father_name' => 'required',
            'father_phone' => 'required|min:11|numeric',
            'mother_name' => 'required',
            'mother_phone' => 'required|min:11|numeric',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'gaurdian_name' => 'required',
            'gaurdian_relation' => 'required',
            'gaurdian_phone' => 'required|min:11|numeric',
            'gaurdian_address' => 'required',
        ]);

        $user = User::find($id);
        $user->first_name=$request->first_name;
        $user->last_name=$request->last_name;
        $user->save();

        $user_profile=$user->profile;

        $user_profile->date_of_birth=$request->date_of_birth;
        $user_profile->gender=$request->gender;
        $user_profile->zoom_id=$request->zoom_id;
        $user_profile->institution=$request->institution;
        $user_profile->father_name=$request->father_name;
        $user_profile->father_phone=$request->father_phone;
        $user_profile->mother_name=$request->mother_name;
        $user_profile->mother_phone=$request->mother_phone;
        $user_profile->present_address=$request->present_address;
        $user_profile->permanent_address=$request->permanent_address;
        $user_profile->gaurdian_name=$request->gaurdian_name;
        $user_profile->gaurdian_relation=$request->gaurdian_relation;
        $user_profile->gaurdian_phone=$request->gaurdian_phone;
        $user_profile->gaurdian_address=$request->gaurdian_address;
        $user_profile->save();
        
        if($file=$request->file('image')){
           
            $usersImage = public_path("studentImage/{$user->image}");
            if (File::exists($usersImage)) {
                unlink($usersImage);
            }
            $image=time().$file->getClientOriginalName();
            $file->move('studentImage',$image);
            $request['image']=$image;
        }

        return response()->json('Updated');


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

    public function changePassword(Request $request){


        $request->validate([
           
            'old_password'=>'required',
            'new_password'=> 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = User::find($request->student_id);

        if ((Hash::check(request('old_password'), $user->password)) == false) {
            return response()->json(['error' => 'Check Your Old password'], 401);
        }else{
             User::where('id', $user->id)->update(['password'=>Hash::make($request->new_password)]);
             return response()->json('Done');
        }


        // return response($request);
        

    }

    public function imageAdd(Request $request){

        $request->validate([

            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            
        ]);

        $student_id=$request->student_id;

        $student_profile=StudentProfile::where('student_id',$student_id)->first();

        if (!$student_profile) {
             
             return response()->json('Profile Does Not Exists');
        }else{

            $file=$request->file('image');
            $image=time().$file->getClientOriginalName();
            $file->move('studentImage',$image);
            
            $student_profile->image=$image;
            $student_profile->save();
            return response()->json('Image Added');
        }

    }

    public function imageUpdate(Request $request){

        $request->validate([

            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            
        ]);

        $student_id=$request->student_id;

        $student_profile=StudentProfile::where('student_id',$student_id)->first();

        if (!$student_profile) {
             
             return response()->json('Profile Does Not Exists');
        }else{

            $usersImage = public_path("studentImage/{$student_profile->image}");
            if (File::exists($usersImage)) {
                unlink($usersImage);
            }
            
            $file=$request->file('image');
            $image=time().$file->getClientOriginalName();
            $file->move('studentImage',$image);
            
            $student_profile->image=$image;
            $student_profile->save();
            return response()->json('Image Updated');
        }

    }
}
