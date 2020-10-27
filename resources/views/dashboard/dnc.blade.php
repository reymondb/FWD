@extends('dashboard.dashboardlayout')
@section('title', 'DNC Leads List')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">DNC Leads <a href="/import_dnc" class="btn btn-primary" >Upload DNC </a></h1>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>DNC Leads</div> 
            <div class="card-body">
                <div class="table-responsive">
                    <form action="/dnc" method="GET">
                        <table>
                            <tr>
                                <td><input type="text" name="mobile" value="{{$mobile}}" placeholder="Mobile Number" class="form-control filter_inputs"></td>
                                <td><input type="text" name="landline" value="{{$landline}}" placeholder="Landline Number" class="form-control filter_inputs"></td>
                                <td><input type="text" name="email" value="{{$email}}" placeholder="Email" class="form-control filter_inputs"></td>
                                <td><input type="text" name="firsttname" value="{{$firsttname}}" placeholder="First Name" class="form-control filter_inputs"></td>
                                <td><input type="text" name="lasttname" value="{{$lasttname}}" placeholder="Last Name" class="form-control filter_inputs"></td>
                                <td style="vertical-align: middle;">
                                    <input type="submit" name="filter_leads" value="Search" class="btn btn-primary" style="font-size:14px" /> <i>*(Leave blank and click search to view all)</i>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table id="dnc_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
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
                            @foreach($data as $d)
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
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    
</main>
@stop

@section('js')
 
<script>
    $(document).ready(function() {
     /*   $('#dnc_all').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
       */ 
       
    });
</script>
<style>
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

@stop
    