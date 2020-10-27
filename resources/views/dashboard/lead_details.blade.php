@extends('dashboard.dashboardlayout')
@section('title', 'Lead Details')

@section('content')
        <main>
            <div class="container-fluid">
                <h2 class="mt-4">Lead Details For {{$phonenumber}}</h2>
                @if(isset($status))
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Content Updated</li>
                    </ol>
                @endif
                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Existing Content</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="host_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                <thead>
                                    <tr>
                                        <th>Campaign</th>
                                        <th>Lead ID</th>
                                        <th>Status</th>
                                        <th>Call Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $z)
                                        @foreach($z as $h)
                                        <tr>
                                            <td>{{$h->campaign_id}}</td>
                                            <td style="width:200px;">{{$h->lead_id}}</td>
                                            <td>{{$h->status_name}}</td>
                                            <td>{{date("M d,Y h:i:s A",strtotime($h->call_date))}}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                        
                        
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </main>
       

          
@stop

@section('js')

@stop