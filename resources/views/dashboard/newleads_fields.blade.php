@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Lead Washing')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Washing</h1>
        <div class="card mb-4">
            <div class="card-header">CSV Import (Check duplicate by @if($checkduplicate==1): Mobile Number @endif @if($checkduplicate==2): Landline Number @endif @if($checkduplicate==3): Email @endif</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form class="form-horizontal" method="POST" action="{{ route('newleads_process') }}" style="font-size:14px">
                        {{ csrf_field() }}
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />
                        <input type="hidden" name="checkduplicate" value="{{ $checkduplicate }}" />

                        <table class="table">
                            @if (isset($csv_header_fields))
                            <tr>
                                @foreach ($csv_header_fields as $csv_header_field)
                                    <th>{{ $csv_header_field }}</th>
                                @endforeach
                            </tr>
                            @endif
                            @foreach ($csv_data as $row)
                                <tr>
                                @foreach ($row as $key => $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                                </tr>
                            @endforeach
                            <tr>
                                @php
                                    $i = 0
                                @endphp 
                                @foreach ($csv_data[0] as $key => $value)
                                    <td>
                                        <select name="fields[{{ $key }}]">
                                            <option value="">Ignore</option>
                                            <!--(\Request::has('header')) ? $db_field :!-->
                                            <!-- @if ($loop->index == $i) selected @endif !-->
                                            @foreach (config('app.db_fields') as $db_field)
                                                <option value="{{ $loop->index }}" >{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @php $i++; @endphp
                                @endforeach
                            </tr>
                        </table>

                        <button type="submit" class="btn btn-primary">
                            Import Data
                        </button><br><br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
    
    

@stop

@section('js')

@stop
    