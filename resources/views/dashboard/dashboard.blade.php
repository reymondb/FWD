@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard')

@section('content')

        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Total Number Of Lead Rows: <b>{{$total[0]->total}}</b></li>
                </ol>
               
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Pie CHART -->
                            <div class="card card-primary">
                                <div class="card-header">Campaigns</div>
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
                                <div class="card-header">From Supplier</div>
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
                                <div class="card-header">Total Blanks</div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="blanktotals" height="280" width="600"></canvas>
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
            var url = "{{url('leadschart')}}";
            console.log(url);
            var Totals = new Array();
            var Labels = new Array();
            $(document).ready(function(){
                $.get(url, function(response){
                    response.forEach(function(data){
                        console.log(data);
                        Totals.push(data.total);
                        Labels.push(data.CampaignName);
                    });
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

            var url2 = "{{url('blankchart')}}";
            var BlankTotals = new Array();
            var BlankLabels = new Array();
            var BlankPercentage = new Array();
            
            $(document).ready(function(){
                $.get(url2, function(response){
                    response.forEach(function(data){
                        console.log(data);
                        BlankTotals.push(data.totals);
                        BlankLabels.push(data.Label);
                        BlankPercentage.push(data.percentage);
                    });
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

            
            var url3 = "{{url('supplierchart')}}";
            console.log(url);
            var supplierTotals = new Array();
            var supplierLabels = new Array();
            $(document).ready(function(){
                $.get(url3, function(response){
                    response.forEach(function(data){
                        console.log(data);
                        supplierTotals.push(data.totals);
                        supplierLabels.push(data.supplier);
                    });
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
            


        </script>
@stop