@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Lead Washing')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard Charts Data</h1>
        @if(isset($status))
            <ol class="breadcrumb mb-4" style="background: orange;">
                <li class="breadcrumb-item active" style="color:#FFFFFF">Refresh Updated</li>
            </ol>
        @endif
        
        <div class="card mb-4">
            <div class="card-header">Refresh Data</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table  class="table table-condensed table-bordered">
                        <tr>
                            <th>Chart</th>
                            <th>Last Updated</th>
                            <th style="width:20%;">Action</th>
                        </tr>
                        
                        <tr>
                            <td>Campaigns </td>
                            <td id="updated1">{{$chart1}}</td>
                            <td style="height: 60px">
                                <button class="btn-primary btn" onclick="refreshChart1()">Refresh Data</button>
                                <img src="images/blue loading.gif" class="loading1 loader"  height="50">
                            </td>
                        </tr>
                        <tr>
                            <td>From Supplier  </td>
                            <td id="updated2">{{$chart2}}</td>
                            <td>
                                <button class="btn-primary btn" onclick="refreshChart2()">Refresh Data</button>
                                
                                <img src="images/blue loading.gif" class="loading2 loader" height="50">
                            </td>
                        </tr>
                        <tr>
                            <td>Total Blanks  </td>
                            <td id="updated3">{{$chart3}}</td>
                            <td>
                                <button class="btn-primary btn" onclick="refreshChart3()">Refresh Data</button>
                                <img src="images/blue loading.gif" class="loading3 loader" height="50">
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Total Records Containing</td>
                            <td id="updated4">{{$chart4}}</td>
                            <td>
                                <button class="btn-primary btn" onclick="refreshChart4()">Refresh Data</button>
                                <img src="images/blue loading.gif" class="loading4 loader" height="50">
                            </td>
                        </tr>
                        <tr>
                            <td>DNC Chart</td>
                            <td id="updated5">{{$chart5}}</td>
                            <td>
                                <button class="btn-primary btn" onclick="refreshChart5()">Refresh Data</button>
                                <img src="images/blue loading.gif" class="loading5 loader" height="50">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>



@stop

@section('js')
<script>
    $(".loading1").hide();
    $(".loading2").hide();
    $(".loading3").hide();
    $(".loading4").hide();
    $(".loading5").hide();
    function refreshChart1(){
        $(".loading1").show();
        
        $.ajax({
            url: "/optimizeChart1",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated1").html(data);
                $(".loading1").hide();                
            }
        });
    }
    function refreshChart2(){
        $(".loading2").show();
        
        $.ajax({
            url: "/optimizeChart2",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated2").html(data);
                $(".loading2").hide();                
            }
        });
    }
    
    function refreshChart3(){
        $(".loading3").show();
        
        $.ajax({
            url: "/optimizeChart3",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated3").html(data);
                $(".loading3").hide();                
            }
        });
    }
    function refreshChart4(){
        $(".loading4").show();
        
        $.ajax({
            url: "/optimizeChart4",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated4").html(data);
                $(".loading4").hide();                
            }
        });
    }
    
    function refreshChart5(){
        $(".loading5").show();
        
        $.ajax({
            url: "/optimizeChart5",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated5").html(data);
                $(".loading5").hide();                
            }
        });
    }
</script>
@stop
