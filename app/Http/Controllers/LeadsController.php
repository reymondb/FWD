<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\NewLeads;
use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class LeadsController extends Controller
{

    
    public function index()
    {
        //DB::enableQueryLog(); // Enable query log
        $contacts = Contact::select('contacts.*','campaign.CampaignName')->leftjoin("campaign_use",'campaign_use.ContactID','contacts.id')
        ->leftjoin("campaign",'campaign.id','campaign_use.CampaignID')
        ->groupBy('contacts.id')
        ->limit(1000)
        ->get();
        //dd(DB::getQueryLog()); // Show results of log
        return view('dashboard/leads')->with('contacts',$contacts);
    }
    

}
