@extends('dashboard.dashboardlayout')
@section('title', 'Leads Washing Success')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Washing Report </h1>
        <div class="card mb-4">
            <div class="card-header">CSV Import</div>
            <div class="card-body">
                Data washed successfully.
            </div>
        </div>
        @csrf
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Unique Leads</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        Total Unique: {{ isset($uniqueleads) ? $uniqueleads : '0'}} 
                    </div>
                    <div class="col-md-2">
                        <a href="/leadwashing/exportunique/" id="downloadLink" class="btn btn-primary" download>Export Unique</a>
                    </div>
                    <div class="loading col-md-2"><img src="images/blue loading.gif" height="100">Exporting...</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Duplicate Leads</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        Total Duplicate: {{ isset($duplicateleads) ? $duplicateleads : '0'}}
                    </div>
                    <div class="col-md-2">
                        <a href="/leadwashing/exportduplicate/" id="downloadLink2" class="btn btn-primary" download>Export Duplicates</a>
                    </div>
                    <div class="loading2 col-md-2"><img src="images/blue loading.gif" height="100">Exporting...</div>
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
    $('#downloadLink2').click(function() {
        $(".loading2").show();
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

@stop
    