<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\LectureSheet;
use App\StudentSubject;

class StudentLectureSheetController extends Controller
{
    public function lectureList(Request $request)
    {
        $student=User::find($request->student_id);
        $subjects=StudentSubject::where('student_id',$student->id)
                                 ->where('status',1)
                                 ->get()
                                  ->map(function ($thing) {
                                    return $thing->subject_id;
                                    
                                  })->toArray();

	    $lectures=LectureSheet::where('branch',$student->branch_id)
	                          ->where('batch',$student->batch_id)
	                          ->where('class',$student->class_id)
                            ->whereIn('subject',$subjects)
	                          
	                          ->get();
	    return response($lectures);                      
        
    }
}
