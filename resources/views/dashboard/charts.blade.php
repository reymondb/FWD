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
                    <table  class="table table-condensed table-bordered table-striped ">
                        <tr>
                            <th>Chart</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                        
                        <tr>
                            <td>Campaigns </td>
                            <td id="updated1">{{$chart1}}</td>
                            <td><button class="btn-primary btn" onclick="refreshChart1()">Refresh Data</button></td>
                        </tr>
                        <tr>
                            <td>From Supplier  </td>
                            <td id="updated2">{{$chart2}}</td>
                            <td><button class="btn-primary btn" onclick="refreshChart2()">Refresh Data</button></td>
                        </tr>
                        <tr>
                            <td>Total Blanks  </td>
                            <td id="updated3">{{$chart3}}</td>
                            <td><button class="btn-primary btn" onclick="refreshChart3()">Refresh Data</button></td>
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
    function refreshChart1(){
        
        $.ajax({
            url: "/optimizeChart1",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated1").html(data);
                
            }
        });
    }
    function refreshChart2(){
        
        $.ajax({
            url: "/optimizeChart2",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated2").html(data);
                
            }
        });
    }
    
    function refreshChart3(){
        
        $.ajax({
            url: "/optimizeChart3",
            type: 'GET',
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (data) {
                console.log(data);
                $("#updated3").html(data);
                
            }
        });
    }
</script>
@stop
