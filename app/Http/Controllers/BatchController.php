<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batch;
use Session;
use App\Branch;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batches=Batch::all();
        return view('admin.batch.batchList',compact('batches'));
    }

    public function activeBatch()
    {
        $batches=Batch::where('status',1)->get();
        return view('admin.batch.activeBatchList',compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches=Branch::all();
        return view('admin.batch.addBatch',compact('branches'));
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
            
            'class_id'=>'required',
            'branch_id'=>'required',
            'name'=>'required',
            'time'=>'required',
            'max_student_number'=>'required',
            'student_type'=>'required',
            'status'=>'required'
        ]);

        $batch=new Batch();
        $batch->class_id=$request->class_id;
        $batch->branch_id=$request->branch_id;
        $batch->name=$request->name;
        $batch->time=$request->time;
        $batch->max_student_number=$request->max_student_number;
        $batch->student_number=0;
        // $batch->phase=$request->phase;
        $batch->status=$request->status;
        $batch->student_type=$request->student_type;
        $batch->save();
        
        $request->session()->flash('success', 'Batch Added Successfully');
        return redirect('admin/batches/');
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
        $batch=Batch::find($id);
        $branches=Branch::all();
        return view('admin.batch.editBatch',compact('batch','branches'));
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
            
            'class_id'=>'required',
            'branch_id'=>'required',
            'name'=>'required',
            'time'=>'required',
            'max_student_number'=>'required',
            'student_type'=>'required',
            'status'=>'required'
        ]);

        $batch=Batch::find($id);
        $batch->class_id=$request->class_id;
        $batch->branch_id=$request->branch_id;
        $batch->name=$request->name;
        $batch->time=$request->time;
        $batch->max_student_number=$request->max_student_number;
        // $batch->phase=$request->phase;
        $batch->status=$request->status;
        $batch->student_type=$request->student_type;
        $batch->save();
        
        $request->session()->flash('success', 'Batch Updated Successfully'); 
        return redirect('admin/batches/');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch=Batch::find($id);
        $batch->delete();

        Session::flash('success', 'Batch Deleted Successfully');
        return redirect('admin/batches/');
    }
}
