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

class ReportsController extends Controller
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

    public function fetchReport(Request $request)
    {
        if(isset($request->landline)){
            $num = $request->landline;
            $getcampaign=Contact::where('LandlineNum',$request->landline)->groupby('campaign_id')->get();
        }
        if(isset($request->mobilenum)){
            $num = $request->mobilenum;
            $getcampaign=Contact::where('LandlineNum',$request->MobileNum)->groupby('campaign_id')->get();
            
        }

        if($getcampaign){
            $data=array();
            foreach($getcampaign as $k=>$c){
                $source=Campaigns::where('id',1)->first();
                config(['database.connections.mysql_external.url' => $source->MySQL_url]);
                #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
                config(['database.connections.mysql_external.database' => $source->Mysql_db]);
                config(['database.connections.mysql_external.username' => $source->Mysql_username]);
                config(['database.connections.mysql_external.password' => $source->Mysql_password]);
                #https://188.166.215.132/

                $data2 = DB::connection('mysql_external')
                    ->table('vicidial_list')
                    ->select('phone_number','lead_id','vicidial_statuses.status_name','last_local_call_time')
                    ->leftjoin('vicidial_statuses','vicidial_statuses.status','vicidial_list.status')
                    ->where('phone_number',"$num")
                    ->get();
                DB::disconnect('mysql_source');
                $data = array_merge($data1, $data2);
            }
            dd($$data);die();
           
        }
        else{

        }
        return view('dashboard/reporting')->with('data',$data);
        
    }

    public function fetchDetails($landline)
    {
        $source=Campaigns::where('id',1)->first();
        config(['database.connections.mysql_external.url' => $source->MySQL_url]);
        #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
        config(['database.connections.mysql_external.database' => $source->Mysql_db]);
        config(['database.connections.mysql_external.username' => $source->Mysql_username]);
        config(['database.connections.mysql_external.password' => $source->Mysql_password]);
        #https://188.166.215.132/

        $data = DB::connection('mysql_external')
            ->table('vicidial_list')
            ->select('phone_number','lead_id','vicidial_statuses.status_name','last_local_call_time')
            ->leftjoin('vicidial_statuses','vicidial_statuses.status','vicidial_list.status')
            ->where('phone_number',"$landline")
            ->get();
        DB::disconnect('mysql_source');
       // SELECT phone_number,vs.status_name,last_local_call_time FROM `vicidial_list` as list left JOIN vicidial_statuses as vs ON vs.status=list.status where phone_number=476796947 
        return view('dashboard/lead_details')->with('data',$data);
    }
   
    
}
