<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subject;
use App\ClassName;
use App\Branch;
use Session;
use DB;


class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects=Subject::all();
        return view('admin.subject.subjectList',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $classes=ClassName::distinct('name')->select('id','name')->get();
      
        
        $branches=Branch::all();
        return view('admin.subject.addSubject',compact('branches'));
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
            'class_id'=>'required',
            'branch_id'=>'required',
            'amount'=>'required',
            'student_type'=>'required'
        ]);

        Subject::create($request->all());
        $request->session()->flash('success', 'Subject Added Successfully');
        return redirect('admin/subjects/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $subject=Subject::find($id);
       $branches=Branch::all();
       return view('admin.subject.editSubject',compact('subject', 'branches')); 
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
            'class_id'=>'required',
            'branch_id'=>'required',
            'amount'=>'required',
            'student_type'=>'required'
        ]);

        $subject=Subject::find($id);
        $subject->name=$request->name;
        $subject->class_id=$request->class_id;
        $subject->branch_id=$request->branch_id;
        $subject->amount=$request->amount;
        $subject->student_type=$request->student_type;

        $subject->save();

        $request->session()->flash('success', 'Subject Updated Successfully'); 
        return redirect('admin/subjects/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject=Subject::find($id);
        $subject->delete();

        Session::flash('success', 'Subject Deleted Successfully');
        return redirect('admin/subjects/');
    }
}
