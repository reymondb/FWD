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
                                <div class="card-header">Campaignszz</div>
                                <div class="card-body">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                    <canvas id="campaigntotalsz" height="280" width="600"></canvas>
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
                        type: 'pie',
                        data:{
                            datasets: [{
                                data: Totals,
                                backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                            }],

                            // These labels appear in the legend and in the tooltips when hovering different arcs
                            labels: Labels
                        }
                      
                    });
                });
            });


        </script>
@stop