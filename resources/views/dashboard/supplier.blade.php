@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Supplier')

@section('content')

<main>
    <div class="container-fluid">
        @if(isset($status))
            <ol class="breadcrumb mb-4" style="background: orange;">
                <li class="breadcrumb-item active" style="color:#FFFFFF">New Supplier Created</li>
            </ol>
        @endif
        @if(isset($error))
            <ol class="breadcrumb mb-4 bg-danger" >
                <li class="breadcrumb-item active r" style="color:#FFFFFF">Email Already Exist.</li>
            </ol>
        @endif
        
        <h1 class="mt-4">Suppliers</h1>
        <div class="card mb-4">
            <div class="card-header">Create a Supplier</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="createsupplier" action="/createsupplier" enctype="multipart/form-data" method="post">
                        @csrf
                        <table class="table table-condensed table-bordered table-striped col-md-6" style="margin-top: 20px ">
                            <tr>
                                <td>Supplier Name</td>
                                <td><input type="text" name="name" id="name" required  autocomplete="off"></td>
                                <td>Email</td>
                                <td><input type="text" name="email" id="email" required  autocomplete="off"></td>
                                <td>Role</td>
                                <td><select name="role"><option value="1">Admin</option><option value="2">User</option><option value="3">Supplier</option></select></td>
                                <td>Password</td>
                                <td><input type="text" name="password" id="password" required  autocomplete="off"></td>
                                <td ><input type="submit" class="btn btn-primary" value="Create Supplier" style="font-size:14px"></td>
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
                                <th>Email</th>
                                <th class="actions">Edit</th>
                                <th class="actions">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($suppliers as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->name}}</td>
                                <td>{{$c->email}}</td>
                                <td><a onclick="editsupplier('{{$c->id}}','{{addslashes($c->name)}}','{{addslashes($c->email)}}','{{addslashes($c->role)}}')" href="#ex1" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></a></td>
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
                                        <div class="form-group">
                                            <label for="campaign" class="col-md-4 control-label">Supplier Name</label>
                                            <div class="col-md-6">
                                                <input type="text" id="editname"  class="form-control" name="editname"  required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="campaign" class="col-md-4 control-label">Email</label>
                                            <div class="col-md-6">
                                                <input type="text" id="editemail"  class="form-control" name="editemail"  required />
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label for="campaign" class="col-md-4 control-label">Role</label>
                                            <div class="col-md-6">
                                                <select name="editrole" id="editrole"><option value="1">Admin</option><option value="2">User</option><option value="3">Supplier</option></select>
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <label for="campaign" class="col-md-4 control-label">New Password</label>
                                            <div class="col-md-6">
                                                <span style="font-style: italic;font-size:12px">*Leave the field blank if you don't want to change password</span>
                                                <input type="password" id="editpassword"  class="form-control" name="editpassword"  />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="campaign" class="col-md-4 control-label">Confirm Password</label>
                                            <div class="col-md-6">
                                                <input type="password" id="confirm_password"  class="form-control" name="confirm_password"  />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-8 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Edit Supplier
                                                </button>
                                            </div>
                                        </div>
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
    var password = document.getElementById("editpassword")
    , confirm_password = document.getElementById("confirm_password");

    function validatePassword(){
        if(password.value != confirm_password.value && password.value!='') {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>

<script>
    $(document).ready(function() {
        var table = $('#suppliers_all').DataTable({
        "order": [[ 2, "desc" ]],
        "iDisplayLength": 50
        } );
    });

    function editsupplier(id,name,email,role){
        console.log("here"+name);
        $("#id").val(id);
        $("#editname").val(name);
        $("#editemail").val(email);
        $("#editrole").val(role);
        
    }

</script>
@stop
