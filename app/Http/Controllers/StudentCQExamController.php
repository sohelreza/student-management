<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CqExam;
use App\Branch;
use App\CqQuestion;
use App\User;
use App\CqExamEnroll;
use App\CqExamEnrollAnswer;
use DB;
use App\StudentSubject;
use Intervention\Image\ImageManagerStatic as Image;

class StudentCQExamController extends Controller
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
       
        $exams=DB::table('cq_exams')
                       ->select('cq_exams.*','branches.name As branch_name','batches.name As batch_name','class_names.name As class_name','subjects.name As subject_name','cq_exam_enrolls.student_id AS attendance')
                       ->join('branches', 'branches.id', '=', 'cq_exams.branch_id')
                       ->join('batches', 'batches.id', '=', 'cq_exams.batch_id')
                       ->join('class_names', 'class_names.id', '=', 'cq_exams.class_id')
                       ->join('subjects', 'subjects.id', '=', 'cq_exams.subject_id')
                      
                       ->leftJoin('cq_exam_enrolls', function ($join) use($student) {
                            $join->on('cq_exams.id', '=', 'cq_exam_enrolls.exam_id')
                                 ->where('cq_exam_enrolls.student_id',$student->id);
                        })
                       ->where('cq_exams.branch_id',$student->branch_id)
                       ->where('cq_exams.batch_id',$student->batch_id)
                       ->where('cq_exams.class_id',$student->class_id)
                       ->where('cq_exams.status',1)
                       ->whereIn('cq_exams.subject_id',$subjects)
                       ->get();
        return response($exams);
    }

    public function exam_show(Request $request)
    {
    	  $exam_id=$request->exam_id;
        $exam=CqExam::with('questions')->where('id',$exam_id)->first();
    	
         return response($exam);
    }


    public function answer_submit(Request $request){

       
       

        $request->validate([
            

          
            // 'homework_image'=>'required |filled| mimes:jpeg,jpg,png | max:2048',
          'exam_image'=>'required |mimes:jpeg,jpg,png,gif|filled|max:2048',

        ]);

       
      
       
       $student=User::find($request->student_id);
       $cq_exam=CqExam::find($request->exam_id);

       // return response($student->branch_id);
       
       $cq_exam_enroll=new CqExamEnroll;
       $cq_exam_enroll->student_id=$request->student_id;
       $cq_exam_enroll->branch_id=$student->branch_id;
       $cq_exam_enroll->class_id=$student->class_id;
       $cq_exam_enroll->batch_id=$student->batch_id;
       $cq_exam_enroll->subject_id=$cq_exam->subject_id;
       $cq_exam_enroll->exam_id=$cq_exam->id;
       $cq_exam_enroll->save();

       session(['cq_exam_enroll_id'=>$cq_exam_enroll->id]);
       $cq_exam_enroll_id=session('cq_exam_enroll_id');


       if($request->hasFile('exam_image')) {

            foreach($request->file('exam_image') as $image)
            {
                // dd($image);
               

                $cq_exam_enroll_answer=new CqExamEnrollAnswer;
                $cq_exam_enroll_answer->student_id=$request->student_id;
                $cq_exam_enroll_answer->exam_id=$request->exam_id;
                $cq_exam_enroll_answer->save();

                $filename=time().$image->getClientOriginalName();
                $image_resize = Image::make($image->getRealPath());
                $image_resize->resize(1000, 1000);
                $image_resize->save(public_path('cq_exam/' .$filename));
                
                $cq_exam_enroll_answer->image = $filename;
                $cq_exam_enroll_answer->save();
            }
            

           
        }
           
      
      


       
    } 


    public function exam_result_list(Request $request)
    {
      $student_id=$request->student_id;
      $student=User::find($student_id);
        
        $exams=DB::table('cq_exams')
                       ->select('cq_exams.*','cq_exam_enrolls.score','branches.name As branch_name','batches.name As batch_name','class_names.name As class_name','subjects.name As subject_name')
                       ->join('cq_exam_enrolls', 'cq_exam_enrolls.exam_id', '=', 'cq_exams.id')
                       ->join('branches', 'branches.id', '=', 'cq_exams.branch_id')
                       ->join('batches', 'batches.id', '=', 'cq_exams.batch_id')
                       ->join('class_names', 'class_names.id', '=', 'cq_exams.class_id')
                       ->join('subjects', 'subjects.id', '=', 'cq_exams.subject_id')
                       ->where('cq_exams.branch_id',$student->branch_id)
                       ->where('cq_exams.batch_id',$student->batch_id)
                       ->where('cq_exams.class_id',$student->class_id)
                       ->where('cq_exam_enrolls.student_id',$student->id)
                       ->where('cq_exams.status',1)
                       ->get();
        return response($exams);
    }

    public function cq_exam_rank(Request $request)
      {
          $students=DB::table('cq_exam_enrolls')
                        ->join('users','cq_exam_enrolls.student_id','=','users.id')
                        ->where('cq_exam_enrolls.exam_id',$request->exam_id)
                        ->orderBY('cq_exam_enrolls.score','desc')
                        ->orderBY('users.first_name','asc')
                        ->orderBY('users.last_name','asc')
                        ->get();
          
          return response($students);
      }



}
