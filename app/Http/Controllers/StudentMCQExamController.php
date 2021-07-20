<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\McqExam;
use App\Branch;
use App\McqOption;
use App\McqQuestion;
use App\User;
use App\McqExamEnroll;
use App\McqExamEnrollAnswer;
use App\StudentSubject;
use DB;

class StudentMCQExamController extends Controller
{
    public function exam_list(Request $request)
    {
    	$student_id=$request->student_id;
    	$student=User::find($student_id);
      $subjects=StudentSubject::where('student_id',$student->id)
                                 ->where('status',1)
                                 ->get()
                                  ->map(function ($thing) {
                                    return $thing->subject_id;
                                    
                                  })->toArray();
       
        $exams=DB::table('mcq_exams')
                       ->select('mcq_exams.*','branches.name As branch_name','batches.name As batch_name','class_names.name As class_name','subjects.name As subject_name','mcq_exam_enrolls.student_id AS attendance')
                       ->join('branches', 'branches.id', '=', 'mcq_exams.branch_id')
                       ->join('batches', 'batches.id', '=', 'mcq_exams.batch_id')
                       ->join('class_names', 'class_names.id', '=', 'mcq_exams.class_id')
                       ->join('subjects', 'subjects.id', '=', 'mcq_exams.subject_id')
                       
                        ->leftJoin('mcq_exam_enrolls', function ($join) use($student) {
                            $join->on('mcq_exams.id', '=', 'mcq_exam_enrolls.exam_id')
                                 ->where('mcq_exam_enrolls.student_id',$student->id);
                        })

                       ->where('mcq_exams.branch_id',$student->branch_id)
                       ->where('mcq_exams.batch_id',$student->batch_id)
                       ->where('mcq_exams.class_id',$student->class_id)
                       ->where('mcq_exams.status',1)
                       ->whereIn('mcq_exams.subject_id',$subjects)

                       ->get();
        return response($exams);
    }

    public function exam_result_list(Request $request)
    {
      $student_id=$request->student_id;
      $student=User::find($student_id);
        
        $exams=DB::table('mcq_exams')
                       ->select('mcq_exams.*','mcq_exam_enrolls.score','branches.name As branch_name','batches.name As batch_name','class_names.name As class_name','subjects.name As subject_name')
                       ->join('mcq_exam_enrolls', 'mcq_exam_enrolls.exam_id', '=', 'mcq_exams.id')
                       ->join('branches', 'branches.id', '=', 'mcq_exams.branch_id')
                       ->join('batches', 'batches.id', '=', 'mcq_exams.batch_id')
                       ->join('class_names', 'class_names.id', '=', 'mcq_exams.class_id')
                       ->join('subjects', 'subjects.id', '=', 'mcq_exams.subject_id')
                       ->where('mcq_exams.branch_id',$student->branch_id)
                       ->where('mcq_exams.batch_id',$student->batch_id)
                       ->where('mcq_exams.class_id',$student->class_id)
                       ->where('mcq_exam_enrolls.student_id',$student->id)
                       ->where('mcq_exams.status',1)
                       ->get();
        return response($exams);
    }

     public function exam_show(Request $request)
    {
    	$exam_id=$request->exam_id;
      $student_id=$request->student_id;

      $exam=McqExam::find($exam_id);
      $exam_enroll=McqExamEnroll::where('exam_id',$exam_id)->where('student_id',$student_id)->first();
    	$exam_questions=McqQuestion::with('options')->where('exam_id',$exam->id)->get();
    	$total_questions=McqQuestion::with('options')
    	                ->where('exam_id',$exam->id)
					    ->count();

      
      //Add record
      // $student=User::find($request->student_id);        
      
      // $mcq_exam_enroll=new McqExamEnroll;
      // $mcq_exam_enroll->student_id=$request->student_id;
      // $mcq_exam_enroll->branch_id=$student->branch_id;
      // $mcq_exam_enroll->class_id=$student->class_id;
      // $mcq_exam_enroll->batch_id=$student->batch_id;
      
      // $mcq_exam_enroll->subject_id=$exam->subject_id;
      // $mcq_exam_enroll->exam_id=$exam->id;
      
      // $mcq_exam_enroll->save();        

    	// $exam_questions=DB::table('mcq_questions')
    	//                ->join('mcq_options','mcq_options.question_id','=','mcq_questions.id')
					//    ->where('mcq_questions.exam_id',$exam->id)
					//    ->get();
        
        $data['exam'] = $exam;
        $data['exam_questions'] = $exam_questions;
        $data['total_questions'] = $total_questions;
        $data['exam_enroll'] = $exam_enroll;

 

        return response($data);
    }

    public function answer_submit(Request $request){

       
       $student=User::find($request->student_id);
       $mcq_exam=McqExam::find($request->exam_id);

       
       //Extra
       $mcq_exam_enroll=McqExamEnroll::where('student_id',$request->student_id)
                                      ->where('exam_id',$request->exam_id)
                                      ->first();

       if (!$mcq_exam_enroll) {

           // Add record
              
            $mcq_exam_enroll=new McqExamEnroll;
            $mcq_exam_enroll->student_id=$request->student_id;
            $mcq_exam_enroll->branch_id=$student->branch_id;
            $mcq_exam_enroll->class_id=$student->class_id;
            $mcq_exam_enroll->batch_id=$student->batch_id;
            
            $mcq_exam_enroll->subject_id=$mcq_exam->subject_id;
            $mcq_exam_enroll->exam_id=$mcq_exam->id;
            $mcq_exam_enroll->score=0;
            
            $mcq_exam_enroll->save(); 
                                       
        } 

        //Extra                              

       
       $mcq_question=McqQuestion::where('id',$request->question_id)
                                 ->first();
       $mcq_right_answers=McqOption::where('question_id',$mcq_question->id)
                                    ->where('right_answer',1)
                                    ->get()
                                     ->map(function ($thing) {
                                      return $thing->option_number;
                                          
                                    })->toArray(); 

       $number_of_questions=$mcq_exam->questions->count();

       if (sizeof($request->answers) > 0 && $request->answers[0] != 0 ) {
                
                foreach ($request->answers as $key => $value) {
                   
                   $mcq_exam_enroll_answer=new McqExamEnrollAnswer;
                   $mcq_exam_enroll_answer->student_id=$request->student_id;
                   $mcq_exam_enroll_answer->exam_id=$request->exam_id;
                   $mcq_exam_enroll_answer->question_id=$request->question_id;
                   $mcq_exam_enroll_answer->option_id=$request->answers[$key];
                   $mcq_exam_enroll_answer->save();

                }
             }

             


             if (!session()->has('score')) {
              
                session(['score'=>0]);

             }

             $score=session('score');

             
             if ($request->answers[0] != 0) {
                 
                 if ( count($mcq_right_answers) == count($request->answers) ) {

                      // $sorted_mcq_right_answers=sort($mcq_right_answers);
                      $answers= $request->answers;
                      $sorted_answers=sort($answers); 
                   
                     if ( count( $mcq_right_answers ) == count( $request->answers ) && !array_diff( $mcq_right_answers, $request->answers ) ) {
                         $right=1;
                     
                     }else {
                       $right=0;
                     }
                 
                  }else{
                  $right=0;
                  }
             
             } elseif($request->answers[0] == 0) {
                  
                  if (count( $mcq_right_answers ) == 0) {
                    $right=1;
                  } elseif(count( $mcq_right_answers ) > 0) {
                    $right=-1;
                  }
                  
             }
             
             
              // else {

              //    if (count($request->answers) == 0) {
              //      $right=-1;
              //    }else{
              //       $right=0;
              //    }
               
              // }
             



              //Score Count 

              if ($right == 1) {

                $score=$score+$mcq_exam->mark_per_question;
                session(['score'=>$score]);

                $mcq_exam_enroll=McqExamEnroll::where('exam_id',$request->exam_id)
                                                   ->where('student_id',$request->student_id)
                                                   ->first();
                $mcq_exam_enroll->score=session('score');
                $mcq_exam_enroll->save();
              
              }elseif($right == 0){
                
                 if ($mcq_exam->negative_marking == 1) {

                    $score=$score-$mcq_exam->negative_mark_per_question;
                    session(['score'=>$score]);

                    $mcq_exam_enroll=McqExamEnroll::where('exam_id',$request->exam_id)
                                                   ->where('student_id',$request->student_id)
                                                   ->first();
                    $mcq_exam_enroll->score=session('score');
                    $mcq_exam_enroll->save();
                  }
                
              }

              //Enter Student Answer


              if ($request->force == 0) {
                    if ($mcq_question->question_number == $number_of_questions ) {
                     
                     // return response(session('score'));
                     // $mcq_exam_enroll=new McqExamEnroll;
                     // $mcq_exam_enroll->student_id=$request->student_id;
                     // $mcq_exam_enroll->branch_id=$student->branch_id;
                     // $mcq_exam_enroll->class_id=$student->class_id;
                     // $mcq_exam_enroll->batch_id=$student->batch_id;
                     // $mcq_exam_enroll->subject_id=$mcq_exam->subject_id;
                     // $mcq_exam_enroll->exam_id=$mcq_exam->id;
                     // $mcq_exam_enroll->score=session('score');
                     // $mcq_exam_enroll->save();

                     $mcq_exam_enroll=McqExamEnroll::where('exam_id',$request->exam_id)
                                                       ->where('student_id',$request->student_id)
                                                      ->first();
                     $mcq_exam_enroll->score=session('score');
                     $mcq_exam_enroll->save();
                     
                     session()->forget('score');
                 }
              } elseif($request->force == 1) {
                       
                       // $mcq_exam_enroll=new McqExamEnroll;
                       // $mcq_exam_enroll->student_id=$request->student_id;
                       // $mcq_exam_enroll->branch_id=$student->branch_id;
                       // $mcq_exam_enroll->class_id=$student->class_id;
                       // $mcq_exam_enroll->batch_id=$student->batch_id;
                       // $mcq_exam_enroll->subject_id=$mcq_exam->subject_id;
                       // $mcq_exam_enroll->exam_id=$mcq_exam->id;
                       // $mcq_exam_enroll->score=session('score');
                       // $mcq_exam_enroll->save();

                        $mcq_exam_enroll=McqExamEnroll::where('exam_id',$request->exam_id)
                                                        ->where('student_id',$request->student_id)
                                                        ->first();
                        $mcq_exam_enroll->score=session('score');
                        $mcq_exam_enroll->save();
                           
                       session()->forget('score');
              }
              

             

       
    
       

      } 


    public function exam_show_result(Request $request)
    {

      $student_id=$request->student_id;
      $exam_id=$request->exam_id;

        $exam=McqExam::with(['enroll' => function ($query) use($student_id) {
                           $query->where('student_id',$student_id)
                           ;
                      }])
                      ->where('id',$exam_id)->first();
        return response($exam);
    }

    public function mcq_exam_rank(Request $request)
      {
          $students=DB::table('mcq_exam_enrolls')
                        ->join('users','mcq_exam_enrolls.student_id','=','users.id')
                        ->where('mcq_exam_enrolls.exam_id',$request->exam_id)
                        ->orderBY('mcq_exam_enrolls.score','desc')
                        ->orderBY('users.first_name','asc')
                        ->orderBY('users.last_name','asc')
                        ->get();
          
          return response($students);
      }

      public function mcq_exam_rank_pdf(Request $request)
      {
          // $students=DB::table('mcq_exam_enrolls')
          //               ->join('users','mcq_exam_enrolls.student_id','=','users.id')
          //               ->where('mcq_exam_enrolls.exam_id',$request->exam_id)
          //               ->orderBY('mcq_exam_enrolls.score','desc')
          //               ->orderBY('users.first_name','asc')
          //               ->orderBY('users.last_name','asc')
          //               ->get();
          
          // return response($students);
      }

    public function exam_show_answer(Request $request)
    {

      $student_id=$request->student_id;
      $exam_id=$request->exam_id;
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
      return response($exam);
    }
}
