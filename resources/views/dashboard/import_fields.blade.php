@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Lead Migration')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Migration</h1>
        @if($warning==1)
            <p class="warning">*Warning: This file might have already been uploaded.</p>
        @endif
        <div class="card mb-4">
            <div class="card-header">CSV Import ({{$totalrows}})</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form class="form-horizontal" method="POST" action="{{ route('import_process') }}" style="font-size:14px">
                        {{ csrf_field() }}
                        <input type="hidden" name="campaign" value="{{ $campaign }}" />
                        <input type="hidden" name="batchdesc" value="{{ $batchdesc }}" />
                        <input type="hidden" name="filename" value="{{ $filename }}" />
                        <input type="hidden" name="supplier_id" value="{{ $supplier_id }}" />
                        <input type="hidden" name="csv_data_file_id" value="{{ $csv_data_file->id }}" />

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
                                            <option value="" selected>Ignore</option>
                                            <!--(\Request::has('header')) ? $db_field :!-->
                                            <!-- @if ($loop->index == $i) selected @endif !-->
                                            @foreach (config('app.db_fields') as $db_field)
                                                <option value="{{ $loop->index }}"  >{{ $db_field }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @php $i++; @endphp
                                @endforeach
                            </tr>
                        </table>

                        <button type="submit" class="btn btn-primary" onlclick="loading()">
                            Import Data
                        </button> <br><br>
                    </form>
                </div>
                <div id="myProgress">
                    <div id="myBar" style="color:#FFF"></div>
                </div>
                  Total Uploaded: <div id="counter" >0 Loaded</div>
            </div>
        </div>
    </div>
</main>
    
    
<style>
    .warning{
        font-style: italic;
        color:red;
        font-weight: bold;
    }
</style>
<script>
    function loading(){
        $(".loading").show();
    }
</script>
@stop

@section('js')
<script>
    console.log("{{$totalrows}}")
    var i = 0;
    var totalrows={{$totalrows}};
    function move() {
        if (i == 0) {
            i = 1;
            var elem = document.getElementById("myBar");
            var width = 10;
            var id = setInterval(frame, 80);
            function frame() {
            if (width >= totalrows) {
                clearInterval(id);
                i = 0;
            } else {
                width++;
                elem.style.width = Math.round((width/totalrows)*100) + "%";
                elem.innerHTML ="  "+ Math.round((width/totalrows)*100)  + " %";
                document.getElementById("counter").innerHTML = width  + " upoaded";
                
            }
            }
        }
    }
</script>
@stop
<style>
#myProgress {
  width: 100%;
  background-color: grey;
}

#myBar {
  width: 1%;
  height: 30px;
  background-color: green;
}

</style>