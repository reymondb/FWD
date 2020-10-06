<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\NewLeads;
use App\Models\LeadBatch;
use App\Models\LeadList;
use App\Models\DuplicateLeads;
use App\Models\UniqueLeads;
use App\User;

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
        $suppliers=User::all();
        return view('dashboard/import')->with('campaigns',$campaigns)->with('suppliers',$suppliers);
    }

    //parse csv 
    public function parseImport(CsvImportRequest $request)
    {
        
        $campaign = $request->campaign;
        $batchdesc = $request->batch_desc;
        $supplier_id = $request->supplier_id;
        
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

        return view('dashboard/import_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('campaign',$campaign)
        ->with('batchdesc',$batchdesc)->with('warning',$warning)->with('filename',$filename)->with('supplier_id',$supplier_id);

    }

    //process import
    public function processImport(Request $request)
    {
        $campaignid= $request->campaign;
        $batchdesc = $request->batchdesc;
        $supplier_id = $request->supplier_id;
        #$supplier_id = Auth::user()->id;
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

        $x=0;
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
                
            //if(str_replace(' ', '', $row[0])!=" " && str_replace(' ', '', $row[1])!=" " && str_replace(' ', '', $row[02])!=" " && str_replace(' ', '', $row[3])!=" " && str_replace(' ', '', $row[4])!=" "){
            if(!empty($row[0]) || !empty($row[1]) || !empty($row[2]) || !empty($row[3]) || !empty($row[4]) )  {
                //echo $x ." = ".$row[0]." == ".$row[1]." == ".$row[2]." == ".$row[3]." == ".$row[4]."<br>";
                foreach($request->fields as $index => $field){
                    if(isset($field) || $field!=""){
                        $dbf = $db_field[$field];
                        //echo $db_field[$field] ." == ".$row[$index];
                        if($dbf=="MobileNum" || $dbf=="LandlineNum"){
                            $val=intval(preg_replace('/[^0-9]+/', '', $row[$index]), 10);
                        }
                        else{
                            $val = $row[$index];
                        }
                        $contact->$dbf = $val;
                    }
                }
                $contact->supplier_id =$supplier_id;
                $contact->save();
                $x++;
                // insert Campaign use database table
                $campaignuse = new CampaignUse();
                $campaignuse->ContactID = $contact->id;
                $campaignuse->CampaignID = $campaignid;
                $campaignuse->save();
                 // insert lead list database table
                $ll = new LeadList();
                $ll->BatchID = $batch_id;
                $ll->CampaignID = $campaignid;
                $ll->ContactID = $contact->id;
                $ll->save();
            }
            
        }
        return view('dashboard/import_success')->with('totalcount',$x);
    }


    public function parseNewLeads(CsvImportRequest $request)
    {
        $path = $request->file('csv_file')->getRealPath();
        $checkduplicate = $request->checkduplicate;
       
        //if ($request->has('header')) {
           // $data = Excel::load($path, function($reader) {})->get()->toArray();
        //} else {
            $data = array_map('str_getcsv', file($path));
        //}
        //print_r($data);
        $csv_header_fields = [];
        $total=count($data);
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

        return view('dashboard/newleads_fields', compact( 'csv_header_fields', 'csv_data', 'csv_data_file'))->with('checkduplicate',$checkduplicate)->with('totalrows',$total);

    }

    public function processNewLeads(Request $request)
    {
        
        $checkduplicate = $request->checkduplicate;
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
        DuplicateLeads::truncate();
        UniqueLeads::truncate(); 
        $x=1;
        foreach ($csv_data as $row) {
            if(!empty($row[0]) || !empty($row[1]) || !empty($row[2]) || !empty($row[3]) || !empty($row[4]) )  {
                $contact = new NewLeads();
                $duplicate = new DuplicateLeads();
                foreach($request->fields as $index => $field){
                    if(isset($field) || $field!=""){
                       
                        $dbf = $db_field[$field];
                        //echo $db_field[$field] ." == ".$row[$index];
                        if($dbf=="MobileNum" || $dbf=="LandlineNum"){
                            $val=intval(preg_replace('/[^0-9]+/', '', $row[$index]), 10);
                        }
                        else{
                            $val = $row[$index];
                        }
                        if($dbf=="LandlineNum"){
                            $landline = intval(preg_replace('/[^0-9]+/', '', $row[$index]), 10);
                        }
                        if($dbf=="MobileNum"){
                            $mobile = intval(preg_replace('/[^0-9]+/', '', $row[$index]), 10);
                        }
                        if($dbf=="email"){
                            $email = $row[$index];
                        }
                        
                        $contact->$dbf = $val;
                        $duplicate->$dbf = $val;

                    }
                }
                /*
                $contact->save();
                */
                //DB::enableQueryLog();
                if($checkduplicate==1){
                    $checkcontact =Contact::select('id',          
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
                    'Email')->where('MobileNum',$email)->first();
                }
                else if($checkduplicate==3){
                    
                    $checkcontact =Contact::select('id',          
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
                    'Email')->where('Email',$email)->first();
                }
                else{
                    $checkcontact =Contact::select('id',          
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
                        'Email')->where('LandlineNum',$landline)->first();

                }
                    //dd(DB::getQueryLog()); die();
                // print_r($checkcontact);die();   
                if($checkcontact){
                    //DB::enableQueryLog(); 
                    //$checkcontactz = $checkcontact->toArray();
                    //DuplicateLeads::insert($checkcontactz);
                    $duplicate->save();
                    //dd(DB::getQueryLog()); die();
                }
                else{
                    //$zzz = $contact->toArray();
                    $contact->save();
                }
            }
        }
        
        /*
        //DB::enableQueryLog();
        //$uniqueleads = NewLeads::select('new_leads.*')
        $uniqueleads = NewLeads::select(
            DB::raw("(  (count(new_leads.id)  ) )  as `totalunique` ")
            )
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
        //$duplicateleads = NewLeads::select('new_leads.*','campaign.CampaignName')
        $duplicateleads = NewLeads::select(
            DB::raw("(  (count(new_leads.id)  ) )  as `totalduplicate` ")
        )
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
        */
        //DB::enableQueryLog();
        /* replaced to redirect 
        $uniqueleadsz = NewLeads::select("contacts.id")
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

        //dd(DB::getQueryLog());die();
        $uniqueleads = $uniqueleadsz->count();//$uniqueleadsz[0]['totalunique'];
          //  dd($uniqueleads);die();
          //DB::enableQueryLog(); // Enable query log
        $duplicateleadsz = NewLeads::select("contacts.id")
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
            #->groupBy('new_leads.id')
            ->get();
            //dd($duplicateleadsz->count());
            //dd(DB::getQueryLog());die();
            $duplicateleads = $duplicateleadsz->count();//$uniqueleadsz[0]['totalduplicate'];

        return view('dashboard/newleads_success')->with('uniqueleads',$uniqueleads)
        ->with('duplicateleads',$duplicateleads)
        ->with('mobile_num',$mobile_num)
        ->with('landline',$landline)
        ->with('email',$email);
        */
        //return view('dashboard/newleads_success');
        return redirect('/new_leads_report');
    }
   
    public function newleadsReport()
    {
        /*
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
        */
        $mobile_num=0;
        $landline=1;
        $email=0;

       /* $uniqueleadsz = NewLeads::select("contacts.id")
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
        */
         
        $uniqueleadsz = NewLeads::all();
;        //dd(DB::getQueryLog());die();
        $uniqueleads = $uniqueleadsz->count();// $uniqueleadsz[0]->totalunique; //$uniqueleadsz[0]['totalunique']; //;
          
        $duplicateleadsz = DuplicateLeads::all();
          
        $duplicateleads = $duplicateleadsz->count();//$duplicateleadsz[0]->totalduplicate; //$uniqueleadsz[0]['totalduplicate'];//;
    
        return view('dashboard/new_leads_report')->with('uniqueleads',$uniqueleads)->with('duplicateleads',$duplicateleads);
    }
    

}
