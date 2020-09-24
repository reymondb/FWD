<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\NewLeads;
use App\Models\LeadBatch;
use App\Models\LeadList;
use App\User;
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
    public function index(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $batch_id = $request->batch_id;
        $campaign_id = $request->campaign_id; 
        
        //DB::enableQueryLog(); // Enable query log
        $contacts = LeadList::select('contacts.*','CampaignName')
        ->leftjoin("contacts",'lead_list.ContactID','contacts.id')
        ->leftjoin("campaign",'lead_list.CampaignID','campaign.id')
        ->where(function ($query) use ($batch_id,$supplier_id,$campaign_id) {
            if($batch_id){
                $query->where('BatchID',$batch_id);
            }
            if($supplier_id){
                $query->where('supplier_id',$supplier_id);
            }
            if($campaign_id){
                $query->where('CampaignID',$campaign_id);
            }
        })
        ->paginate(15);
        //dd(DB::getQueryLog());
        $LeadBatch = LeadBatch::all();
        $User = User::all();
        $Campaigns = Campaigns::all();
      
        return view('dashboard/leads')->with('LeadBatch',$LeadBatch)->with('User',$User)->with('Campaigns',$Campaigns)
        ->with('supplier_id',$supplier_id)->with('batch_id',$batch_id)->with('campaign_id',$campaign_id)
        ->with('contacts',$contacts);
    }
    public function filter_leads(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $batch_id = $request->batch_id;
        $campaign_id = $request->campaign_id;
        //DB::enableQueryLog(); // Enable query log
        $contacts = Contact::where('supplier_id',1)->paginate(15);
        #$contacts = LeadList::where('batch_id')
        //dd(DB::getQueryLog()); // Show results of log 
        $LeadBatch = LeadBatch::all();
        $User = User::all();
        $Campaigns = Campaigns::all();
        return view('dashboard/filter_leads')->with('LeadBatch',$LeadBatch)->with('User',$User)->with('Campaigns',$Campaigns)
        ->with('supplier_id',$supplier_id)->with('batch_id',$batch_id)->with('campaign_id',$campaign_id)
        ->with('contacts',$contacts);
        
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
    
    public function exportDuplicateLeads2()
    {
        
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new DuplicateLeadsExport(), "Lead Wasing - Duplicate Leads $datetime.csv");
    }

    public function exportUniqueLeads2()
    {
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new UniqueLeadsExport(), "Lead Wasing - Unique Leads $datetime.csv");
    }

    public function export() 
    {
            return Excel::download(new UniqueExport, 'zzz.csv');
    }
    
}
