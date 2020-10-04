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
        $source=Campaigns::where('id',1)->first();
        config(['database.connections.mysql_external.url' => $source->MySQL_url]);
        #config(['database.connections.mysql_external.host' => $source->MySQL_url]);
        config(['database.connections.mysql_external.database' => $source->Mysql_db]);
        config(['database.connections.mysql_external.username' => $source->Mysql_username]);
        config(['database.connections.mysql_external.password' => $source->Mysql_password]);
        #https://188.166.215.132/

        $data = DB::connection('mysql_external')
            ->table('vicidial_list')
            ->limit(10)
            ->get();
        DB::disconnect('mysql_source');

        return view('dashboard/reporting')->with('data',$data);
    }
   
    
}
