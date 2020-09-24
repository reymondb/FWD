
@extends('dashboard.dashboardlayout')
@section('title', 'Contact Leads List')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Leads</h1>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Contact Leads</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="contact_filter" method="POST">
                        <table id="contact_filter_table" class="table" style="background-color:rgba(0, 0, 0, 0.03)">
                            <tr>
                                <td>
                                    <select name="batch_id" class="form-control filter_inputs">
                                        <option value="">Select Batch</option>
                                        @foreach ($LeadBatch as $l)
                                            <option @if($batch_id==$l->id) selected @endif value="{{$l->id}}">{{$l->BatchDescription}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="supplier_id" class="form-control filter_inputs">
                                        <option value="">Select Supplier</option>
                                        @foreach ($User as $u)
                                            <option @if($supplier_id==$u->id) selected @endif value="{{$u->id}}">{{$u->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="campaign_id" class="form-control filter_inputs">
                                        <option value="">Select Campaign</option>
                                        @foreach ($Campaigns as $c)
                                            <option @if($campaign_id==$c->id) selected @endif value="{{$c->id}}">{{$c->CampaignName}}</option>
                                        @endforeach
                                        
                                    </select>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="mobile_num" value="1" checked  /> Mobile number
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="landline" value="1" checked  /> Landline
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="email" value="1" checked  /> Email
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="first_name" value="1" checked  /> First Name
                                        </label>
                                    </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="last_name" value="1" checked  /> Last  Name
                                        </label>
                                    </div>
                                </td>
                                
                                <td style="vertical-align: middle;">
                                    <input type="submit" name="filter_leads" value="Search" class="btn btn-primary" style="font-size:14px" />
                                </td>
                            </tr>
                        </table>
                    </form>
                    <table id="contacts_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
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
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
    
</main>
@stop

@section('js')
 
<script>
    $(document).ready(function() {
     /*   $('#contacts_all').DataTable( {
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
    