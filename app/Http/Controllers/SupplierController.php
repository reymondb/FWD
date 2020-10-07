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
        
        $supplier = new User;
        $supplier->name = $_POST['name'];
        $supplier->email = $_POST['email'];
        $supplier->password = Hash::make($_POST['password']);
        $supplier->save();

        return redirect('/supplier')->with('status', 'saved');

    }

    
    public function editSupplier(Request $request){
        
        $supplier = User::where('id',$request->id)->first();
        $supplier->name = $request->editname;
        $supplier->email = $request->editemail;
        
        if($request['editpassword'] != null || $request['editpassword'] != ''){
            $supplier->password = Hash::make($request['editpassword']);
        }
        $supplier->save();

        return redirect('/supplier')->with('status', 'saved');

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
