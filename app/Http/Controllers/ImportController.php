<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\NewLeads;
use App\Models\LeadBatch;
use App\Models\LeadList;

use App\CsvData;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Auth;

class ImportController extends Controller
{

    public function getImport()
    {
        $campaigns=Campaigns::all();
        return view('dashboard/import')->with('campaigns',$campaigns);
    }

    //parse csv 
    public function parseImport(CsvImportRequest $request)
    {
        
        $campaign = $request->campaign;
        $batchdesc = $request->batch_desc;
        $filename = $request->file('csv_file')->getClientOriginalName();
        
        $path = $request->file('csv_file')->getRealPath();

        //if ($request->has('header')) {
           // $data = Excel::load($path, function($reader) {})->get()->toArray();
        //} else {
            $data = array_map('str_getcsv', file($path));
        //}
        //print_r($data);
        $csv_header_fields = [];
        if (count($data) > 0) {
            if($request->has('header')) {
                /* foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }*/
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }
        $checkfile = LeadBatch::where('FileName',$request->file('csv_file')->getClientOriginalName())->first();
        if($checkfile){
            $warning=1;
        }
        else{
            $warning=0;
        }

        return view('dashboard/import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('campaign',$campaign)->with('batchdesc',$batchdesc)->with('warning',$warning)->with('filename',$filename);

    }

    //process import
    public function processImport(Request $request)
    {
        $campaignid= $request->campaign;
        $batchdesc = $request->batchdesc;
        $supplier_id = Auth::user()->id;
        // create lead batch in database
        $lb = new LeadBatch();        
        $lb->BatchDescription = $batchdesc;
        $lb->FileName = $request->filename;
        $lb->supplier_id =$supplier_id;
        $lb->save();
        $batch_id = $lb->id;

        //import csv start
        $data = CsvData::find($request->csv_data_file_id);
        if ($data->csv_header) {
            $jsondata = json_encode(array_slice(json_decode($data->csv_data, true), 1));
            $csv_data = json_decode($jsondata, true);
        }
        else{
            $csv_data = json_decode($data->csv_data, true);
        }
        //print_r($request->fields);
        $db_field = config('app.db_fields');
        //print_r($db_field);
        foreach ($csv_data as $row) {
            $contact = new Contact();
                //foreach (config('app.db_fields') as $index => $field) {
                /* if ($data->csv_header) {
                        $contact->$field = $row[$request->fields[$field]];
                    } else {
                    */ 
                    //if(($index+1) <= count($row)){
                    // $contact->$field = $row[$request->fields[$index]]; 
                    //}
                    //}
                //}
                foreach($request->fields as $index => $field){
                    $dbf = $db_field[$field];
                    //echo $db_field[$field] ." == ".$row[$index];
                    $contact->$dbf = $row[$index];
                }
            $contact->supplier_id =$supplier_id;
            $contact->save();
            
            // insert lead list database table
            $ll = new LeadList();
            $ll->BatchID = $batch_id;
            $ll->CampaignID = $campaignid;
            $ll->ContactID = $contact->id;
            $ll->save();

            // insert Campaign use database table
            $campaignuse = new CampaignUse();
            $campaignuse->ContactID = $contact->id;
            $campaignuse->CampaignID = $campaignid;
            $campaignuse->save();
            

        }

        return view('dashboard/import_success');
    }


    public function getNewLeads()
    {   
        return view('dashboard/newleads');
    }

    public function parseNewLeads(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $mobile_num = $request->mobile_num;
        $landline = $request->landline;
        $email = $request->email;
        //if ($request->has('header')) {
           // $data = Excel::load($path, function($reader) {})->get()->toArray();
        //} else {
            $data = array_map('str_getcsv', file($path));
        //}
        //print_r($data);
        $csv_header_fields = [];
        if (count($data) > 0) {
             if($request->has('header')) {
                /*foreach ($data[0] as $key => $value) {
                    $csv_header_fields[] = $key;
                }*/
            }
            $csv_data = array_slice($data, 0, 2);

            $csv_data_file = CsvData::create([
                'csv_filename' => $request->file('csv_file')->getClientOriginalName(),
                'csv_header' => $request->has('header'),
                'csv_data' => json_encode($data)
            ]);
        } else {
            return redirect()->back();
        }

        return view('dashboard/newleads_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('mobile_num',$mobile_num) ->with('landline',$landline) ->with('email',$email);

    }

    public function processNewLeads(Request $request)
    {
        //$csv_data = json_decode($data->csv_data, true);
        //import csv start
        $data = CsvData::find($request->csv_data_file_id);
        if ($data->csv_header) {
            $jsondata = json_encode(array_slice(json_decode($data->csv_data, true), 1));
            $csv_data = json_decode($jsondata, true);
        }
        else{
            $csv_data = json_decode($data->csv_data, true);
        }
        $db_field = config('app.db_fields');
        //empty Lead Washing table
        NewLeads::truncate();
        foreach ($csv_data as $row) {
            $contact = new NewLeads();
            foreach($request->fields as $index => $field){
                $dbf = $db_field[$field];
                //echo $db_field[$field] ." == ".$row[$index];
                $contact->$dbf = $row[$index];
            }
            $contact->save();
        }
        
        $mobile_num = $request->mobile_num;
        $landline = $request->landline;
        $email = $request->email;
        //DB::enableQueryLog();
        $uniqueleads = NewLeads::select('new_leads.*')
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
        ->whereNull('contacts.id')->get();
        //dd(DB::getQueryLog());
                #->leftjoin("contacts",'new_leads.MobileNum','contacts.MobileNum')
        
        //dd($uniqueleads);die();
        //DB::enableQueryLog(); // Enable query log
        $duplicateleads = NewLeads::select('new_leads.*','campaign.CampaignName')
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
            ->groupBy('new_leads.id')->get();
        //dd(DB::getQueryLog());
        return view('dashboard/newleads_success')->with('uniqueleads',$uniqueleads)->with('duplicateleads',$duplicateleads);
    }
    /*
    public function newleadsReport()
    {
        //DB::enableQueryLog(); // Enable query log
        $uniqueleads = NewLeads::select('new_leads.*')->leftjoin("contacts",'new_leads.MobileNum','contacts.MobileNum')
                    ->whereNull('contacts.id')->get();
        $duplicateleads = NewLeads::select('new_leads.*','campaign.CampaignName')
                ->leftjoin("contacts",'new_leads.MobileNum','contacts.MobileNum')
                ->leftjoin("campaign_use",'campaign_use.ContactID','contacts.id')
                ->leftjoin("campaign",'campaign.id','campaign_use.CampaignID')
                ->whereNotNull('contacts.id')
                ->groupBy('new_leads.id')->get();
        //dd(DB::getQueryLog()); // Show results of log
        return view('dashboard/new_leads_report')->with('uniqueleads',$uniqueleads)->with('duplicateleads',$duplicateleads);
    }
    */

}
