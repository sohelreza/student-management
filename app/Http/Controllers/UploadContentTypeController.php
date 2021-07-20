<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UploadContentType;
use Session;

class UploadContentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content_types=UploadContentType::all();
        return view('admin.contentType.contentTypeList',compact('content_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.contentType.addContentType');
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
        ]);

        UploadContentType::create($request->all());
        $request->session()->flash('success', 'Content Type Added Successfully');
        return redirect('admin/upload_content_types/');
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
        $content_type=UploadContentType::find($id);
        return view('admin.contentType.editContentType',compact('content_type'));
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
        ]);

        $content_type=UploadContentType::find($id);
        $content_type->name=$request->name;
        $content_type->save();
        
        $request->session()->flash('success', 'Content Type Updated Successfully');
        return redirect('admin/upload_content_types/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content_type=UploadContentType::find($id);
        $content_type->delete();
        Session::flash('success', 'Content Type Deleted Successfully');
        return redirect('admin/upload_content_types/');
    }
}
