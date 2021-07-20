<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\McqExam;
use App\Branch;
use App\McqOption;
use App\McqQuestion;
use Session;
use App\McqExamEnroll;
use DB;

class AdminMCQExamController extends Controller
{
    public function exam_list()
    {
        $exams=McqExam::all();

        return view('admin.mcqExam.mcqExamList',compact('exams'));
    }

    public function add_mcq_exam(){

        return view('admin.mcqExam.mcqExamAdd');
    }

    public function create_mcq_exam(Request $request){

        // return $request->all();

         $request->validate([
            
            'name' => 'required',
            'branch_id' => 'required',
            'class_id' => 'required',
            'batch_id' => 'required',
            'subject_id' => 'required',
            'student_type' => 'required',
            'exam_date' => 'required|date',
            
            'start_time' => 'required',
            'end_time' => 'required',
            
            'total_exam_duration' => 'required',
            'total_exam_marks' => 'required',
            'duration_per_question' => 'required',
            'mark_per_question' => 'required',
        
            
        ]);

        if (!$request->negative_marking) {
            
            $request['negative_marking']=0;
            $request['negative_mark_per_question']=0;
            $request['publish_answer']=0;

        } 
        
        $request['start_time']=date("G:i", strtotime($request->start_time));
        $request['end_time']=date("G:i", strtotime($request->end_time));

        $request['status']=0;


        McqExam::create($request->all());
        $request->session()->flash('success', 'Exam Added Successfully');
        return redirect('admin/mcq_exams/');
    
    }

    public function duplicate_mcq_exam($id){

         
           
           $exam=McqExam::find($id);

           $replicated_exam = $exam->replicate();
           $replicated_exam->status = 0;
           $replicated_exam->publish_answer = 0;
           $replicated_exam->save();

          foreach ($exam->questions as $question) {
              
              $replicated_question = $question->replicate();
              $replicated_question->exam_id=$replicated_exam->id;
              $replicated_question->save();

              foreach ($question->options as $option) {
                  
                  $replicated_option = $option->replicate();
                  $replicated_option->question_id=$replicated_question->id;
                  $replicated_option->save();
              }
          }
           

           Session::flash('success', 'Exam Duplicate Created');
           return back();
    }

    public function changeStatus(Request $request){

         
           
           $exam=McqExam::find($request->exam_id);
           $exam->status=$request->status;
           $exam->save();

           $request->session()->flash('success', 'Exam Status Changed');
           return back();
    }

     public function changeResultPublishStatus(Request $request){

           
           // return $request->all();
           
           $exam=McqExam::find($request->exam_id);
           $exam->publish_answer=$request->publish_answer;
           $exam->save();

           $request->session()->flash('success', 'Exam Result Publish Status Changed');
           return back();
    }

     public function edit_mcq_exam($id){

        $exam=McqExam::find($id);
        return view('admin.mcqExam.mcqExamEdit',compact('exam'));
    }

    public function update_mcq_exam(Request $request,$id){


         // return $request->all();
        

        $request->validate([
            
            'name' => 'required',
            'branch_id' => 'required',
            'class_id' => 'required',
            'batch_id' => 'required',
            'subject_id' => 'required',
            'student_type' => 'required',
            'exam_date' => 'required|date',
            
            'start_time' => 'required',
            'end_time' => 'required',
            
            'total_exam_duration' => 'required',
            'total_exam_marks' => 'required',
            'duration_per_question' => 'required',
            'mark_per_question' => 'required',
        
            
        ]);



        $exam=McqExam::find($id);
        $exam->name=$request->name;
        $exam->description=$request->description;
        $exam->branch_id=$request->branch_id;
        $exam->class_id=$request->class_id;
        $exam->batch_id=$request->batch_id;
        $exam->subject_id=$request->subject_id;
        $exam->student_type=$request->student_type;
        $exam->exam_date=$request->exam_date;
        $exam->start_time=date("G:i", strtotime($request->start_time));
        $exam->end_time=date("G:i", strtotime($request->end_time));
        $exam->total_exam_duration=$request->total_exam_duration;
        $exam->total_exam_marks=$request->total_exam_marks;
        $exam->passing_percentage=$request->passing_percentage;
        $exam->duration_per_question=$request->duration_per_question;
        $exam->mark_per_question=$request->mark_per_question;

        if (!$request->negative_marking) {

            $exam->negative_marking=0;
            $exam->negative_mark_per_question=0;
        
        } else {
            
            $exam->negative_marking=$request->negative_marking;
            $exam->negative_mark_per_question=$request->negative_mark_per_question;
        
        }

        $exam->save();
        $request->session()->flash('success', 'Exam Updated Successfully');        
        return redirect('admin/mcq_exams/');
    
    }

     public function delete_mcq_exam($id){

       
        $exam=McqExam::find($id);
        foreach ($exam->questions as $question) {
            $question->options()->delete();
        }
        $exam->questions()->delete();
        $exam->delete();
        Session::flash('success', 'Exam Deleted Successfully');
        return redirect('admin/mcq_exams/');
    }

    public function add_mcq_question($id){

        $exam=McqExam::find($id);
        return view('admin.mcqExam.mcqQuestionAdd',compact('exam'));
    }

    public function create_mcq_question(Request $request){

        // return $request->all();
        

        $request->validate([
            
            'question_number' => 'required',
            'question_title' => 'required',
            'option_title.*' => 'required',
        ]);


        $question=new McqQuestion;
        $question->exam_id=$request->exam_id;
        $question->question_number=$request->question_number;
        $question->question_title=$request->question_title;
        $question->save();

        session(['question_id'=>$question->id]);
        $question_id=session('question_id');


        foreach ($request->option_number as $key => $value) {
           McqOption::create(
                [
                'question_id'=>$question_id,
                'option_number'=>$request->option_number[$key],
                'option_title'=>$request->option_title[$key],
                'right_answer'=>$request->right_answer[$key],
                ]
            );
        }


        $request->session()->flash('success', 'Question Added Successfully');
        return redirect('admin/mcq_exams/');
    }

    public function view_mcq_question($id){

        $exam=McqExam::find($id);
        $questions=$exam->questions;
        return view('admin.mcqExam.mcqQuestionView',compact('questions','exam'));
    }

    public function edit_mcq_question($id){

        

        $question=McqQuestion::find($id);


       
        return view('admin.mcqExam.mcqQuestionEdit',compact('question'));
    }

    public function update_mcq_question(Request $request,$id){

        $request->validate([
            
            'question_number' => 'required',
            'question_title' => 'required',
            'option_title.*' => 'required',
        ]);

        $question=McqQuestion::find($id);
        $question->question_number=$request->question_number;
        $question->question_title=$request->question_title;
        $question->save();


        foreach ($request->option_number as $key => $value) {

           $question_option=McqOption::where('question_id',$question->id)->where('option_number',$request->option_number[$key])->first();  
           
           $question_option->update(
                [
                'question_id'=>$question->id,
                'option_number'=>$request->option_number[$key],
                'option_title'=>$request->option_title[$key],
                'right_answer'=>$request->right_answer[$key],
                ]
            );
        }


        $request->session()->flash('success', 'Question Updated Successfully');


        return redirect('admin/mcq_exams/');
    
    }

    public function delete_mcq_question($id){

        $question=McqQuestion::find($id);
        $question->options()->delete();
        $question->delete();

        Session::flash('success', 'Question Deleted Successfully');
        return back();
    }

    public function upload_mcq_image(Request $request) { 
            
            if($request->hasFile('upload')) {
                    
                    $originName = $request->file('upload')->getClientOriginalName();
                    $fileName = pathinfo($originName, PATHINFO_FILENAME);
                    $extension = $request->file('upload')->getClientOriginalExtension();
                    $fileName = $fileName.'_'.time().'.'.$extension;
                
                    $request->file('upload')->move(public_path('mcq_image'), $fileName);
           
                    $CKEditorFuncNum = $request->input('CKEditorFuncNum');
                    $url = asset('mcq_image/'.$fileName); 
                    $msg = 'Image uploaded successfully'; 
                    $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
                       
                    @header('Content-type: text/html; charset=utf-8'); 
                    echo $response;
                }
    } 



    public function mcq_exam_result()
    {
        $exams=McqExam::all();

        return view('admin.mcqExamResult.mcqExamList',compact('exams'));
    }

    public function mcq_exam_result_view($id)
    {
        $students=DB::table('mcq_exam_enrolls')
                         ->join('users','mcq_exam_enrolls.student_id','=','users.id')
                        ->join('mcq_exams','mcq_exam_enrolls.exam_id','=','mcq_exams.id')

                        ->where('mcq_exam_enrolls.exam_id',$id)
                        ->orderBY('mcq_exam_enrolls.score','desc')
                        ->orderBY('users.first_name','asc')
                        ->orderBY('users.last_name','asc')
                        ->get();
                   
        
        return view('admin.mcqExamResult.studentList',compact('students'));
    }

    public function mcq_student_result($exam_id,$student_id)
    {
        
        $exam=McqExam::with(['enroll' => function ($query) use($student_id) {
                           $query->where('student_id', $student_id);
                      }])
                      ->with('questions')
                      ->with('questions.options')
                      ->with(['questions.mcq_right_answers' => function ($query) use($student_id) {
                           $query->where('right_answer',1)
                           ;
                      }])
                      ->with(['questions.answers' => function ($query) use($student_id) {
                           $query->where('student_id', $student_id);
                      }])
                    ->with(['questions.exam_enroll_answers' => function ($query) use($student_id) {
                           $query->where('student_id', $student_id);
                      }])
                     ->where('id',$exam_id)
                     ->first();

        
                     
        
        return view('admin.mcqExamResult.studentResult',compact('exam'));
    }
}
