<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StudentHomework;
use PDF;

class AdminHomeworkController extends Controller
{
    public function index()
    {
        $homeworks=StudentHomework::orderBy('created_at', 'desc')->get();
        return view('admin.homework.homework',compact('homeworks'));
    }



    public function pdfHomework($id)
    {
        $homework=StudentHomework::find($id);
// dd($homework->images[0]->homework_image);

        $pdf = PDF::loadView('admin.homework.pdfHomework', compact('homework') );
        
        return $pdf->stream('Homework.pdf'); 
       
    }

    public function evaluateHomework($id)
    {
        $homework=StudentHomework::find($id);

        return view('admin.homework.evaluateHomework',compact('homework'));
        
       
    }

    public function evaluateHomeworkScore(Request $request,$id)
    {

       

        $homework=StudentHomework::find($id);

        $homework->score=$request->score;
        $homework->evaluation_date=$request->evaluation_date;
        $homework->save();

        $request->session()->flash('success', 'Homework Evaluated');
        return redirect('admin/homework/');
        
      
        
       
    }
}
