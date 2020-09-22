<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\NewLeads;

use DB;

class DuplicateLeadsExportz implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(int $mobile_num,int $landline,int $email)
    {
        $this->mobile_num = $mobile_num;
        $this->email = $email;
        $this->landline = $landline;
    }

    public function query()
    {
        $landline =$this->landline;
        $mobile_num =$this->mobile_num;
        $email =$this->email;
        //DB::enableQueryLog(); // Enable query log
        $duplicates = NewLeads::select('new_leads.MobileNum',
                                'new_leads.LandlineNum',
                                'new_leads.PhoneCode',
                                'new_leads.ListID',
                                'new_leads.FirstName',
                                'new_leads.LastName',
                                'new_leads.Address',
                                'new_leads.City',
                                'new_leads.State',
                                'new_leads.Zip',
                                'new_leads.Email',
                                'new_leads.OptInWhere',
                                'new_leads.OptInWhen',
                                'new_leads.DateFirstImported',
                                'new_leads.LastDNCWashing',
                                'new_leads.LastDNCResult')
                    ->leftJoin('contacts', function($join)use($mobile_num,$landline,$email){
                        if($mobile_num==1){
                            $join->orOn('contacts.MobileNum','=','new_leads.MobileNum');
                        }
                        if($landline==1){
                            $join->orOn('contacts.LandlineNum','=','new_leads.LandlineNum');
                        }
                        if($email==1){
                            $join->orOn('contacts.Email','=','new_leads.Email');
                        }
                    })
                    ->leftjoin("campaign_use",'campaign_use.ContactID','contacts.id')
                    ->leftjoin("campaign",'campaign.id','campaign_use.CampaignID')
                    ->whereNotNull('contacts.id')
                    ->groupBy('new_leads.id');
                   // dd(DB::getQueryLog());die();
        return $duplicates;
    }

    public function headings() : array
    {
        return [            
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
        'LastDNCResult'
        ];
    }
}
