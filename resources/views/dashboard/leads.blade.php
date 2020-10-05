
@extends('dashboard.dashboardlayout')
@section('title', 'Contact Leads List')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Leads</h1>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Contact Leads</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="contact_filter" action="/leads" method="GET">
                        {{ csrf_field() }}
                        <table id="contact_filter_table" class="table" style="background-color:rgba(0, 0, 0, 0.03)">
                            <tr>
                                <td>
                                    <select name="batch_id" class="form-control filter_inputs">
                                        <option value="">Select Batch</option>
                                        @foreach ($LeadBatch as $l)
                                            <option @if($batch_id==$l->id) selected @endif value="{{$l->id}}">{{$l->BatchDescription}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="supplier_id" class="form-control filter_inputs">
                                        <option value="">Select Supplier</option>
                                        @foreach ($User as $u)
                                            <option @if($supplier_id==$u->id) selected @endif value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="campaign_id" class="form-control filter_inputs">
                                        <option value="">Select Campaign</option>
                                        @foreach ($Campaigns as $c)
                                            <option @if($campaign_id==$c->id) selected @endif value="{{$c->id}}">{{$c->CampaignName}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label style="margin-bottom: 0;">
                                            <select name="mobile_num" >
                                                <option value="2" @if($mobile_num==2) selected @endif>exclude</option>
                                                <option value="1" @if($mobile_num==1) selected @endif>w/</option>
                                                <option value="0" @if($mobile_num==0) selected @endif>w/o</option>
                                            </select>
                                            Mobile number
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label style="margin-bottom: 0;"> 
                                            <select name="landline" >
                                                <option value="2" @if($landline==2) selected @endif>exclude</option>
                                                <option value="1" @if($landline==1) selected @endif>w/</option>
                                                <option value="0" @if($landline==0) selected @endif>w/o</option>
                                            </select> Landline
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label style="margin-bottom: 0;">
                                            <select name="email" >
                                                <option value="1" @if($email==1) selected @endif>w/</option>
                                                <option value="0" @if($email==0) selected @endif>w/o</option>
                                                <option value="2" @if($email==2) selected @endif>exclude</option>
                                            </select> Email
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label style="margin-bottom: 0;"> 
                                            <select name="first_name" >
                                                <option value="2" @if($first_name==2) selected @endif>exclude</option>
                                                <option value="1" @if($first_name==1) selected @endif>w/</option>
                                                <option value="0" @if($first_name==0) selected @endif>w/o</option>
                                            </select> First Name
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label style="margin-bottom: 0;">
                                            <select name="last_name" >
                                                <option value="2" @if($last_name==2) selected @endif>exclude</option>
                                                <option value="1" @if($last_name==1) selected @endif>w/</option>
                                                <option value="0" @if($last_name==0) selected @endif>w/o</option>
                                            </select> Last Name
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="text" name="search_mobile" placeholder="Mobile Number" value="{{$search_mobile}}" class="form-control filter_inputs" /></td>
                                <td><input type="text" name="search_landline" placeholder="Landline Number" value="{{$search_landline}}" class="form-control filter_inputs" /></td>
                                <td><input type="text" name="search_email" placeholder="Email" value="{{$search_email}}" class="form-control filter_inputs" /></td>
                                <td><input type="text" name="search_firstname" placeholder="First Name" value="{{$search_mobile}}" class="form-control filter_inputs" /></td>
                                <td><input type="text" name="search_lastname" placeholder="Last Name" value="{{$search_mobile}}" class="form-control filter_inputs" /></td>
                                <td></td>
                                <td></td>
                                <td style="vertical-align: middle;">
                                    <input type="submit" name="filter_leads" value="Search" class="btn btn-primary" style="font-size:14px" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table id="contacts_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>MobileNum</th>
                                <th>Landline</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Campaign Name Used</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $d)
                                <tr>
                                    <td>{{$d->id}}</td>
                                    <td>{{$d->MobileNum}}</td>
                                    <td>{{$d->LandlineNum}}</td>
                                    <td>{{$d->FirstName}}</td>
                                    <td>{{$d->LastName}}</td>
                                    <td>{{$d->Address}}</td>
                                    <td>{{$d->Email}}</td>  
                                    <td>{{$d->CampaignName}}</td>                                     
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <b>TOTAL: {{$contacts->total()}}</b>
                    {{ $contacts->appends(request()->query())->links() }}
                    <br><br>
                    <form  action="/downloadleads" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="supplier_id" id="supplier_id" value="{{$supplier_id}}">
                        <input type="hidden" name="batch_id" id="batch_id" value="{{$batch_id}}">
                        <input type="hidden" name="campaign_id" id="campaign_id" value="{{$campaign_id}}">
                        <input type="hidden" name="mobile_num" id="mobile_num" value="{{$mobile_num}}">
                        <input type="hidden" name="landline" id="landline" value="{{$landline}}">
                        <input type="hidden" name="email" id="supplier_id" value="{{$email}}">
                        <input type="hidden" name="first_name" id="first_name" value="{{$first_name}}">
                        <input type="hidden" name="last_name" id="last_name" value="{{$last_name}}">
                        @if($contacts->total() > 0)
                            <input type="submit" id="downloadLink" value="Download Leads" name="download" class="btn btn-primary" />
                        
                            <div class="loading2 col-md-2"><img src="images/blue loading.gif" height="100">Exporting...</div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</main>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $(".loading").hide();
        $(".loading2").hide();
    });

    var setCookie = function(name, value, expiracy) {
        var exdate = new Date();
        exdate.setTime(exdate.getTime() + expiracy * 1000);
        var c_value = escape(value) + ((expiracy == null) ? "" : "; expires=" + exdate.toUTCString());
        document.cookie = name + "=" + c_value + '; path=/';
    };

    var getCookie = function(name) {
        var i, x, y, ARRcookies = document.cookie.split(";");
        for (i = 0; i < ARRcookies.length; i++) {
            x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
            y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
            x = x.replace(/^\s+|\s+$/g, "");
            if (x == name) {
            return y ? decodeURI(unescape(y.replace(/\+/g, ' '))) : y; //;//unescape(decodeURI(y));
            }
        }
    };

    $('#downloadLink').click(function() {
        $(".loading").hide();
        setCookie('downloadStarted', 0, 100); //Expiration could be anything... As long as we reset the value
        setTimeout(checkDownloadCookie, 1000); //Initiate the loop to check the cookie.
    });
    var downloadTimeout;
    var checkDownloadCookie = function() {
        if (getCookie("downloadStarted") == 1) {
            setCookie("downloadStarted", "false", 100); //Expiration could be anything... As long as we reset the value
            $(".loading2").hide();
            $(".loading").hide();
        } else {
            downloadTimeout = setTimeout(checkDownloadCookie, 1000); //Re-run this function in 1 second.
        }
    };
        
</script>

<style>
    .table-responsive nav{ float:right },
    .filter_inputs{
        font-size:14px;
    }
    #contact_filter_table th, #contact_filter_table td {
        border-top: 0px solid #dee2e6;
    }
</style>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

@stop
    