<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\StudentPayment;
use App\StudentSubject;
use PDF;

class AdminStudentController extends Controller
{
    public function list(){

        
        $students=User::with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->get();
        return view('admin.student.studentList',compact('students'));


    }

     public function listSearch(Request $request)
    {
        $request_student_type=$request->student_type;
        $request_branch=$request->branch_id;
        $request_class=$request->class_id;
        $request_batch=$request->batch_id;

        $students=User::with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->where('student_type',$request_student_type)
                       ->where('branch_id',$request_branch)
                       ->where('class_id',$request_class)
                       ->where('batch_id',$request_batch)
                       ->get();

        return view('admin.student.studentListSearch', compact('students','request_student_type','request_branch','request_class','request_batch'));
    }

    public function listSearchPdf(Request $request)
    {
        $request_student_type=$request->request_student_type;
        $request_branch=$request->request_branch_id;
        $request_class=$request->request_class_id;
        $request_batch=$request->request_batch_id;

        $students=User::with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->where('student_type',$request_student_type)
                       ->where('branch_id',$request_branch)
                       ->where('class_id',$request_class)
                       ->where('batch_id',$request_batch)
                       ->get();          
        
        // dd($students);

        $pdf = PDF::loadView('admin.student.studentPdf', compact('students','request_student_type','request_branch','request_class','request_batch'));
        return $pdf->stream('StudentList.pdf');
    }

    
    public function viewStudent($id){

        
        $student=User::with(['subjects' => function ($query) {
                       $query->where('status', '=', '1');
                       }])
                       ->where('id',$id)
                       ->first();
        $payments=StudentPayment::where('student_id',$id)->get();
        return view('admin.student.viewStudent',compact('student','payments'));


    }

     public function deleteStudent($id){

        
        Session::flash('success', 'Student Deleted');
        return redirect('admin/students');


    }

    public function viewStudentPayment($id){

        
        $payments=StudentPayment::where('student_id',$id)->get();
        return view('admin.student.viewStudentPayment',compact('payments'));


    }

     public function changeDueDate($id){

        
        $student=User::where('id',$id)->first();

        return view('admin.student.changeDueDate',compact('student'));


    }

    public function updateDueDate(Request $request){


       

        
        $student=User::where('id',$request->id)->first();

        $student->next_payment_date=$request->next_payment_date;
        $student->save();

         //Update Subject

        $student_subjects=StudentSubject::where('student_id',$student->id)->where('status',1)->get(); 

        foreach ($student_subjects as $subject) {
                    
            $subject->update([

                    
                'end_date'=>$request->next_payment_date,
                                
            ]);
        } 
        
        $request->session()->flash('success', 'Student Due Date Changed');
        return redirect('admin/students');


    }
}
