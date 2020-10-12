<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use DB;
use Auth;
use Illuminate\Http\Request;

class SupplierController extends Controller
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
    public function supplier()
    {
        $suppliers=User::where('id','!=','1')->get();
        return view('dashboard/supplier')->with('suppliers',$suppliers);
    }
    
    public function createSupplier(Request $request){
        try {
            $supplier = new User;
            $supplier->name = $_POST['name'];
            $supplier->email = $_POST['email'];
            $supplier->role = $_POST['role'];
            $supplier->password = Hash::make($_POST['password']);
            $supplier->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $suppliers=User::where('id','!=','1')->get();
            return view('dashboard/supplier')->with('suppliers',$suppliers)->with('error',"Email already exist.");
        }

        
        $suppliers=User::where('id','!=','1')->get();
        return view('dashboard/supplier')->with('suppliers',$suppliers)->with('status',"success");

    }

    
    public function editSupplier(Request $request){
        try {
            $supplier = User::where('id',$request->id)->first();
            $supplier->name = $request->editname;
            $supplier->email = $request->editemail;
            $supplier->role = $request->editrole;
            
            if($request['editpassword'] != null || $request['editpassword'] != ''){
                $supplier->password = Hash::make($request['editpassword']);
            }
            $supplier->save();
        } catch (\Illuminate\Database\QueryException $e) {
            $suppliers=User::where('id','!=','1')->get();
            return view('dashboard/supplier')->with('suppliers',$suppliers)->with('error',"Email already exist.");
        }

        return redirect('/supplier')->with('status', 'saved');

    }
    public function deletesupplier($id){
        $supplier = User::where('id',$id)->delete();
        return redirect('/supplier')->with('status', 'deleted');
    }

    public function deleteCampaign($id)
    {
        $delete = User::where('id', $id)->delete();

        return redirect('/supplier')->with('status', 'deleted');
    }

    public function editCampaign(Request $request){

        $supplier = Campaigns::where('id', $_POST['id'])->first();
        $supplier->CampaignName = $_POST['editname'];
        $supplier->save();

        return redirect('/supplier')->with('status', 'saved');

    }
}
