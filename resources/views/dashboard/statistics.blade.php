@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Content')

@section('content')
        <main>
            <div class="container-fluid">
                <h2 class="mt-4">Lead Statistics</h2>
                
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Select Campaing: 
                        @csrf
                        <select name="campaign_id" id="campaign">
                            <option value="">Select Capaign</option>
                            @foreach ($campaigns as $c)
                                <option value="{{$c->id}}">{{$c->CampaignName}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            
                        </div>
                    </div>
                </div>
               
            </div>
        </main>
       

          
@stop

@section('js')
        <script>
             $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('input[name=_token]').val()
                }
            });
            $(document).ready(function(){
                $("#campaign_id").on("change",function(){
                    $.ajax({
                        url: "/getleadlists?campaignid="+$("#campaign_id").val(),
                        type: 'GET',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function (data) {
                            console.log(data);
                                    
                        }
                    });
                });
            });
        </script>
@stop