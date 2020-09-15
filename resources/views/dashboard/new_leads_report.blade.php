@extends('dashboard.dashboardlayout')
@section('title', 'Upload Leads Success')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Lead Washing Report </h1>
        <div class="card mb-4">
            <div class="card-header">CSV Import</div>
            <div class="card-body">
                Data washed successfully.
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Unique Leads</div>
            <div class="card-body">
                Total Unique: {{ isset($uniqueleads) ? $uniqueleads : '0'}}
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Duplicate Leads</div>
            <div class="card-body">
                Total Duplicate: {{ isset($duplicateleads) ? $duplicateleads : '0'}}
            </div>
        </div>
    </div>
    
</main>
@stop

@section('js')
 
<script>
    $(document).ready(function() {
        $('#unique_all').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        
        $('#duplicates_all').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
    });
</script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>

@stop
    