@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Games')

@section('content')

<main>
    <div class="container-fluid">
        @if(isset($status))
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">New Game Created</li>
            </ol>
        @endif
        <h1 class="mt-4">Games</h1>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-gamepad"></i></i>Create a Game</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form id="creategame" action="/creategame" enctype="multipart/form-data" method="post">
                        @csrf
                        <table class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                            <tr>
                                <td>Name of Event</td>
                                <td><input type="text" name="name" id="name" required  autocomplete="off" ></td>
                                <td>Game Type</td>
                                <td>
                                    <select name="game_type" id="game_type" class="form-selectd" required>
                                        <option></option>
                                        @foreach($gametypes as $gt)
                                            <option value="{{$gt->id}}">{{$gt->label}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Host</td>
                                <td>
                                    <select name="host" id="host" class="form-selectd" required>
                                        <option></option>
                                        @foreach($hosts as $h)
                                            <option value="{{$h->id}}">{{$h->host}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>Date</td>
                                <td><input type="text" name="start_date" id="start_date" class="date-picker" required   autocomplete="off" ></td>
                            </tr>
                            <tr>
                                <td rowspan="2">Description</td>
                                <td rowspan="2">
                                    <textarea  name="description" id="description" rows="6" style="width:100%"></textarea>
                                </td>
                                <td>Time</td>
                                <td><input type="text" name="start_time" id="start_time" class="timepicker" required   autocomplete="off" ></td>
                            </tr>
                            <tr>
                                <td>Spots</td>
                                <td>
                                    <select name="spots" id="spots" class="form-selectd" required>
                                        <option></option>
                                        @for($x=0;$x<100;$x++)
                                            <option>{{$x}}</option>
                                        @endfor
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Game Image</td>
                                <td><input type="file" name="game_image" id="game_image"></td>
                                <td colspan="2"><input type="submit" value="Create Game"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-table mr-1"></i>Existing Games</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="games_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Spots</th>
                                <th>Game Type</th>
                                <th class="actions">Edit</th>
                                <th class="actions">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($games as $g)
                            <tr>
                                <td>{{$g->id}}</td>
                                <td><a href="#" onclick="seeRegistrations({{$g->id}},'{{addslashes($g->title)}}')" >{{$g->title}}</a></td>
                                <td data-sort="{{strtotime($g->start_date)}}">{{date('F d,Y',strtotime($g->start_date))}}</td>
                                <td data-sort="{{strtotime($g->start_date)}}">{{date('g:iA',strtotime($g->start_time))}}</td>
                                <td>{{$g->spots}}</td>
                                <td>{{$g->label}}</td>
                                <td><a onclick="editgame('{{$g->id}}','{{addslashes($g->title)}}','{{$g->game_type}}','{{$g->host_id}}','{{date("m/d/Y",strtotime($g->start_date))}}','{{addslashes($g->description)}}','{{date("h:i A",strtotime($g->start_time))}}','{{$g->spots}}','{{$g->image}}')" href="#ex1" data-toggle="modal" data-target="#myModal"><i class="fas fa-edit"></i></a></td>
                                <td><a href="/deletegame/{{$g->id}}" onclick="return confirm('are you sure?')"class="delete"><i class="fas fa-trash-alt"></i></a></td>
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
                <h4 class="modal-title"><i class="fas fa-table mr-1"></i>Edit a Game</h4>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="editgame" action="/editgame" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="hidden" name="id" id="id" autocomplete="off" required>
                                    <table class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                        <tr>
                                            <td>Name of Event</td>
                                            <td><input type="text" name="editname" id="editname" required  autocomplete="off" ></td>
                                            <td>Game Type</td>
                                            <td>
                                                <select name="editgame_type" id="editgame_type" class="form-selectd" required>
                                                    <option></option>
                                                    @foreach($gametypes as $gt)
                                                        <option value="{{$gt->id}}">{{$gt->label}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Host</td>
                                            <td>
                                                <select name="edithost" id="edithost" class="form-selectd" required>
                                                    <option></option>
                                                    @foreach($hosts as $h)
                                                        <option value="{{$h->id}}">{{$h->host}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>Date</td>
                                            <td><input type="text" name="editstart_date" id="editstart_date" class="date-picker" required   autocomplete="off" ></td>
                                        </tr>
                                        <tr>
                                            <td rowspan="2">Description</td>
                                            <td rowspan="2">
                                                <textarea  name="editdescription" id="editdescription" rows="6" style="width:100%"></textarea>
                                            </td>
                                            <td>Time</td>
                                            <td><input type="text" name="editstart_time" id="editstart_time" class="timepicker" required   autocomplete="off" ></td>
                                        </tr>
                                        <tr>
                                            <td>Spots</td>
                                            <td>
                                                <select name="editspots" id="editspots" class="form-selectd" required>
                                                    <option></option>
                                                    @for($x=0;$x<100;$x++)
                                                        <option>{{$x}}</option>
                                                    @endfor
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Game Image</td>
                                            <td>
                                                <input type="file" name="editgame_image" id="editgame_image">
                                                <div id="editimage"></div>
                                            </td>
                                            <td colspan="2"><input type="submit" value="Update Game"></td>
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

        <!-- Modal -->
        <div class="modal fade" id="bookedmodal" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="width: 800px;">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-table mr-1"></i>Registered For <span id="game_title"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive" id="bookingholder">

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
        var table = $('#games_all').DataTable({
        "order": [[ 2, "desc" ]],
        "iDisplayLength": 50
        } );
    });

    function editgame(id,name,game_type,host,start_date,description,start_time,spots,image){
        $("#id").val(id);
        $("#editname").val(name);
        $("#editgame_type").val(game_type);
        $("#edithost").val(host);
        $("#editstart_date").val(start_date);
        $("#editdescription").val(description);
        $("#editstart_time").val(start_time);
        $("#editspots").val(spots);
        $("#editimage").html("<image src='"+image+"' width='100px'>");
        $("#ex1").modal('show');
        
        $( document ).ready(function() {
            $('input#editstart_time').timepicker({});
        });
        
    }
    
    function seeRegistrations(id,game_title){
        //console.log(id);
        $("#game_title").html(game_title);

        $.ajax({
          url: "/getregistered/"+id,
          type: 'GET',
          contentType: false, // The content type used when sending data to the server.
          cache: false, // To unable request pages to be cached
          processData: false,
          success: function (data) {
                if(data.success){
                        console.log(data.bookings);
                        var table = '<table id="bookings" class="table table-condensed table-bordered table-striped " style="margin-top: 20px "><thead><tr><th>Email</th><th>Team Name</th><th>Number Players</th><th>Amount</th><th>Date Registered</th></tr></thead><tbody></tbody></table>';
                        $("#bookingholder").html(table);
                        if(data['bookings'].length > 0){
                            for(var x=0;x<data['bookings'].length;x++){
                                // $("#bookings tbody").append("<tr><td>"+data["bookings"][x]["email"]+"</td><td>"+data["bookings"][x]["team_name"]+"</td><td>"+data["bookings"][x]["players"]+"</td><td>"+data["bookings"][x]["amount"]+"</td><td>"+data["bookings"][x]["created_atz"]+"</td></tr>");
                                $("#bookings tbody").append("<tr><td>"+data["bookings"][x]["emails"]+"</td><td>"+data["bookings"][x]["team_name"]+"</td><td>"+data["bookings"][x]["players"]+"</td><td>"+data["bookings"][x]["amount"]+"</td><td>"+data["bookings"][x]["created_atz"]+"</td></tr>");
                            }
                        }
                        else{
                            $("#bookings tbody").append("<tr><td colsan='4'>No registrations yet.</td></tr>");
                        }
                    $("#bookedmodal").modal("show");
                    $(document).ready(function() {
                        var table = $('#bookings').DataTable({
                        "iDisplayLength": 50
                        });
                    });
                }
          }
      });
    }

</script>
<style>
    .ui-timepicker-container {
        z-index: 3500 !important;
    }
</style>
@stop
