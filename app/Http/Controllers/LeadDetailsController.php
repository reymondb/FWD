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
use config;
use App\Exports\UniqueLeadsExport;
use App\Exports\DuplicateLeadsExport;
use App\Exports\UniqueExport;
use App\Exports\LeadsExport;

class LeadDetailsController extends Controller
{
    public function index(Request $request)
    {
        /*
        mysql_external
        url MySQL_url
        database Mysql_db
        username Mysql_username
        password Mysql_password*/
    }

    
    public function fetchDetails(Request $request)
    {
        if(isset($request->landline)){
            $num = $request->landline;
            $getcampaign=Contact::where('LandlineNum',$request->landline)->groupby('campaign_id')->get();
        }
        if(isset($request->mobile)){
            $num = $request->mobile;
            $getcampaign=Contact::where('MobileNum',$request->mobile)->groupby('campaign_id')->get();
            
        }

        if($getcampaign){
            
            $data=array();
            foreach($getcampaign as $k=>$c){
                $source=Campaigns::where('id',$c->campaign_id)->first();
                
                config(['database.connections.mysql_external.host' => $source->MySQL_host]);
                #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
                config(['database.connections.mysql_external.database' => $source->Mysql_db]);
                config(['database.connections.mysql_external.username' => $source->Mysql_username]);
                config(['database.connections.mysql_external.password' => $source->Mysql_password]);
                #https://188.166.215.132/

                /*$dataz = DB::connection('mysql_external')
                    #->table('vicidial_list')
                    ->table('vicidial_log')
                    ->select('phone_number','lead_id','vicidial_statuses.status_name','call_date','campaign_id')
                    ->leftjoin('vicidial_statuses','vicidial_statuses.status','vicidial_log.status')
                    ->where('phone_number',"$num")
                    ->get();*/
                 //   DB::enableQueryLog();
                $dataz = DB::connection('mysql_external')
                    ->table('vicidial_list')
                    ->select('vicidial_list.phone_number','vicidial_list.lead_id','vicidial_statuses.status_name','vicidial_log.call_date','vicidial_list.entry_date','vicidial_log.campaign_id')
                    ->leftjoin('vicidial_statuses','vicidial_statuses.status','vicidial_list.status')
                    ->leftjoin('vicidial_log','vicidial_log.phone_number','vicidial_list.phone_number')
                    ->where('vicidial_list.phone_number',"$num")
                    ->get();
                //    dd(DB::getQueryLog());
                DB::disconnect('mysql_source');
               
                $data[] = $dataz;
            }
           
        }
        else{

        }
        return view('dashboard/lead_details')->with('data',$data)->with("phonenumber",$num);
    }

   
    
   
    
}
