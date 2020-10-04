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
        $leads=CampaignUse::select('campaign.CampaignName',DB::raw('count(campaign_use.id) as total'))
        ->leftjoin('campaign','campaign_use.CampaignID','campaign.id')->get();
        //dd(DB::getQueryLog());
        return response()->json($leads);
    }

}
