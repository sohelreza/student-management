<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentHomework;
use PDF;
use Auth;

class TeacherHomeworkController extends Controller
{
    public function index()
    {

    	$admin=Auth::guard('admin')->user(); 

        $homeworks=StudentHomework::orderBy('created_at', 'desc')->where('teacher_id',$admin->id)->get();
        return view('teacher.homework.homework',compact('homeworks'));
    }

     public function pdfHomework($id)
    {
        $homework=StudentHomework::find($id);
        
        $pdf = PDF::loadView('teacher.homework.pdfHomework', compact('homework') );
        
        return $pdf->stream('Homework.pdf'); 
       
    }

    public function evaluateHomework($id)
    {
        $homework=StudentHomework::find($id);

        return view('teacher.homework.evaluateHomework',compact('homework'));
        
       
    }

    public function evaluateHomeworkScore(Request $request,$id)
    {

        

        $homework=StudentHomework::find($id);

        $homework->score=$request->score;
        $homework->evaluation_date=$request->evaluation_date;
        $homework->save();

        $request->session()->flash('success', 'Homework Evaluated');
        return redirect('teacher/homework/');
        
      
        
       
    }


}
