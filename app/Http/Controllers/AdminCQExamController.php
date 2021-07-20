<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CqExam;
use App\CqExamEnroll;
use App\CqExamEnrollAnswer;
use App\Branch;
use App\CqQuestion;
use Session;
use PDF;
use File;
use Response;
use App\Admin;

class AdminCQExamController extends Controller
{
    public function exam_list()
    {
        $exams=CqExam::all();

        return view('admin.cqExam.cqExamList',compact('exams'));
    }

     public function add_cq_exam(){

        $teachers=Admin::where('role_id',4)->get();  
        return view('admin.cqExam.cqExamAdd',compact('teachers'));
    }

    public function create_cq_exam(Request $request){

        

        $request->validate([
            
            'name' => 'required',
            'teacher_id'=>'required',
            'student_type' => 'required',
            'branch_id' => 'required',
            'class_id' => 'required',
            'batch_id' => 'required',
            'subject_id' => 'required',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            
            'total_exam_duration' => 'required',
            'total_exam_marks' => 'required',
        
            
        ]);
        
        $request['start_time']=date("G:i", strtotime($request->start_time));
        $request['end_time']=date("G:i", strtotime($request->end_time));

        $request['status']=0;
        $request['publish_rank']=0;


        CqExam::create($request->all());
        $request->session()->flash('success', 'Exam Added Successfully');
        return redirect('admin/cq_exams/');
    
    }

    public function change_cq_exam_status(Request $request){

         
           
           $exam=CqExam::find($request->exam_id);
           $exam->status=$request->status;
           $exam->save();

           $request->session()->flash('success', 'Exam Status Changed');
           return back();
    }

     public function edit_cq_exam($id){

        $teachers=Admin::where('role_id',4)->get(); 
        $exam=CqExam::find($id);
        return view('admin.cqExam.cqExamEdit',compact('exam','teachers'));
    }


    public function update_cq_exam(Request $request,$id){


         $request->validate([
            
            'name' => 'required',
            'teacher_id'=>'required',
            'student_type' => 'required',
            'branch_id' => 'required',
            'class_id' => 'required',
            'batch_id' => 'required',
            'subject_id' => 'required',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            
            'total_exam_duration' => 'required',
            'total_exam_marks' => 'required',
        
            
        ]);



        $exam=CqExam::find($id);
        $exam->name=$request->name;
        $exam->description=$request->description;
        $exam->teacher_id=$request->teacher_id;
        $exam->student_type=$request->student_type;
        $exam->branch_id=$request->branch_id;
        $exam->class_id=$request->class_id;
        $exam->batch_id=$request->batch_id;
        $exam->subject_id=$request->subject_id;
        $exam->exam_date=$request->exam_date;
        $exam->start_time=date("G:i", strtotime($request->start_time));
        $exam->end_time=date("G:i", strtotime($request->end_time));
        $exam->total_exam_duration=$request->total_exam_duration;
        $exam->total_exam_marks=$request->total_exam_marks;
        $exam->passing_percentage=$request->passing_percentage;
        $exam->save();
        
        $request->session()->flash('success', 'Exam Updated Successfully');        
        return redirect('admin/cq_exams/');
    
    }

     public function delete_cq_exam($id){

       
        $exam=CqExam::find($id);
        $exam->questions()->delete();
        $exam->delete();
        Session::flash('success', 'Exam Deleted Successfully');
        return redirect('admin/cq_exams/');
    }

    public function add_cq_question($id){

        $exam=CqExam::find($id);
        return view('admin.cqExam.cqQuestionAdd',compact('exam'));
    }

    public function create_cq_question(Request $request){

        // return $request->all();
        

        $request->validate([
            
            'question_number' => 'required',
            'question_title' => 'required',
            'mark'=>'required'
        ]);


        $question=new CqQuestion;
        $question->exam_id=$request->exam_id;
        $question->question_number=$request->question_number;
        $question->question_title=$request->question_title;
        $question->mark=$request->mark;

        $question->save();

        $request->session()->flash('success', 'Question Added Successfully');
        return redirect('admin/cq_exams/');
    }

    public function upload_cq_image(Request $request) { 
            
            if($request->hasFile('upload')) {
                    
                    $originName = $request->file('upload')->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $extension = $request->file('upload')->getClientOriginalExtension();
                    $fileName = $fileName.'_'.time().'.'.$extension;
                
                    $request->file('upload')->move(public_path('cq_image'), $fileName);
           
                    $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                    $url = asset('cq_image/'.$fileName); 
                    $msg = 'Image uploaded successfully'; 
                    $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                       
                    @header('Content-type: text/html; charset=utf-8'); 
                    echo $response;
                }
    } 



     public function view_cq_question($id){

        $exam=CqExam::find($id);
        $questions=$exam->questions;
        return view('admin.cqExam.cqQuestionView',compact('questions','exam'));
    }

    public function edit_cq_question($id){

        
        
        $question=CqQuestion::find($id);
        return view('admin.cqExam.cqQuestionEdit',compact('question'));
    
    }

    public function update_cq_question(Request $request,$id){

        $request->validate([
            
            'question_number' => 'required',
            'question_title' => 'required',
            'mark' => 'required',
        ]);

        $question=CqQuestion::find($id);
        $question->question_number=$request->question_number;
        $question->question_title=$request->question_title;
        $question->mark=$request->mark;

        $question->save();


        $request->session()->flash('success', 'Question Updated Successfully');


        return redirect('admin/cq_exams/');
    
    }

    public function delete_cq_question($id){

        $question=CqQuestion::find($id);
        $question->delete();

        Session::flash('success', 'Question Deleted Successfully');
        return back();
    }

     public function cq_exam_result()
    {
        $exams=CqExam::all();

        return view('admin.cqExamResult.cqExamList',compact('exams'));
    }

    public function cq_exam_result_view($id)
    {
        $students=CqExamEnroll::where('exam_id',$id)->orderBY('score','desc')->get();
        
        return view('admin.cqExamResult.studentList',compact('students'));
    }

    public function pdfStudentAnswer($exam_id,$student_id)
    {
        
        $exam_answers=CqExamEnrollAnswer::where('exam_id',$exam_id)->where('student_id',$student_id)->get();

                 


        $pdf = PDF::loadView('admin.cqExamResult.pdfStudentAnswer', compact('exam_answers') );
        
        return $pdf->stream('ExamAnswer.pdf',array('Attachment'=>0)); 
        exit(0);
    }

    public function studentMarking($exam_id,$student_id)
    {
        
        $exam_student=CqExamEnroll::where('exam_id',$exam_id)->where('student_id',$student_id)->first();

        return view('admin.cqExamResult.marking',compact('exam_student'));
        
      
    }

     public function studentMarkingUpdate(Request $request)
    {

       
        
        $exam_student=CqExamEnroll::where('id',$request->id)->first();
        $exam_student->score=$request->score;
        $exam_student->save();


        $request->session()->flash('success', 'Student Mark Added');


        return redirect('admin/cq_exam_result/');


        
        
      
    }


    public function add_solve_sheet($id)
    {
        $cq_exam=CqExam::where('id',$id)->first();

        return view('admin.cqExamResult.addSolveSheet',compact('cq_exam'));
    }

    public function post_solve_sheet(Request $request,$id)
    {
        
        $request->validate([
            
            'file'=>'mimes:doc,pdf,docx,zip'
            
        ]);

        $cq_exam=CqExam::find($id);
        
       

        if($file=$request->file('file')){

             if(File::exists('solve_sheet/'.$cq_exam->solve_sheet)) {
                
                File::delete('solve_sheet/'.$cq_exam->solve_sheet);
            }
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/solve_sheet'),$name);
            $cq_exam->solve_sheet = $name;
            $cq_exam->save();
        }

        $request->session()->flash('success', 'Solve Sheet Successfully Added');
        return redirect('admin/cq_exam_result');
    }

     public function solve_download($path){
        
        
        
        return Response::download('solve_sheet/'.$path);
    }


     public function changeRankPublishStatus(Request $request){

           
           // return $request->all();
           
           $exam=CqExam::find($request->exam_id);
           $exam->publish_rank=$request->publish_rank;
           $exam->save();

           $request->session()->flash('success', 'Exam Rank Publish Status Changed');
           return back();
    }


}

