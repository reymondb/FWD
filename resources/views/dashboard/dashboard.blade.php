@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard')

@section('content')

        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Total Number Of Lead Rows: <b>{{number_format($total[0]->total)}}</b></li>
                </ol>
               
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header" >
                                    
                                    <div style="display: inline;">
                                    Campaigns (Total: <span id="campaign_total">0</span>) 
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart1()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading1"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="campaigntotals" height="280" width="600"></canvas>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        From Supplier (Total: <span id="supplier_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart2()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading2"  height="30">
                                    </div>
                                    @endif                                
                                </div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="supplierchart" height="280" width="600"></canvas>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>      
                    </div>
                    <div class="row" style="padding-top:20px;">
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        Total Blanks (Total: <span id="blank_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart3()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading3"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="blanktotals" height="280" width="600"></canvas>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>    
                        <div class="col-md-6">    
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div style="display: inline;">
                                        Total No Blanks (Total: <span id="noblank_total">0</span>)
                                    </div>
                                    @if( Auth::user()->role ==1)
                                    <div style="display: inline-block"">
                                        <button class="btn-primary btn" onclick="refreshChart4()" style="font-size: 12px;">Refresh Data</button>
                                        <img src="images/blue loading.gif" class="loading4"  height="30">
                                    </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="noblanktotals" height="280" width="600"></canvas>
                                </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>      
                    </div>
                </div>
                
                  <!-- /.row -->
            </section>
        </main>

          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
          <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js" charset="utf-8"></script>
          

        <script>
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            loadChart1();
            loadChart2();
            loadChart3();
            loadChart4();
            
            $(".loading1").hide();
            $(".loading2").hide();
            $(".loading3").hide();
            $(".loading4").hide();
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
                        loadChart1();
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
                        loadChart2();
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
                        loadChart3();
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
                        loadChart4();
                        $(".loading4").hide();                
                    }
                });
            }

            function loadChart1(){
                var url = "{{url('leadschart')}}";
                var Totals = new Array();
                var Labels = new Array();
                var campaigntotals=0;
                $(document).ready(function(){
                    $.get(url, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            Totals.push(data.total);
                            Labels.push(data.CampaignName);
                            campaigntotals = campaigntotals + data.total;
                        });
                        $("#campaign_total").html(numberWithCommas(campaigntotals));
                        var ctx = document.getElementById("campaigntotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: Totals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: Labels
                            },                   
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }

                        
                        });
                    });
                });
            }

            function loadChart2(){
                var url2 = "{{url('blankchart')}}";
                var BlankTotals = new Array();
                var BlankLabels = new Array();
                var BlankPercentage = new Array();
                var blank_total = 0;
                $(document).ready(function(){
                    $.get(url2, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            BlankTotals.push(data.totals);
                            BlankLabels.push(data.Label);
                            BlankPercentage.push(data.percentage);
                            blank_total = blank_total + data.totals;
                        });
                        $("#blank_total").html(numberWithCommas(blank_total));
                        var ctx = document.getElementById("blanktotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: BlankTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: BlankLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    });
                });
            }

            
            function loadChart3(){
                var url3 = "{{url('supplierchart')}}";
                var supplierTotals = new Array();
                var supplierLabels = new Array();
                var supplier_total = 0;
                $(document).ready(function(){
                    $.get(url3, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            supplierTotals.push(data.totals);
                            supplierLabels.push(data.supplier);
                            supplier_total = supplier_total + data.totals;
                        });
                        $("#supplier_total").html(numberWithCommas(supplier_total));
                        var ctx = document.getElementById("supplierchart").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: supplierTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: supplierLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    });
                });
            }

            function loadChart4(){
                var url2 = "{{url('noblankchart')}}";
                var noBlankTotals = new Array();
                var noBlankLabels = new Array();
                var noBlankPercentage = new Array();
                var noblank_total = 0;
                $(document).ready(function(){
                    $.get(url2, function(response){
                        response.forEach(function(data){
                            console.log(data);
                            noBlankTotals.push(data.totals);
                            noBlankLabels.push(data.Label);
                            noBlankPercentage.push(data.percentage);
                            noblank_total = noblank_total + data.totals;
                        });
                        $("#noblank_total").html(numberWithCommas(noblank_total));
                        var ctx = document.getElementById("noblanktotals").getContext('2d');
                        var myPieChart = new Chart(ctx, {
                            type: 'doughnut',
                            data:{
                                datasets: [{
                                    data: noBlankTotals,
                                    backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: noBlankLabels
                            },                        
                            options: {
                                legend: {
                                    display: true,
                                    position: 'left',
                                },
                                tooltips: {
                                    enabled: false
                                },
                                plugins: {
                                    labels: {
                                        render: 'percentage',
                                        fontColor: '#FFFFFF',
                                        precision: 2
                                    }
                                }
                            }
                        
                        });
                    });
                });
            }
            


        </script>
@stop