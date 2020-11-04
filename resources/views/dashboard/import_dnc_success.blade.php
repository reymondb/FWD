
@extends('dashboard.dashboardlayout')
@section('title', 'Upload Leads Success')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Migration</h1>
        <div class="card mb-4">
            <div class="card-header">CSV Import</div>
                <div class="card-body">
                   <b>{{$totalcount}}</b> Data imported successfully.
                </div>
            </div>
        </div>
    </div>
</main>

@stop

@section('js')

@stop
    