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
        $campaigns = Campaigns::all();
        /*
        mysql_external
        url MySQL_url
        database Mysql_db
        username Mysql_username
        password Mysql_password*/
        return view('dashboard/statistics')->with('campaigns',$campaigns);
    }


    public function fetchLeadLists(Request $request)
    {
        if(isset($request->campaignid)){
            DB::enableQueryLog();
            $source=Campaigns::where('id',$request->campaignid)->first();
            dd(DB::getQueryLog());
            config(['database.connections.mysql_external.url' => $source->MySQL_host]);
            #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
            config(['database.connections.mysql_external.database' => $source->Mysql_db]);
            config(['database.connections.mysql_external.username' => $source->Mysql_username]);
            config(['database.connections.mysql_external.password' => $source->Mysql_password]);

            $data = DB::connection('mysql_external')
                ->table('vicidial_list')
                ->select('list_id')
                ->groupby('list_id')
                ->get();
            return $data;
        }
        else{
            return 0;
        }
       
    }

    
}
