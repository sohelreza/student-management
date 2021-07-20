<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadContentType;
use App\Content;
use Response;
use File;
use Storage;
use Session;


class AdminContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contents=Content::all();
        return view('admin.content.contentList',compact('contents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $content_types=UploadContentType::all();
        return view('admin.content.addContent',compact('content_types'));
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
            
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            // 'description' => 'required',
            'student_type' => 'required',

            'branch' => 'required',
            'class' => 'required',
            'batch' => 'required',
            'subject' => 'required',
            'file'=>'required|mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg,ppt,pptx'
            
        ]);

        $content=new Content;
        
        $content->title=$request->title;
        $content->type=$request->type;
        $content->date=$request->date;
        $content->description=$request->description;
        $content->student_type=$request->student_type;
        $content->branch=$request->branch;
        $content->class=$request->class;
        $content->batch=$request->batch;
        $content->subject=$request->subject;

        $content->save();

        if($file=$request->file('file')){

            // if(File::exists('/content/'.$content->file)) {
            //     return "ase";
            //     File::delete('/content/'.$content->file);
            // }
                 
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/content'),$name);
            $content->file = $name;
            $content->save();
        }

        $request->session()->flash('success', 'Content Successfully Added');
        return redirect('admin/contents');

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
        $content=Content::find($id);
        $content_types=UploadContentType::all();
        return view('admin.content.editContent',compact('content_types','content'));
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
            
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            // 'description' => 'required',
            'student_type' => 'required',
            'branch' => 'required',
            'class' => 'required',
            'batch' => 'required',
            'subject' => 'required',
            
            'file'=>'mimes:doc,pdf,docx,zip,jpeg,png,jpg,gif,svg,ppt,pptx'
            
        ]);

        $content=Content::find($id);
        
        $content->title=$request->title;
        $content->type=$request->type;
        $content->date=$request->date;
        $content->description=$request->description;
        $content->student_type=$request->student_type;

        $content->branch=$request->branch;
        $content->class=$request->class;
        $content->batch=$request->batch;
        $content->subject=$request->subject;

        $content->save();

        if($file=$request->file('file')){

             if(File::exists('content/'.$content->file)) {
                
                File::delete('content/'.$content->file);
            }
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/content'),$name);
            $content->file = $name;
            $content->save();
        }

        $request->session()->flash('success', 'Content Successfully Updated');
        return redirect('admin/contents');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content=Content::find($id);
        if(File::exists('content/'.$content->file)) {
                
                File::delete('content/'.$content->file);
            }
        $content->delete();
        Session::flash('success', ' Content Deleted Successfully');
        return redirect('admin/contents/');
    }


     public function content_download($path){
        
       
        
        return Response::download('content/'.$path);
    }

    public function content_view($id){
        
       
        $content = Content::findOrFail($id);
        return view('admin.content.showFile',compact('content'));

    }



}
