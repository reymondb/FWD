<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Models\Campaigns;
use App\Models\LeadList;
use App\Models\LeadBatch;
use App\Models\CampaignUse;
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
    public function index(Request $request){
        $campaigns=Campaigns::all();
        
        return view('dashboard/campaign')->with('campaigns',$campaigns);
    }

    public function createCampaign(Request $request){
       
            $campaign = new Campaigns;
            $campaign->CampaignName = $_POST['name'];
            $campaign->MySQL_host = $_POST['MySQL_url'];
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
        $batches_search = $request['batches_search'];
        $contacts = LeadList::select('contacts.*')
        ->leftjoin("contacts",'lead_list.ContactID','contacts.id')
        ->where('BatchID',$batches_search)
        ->paginate(15);
        if(!$contacts){
            return view('dashboard/batchmessage')->with('message','Batch has no leads.');
        }
        return view('dashboard/batchleads')->with('contacts',$contacts)->with('batch_id',$batches_search);

    }
    
    
    public function deleteBatch($batchid){
        $contactsfirst = LeadList::select('ContactID')->orderby('id','asc')->where('BatchID',$batchid)->first();
        $contactslast = LeadList::select('ContactID')->orderby('id','desc')->where('BatchID',$batchid)->first();
        LeadBatch::find($batchid)->delete();
        LeadList::where('BatchID',$batchid)->delete();
        CampaignUse::whereBetween('ContactID', [$contactsfirst->ContactID, $contactslast->ContactID])->delete();
        Contact::whereBetween('id', [$contactsfirst->ContactID, $contactslast->ContactID])->delete();

        return view('dashboard/batchmessage')->with('message','Batch Has been deleted');

    }

}
