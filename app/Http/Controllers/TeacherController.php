<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers=Admin::where('role_id',4)->get();
        return view('admin.teacher.teacherList',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.teacher.addTeacher');
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
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',

            
        ]);

        $teacher=new Admin;
        $teacher->name=$request->name;
        $teacher->email=$request->email;
        $teacher->role_id=4;
        $teacher->password=bcrypt($request->password);
        $teacher->save();

        return redirect('admin/teachers/');
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
        $teacher=Admin::find($id);
        return view('admin.teacher.editTeacher',compact('teacher'));
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
            'email' => 'required|email',

        ]);

        $teacher=Admin::find($id);
        $teacher->name=$request->name;
        $teacher->email=$request->email;
        $teacher->save();

        return redirect('admin/teachers/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $teacher=Admin::find($id);
        $teacher->delete();
        return redirect('admin/teachers/');
    }
}
