<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZoomApi;

class ZoomApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apis=ZoomApi::all();
        return view('admin.zoomApi.apiList',compact('apis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.zoomApi.zoomApiAdd');
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
            'zoom_api_key' => 'required',
            'zoom_api_secret' => 'required',
            'zoom_api_name' => 'required',
           
        ]);

        $zoomapi=new ZoomApi();
        $zoomapi->zoom_api_key= $request->zoom_api_key;
        $zoomapi->zoom_api_secret= $request->zoom_api_secret;
        $zoomapi->zoom_api_name= $request->zoom_api_name;

        $zoomapi->save();

        $request->session()->flash('success', 'Zoom Api Information Successfully Updated');
        return redirect('admin/zoomApis');
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
        $zoomapi=ZoomApi::find($id);
        return view('admin.zoomApi.zoomApi',compact('zoomapi'));
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
            'zoom_api_name' => 'required',
            'zoom_api_key' => 'required',
            'zoom_api_secret' => 'required',
           
        ]);

        $zoomapi=ZoomApi::find($id);
        $zoomapi->zoom_api_name= $request->zoom_api_name;
        $zoomapi->zoom_api_key= $request->zoom_api_key;
        $zoomapi->zoom_api_secret= $request->zoom_api_secret;
        $zoomapi->save();

        $request->session()->flash('success', 'Zoom Api Information Successfully Updated');
        return redirect('admin/zoomApis');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $api=ZoomApi::find($id);
        $api->delete();
        return redirect('admin/zoomApis/');
    }
}
