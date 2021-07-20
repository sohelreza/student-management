<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LectureSheet;
use Response;
use File;
use Storage;
use Session;
use App\Branch;

class AdminLectureSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lectures=LectureSheet::all();
        return view('admin.lectureSheet.lectureSheetList',compact('lectures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.lectureSheet.addLectureSheet');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            
            'name' => 'required',
            'date' => 'required|date',
            // 'description' => 'required',
            'student_type' => 'required',
            'branch' => 'required',
            'class' => 'required',
            'batch' => 'required',
            'subject' => 'required',

            'file'=>'required|mimes:pdf,ppt,pptx'
            
        ]);

        $lecture=new LectureSheet;
        
        $lecture->name=$request->name;
        $lecture->date=$request->date;
        $lecture->description=$request->description;
        $lecture->student_type=$request->student_type;

        $lecture->branch=$request->branch;
        $lecture->class=$request->class;
        $lecture->batch=$request->batch;
        $lecture->subject=$request->subject;

        $lecture->save();

        if($file=$request->file('file')){

          
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/lecture_sheet'),$name);
            $lecture->file = $name;
            $lecture->save();
        }

        $request->session()->flash('success', 'Lecture Sheet Successfully Added');
        return redirect('admin/lecture_sheets');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lecture=LectureSheet::find($id);
        // $branches=Branch::where('student_type',1)
        //                     ->orWhere('student_type',2)
        //                     ->get();
        return view('admin.lectureSheet.editLectureSheet',compact('lecture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            
            'name' => 'required',
            'date' => 'required|date',
            // 'description' => 'required',
            'student_type' => 'required',
            'branch' => 'required',
            'class' => 'required',
            'batch' => 'required',
            'subject' => 'required',
            
            'file'=>'mimes:pdf,ppt,pptx,'
            
        ]);

        $lecture= LectureSheet::find($id);
        
        $lecture->name=$request->name;
        $lecture->date=$request->date;
        $lecture->description=$request->description;
        $lecture->student_type=$request->student_type;

        $lecture->branch=$request->branch;
        $lecture->class=$request->class;
        $lecture->batch=$request->batch;
        $lecture->subject=$request->subject;

        $lecture->save();

        if($file=$request->file('file')){
            
            if(File::exists('lecture_sheet/'.$lecture->file)) {
                
                File::delete('lecture_sheet/'.$lecture->file);
            }
          
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/lecture_sheet'),$name);
            $lecture->file = $name;
            $lecture->save();
        }

        $request->session()->flash('success', 'Lecture Sheet Successfully Updated');
        return redirect('admin/lecture_sheets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lecture=LectureSheet::find($id);
        if(File::exists('lecture_sheet/'.$lecture->file)) {
                
                File::delete('lecture_sheet/'.$lecture->file);
            }
        $lecture->delete();
        Session::flash('success', 'Lecture Sheet Deleted Successfully');
        return redirect('admin/lecture_sheets/');
    }

     public function lecture_download($path){
        
       
        
        return Response::download('lecture_sheet/'.$path);
    }

    public function lecture_view($id){
        
       
        $lecture = LectureSheet::findOrFail($id);
        return view('admin.lectureSheet.showFile',compact('lecture'));

    }
}
