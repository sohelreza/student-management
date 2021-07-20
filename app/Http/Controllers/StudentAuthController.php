<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Str;
use DB;
use App\Branch;
use App\Batch;
use App\ClassName;
use App\Subject;
use App\StudentPayment;

class StudentAuthController extends Controller
{
    public function registration(){
      
      $users=User::all();
      return response()->json($users);
       
    }

    public function searchBranch(Request $request){

           $student_type=$request->get('student_type');
           
           if ($student_type == 0) {
                
                $data=Branch::where('student_type',$student_type)
                            ->orWhere('student_type',2)
                            ->get();
           
           } elseif($student_type == 1) {
                
                $data=Branch::where('student_type',$student_type)
                            ->orWhere('student_type',2)
                            ->get();
           }
           
           return response()->json($data);
    }

    public function searchBranchSingle(Request $request){

           $branch_id=$request->get('branch_id');
           
           $data=Branch::where('id',$branch_id)
                            ->first();
           
           
           return response()->json($data);
    }


    public function searchClass(Request $request){

         
           $branch_id=$request->get('branch_id');
           
           $data=ClassName::where('branch_id',$branch_id)
                            ->where('status',1)
                            ->get();
           
           
           
           return response()->json($data);
    }


    public function searchBatch(Request $request){

         
           $student_type=$request->get('student_type');
           $branch_id=$request->get('branch_id');
           $class_id=$request->get('class_id');
           
           $data=Batch::where('student_type',$student_type)
                       ->where('branch_id',$branch_id)
                       ->where('class_id',$class_id)
                       ->where('status',1)
                       ->get();
           
           
           
           return response()->json($data);
    }


    public function searchSubject(Request $request){

         
           $student_type=$request->get('student_type');
           $class_id=$request->get('class_id');
           
           $data=Subject::where('student_type',$student_type)
                       ->where('class_id',$class_id)
                       ->get();
           
           
           
           return response()->json($data);
    }


    public function searchSubjectAmount(Request $request){

         
           $subject_id=$request->get('subject_id');
           $data=Subject::select('amount')
                 ->where('id',$subject_id)
                 ->first() ;
           
           return response()->json($data);
    }




    public function searchStudentBranch(Request $request){

           $student_branch=$request->get('student_branch');
           $data=Branch::find($student_branch);
           
           return response()->json($data);
    }


    public function searchStudentClass(Request $request){

         
           $student_class=$request->get('student_class');
           $data=ClassName::where('id',$student_class)
                            ->first();
           
           return response()->json($data);
    }


    public function searchStudentBatch(Request $request){

         
           $student_batch=$request->get('student_batch');
           $data=Batch::where('id',$student_batch)
                            ->first();
           
           return response()->json($data);
           
    }

     public function lastPayment(Request $request){

         
           $student_id=$request->get('student_id');
           $data=StudentPayment::where('student_id',$student_id)
                            ->latest('id')
                            ->first();
           
           return response()->json($data);
           
    }


    








    
}
