<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use Session;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches=Branch::all();
        return view('admin.branch.branchList',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.branch.addBranch');
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
            'address'=>'required',
            'student_type'=>'required'
        ]);

        Branch::create($request->all());
        $request->session()->flash('success', 'Branch Added Successfully');
        return redirect('admin/branches/');
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
        $branch=Branch::find($id);
        return view('admin.branch.editBranch',compact('branch'));
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
            'address'=>'required',
            'student_type'=>'required'
        ]);

        $branch=Branch::find($id);
        $branch->name=$request->name;
        $branch->address=$request->address;
        $branch->student_type=$request->student_type;
        $branch->save();

        $request->session()->flash('success', 'Branch Updated Successfully'); 
        return redirect('admin/branches/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin=Branch::find($id);
        $admin->delete();
        Session::flash('success', 'Branch Deleted Successfully');
        return redirect('admin/branches/');
    }
}
