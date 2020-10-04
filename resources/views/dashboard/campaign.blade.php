@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Campaign')

@section('content')

<main>
    <div class="container-fluid">
        @if(isset($status))
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">New Campaign Created</li>
            </ol>
        @endif
        <h1 class="mt-4">Campaigns</h1>
        <div class="card mb-4">
            <div class="card-header">Create a Campaign</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="createcampaign" action="/createcampaign" enctype="multipart/form-data" method="post">
                        @csrf
                        <table class="table table-condensed table-bordered table-striped col-md-4" style="margin-top: 20px ">
                            <tr>
                                <td>Campaign Name</td>
                                <td><input type="text" name="name" id="name" required  autocomplete="off" ></td>
                                <td>Database Url(IP address)</td>
                                <td><input type="text" name="MySQL_url" required  autocomplete="off" ></td>
                            </tr>
                            <tr>
                                <td>Mysql Database</td>
                                <td><input type="text" name="Mysql_db"  required  autocomplete="off" ></td>
                                <td>Database Username</td>
                                <td><input type="text" name="Mysql_username" required  autocomplete="off" ></td>
                            </tr>
                            <tr>
                                <td>Mysql Password</td>
                                <td><input type="text" name="Mysql_password"  required  autocomplete="off" ></td>
                                <td ><input type="submit" class="btn btn-primary" value="Create Campaign"  style="font-size:14px"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">Existing Campaigns</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="campaigns_all" class="table table-condensed table-bordered table-striped col-md-6" style="margin-top: 20px ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Campaign name</th>
                                <th class="actions">Edit</th>
                                <th class="actions">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($campaigns as $c)
                            <tr>
                                <td>{{$c->id}}</td>
                                <td>{{$c->CampaignName}}</td>
                                <td><a onclick="editcampaign('{{$c->id}}','{{addslashes($c->CampaignName)}}','{{$c->MySQL_url}}','{{$c->Mysql_db}}','{{$c->Mysql_username}}','{{$c->Mysql_password}}')" href="#ex1" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></a></td>
                                <td><a href="/deletecampaign/{{$c->id}}" onclick="return confirm('Are you sure?')"class="delete"><i class="fas fa-trash-alt"></i></a></td>
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
                <h4 class="modal-title"><i class="fas fa-table mr-1"></i>Edit a Campaign</h4>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="editcampaign" action="/editcampaign" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="hidden" name="id" id="id" autocomplete="off" required>
                                    <table class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                        <tr>
                                            <td>Campaign Name</td>
                                            <td><input type="text" name="editname" id="editname" required  autocomplete="off" ></td>
                                            <td>Database Url(IP address)</td>
                                            <td><input type="text" name="MySQL_url" id="MySQL_url" required  autocomplete="off" ></td>
                                        </tr>
                                        <tr>
                                            <td>Mysql Database</td>
                                            <td><input type="text" name="Mysql_db" id="Mysql_db" required  autocomplete="off" ></td>
                                            <td>Database Username</td>
                                            <td><input type="text" name="Mysql_username" id="Mysql_username" required  autocomplete="off" ></td>
                                        </tr>
                                        <tr>
                                            <td>Mysql Password</td>
                                            <td><input type="text" name="Mysql_password" id="Mysql_password" required  autocomplete="off" ></td>
                                            <td ><input type="submit" value="Update Campaign" class="btn btn-primary" style="font-size:14px"></td>
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
        var table = $('#campaigns_all').DataTable({
        "order": [[ 2, "desc" ]],
        "iDisplayLength": 50
        } );
    });

    function editcampaign(id,name,MySQL_url,Mysql_db,Mysql_username,Mysql_password){
        $("#id").val(id);
        $("#editname").val(name);
        $("#MySQL_url").val(MySQL_url);
        $("#Mysql_db").val(Mysql_db);
        $("#Mysql_username").val(Mysql_username);
        $("#Mysql_password").val(Mysql_password);
        
    }
    

</script>
@stop
