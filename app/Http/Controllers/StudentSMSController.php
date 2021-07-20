<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Sms;

class StudentSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sms(Request $request)
    {
        $student=User::find($request->student_id);

        $message=Sms::where(function($query) use ($student){
                               $query->where('student_type',$student->student_type);
                               $query->where('branch',$student->branch_id);
                               $query->where('batch',$student->batch_id);
                               $query->where('class',$student->class_id);
                               $query->orderBy('id', 'desc');
                        }) 
                        ->orWhere(function($query) use ($student){
                               $query->where('student_type',null);
                               $query->where('branch',null);
                               $query->where('batch',null);
                               $query->where('class',null);
                               $query->orderBy('id', 'desc');
                        }) 
                        ->get();
        return response($message); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
