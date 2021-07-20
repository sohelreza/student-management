<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ClassName;
use App\Branch;
use Session;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes=ClassName::all();
        return view('admin.class.classList',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches=Branch::all();
        return view('admin.class.addClass',compact('branches'));
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
            'branch_id'=>'required',
            'year'=>'required',
            'status'=>'required'
        ]);

        ClassName::create($request->all());
        $request->session()->flash('success', 'Class Added Successfully');
        return redirect('admin/classes');
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
       $branches=Branch::all();
       $class=ClassName::find($id);
       return view('admin.class.editClass',compact('branches', 'class')); 
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
            'branch_id'=>'required',
            'year'=>'required',
            'status'=>'required'
        ]);

        $class=ClassName::find($id);
        $class->name=$request->name;
        $class->branch_id=$request->branch_id;
        $class->year=$request->year;
        $class->status=$request->status;
        $class->save();

        $request->session()->flash('success', 'Class Updated Successfully');
        return redirect('admin/classes/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class=ClassName::find($id);
        $class->delete();
        Session::flash('success', ' Class Deleted Successfully');
        return redirect('admin/classes/');
    }
}
