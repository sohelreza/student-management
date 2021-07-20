<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\ExamEnroll;
use Session;
use App\Imports\ExamEnrollsImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;


class AdminExamController extends Controller
{
    public function exam_list()
    {
        $exams=Exam::all();

        return view('admin.exam.examList',compact('exams'));
    }

    public function add_exam(){

        return view('admin.exam.examAdd');
    }

    public function create_exam(Request $request){

        $request->validate([
            
            'name' => 'required',
            // 'code'=>'required',
            // 'branch_id' => 'required',
            // 'class_id' => 'required',
            // 'batch_id' => 'required',
            // 'subject_id' => 'required',
            // 'student_type' => 'required',
            
            'total_marks' => 'required',
            'height_marks' => 'required',

            'file' =>'required|mimes:xls,xlsx,csv,txt'

            
        ]);

        $exam=Exam::create($request->all());

        Excel::import(new ExamEnrollsImport($exam->id), $request->file('file'));
        
        $request->session()->flash('success', 'Exam Result Uploaded Successfully');
        return redirect('admin/exams/');
    
    }

    public function exam_result($id)
    {
        $students=DB::table('exam_enrolls')
                    ->join('users','exam_enrolls.student_id','=','users.id')
                    ->join('exams','exam_enrolls.exam_id','=','exams.id')
                    ->where('exam_enrolls.exam_id',$id)
                    ->get();
                   
        
        return view('admin.exam.studentList',compact('students'));
    }

}
