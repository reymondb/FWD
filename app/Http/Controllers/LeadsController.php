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

use App\Exports\UniqueLeadsExport;
use App\Exports\DuplicateLeadsExport;
use App\Exports\UniqueExport;


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

    public function contacts()
    {
       // DB::enableQueryLog(); // Enable query log
        $contacts = Contact::select('contacts.*')->with('campaign')
        ->limit(1000)
        ->get();
        //dd(DB::getQueryLog()); // Show results of log
        return view('dashboard/contacts')->with('contacts',$contacts);
    }
    
    public function exportUniqueLeads(Request $request)
    {
        $mobile_num = $request->mobile_num;
        $landline = $request->landline;
        $email = $request->email;
        $type ="csv";
        $datetime=date("Y-m-d H:i:s");
        return Excel::download(new UniqueLeadsExport($mobile_num,$landline,$email), "Lead Wasing - Unique Leads.csv");
    }
    public function exportDuplicateLeads(Request $request)
    {
        $mobile_num = $request->mobile_num;
        $landline = $request->landline;
        $email = $request->email;
        $type ="csv";
        $datetime=date("Y-m-d H:i:s");
        return Excel::download(new DuplicateLeadsExport($mobile_num,$landline,$email), "Lead Wasing - Duplicate Leads.csv");
    }
    
    public function exportDuplicateLeads2($mobile_num,$landline,$email)
    {
        
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new DuplicateLeadsExport($mobile_num,$landline,$email), "Lead Wasing - Duplicate Leads $datetime.csv");
    }

    public function exportUniqueLeads2($mobile_num,$landline,$email)
    {
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new UniqueLeadsExport($mobile_num,$landline,$email), "Lead Wasing - Unique Leads $datetime.csv");
    }

    public function export() 
    {
            return Excel::download(new UniqueExport, 'zzz.csv');
    }
    
}
