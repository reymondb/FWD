@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Supplier')

@section('content')

<main>
    <div class="container-fluid">
        @if(isset($status))
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">New Supplier Created</li>
            </ol>
        @endif
        <h1 class="mt-4">Suppliers</h1>
        <div class="card mb-4">
            <div class="card-header">Create a Supplier</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="createsupplier" action="/createsupplier" enctype="multipart/form-data" method="post">
                        @csrf
                        <table class="table table-condensed table-bordered table-striped col-md-4" style="margin-top: 20px ">
                            <tr>
                                <td>Supplier Name</td>
                                <td><input type="text" name="name" id="name" required  autocomplete="off" ></td>
                                <td ><input type="submit" class="btn btn-primary" value="Create Supplier"  style="font-size:14px"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Existing Suppliers</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="suppliers_all" class="table table-condensed table-bordered table-striped col-md-6" style="margin-top: 20px ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Supplier Name</th>
                                <th class="actions">Edit</th>
                                <th class="actions">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->name}}</td>
                                <td><a onclick="editsupplier('{{$c->id}}','{{addslashes($c->name)}}')" href="#ex1" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></a></td>
                                <td><a href="/deletesupplier/{{$c->id}}" onclick="return confirm('Are you sure?')"class="delete"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</main>


        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" style="width: 800px;">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-table mr-1"></i>Edit a supplier</h4>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form id="editsupplier" action="/editsupplier" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="hidden" name="id" id="id" autocomplete="off" required>
                                        <table class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                            <tr>
                                                <td>Supplier Name</td>
                                                <td><input type="text" name="editname" id="editname" required  autocomplete="off" ></td>                                            
                                                <td ><input type="submit" value="Update Supplier" class="btn btn-primary" style="font-size:14px"></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



@stop

@section('js')

<script>
    $(document).ready(function() {
        var table = $('#suppliers_all').DataTable({
        "order": [[ 2, "desc" ]],
        "iDisplayLength": 50
        } );
    });

    function editsupplier(id,name){
        $("#id").val(id);
        $("#editname").val(name);
        
    }
    

</script>
@stop