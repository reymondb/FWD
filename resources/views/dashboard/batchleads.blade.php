
    <link href="/css/fwd.webflow.css" rel="stylesheet" type="text/css">
    <script src="https://use.typekit.net/cmh4dsx.js" type="text/javascript"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
    <link href="/images/fwd.png" rel="shortcut icon" type="image/x-icon">
    <link href="/images/webclip.png" rel="apple-touch-icon">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/custom.css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
<main>
    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Contact Leads <b>(TOTAL: {{$contacts->total()}})</b> <a href="/delete/{{$batch_id}}" class="btn btn-danger">Delete Batch</a></div>
            <div class="card-body">
                <div class="table-responsive">                    
                    <table id="batch_leads" class="table table-condensed table-bordered table-striped " >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>MobileNum</th>
                                <th>Landline</th>
                                <th>FirstName</th>
                                <th>LastName</th>
                                <th>Address</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $d)
                                <tr>
                                    <td>{{$d->id}}</td>
                                    <td>{{$d->MobileNum}}</td>
                                    <td>{{$d->LandlineNum}}</td>
                                    <td>{{$d->FirstName}}</td>
                                    <td>{{$d->LastName}}</td>
                                    <td>{{$d->Address}}</td>
                                    <td>{{$d->Email}}</td>                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <b>TOTAL: {{$contacts->total()}}</b>
                    {{ $contacts->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    
</main>
<style>
    #batch_leads td,#batch_leads th {
        font-size:12px;
    }
</style>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="/js/scripts.js"></script>
    
<link rel="stylesheet" href="{{ asset('/css/loader.css') }}">


<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- #region datatables files -->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css " />

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="//cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js "></script>

<!-- #endregion -->


<script src="/js/webflow.js" type="text/javascript"></script>
<script src="/js/custom.js" type="text/javascript"></script>

<!-- include timepickers !-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="/js/custom.js"></script>

<script src='/js/spectrum.js'></script>
<link rel='stylesheet' href='/css/spectrum.css' />
<!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->



<style>
    .table-responsive nav{ float:right },
    .filter_inputs{
        font-size:14px;
    }
    #contact_filter_table th, #contact_filter_table td {
        border-top: 0px solid #dee2e6;
    }
</style>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

    