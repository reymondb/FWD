@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Content')

@section('content')
        <main>
            <div class="container-fluid">
                <h2 class="mt-4">Lead Statistics</h2>
                
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Select Campaign: 
                        @csrf
                        <select name="campaign_id" id="campaign">
                            <option value="">Select Campaign</option>
                            @foreach ($campaigns as $c)
                                <option value="{{$c->id}}">{{$c->CampaignName}}</option>
                            @endforeach
                        </select>
                        <select id="list_id" name="list_id"></select>
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

    <style>
        .filter_inputs{
            font-size:14px;
        }
    </style>
    <script>
            $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('input[name=_token]').val()
            }
        });
        $(document).ready(function(){
            $("#campaign").on("change",function(){
                $.ajax({
                    url: "/getleadlists?campaignid="+$("#campaign").val(),
                    type: 'GET',
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false,
                    success: function (data) {
                        $('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                        $.each(data, function(k, v) {
                            $('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                        });
                                
                    }
                });
            });
            $("#list_id").on("change",function(){
                fetchLeadStatList();
            });
            
        });

        function fetchLeadStatList(){
            $.ajax({
                    url: "/getleadstats?list_id="+$("#list_id").val()+"&campaignid="+$("#campaign").val(),
                        type: 'GET',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function (data) {
                            //$('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                            $.each(data, function(k, v) {
                                //$('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                            });
                                    
                        }
                    });
                });
        }
        function fetchLeadStatLog(){
            $.ajax({
                    url: "/getleadstatslogs?list_id="+$("#list_id").val()+"&campaignid="+$("#campaign").val(),
                        type: 'GET',
                        contentType: false, // The content type used when sending data to the server.
                        cache: false, // To unable request pages to be cached
                        processData: false,
                        success: function (data) {
                            //$('#list_id').empty().append('<option selected="selected" value="">Select List ID</option>');
                            $.each(data, function(k, v) {
                                //$('#list_id').append('<option value="'+v.list_id+'">'+v.list_id+'</option>');
                            });
                                    
                        }
                    });
                });
        }
    </script>
@stop