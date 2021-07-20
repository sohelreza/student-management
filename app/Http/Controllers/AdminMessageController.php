<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Session;

class AdminMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages=Message::all();
        return view('admin.message.messageList',compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.message.addMessage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->all_student) {
                
                $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'all_student' => 'required',
                'status'=>'required'
            ]);

                $message=new Message;
        
                $message->title=$request->title;
                $message->date=$request->date;
                $message->message=$request->message;
                $message->all_student=$request->all_student;
                $message->student_type=null;
                $message->branch=null;
                $message->class=null;
                $message->batch=null;
                $message->status=$request->status;

                $message->save();
        
        } else {
            
            $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'student_type' => 'required',
                'branch' => 'required',
                'class' => 'required',
                'batch' => 'required',
                'status'=>'required'
                
            ]);

            $message=new Message;
        
            $message->title=$request->title;
            $message->date=$request->date;
            $message->message=$request->message;
            $message->all_student=null;
            $message->student_type=$request->student_type;
            $message->branch=$request->branch;
            $message->class=$request->class;
            $message->batch=$request->batch;
            $message->status=$request->status;

            $message->save();
        }
        
        

        

        $request->session()->flash('success', 'Message Successfully Added');
        return redirect('admin/messages');
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
        $message=Message::find($id);
        return view('admin.message.editMessage',compact('message'));
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
        if ($request->all_student) {
                
                $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'all_student' => 'required',
                'status'=>'required'
            ]);

                $message=Message::find($id);
        
                $message->title=$request->title;
                $message->date=$request->date;
                $message->message=$request->message;
                $message->all_student=$request->all_student;
                $message->student_type=null;
                $message->branch=null;
                $message->class=null;
                $message->batch=null;
                $message->status=$request->status;

                $message->save();
        
        } else {
            
            $request->validate([
                
                'title' => 'required',
                'date' => 'required|date',
                'message' => 'required',
                'student_type' => 'required',
                'branch' => 'required',
                'class' => 'required',
                'batch' => 'required',
                'status'=>'required'
                
            ]);

            $message=Message::find($id);
            
        
            $message->title=$request->title;
            $message->date=$request->date;
            $message->message=$request->message;
            $message->all_student=null;
            $message->student_type=$request->student_type;
            $message->branch=$request->branch;
            $message->class=$request->class;
            $message->batch=$request->batch;
            $message->status=$request->status;

            $message->save();
        }
        

        $request->session()->flash('success', 'Message Successfully Updated');
        return redirect('admin/messages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $message = Message::findOrFail($id);
        $message->delete();
        return redirect('admin/messages/');
    }
}
