<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\NewLeads;
use App\Models\Dnc;
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
use App\Exports\LeadsExport;
use App\Exports\DNCLeadsExport;


class DncController extends Controller
{
    public function index(Request $request)
    {
        $mobile = $request->mobile;
        $landline = $request->landline;
        $email = $request->email;
        $firsttname = $request->firsttname;
        $lasttname = $request->lasttname;
        
        if(!isset($mobile)){ $mobile=""; }
        if(!isset($landline)){ $landline=""; }
        if(!isset($email)){ $email=""; }
        if(!isset($firsttname)){ $firsttname=""; }
        if(!isset($lasttname)){ $lasttname=""; }

        $data= DNC::where(function ($query) use ($mobile, $landline, $email, $firsttname, $lasttname) {
            if($mobile){
                $query->where('MobileNum',"=",$mobile);
            }
            if($landline){
                $query->where('LandlineNum',"=",$landline);
            }
            if($email){
                $query->where('Email',"=",$email);
            } 
            if($firsttname){
                $query->where('FirstName',"=",$firsttname);
            }
            if($lasttname){
                $query->where('LastName',"=",$lasttname);
            }
        })
        ->paginate(15);
        return view('dashboard/dnc')
        ->with('data',$data)
        ->with('mobile',$mobile)
        ->with('landline',$landline)
        ->with('email',$email)
        ->with('firsttname',$firsttname)
        ->with('lasttname',$lasttname);
    }
   
    public function exportLeads(Request $request)
    {
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        $supplier_id = $request->supplier_id;
        if(!isset($supplier_id)){ $supplier_id = 0; }
        $batch_id = $request->batch_id;
        if(!isset($batch_id)){ $batch_id = 0; }
        $campaign_id = $request->campaign_id;
        if(!isset($campaign_id)){ $campaign_id = 0; }         
        $mobile = $request->mobile;
        if(!isset($mobile)){ $mobile = 0; } 
        $landline = $request->landline;
        if(!isset($landline)){ $landline = 0; } 
        $email = $request->email; 
        if(!isset($email)){ $email = 0; }
        $first_name = $request->first_name;
        if(!isset($first_name)){ $first_name = 0; } 
        $last_name = $request->last_name;
        if(!isset($last_name)){ $last_name = 0; }
        
        $search_mobile = $request->search_mobile;
        $search_landline = $request->search_landline;
        $search_email = $request->search_email;
        $search_firstname = $request->search_firstname;
        $search_lastname = $request->search_lastname;
        
        if(!isset($search_mobile)){ $search_mobile=""; }
        if(!isset($search_landline)){ $search_landline=""; }
        if(!isset($search_email)){ $search_email=""; }
        if(!isset($search_firstname)){ $search_firstname=""; }
        if(!isset($search_lastname)){ $search_lastname=""; }

        $type ="csv";
        $datetime=date("Y-m-d H:i:s");
        return Excel::download(new LeadsExport($mobile, $landline, $email, $supplier_id, $batch_id, $campaign_id, $first_name, $last_name,$search_mobile,$search_landline, $search_email,$search_firstname,$search_lastname), "Leads.csv");
    }

    public function exportUniqueLeads(Request $request)
    {
        $mobile = $request->mobile;
        $landline = $request->landline;
        $email = $request->email;
        $type ="csv";
        $datetime=date("Y-m-d H:i:s");
        return Excel::download(new UniqueLeadsExport($mobile,$landline,$email), "Lead Wasing - Unique Leads.csv");
    }
    public function exportDuplicateLeads(Request $request)
    {
        $mobile = $request->mobile;
        $landline = $request->landline;
        $email = $request->email;
        $type ="csv";
        $datetime=date("Y-m-d H:i:s");
        return Excel::download(new DuplicateLeadsExport($mobile,$landline,$email), "Lead Wasing - Duplicate Leads.csv");
    }
    
    public function exportDuplicateLeads2()
    {
        
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new DuplicateLeadsExport(), "Lead Wasing - Duplicate Leads $datetime.csv");
    }

    public function exportdnc()
    {
        $datetime=date("Y-m-d His");
        setCookie("downloadStarted", 1, time() + 20, '/', "", false, false);
        return Excel::download(new DNCLeadsExport(), "DNC List - $datetime.csv");
    }

    public function export() 
    {
            return Excel::download(new UniqueExport, 'zzz.csv');
    }
    
    
}
