<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Campaigns;
use App\Models\LeadList;
use App\Models\LeadBatch;
use Response;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns=Campaigns::all();
        return view('dashboard/campaign')->with('campaigns',$campaigns);
    }

    public function createCampaign(Request $request){
       
            $campaign = new Campaigns;
            $campaign->CampaignName = $_POST['name'];
            $campaign->MySQL_host = $_POST['MySQL_host'];
            $campaign->Mysql_db = $_POST['Mysql_db'];
            $campaign->Mysql_username = $_POST['Mysql_username'];
            $campaign->Mysql_password = $_POST['Mysql_password'];
            $campaign->save();

            return redirect('/campaigns')->with('status', 'saved');

    }

    public function deleteCampaign($id)
    {
        $delete = Campaigns::where('id', $id)->delete();

        return redirect('/campaigns')->with('status', 'deleted');
    }

    public function editCampaign(Request $request){

        $campaign = Campaigns::where('id', $_POST['id'])->first();
        $campaign->CampaignName = $_POST['editname'];
        $campaign->save();

        return redirect('/campaigns')->with('status', 'saved');

    }

    public function fetchBatches(Request $request){

        $batches = LeadBatch::where('campaign_id', $_POST['campaign'])->get();
        $options="<option></option>";
        foreach($batches as $batch){
            $options.="<option value='".$batch->id."'>".$batch->BatchDescription."</option>";
        }
        return response()->json(array('optionz' => $options));

    }
    
    public function search_campaign(Request $request){

        $campaign = Campaigns::where('id', $_POST['id'])->first();
        $campaign->CampaignName = $_POST['editname'];
        $campaign->save();

        return redirect('/campaigns')->with('status', 'saved');

    }
    
    


}
