<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Campaigns;

class CampaignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
    


}
