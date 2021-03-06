<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Contact;
use App\Models\Campaigns;
use App\Models\CampaignUse;
use App\Models\Charts;
use Auth;
use DB;


class OptimizerController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $chart1=Charts::select('created_at')->where('chart_type',1)->first();
         $chart2=Charts::select('created_at')->where('chart_type',2)->first();
         $chart3=Charts::select('created_at')->where('chart_type',3)->first();
         $chart4=Charts::select('created_at')->where('chart_type',4)->first();
         $chart5=Charts::select('created_at')->where('chart_type',5)->first();
        
         //return view('dashboard/charts')->with('chart1',$chart1)->with('chart2',$chart2)->with('chart3',$chart3);
         return view('dashboard/charts')->with('chart1',date("M d,Y h:i:s A",strtotime($chart1->created_at)))
         ->with('chart2',date("M d,Y h:i:s A",strtotime($chart2->created_at)))
         ->with('chart3',date("M d,Y h:i:s A",strtotime($chart3->created_at)))
         ->with('chart4',date("M d,Y h:i:s A",strtotime($chart4->created_at)))
         ->with('chart5',date("M d,Y h:i:s A",strtotime($chart5->created_at)));

    }

    public function leadschart()
    {
        //DB::enableQueryLog();
        /*$leads=CampaignUse::select(DB::raw('CONCAT(campaign.CampaignName,"(",count(campaign_use.id),")") as CampaignName'),DB::raw('count(campaign_use.id) as total'))
        ->leftjoin('campaign','campaign_use.CampaignID','campaign.id')->groupby('campaign_use.CampaignID')->get();*/
        $leads=Contact::select(DB::raw('CONCAT(campaign.CampaignName,"(",count(contacts.id),")") as CampaignName'),DB::raw('count(contacts.id) as total'))
        ->leftjoin('campaign','contacts.campaign_id','campaign.id')->groupby('contacts.campaign_id')->get();

        Charts::where('chart_type',1)->delete();
        foreach($leads as $lead){
            $chart=new Charts();
            $chart->label = $lead->CampaignName;
            $chart->total = $lead->total;
            $chart->chart_type=1 ;
            $chart->save();
        }
        
        //dd(DB::getQueryLog());
        $date=date("M d,Y H:i:s A",strtotime($chart->created_at));
        return $date;
    }

    public function blankchart()
    {
        Charts::where('chart_type',3)->delete();
        //DB::enableQueryLog();        
        $landline=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LandlineNum')
        ->orwhere('LandlineNum',"=","")->get();
       
        $chart=new Charts();
        $chart->label = 'No Landline ('.$landline[0]->total.')';
        $chart->total = $landline[0]->total;
        $chart->chart_type = 3 ;
        $chart->save();

        $mobile=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('MobileNum')
        ->orwhere('MobileNum',"=","")->get();

        $chart=new Charts();
        $chart->label = 'No Mobile ('.$mobile[0]->total.')';
        $chart->total = $mobile[0]->total;
        $chart->chart_type = 3 ;
        $chart->save();

        $email=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('Email')
        ->orwhere('Email',"=","")->get();

        $chart=new Charts();
        $chart->label = 'No Email ('.$email[0]->total.')';
        $chart->total = $email[0]->total;
        $chart->chart_type = 3 ;
        $chart->save();

        $firstname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('FirstName')
        ->orwhere('FirstName',"=","")->get();
        $chart=new Charts();
        $chart->label = 'No Firstname ('.$firstname[0]->total.')';
        $chart->total = $firstname[0]->total;
        $chart->chart_type = 3 ;
        $chart->save();

        $lastname=Contact::select(DB::raw('count(id) as total'))
        ->whereNull('LastName')
        ->orwhere('LastName',"=","")->get();
        
        $chart=new Charts();
        $chart->label = 'No Lastname ('.$lastname[0]->total.')';
        $chart->total = $lastname[0]->total;
        $chart->chart_type = 3 ;
        $chart->save();

        //dd(DB::getQueryLog());
        $date=date("M d,Y H:i:s A",strtotime($chart->created_at));
        return $date;
    }

    public function supplierchart()
    {
        //DB::enableQueryLog();
        $leads=Contact::select(DB::raw('CONCAT(users.name,"(",count(contacts.id),")") as supplier'),DB::raw('count(contacts.id) as totals'))
        ->leftjoin('users','contacts.supplier_id','users.id')->groupby('contacts.supplier_id')->get();
        //dd(DB::getQueryLog());
        Charts::where('chart_type',2)->delete();
        foreach($leads as $lead){
            $chart=new Charts();
            $chart->label = $lead->supplier;
            $chart->total = $lead->totals;
            $chart->chart_type=2 ;
            $chart->save();
        }
        $date=date("M d,Y H:i:s A",strtotime($chart->created_at));
        return $date;
    }

    public function notblankchart()
    {
        Charts::where('chart_type',4)->delete();
       // DB::enableQueryLog();        
        $landline=Contact::IndexRaw('FORCE INDEX (contacts_landlinenum_index)')->select(DB::raw('count(id) as total'))
        ->whereNotNull('LandlineNum')
        ->orwhere('LandlineNum',"!=","")->get();
        //dd(DB::getQueryLog());die();
        $chart=new Charts();
        $chart->label = 'Landline ('.$landline[0]->total.')';
        $chart->total = $landline[0]->total;
        $chart->chart_type = 4 ;
        $chart->save();

        $mobile=Contact::select(DB::raw('count(id) as total'))
        ->whereNotNull('MobileNum')
        ->orwhere('MobileNum',"!=","")->get();

        $chart=new Charts();
        $chart->label = 'Mobile ('.$mobile[0]->total.')';
        $chart->total = $mobile[0]->total;
        $chart->chart_type = 4 ;
        $chart->save();

        $email=Contact::select(DB::raw('count(id) as total'))
        ->whereNotNull('Email')
        ->orwhere('Email',"!=","")->get();

        $chart=new Charts();
        $chart->label = 'Email ('.$email[0]->total.')';
        $chart->total = $email[0]->total;
        $chart->chart_type = 4 ;
        $chart->save();

        $firstname=Contact::select(DB::raw('count(id) as total'))
        ->whereNotNull('FirstName')
        ->orwhere('FirstName',"!=","")->get();
        $chart=new Charts();
        $chart->label = 'Firstname ('.$firstname[0]->total.')';
        $chart->total = $firstname[0]->total;
        $chart->chart_type = 4 ;
        $chart->save();

        $lastname=Contact::select(DB::raw('count(id) as total'))
        ->whereNotNull('LastName')
        ->orwhere('LastName',"!=","")->get();
        
        $chart=new Charts();
        $chart->label = 'Lastname ('.$lastname[0]->total.')';
        $chart->total = $lastname[0]->total;
        $chart->chart_type = 4 ;
        $chart->save();

        
        $date=date("M d,Y H:i:s A",strtotime($chart->created_at));
        return $date;
    }


    public function DncChart()
    {
        
        Charts::where('chart_type',5)->delete();
        $fivedays = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                        END AS z
                FROM
                    dnc) AS a
                WHERE
                z BETWEEN CURDATE() - INTERVAL 5 DAY AND CURDATE()");

        $chart=new Charts();
        $chart->label = '5 days and below ('.$fivedays[0]->totals.')';
        $chart->total = $fivedays[0]->totals;
        $chart->chart_type = 5 ;
        $chart->save();

        $thirtydays = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                        END AS z
                                FROM
                                    dnc) AS a
                            WHERE
                                z BETWEEN CURDATE() - INTERVAL 30 DAY AND CURDATE() - INTERVAL 5 DAY");

        $chart=new Charts();
        $chart->label = '5 days to 30 days ('.$thirtydays[0]->totals.')';
        $chart->total = $thirtydays[0]->totals;
        $chart->chart_type = 5 ;
        $chart->save();

        $sixty = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                                END AS z
                                        FROM
                                            dnc) AS a
                                    WHERE
                                        z BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE() - INTERVAL 30 DAY");
        $chart=new Charts();
        $chart->label = '30 days to 60 days ('.$sixty[0]->totals.')';
        $chart->total = $sixty[0]->totals;
        $chart->chart_type = 5 ;
        $chart->save();

        $sixtyup = DB::select("SELECT count(id) as totals FROM (SELECT id,CASE WHEN LastDNCWashing IS NULL THEN created_at ELSE STR_TO_DATE(LastDNCWashing,'%m/%d/%Y')
                                            END AS z
                                    FROM
                                        dnc) AS a
                                WHERE
                                    z < CURDATE() - INTERVAL 60 DAY");
        $chart=new Charts();
        $chart->label = '60 days and up  ('.$sixtyup[0]->totals.')';
        $chart->total = $sixtyup[0]->totals;
        $chart->chart_type = 5 ;
        $chart->save();

        $date=date("M d,Y H:i:s A",strtotime($chart->created_at));
        return $date;

    }
}
