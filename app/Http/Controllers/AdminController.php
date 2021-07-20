<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins=Admin::where('role_id',1)->get();

        return view('admin.admin.adminList',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.addAdmin');
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

        $admin=new Admin;
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->role_id=1;

        $admin->password=bcrypt($request->password);
        $admin->save();

        return redirect('admin/admins/');


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

        $admin=Admin::find($id);
        return view('admin.admin.editAdmin',compact('admin'));
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

        $admin=Admin::find($id);
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->save();

        return redirect('admin/admins/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin=Admin::find($id);
        $admin->delete();
        return redirect('admin/admins/');
    }

    public function changeProfile(Request $request){
        $this->validate($request, [
            
            'name'   => 'required',
            'email'   => 'required|email',
            
        ]);

        $admin=Auth::guard('admin')->user(); 
        $admin->name=$request->name;
        $admin->email=$request->email;
        $admin->save();
        
        return back();
    }

    public function changePassword(Request $request){

        


        $request->validate([
           
            'old_password'=>'required',
            'new_password'=> 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        
        $admin=Auth::guard('admin')->user(); 

        if ((Hash::check(request('old_password'), $admin->password)) == false) {
            return back()->withErrors('Please enter correct current password');
        }else{
             $admin->update(['password'=>bcrypt($request->new_password)]);
             return back()->with('success','Password has been changed');

        }
        

    }

}
