<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompanyDetail;

class CompanyDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company=CompanyDetail::first();
        return view('admin.companyDetail.companyDetail',compact('company'));
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
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'facebook' => 'required',
            'establishDate' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $company=new CompanyDetail();
        $company->name= $request->name;
        $company->email= $request->email;
        $company->phone= $request->phone;
        $company->address= $request->address;
        $company->facebook= $request->facebook;
        $company->establishDate= $request->establishDate;
        $company->save();

        if($file=$request->file('logo')){
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/company'),$name);
            $company->logo = $name;
            $company->save();
        }

        if($file=$request->file('favicon')){
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/company'),$name);
            $company->favicon = $name;
            $company->save();
        }


        $request->session()->flash('success', 'Company Information Successfully Updated');
        return redirect('admin/company');
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


        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'facebook' => 'required',
            'establishDate' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $company=CompanyDetail::find($id);
        $company->name= $request->name;
        $company->email= $request->email;
        $company->phone= $request->phone;
        $company->address= $request->address;
        $company->facebook= $request->facebook;
        $company->establishDate= $request->establishDate;
        $company->save();

        if($file=$request->file('logo')){
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/company'),$name);
            $company->logo = $name;
            $company->save();
        }

        if($file=$request->file('favicon')){
           
            $name=time().$file->getClientOriginalName();
            $file->move(public_path('/company'),$name);
            $company->favicon = $name;
            $company->save();
        }


        $request->session()->flash('success', 'Company Information Successfully Updated');
        return redirect('admin/company');
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
