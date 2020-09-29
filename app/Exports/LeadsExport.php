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

    public function __construct(int $mobile_num,int $landline,int $email,int $supplier_id,int $batch_id,int $campaign_id,int $first_name,int $last_name)
    {
        $this->supplier_id = $supplier_id;
        $this->batch_id = $batch_id;
        $this->campaign_id = $campaign_id;
        $this->landline = $landline;
        $this->mobile_num = $mobile_num;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
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
        
        $contacts = LeadList::select('contacts.*','CampaignName')
        ->leftjoin("contacts",'lead_list.ContactID','contacts.id')
        ->leftjoin("campaign",'lead_list.CampaignID','campaign.id')
        ->where(function ($query) use ($batch_id,$supplier_id,$campaign_id, $mobile_num, $landline, $email, $first_name, $last_name) {
            if($batch_id!=0){
                $query->where('BatchID',$batch_id);
            }
            if($supplier_id!=0){
                $query->where('supplier_id',$supplier_id);
            }
            if($campaign_id!=0){
                $query->where('CampaignID',$campaign_id);
            }
            
            if($mobile_num==1){
                $query->where('MobileNum', '!=' ,null);
            }
            elseif($mobile_num==0){
                $query->where('MobileNum', '=' ,null);
            }
            if($landline==1){
                $query->where('LandlineNum', '!=' ,null);
            }
            elseif($landline==0){
                $query->where('LandlineNum', '=' ,null);
            }
            if($email==1){
                $query->where('Email', '!=' ,null);
            }
            elseif($email==0){
                $query->where('Email', '=' ,null);
            }
            if($first_name==1){
                $query->where('FirstName', '!=' ,null);
            }
            elseif($first_name==0){
                $query->where('FirstName', '=' ,null);
            }
            if($last_name==1){
                $query->where('LastName', '!=' ,null);
            }
            elseif($last_name==0){
                $query->where('LastName', '=' ,null);
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
