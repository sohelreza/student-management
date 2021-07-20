<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UploadContentType;
use App\Content;
use App\StudentPayment;
use App\StudentSubject;

class StudentContentController extends Controller
{
    public function contentList(Request $request)
    {
        $student=User::find($request->student_id);

        $subjects=StudentSubject::where('student_id', $student->id)
                                 ->where('status', 1)
                                 ->get()
                                  ->map(function ($thing) {
                                      return $thing->subject_id;
                                  })->toArray();



        // $student_history=StudentPayment::where('student_id',$request->student_id)
        //                                ->groupBY('branch_id')
        //                                ->groupBY('batch_id')
        //                                ->groupBY('class_id')
        //                                ->groupBY('student_type')
        //                                ->get();

        $contents=Content::with('content_type')
                              ->where('student_type', $student->student_type)
                              ->where('branch', $student->branch_id)
                              ->where('batch', $student->batch_id)
                              ->where('class', $student->class_id)
                            ->whereIn('subject', $subjects)
                            ->get();

        //   dd($contents);
        
        return response($contents);
    }
}
