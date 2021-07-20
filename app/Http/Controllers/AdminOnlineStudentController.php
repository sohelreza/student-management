<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Session;
use PDF;
use App\StudentSubject;
use App\StudentPayment;

class AdminOnlineStudentController extends Controller
{
     public function list(){

        
        $students=User::where('student_type',1)
                        ->with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->get();
        
        return view('admin.online.studentList',compact('students'));


    }

     public function listSearch(Request $request)
    {
        $request_student_type=$request->student_type;
        $request_branch=$request->branch_id;
        $request_class=$request->class_id;
        $request_batch=$request->batch_id;

        $students=User::where('student_type',1)
                       ->with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->where('student_type',$request_student_type)
                       ->where('branch_id',$request_branch)
                       ->where('class_id',$request_class)
                       ->where('batch_id',$request_batch)
                       ->get();

        return view('admin.online.studentListSearch', compact('students','request_student_type','request_branch','request_class','request_batch'));
    }

    public function listSearchPdf(Request $request)
    {
        $request_student_type=$request->request_student_type;
        $request_branch=$request->request_branch_id;
        $request_class=$request->request_class_id;
        $request_batch=$request->request_batch_id;

        $students=User::where('student_type',1)
                       ->with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->where('student_type',$request_student_type)
                       ->where('branch_id',$request_branch)
                       ->where('class_id',$request_class)
                       ->where('batch_id',$request_batch)
                       ->get();          
        
        // dd($students);

        $pdf = PDF::loadView('admin.online.studentPdf', compact('students','request_student_type','request_branch','request_class','request_batch'));
        return $pdf->stream('StudentList.pdf');
    }

     public function delete($id){

        
        $student=User::where('id',$id)->first();

        $student->payments()->delete();
        $student->subjects()->delete();
        $student->profile()->delete();

        $student->delete();
        
        Session::flash('success', 'Exam Deleted Successfully');
        return redirect('admin/online_students/');


    }

    public function online_student_registration_pdf($id){

        
        $student=User::find($id);
        $student_subjects=StudentSubject::where('student_id',$id)->where('status',1)->get();
        $student_payment=StudentPayment::where('student_id',$id)->first();

        $pdf = PDF::loadView('admin.offline.pdfRegistration', compact('student','student_subjects','student_payment') );
        return $pdf->stream('Registartion.pdf'); 

        
    }
}
