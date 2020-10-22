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

                        Select List ID:
                        <select id="list_id" name="list_id"></select>
                        Lead Cost: <input type="text" name="lead_cost" id="lead_cost" value="0">
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" >
                            <table class='table table-bordered table-hover' id="leadstats">
                                <thead>
                                    <tr><th colspan='16'>From vicidial_list (Overall Lead Total: <span id="over_all">0</span> )</th></tr>
                                    
                                    <tr><th colspan=2 class="report_th">Original Batch Date</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">Batch ID</th><th colspan=2 class="report_th" id="batch_id"></th></tr> 
                                    <tr><th colspan=2 class="report_th">LEAD COST (AUD)</th><th colspan=2 class="report_th" id="lead_cost_report"></th></tr>
                                    <tr><th colspan=2 class="report_th">TOTAL NUMBERS IN THE FILE</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">Lead Batch Dialer Cycle</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">TOTAL QUALIFIED LEADS (QL)</th><th colspan=2 class="report_th" id="replace"></th></tr>

                                    <tr><th colspan=2 class="report_th">COST / QL (CPQL)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">COST / LEAD (CPL)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">Penetration (Human Ans)</th><th colspan=2 class="report_th" id="human_answered"></th></tr>
                                    <tr><th colspan=2 class="report_th">Penetration Rate</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">COST / Contactable LEAD (CPCL)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">FX</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">COST / QL (PHP)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">COST / LEAD (PHP)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">COST / Contactable LEAD (PHP)</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    <tr><th colspan=2 class="report_th">TOTAL DIALS</th><th colspan=2 class="report_th" id="replace"></th></tr>
                                    
                                    <tr>
                                        <th colspan=4></th>
                                        <th colspan='2'>Dial Attempt Pass #1</th>
                                        <th colspan='2'>Dial Attempt Pass #2</th>
                                        <th colspan='2'>Dial Attempt Pass #3</th>
                                        <th colspan='2'>Dial Attempt Pass #4</th>
                                        <th colspan='2'>Dial Attempt Pass #5</th>
                                        <th colspan='2'>Dial Attempt Pass > #5</th>
                                    </th>
                                    <tr>
                                        <th style='width:50px'>Status</th>
                                        <th style='width:200px'>Status Name</th>
                                        <th class="sum"></th> 
                                        <th class="sum2"></th>                                       
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>
                                    </tr>
                                </thead>                                
                                <tbody id="leadstatslists">

                                </tbody>
                                <tfoot>
                                    <th></th><th>Total:</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                </tfoot>
                            </table>
                        </div>
                        <hr>
                        <br>
                        <div class="table-responsive">
                            <table class='table table-bordered table-hover' id="reportholderlogs">
                                <thead>
                                    <tr><th colspan='16'>From vicidial_list (Overall Lead Total: <span id="over_all2">0</span> )</th></tr>
                                    <tr>
                                        <th colspan=4></th>
                                        <th colspan='2'>Dial Attempt Pass #1</th>
                                        <th colspan='2'>Dial Attempt Pass #2</th>
                                        <th colspan='2'>Dial Attempt Pass #3</th>
                                        <th colspan='2'>Dial Attempt Pass #4</th>
                                        <th colspan='2'>Dial Attempt Pass #5</th>
                                        <th colspan='2'>Dial Attempt Pass > #5</th>
                                    </th>
                                    <tr>
                                        <th style='width:50px'>Status</th>
                                        <th style='width:200px'>Status Name</th>
                                        <th class="sum"></th> 
                                        <th class="sum2"></th>                                       
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>                                     
                                        <th class="sum">COUNT</th>
                                        <th class="sum2">LEAD %</th>
                                    </tr>
                                </thead>                                
                                <tbody id="reportholderlogzz">

                                </tbody>
                                <tfoot>
                                    <th></th><th>Total:</th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                </tfoot>
                            </table>
                            
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
                $("#leadstatslists").html("");
                $("#reportholderlogzz").html("");
                $("#over_all").html("0");
                $("#over_all2").html("0");
                fetchLeadStatList();
                fetchLeadStatLog();
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
                    if ( $.fn.DataTable.isDataTable('#leadstats') ) {
                        $('#leadstats').DataTable().destroy();
                    }
                    var ha = 0;
                    var nha = 0;
                    $('#leadstats tbody').empty();
                    $.each(data, function(k, v) {
                        $("#over_all").html(v.overalltotal);
                        if(v.human_answered=="Y"){
                            ha = ha + v.total;
                        }
                        else{
                           nha = nha + v.total;
                        }
                        $('#leadstatslists').append('<tr><td>'+v.status+'</td><td>'+v.status_name+'</td><td>'+v.total+'</td><td>'+(v.total / v.overalltotal).toFixed(4)+'</td><td>'+v.total1+'</td><td>'+(v.total1 / v.overalltotal).toFixed(4)+'</td><td>'+v.total2+'</td><td>'+(v.total2 / v.overalltotal).toFixed(4)+'</td><td>'+v.total3+'</td><td>'+(v.total3 / v.overalltotal).toFixed(4)+'</td><td>'+v.total4+'</td><td>'+(v.total4 / v.overalltotal).toFixed(4)+'</td><td>'+v.total5+'</td><td>'+(v.total5 / v.overalltotal).toFixed(4)+'</td><td>'+v.total6+'</td><td>'+(v.total6 / v.overalltotal).toFixed(4)+'</td></tr>');
                    });
                    $("#human_answered").html(ha);
                    $("#batch_id").html($("#list_id").val());
                    $("#lead_cost_report").html($("#lead_cost").val());
                     
                    $('#leadstats').DataTable( {
                        "paging":   false,
                        "ordering": true,
                        "info":     false,
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copyHtml5', header:true, footer: true },
                            { extend: 'excelHtml5', header:true, footer: true,
                            customize: function (xlsx) {
                                //Apply styles, Center alignment of text and making it bold.
                                var sSh = xlsx.xl['styles.xml'];
                                var lastXfIndex = $('cellXfs xf', sSh).length - 1;

                                var n1 = '<numFmt formatCode="##0.0000%" numFmtId="300"/>';
                                var s2 = '<xf numFmtId="0" fontId="2" fillId="0" borderId="0" applyFont="1" applyFill="0" applyBorder="0" xfId="0" applyAlignment="1">' +
                                        '<alignment horizontal="center"/></xf>';

                                sSh.childNodes[0].childNodes[0].innerHTML += n1;
                                sSh.childNodes[0].childNodes[5].innerHTML += s2;

                                var greyBoldCentered = lastXfIndex + 1;

                                //Merge cells as per the table's colspan
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                                var dt = $('#tblReport').DataTable();
                                var frColSpan = $(dt.table().header()).find('th:nth-child(1)').prop('colspan');
                                var srColSpan = $(dt.table().header()).find('th:nth-child(2)').prop('colspan');
                                var columnToStart = 2;

                                var mergeCells = $('mergeCells', sheet);
                                mergeCells[0].appendChild(_createNode(sheet, 'mergeCell', {
                                    attr: {
                                        ref: 'A1:' + toColumnName(frColSpan) + '1'
                                    }
                                }));

                                mergeCells.attr('count', mergeCells.attr('count') + 1);

                                var columnToStart = 2;

                                while (columnToStart <= frColSpan) {
                                    mergeCells[0].appendChild(_createNode(sheet, 'mergeCell', {
                                        attr: {
                                            ref: toColumnName(columnToStart) + '2:' + toColumnName((columnToStart - 1) + srColSpan) + '2'
                                        }
                                    }));
                                    columnToStart = columnToStart + srColSpan;
                                    mergeCells.attr('count', mergeCells.attr('count') + 1);
                                }

                                //Text alignment to center and apply bold
                                $('row:nth-child(1) c:nth-child(1)', sheet).attr('s', greyBoldCentered);
                                for (i = 0; i < frColSpan; i++) {
                                    $('row:nth-child(2) c:nth-child(' + i + ')', sheet).attr('s', greyBoldCentered);
                                }

                                function _createNode(doc, nodeName, opts) {
                                    var tempNode = doc.createElement(nodeName);
                                    if (opts) {
                                        if (opts.attr) {
                                            $(tempNode).attr(opts.attr);
                                        }
                                        if (opts.children) {
                                            $.each(opts.children, function (key, value) {
                                                tempNode.appendChild(value);
                                            });
                                        }
                                        if (opts.text !== null && opts.text !== undefined) {
                                            tempNode.appendChild(doc.createTextNode(opts.text));
                                        }
                                    }
                                    return tempNode;
                                }

                                //Function to fetch the cell name
                                function toColumnName(num) {
                                    for (var ret = '', a = 1, b = 26; (num -= a) >= 0; a = b, b *= 26) {
                                        ret = String.fromCharCode(parseInt((num % b) / a) + 65) + ret;
                                    }
                                    return ret;
                                }
                        
                            }},
                            { extend: 'csvHtml5', header:true, footer: true },
                            { extend: 'pdfHtml5', header:true, footer: true }
                        ],
                        "initComplete": function (settings, json) {
                            if(this.fnSettings().aoData.length===0) {
                                console.log("no data");
                            } else {
                                this.api().columns('.sum').every(function () {
                                    var column = this;
                                
                                    var sum = column
                                    .data()
                                    .reduce(function (a, b) { 
                                        a = parseInt(a, 10);
                                        if(isNaN(a)){ a = 0; }
                                        b = parseInt(b, 10);
                                        if(isNaN(b)){ b = 0; }
                                        
                                        return a + b;
                                    });

                                    $(column.footer()).html(sum);
                                });
                                this.api().columns('.sum2').every(function () {
                                    var column = this;
                                
                                    var sum = column
                                    .data()
                                    .reduce(function (a, b) { 
                                        a = parseFloat(a);
                                        if(isNaN(a)){ a = 0; }
                                        b = parseFloat(b);
                                        if(isNaN(b)){ b = 0; }
                                        
                                        return a + b;
                                    });

                                    $(column.footer()).html(parseFloat(sum).toFixed(4));
                                });
                            }
                        }
                    } );
                }
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
                    
                    if ( $.fn.DataTable.isDataTable('#reportholderlogs') ) {
                        $('#reportholderlogs').DataTable().destroy();
                    }

                    $('#reportholderlogs tbody').empty();
                   // $("#reportholderlogs").html("<table id='leadstatslogs' class='table' ><tr><th colspan='8'>From vicidial_logs</th></tr><tr><th >Status</th><th  style='width:200px'>Status Name</th><th>Total Count</th><th colspan='2'>Dial Attempt Pass #1</th><th colspan='2'>Dial Attempt Pass #2</th><th colspan='2'>Dial Attempt Pass #3</th><th colspan='2'>Dial Attempt Pass #4</th><th colspan='2'>Dial Attempt Pass #5</th><th colspan='2'>Dial Attempt Pass > #5</th></tr></table>");
                    $.each(data, function(k, v) {
                        $("#over_all2").html(v.overalltotal);
                        $('#leadstatslists').append('<tr><td>'+v.status+'</td><td>'+v.status_name+'</td><td>'+v.total+'</td><td>'+(v.total / v.overalltotal).toFixed(4)+'</td><td>'+v.total1+'</td><td>'+(v.total1 / v.overalltotal).toFixed(4)+'</td><td>'+v.total2+'</td><td>'+(v.total2 / v.overalltotal).toFixed(4)+'</td><td>'+v.total3+'</td><td>'+(v.total3 / v.overalltotal).toFixed(4)+'</td><td>'+v.total4+'</td><td>'+(v.total4 / v.overalltotal).toFixed(4)+'</td><td>'+v.total5+'</td><td>'+(v.total5 / v.overalltotal).toFixed(4)+'</td><td>'+v.total6+'</td><td>'+(v.total6 / v.overalltotal).toFixed(4)+'</td></tr>');
                    });

                    
                    $('#reportholderlogs').DataTable( {
                        "paging":   false,
                        "ordering": true,
                        "info":     false,
                        dom: 'Bfrtip',
                        buttons: [
                            { extend: 'copyHtml5', header:true, footer: true },
                            { extend: 'excelHtml5', header:true, footer: true },
                            { extend: 'csvHtml5', header:true, footer: true },
                            { extend: 'pdfHtml5', header:true, footer: true }
                        ],
                        "initComplete": function (settings, json) {
                            if(this.fnSettings().aoData.length===0) {
                                console.log("no data");
                            } else {
                                
                                this.api().columns('.sum').every(function () {
                                    var column = this;
                                
                                    var sum = column
                                    .data()
                                    .reduce(function (a, b) { 
                                        a = parseInt(a, 10);
                                        if(isNaN(a)){ a = 0; }
                                        b = parseInt(b, 10);
                                        if(isNaN(b)){ b = 0; }
                                        
                                        return a + b;
                                    });

                                    $(column.footer()).html(sum);
                                });
                                this.api().columns('.sum2').every(function () {
                                    var column = this;
                                
                                    var sum = column
                                    .data()
                                    .reduce(function (a, b) { 
                                        a = parseFloat(a);
                                        if(isNaN(a)){ a = 0; }
                                        b = parseFloat(b);
                                        if(isNaN(b)){ b = 0; }
                                        
                                        return a + b;
                                    });

                                    $(column.footer()).html(parseFloat(sum).toFixed(4));
                                });
                            }
                        }
                    } );
                            
                }
            });
        }

        $(document).ready(function() {
    
} );
    </script>
    <style>
        .report_th{
            padding:5px 10px !important;
            font-size:12px;
        }
    </style>
    
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    
@stop
