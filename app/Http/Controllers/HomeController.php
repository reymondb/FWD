<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()) {
            return redirect('/home');
        } else {
            return view('auth.login');
        }
    }

    
    public function profile()
    {
        $user=Auth::user();
        $user=User::where('id',$user->id)->first();
        return view('dashboard/profile')->with('user',$user);        
    }

    public function edit_profile(Request $request)
    {
        $user=Auth::user();
        $user=User::where('id',$user->id)->first();
        
        $user->email = $request['email'];
        $user->name = $request['name'];
        if($request['password'] != null || $request['password'] != ''){
            $user->password = Hash::make($request['password']);
        }
        $user->save();   
        return view('dashboard/profile')->with('user',$user)->with('status',1);     
    }

    

    
}
