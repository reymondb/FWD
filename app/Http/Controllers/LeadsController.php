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
use App\Exports\LeadsExport;

class LeadsController extends Controller
{
    public function index(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $batch_id = $request->batch_id;
        $campaign_id = $request->campaign_id;         
        $mobile_num = $request->mobile_num; 
        $landline = $request->landline; 
        $email = $request->email; 
        $first_name = $request->first_name; 
        $last_name = $request->last_name;
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
        if(!isset($mobile_num)){ $mobile_num=2; }
        if(!isset($landline)){ $landline=2; }
        if(!isset($email)){ $email=2; }
        if(!isset($first_name)){ $first_name=2; }
        if(!isset($last_name)){ $last_name=2; }
        
        //DB::enableQueryLog(); // Enable query log
        $contacts = Contact::select('contacts.*','CampaignName')
        ->leftjoin("contacts",'lead_list.ContactID','contacts.id')
        ->leftjoin("campaign",'contacts.campaign_id','campaign.id')
        ->where(function ($query) use ($batch_id,$supplier_id,$campaign_id, $mobile_num, $landline, $email, $first_name, $last_name, $search_mobile,$search_landline,$search_email, $search_firstname, $search_lastname) {
            if($search_mobile){
                $query->where('MobileNum',"=",$search_mobile);
            }
            if($search_landline){
                $query->where('LandlineNum',"=",$search_landline);
            }
            if($search_email){
                $query->where('Email',"=",$search_email);
            } 
            if($search_firstname){
                $query->where('FirstName',"=",$search_firstname);
            }
            if($search_lastname){
                $query->where('LastName',"=",$search_lastname);
            }
            if($batch_id){
                $query->where('BatchID',$batch_id);
            }
            if($supplier_id){
                $query->where('supplier_id',$supplier_id);
            }
            if($campaign_id){
                $query->where('campaign_id',$campaign_id);
            }
            if($mobile_num==1){
                $query->where('MobileNum', '!=' ,null);
            }
            elseif($mobile_num==0){
                $query->where(function ($query2) {
                    $query2->whereNull('MobileNum')->orwhere('MobileNum', '=' ,"");
                });
               # $query->where('MobileNum', '=' ,null)->orwhere('LastName', '=' ,"");
            }
            if($landline==1){
                $query->where('LandlineNum', '!=' ,null);
            }
            elseif($landline==0){
                $query->where(function ($query2) {
                    $query2->whereNull('LandlineNum')->orwhere('LandlineNum', '=' ,"");
                });
                #$query->where('LandlineNum', '=' ,null)->orwhere('LastName', '=' ,"");
            }
            if($email==1){
                $query->where('Email', '!=' ,null);
            }
            elseif($email==0){
                $query->where(function ($query2) {
                    $query2->whereNull('Email')->orwhere('Email', '=' ,"");
                });
                #$query->where('Email', '=' ,null)->orwhere('LastName', '=' ,"");
            }
            if($first_name==1){ 
                $query->where('FirstName', '!=' ,null);
            }
            elseif($first_name==0){
                $query->where(function ($query2) {
                    $query2->whereNull('FirstName')->orwhere('FirstName', '=' ,"");
                });
                #$query->where('FirstName', '=' ,null)->orwhere('LastName', '=' ,"");
            }
            if($last_name==1){
                $query->where('LastName', '!=' ,null);
            }
            elseif($last_name==0){
                $query->where(function ($query2) {
                    $query2->whereNull('LastName')->orwhere('LastName', '=' ,"");
                });
                
            }
        })
        ->paginate(15);
        //dd(DB::getQueryLog());
        $LeadBatch = LeadBatch::all();
        $User = User::all();
        $Campaigns = Campaigns::all();
        return view('dashboard/leads')->with('LeadBatch',$LeadBatch)->with('User',$User)->with('Campaigns',$Campaigns)
        ->with('supplier_id',$supplier_id)->with('batch_id',$batch_id)->with('campaign_id',$campaign_id)        
        ->with('mobile_num',$mobile_num)
        ->with('landline',$landline)
        ->with('email',$email)
        ->with('first_name',$first_name)
        ->with('last_name',$last_name)
        ->with('contacts',$contacts)
        ->with('search_mobile',$search_mobile)
        ->with('search_landline',$search_landline)
        ->with('search_email',$search_email)
        ->with('search_firstname',$search_firstname)
        ->with('search_lastname',$search_lastname);
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
        $mobile_num = $request->mobile_num;
        if(!isset($mobile_num)){ $mobile_num = 0; } 
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
        return Excel::download(new LeadsExport($mobile_num, $landline, $email, $supplier_id, $batch_id, $campaign_id, $first_name, $last_name,$search_mobile,$search_landline, $search_email,$search_firstname,$search_lastname), "Leads.csv");
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
