<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
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
        $total=Contact::select(DB::raw('count(id) as total'))->get();
        
        $data=[];
        return view('dashboard/dashboard')->with('total', $total);  
    }

    public function leadschart()
    {
        //DB::enableQueryLog();
        $leads=CampaignUse::select(DB::raw('CONCAT(campaign.CampaignName,"(",count(campaign_use.id),")") as CampaignName'),DB::raw('count(campaign_use.id) as total'))
        ->leftjoin('campaign','campaign_use.CampaignID','campaign.id')->groupby('campaign_use.CampaignID')->get();
        //dd(DB::getQueryLog());
        return response()->json($leads);
    }

    public function blankchart()
    {
        //DB::enableQueryLog();
        
        $mobile=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LandlineNum')
        ->orwhere('LandlineNum',"=","")->get();
        $landline=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('MobileNum')
        ->orwhere('MobileNum',"=","")->get();
        $email=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('Email')
        ->orwhere('Email',"=","")->get();
        $firstname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('FirstName')
        ->orwhere('FirstName',"=","")->get();
        $lastname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LastName')
        ->orwhere('LastName',"=","")->get();
        $data=array();
        $data[0] = array('Label' => 'No Mobile ('.$mobile[0]->total.')','totals' =>$mobile[0]->total);
        $data[1] = array('Label' => 'No Landline ('.$landline[0]->total.')','totals' => $landline[0]->total);
        $data[2] = array('Label' => 'No Email ('.$email[0]->total.')','totals' => $email[0]->total);
        $data[3] = array('Label' => 'No Firstname ('.$firstname[0]->total.')','totals' => $firstname[0]->total);
        $data[4] = array('Label' => 'No Lastname ('.$lastname[0]->total.')','totals' => $lastname[0]->total);
        
        //dd(DB::getQueryLog());
        return response()->json($data);
    }

    public function supplierchart()
    {
        //DB::enableQueryLog();
        $leads=Contact::select(DB::raw('CONCAT(users.name,"(",count(contacts.id),")") as supplier'),DB::raw('count(contacts.id) as totals'))
        ->leftjoin('users','contacts.supplier_id','users.id')->groupby('contacts.supplier_id')->get();
        //dd(DB::getQueryLog());
        return response()->json($leads);
    }

}
