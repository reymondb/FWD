<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Content;
use Auth;
use DB;


class DashboardController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data=[];
            return view('dashboard/dashboard')->with('data', $data);
        //}elseif(Gate::allows('tpl-only', auth()->user())){
        //   return redirect('/thirdparty/dashboard');
        //}
            
       

    }

    public function getContents()
    {
        $data = Content::all();

        return view('dashboard/content')->with('data', $data);
    }

    public function editContent(Request $request){
        
        $content = Content::where('id', $_POST['id'])->first();
        
            $content->title = $_POST['title'];
            $content->content = $_POST['content'];
            
            
            $content->save();

           
            return redirect('/content')->with('status', 'saved');
        
    }

}
