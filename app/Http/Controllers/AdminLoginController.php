<?php

namespace App\Http\Controllers;

// use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;



class AdminLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);



        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))  && Auth::guard('admin')->user()->role->id == 1 ) {

            return redirect()->intended('/admin/dashboard');
        
        }elseif(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))  && Auth::guard('admin')->user()->role->id == 4){
            
            return redirect()->intended('/teacher/dashboard');
        }

        return back()->withInput($request->only('email', 'remember'));
        // return back()->with('error', 'Invalid Email address or Password');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }

    public function profile()
    {
        $admin=Auth::guard('admin')->user(); 
        return view('admin.profile.profile',compact('admin'));
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

        // return $request->all();


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
             return back();

        }
        

    }


}
