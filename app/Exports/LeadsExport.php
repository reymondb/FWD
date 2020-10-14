<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
 
use App\Models\LeadList;

use DB;

class LeadsExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(int $mobile_num,int $landline,int $email,int $supplier_id,int $batch_id,int $campaign_id,int $first_name,int $last_name, $search_mobile,$search_landline, $search_email,$search_firstname,$search_lastname)
    {
        $this->supplier_id = $supplier_id;
        $this->batch_id = $batch_id;
        $this->campaign_id = $campaign_id;
        $this->landline = $landline;
        $this->mobile_num = $mobile_num;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        
        $this->search_mobile = $search_mobile;
        $this->search_landline = $search_landline;
        $this->search_email = $search_email;
        $this->search_firstname = $search_firstname;
        $this->search_lastname = $search_lastname;
    }

    public function query()
    {
        
        $batch_id =$this->batch_id;
        $supplier_id =$this->supplier_id;
        $campaign_id =$this->campaign_id;
        $mobile_num =$this->mobile_num;
        $landline =$this->landline;
        $email =$this->email;
        $first_name =$this->first_name;
        $last_name =$this->last_name;
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
        //DB::enableQueryLog(); // Enable query log
        $contacts = LeadList::select('contacts.*','CampaignName')
        ->leftjoin("contacts",'lead_list.ContactID','contacts.id')
        ->leftjoin("campaign",'lead_list.CampaignID','campaign.id')
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
                $query->where('CampaignID',$campaign_id);
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
        });
            
        return $contacts;
    }

    public function headings() : array
    {
        return [            
            'id',
        'MobileNum',
        'LandlineNum',
        'PhoneCode',
        'ListID',
        'FirstName',
        'LastName',
        'Address',
        'City',
        'State',
        'Zip',
        'Email',
        'OptInWhere',
        'OptInWhen',
        'DateFirstImported',
        'LastDNCWashing',
        'LastDNCResult',
        'CampaignName'
        ];
    }
}
