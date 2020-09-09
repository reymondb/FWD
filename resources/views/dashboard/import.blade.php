@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Lead Migration')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Migration</h1>
        <div class="card mb-4">
            <div class="card-header">CSV Import</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form class="form-horizontal" method="POST" action="{{ route('import_parse') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="campaign" class="col-md-4 control-label">Campaign</label>
                            <div class="col-md-6">
                                <select id="campaign"  class="form-control" name="campaign" required>
                                    @foreach($campaigns as $c)
                                        <option value="{{$c->id}}">{{$c->CampaignName}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('csv_file') ? ' has-error' : '' }}">
                            <label for="csv_file" class="col-md-4 control-label">CSV file to import</label>

                            <div class="col-md-6">
                                <input id="csv_file" type="file" class="form-control" name="csv_file" required>

                                @if ($errors->has('csv_file'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('csv_file') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="header" checked> File contains header row?
                                    </label>
                                </div>
                            </div>
                        </div>
                        !-->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Parse CSV
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>



@stop

@section('js')

@stop
