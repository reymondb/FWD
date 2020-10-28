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
        $source=Campaigns::where('id',$request->campaignid)->first();
        config(['database.connections.mysql_external.host' => $source->MySQL_host]);
        #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
        config(['database.connections.mysql_external.database' => $source->Mysql_db]);
        config(['database.connections.mysql_external.username' => $source->Mysql_username]);
        config(['database.connections.mysql_external.password' => $source->Mysql_password]);

        $data = DB::connection('mysql_external')
            ->table('vicidial_list')
            ->select('list_id')
            ->groupby('list_id')
            ->get();
        DB::disconnect('mysql_source');

        return $data;
    }

    //SELECT list_id,status,count(status)as total FROM `vicidial_list` WHERE list_id=61626190000377 GROUP by status
    /* SELECT list_id,status,count(status)as total,
SUM(CASE WHEN vicidial_list.called_count = 1 THEN 1 ELSE 0 END) AS total1,
SUM(CASE WHEN vicidial_list.called_count = 2 THEN 1 ELSE 0 END) AS total2,
SUM(CASE WHEN vicidial_list.called_count = 3 THEN 1 ELSE 0 END) AS total3,
SUM(CASE WHEN vicidial_list.called_count = 4 THEN 1 ELSE 0 END) AS total4,
SUM(CASE WHEN vicidial_list.called_count = 5 THEN 1 ELSE 0 END) AS total5,
SUM(CASE WHEN vicidial_list.called_count >=6 THEN 1 ELSE 0 END) AS total6
           FROM `vicidial_list` WHERE list_id=61626190000377 GROUP by status */

           
           
    public function fetchLeadStats(Request $request)
    {
        $source=Campaigns::where('id',$request->campaignid)->first();
        config(['database.connections.mysql_external.host' => $source->MySQL_host]);
        #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
        config(['database.connections.mysql_external.database' => $source->Mysql_db]);
        config(['database.connections.mysql_external.username' => $source->Mysql_username]);
        config(['database.connections.mysql_external.password' => $source->Mysql_password]);

        $data = DB::connection('mysql_external')
            ->table('vicidial_list')
            ->select('list_id',
            'vicidial_list.status',
            DB::raw("(SELECT COUNT(vicidial_list.list_id) FROM `vicidial_list` WHERE list_id=$request->list_id) as overalltotal"),
            DB::raw("count(vicidial_list.status)as total"),
            'status_name',
            'human_answered',
            'sale',
            DB::raw("SUM(CASE WHEN vicidial_list.called_count = 1 THEN 1 ELSE 0 END) AS total1"),
            DB::raw("SUM(CASE WHEN vicidial_list.called_count = 2 THEN 1 ELSE 0 END) AS total2"),
            DB::raw("SUM(CASE WHEN vicidial_list.called_count = 3 THEN 1 ELSE 0 END) AS total3"),
            DB::raw("SUM(CASE WHEN vicidial_list.called_count = 4 THEN 1 ELSE 0 END) AS total4"),
            DB::raw("SUM(CASE WHEN vicidial_list.called_count = 5 THEN 1 ELSE 0 END) AS total5"),
            DB::raw("SUM(CASE WHEN vicidial_list.called_count >=6 THEN 1 ELSE 0 END) AS total6"))
            ->leftjoin('vicidial_campaign_statuses','vicidial_campaign_statuses.status','vicidial_list.status') #vicidial_statuses
            ->where('list_id',$request->list_id)
            ->groupby('vicidial_list.status')
            ->get();
        DB::disconnect('mysql_source');

        return $data;
    }

    public function fetchLeadStatsLogs(Request $request)
    {
        $source=Campaigns::where('id',$request->campaignid)->first();
        config(['database.connections.mysql_external.host' => $source->MySQL_host]);
        #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
        config(['database.connections.mysql_external.database' => $source->Mysql_db]);
        config(['database.connections.mysql_external.username' => $source->Mysql_username]);
        config(['database.connections.mysql_external.password' => $source->Mysql_password]);

        $data = DB::connection('mysql_external')
            ->table('vicidial_log')
            ->select('list_id',
            'vicidial_log.status',
            DB::raw("count(vicidial_log.status)as total"),
            'status_name',
            'human_answered',
            DB::raw("(SELECT COUNT(vicidial_log.list_id) FROM `vicidial_log` WHERE list_id=$request->list_id) as overalltotal"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count = 1 THEN 1 ELSE 0 END) AS total1"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count = 2 THEN 1 ELSE 0 END) AS total2"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count = 3 THEN 1 ELSE 0 END) AS total3"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count = 4 THEN 1 ELSE 0 END) AS total4"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count = 5 THEN 1 ELSE 0 END) AS total5"),
            DB::raw("SUM(CASE WHEN vicidial_log.called_count >=6 THEN 1 ELSE 0 END) AS total6"))
            ->leftjoin('vicidial_statuses','vicidial_statuses.status','vicidial_log.status')
            ->where('list_id',$request->list_id)
            ->groupby('vicidial_log.status')
            ->get();
        DB::disconnect('mysql_source');

        return $data;
    }
        
}