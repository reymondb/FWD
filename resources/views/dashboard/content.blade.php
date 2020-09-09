@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Content')

@section('content')
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Content</h1>
                @if(isset($status))
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Content Updated</li>
                    </ol>
                @endif
                

                <div class="card mb-4">
                    <div class="card-header"><i class="fas fa-table mr-1"></i>Existing Content</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="host_all" class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th class="actions">Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $h)
                                    <tr>
                                        <td style="width:200px;">{{$h->title}}</td>
                                        <td>{{$h->content}}</td>
                                        <td><a onclick="editContent('{{$h->id}}','{{$h->title}}','{{$h->content}}')" href="#ex1" data-toggle="modal" data-target="#myModal"><i class="far fa-edit"></i></a></td>
                                       
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
            <div class="modal-dialog"  style="width:800px">
            
            <!-- Modal content-->
            <div class="modal-content" style="width:800px">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-table mr-1"></i>Edit a Content</h4>
                </div>
                <div class="modal-body">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="editcontent" action="/editcontent" method="post">
                                    @csrf
                                    <input type="hidden" name="id" id="id" autocomplete="off" required>
                                    <table  class="table table-condensed table-bordered table-striped " style="margin-top: 20px ">
                                        <tbody>
                                            <tr>
                                                <td>Title</td>
                                                <td><input type="text" name="title" id="title" autocomplete="off" required></td>
                                            </tr>
                                            <tr>
                                                <td>Content</td>
                                            <td><textarea name="content" id="content" rows="5" cols="80"></textarea></td></tr>
                                            <tr>
                                                <td></td>
                                                <td><input type="Submit" name="Submit" id="Submit" Value="Update Content" ></td>
                                            </tr>
                                        </tbody>
                                
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
        var table = $('#host_all').DataTable({
        "iDisplayLength": 50
            });
    });
    function editContent(id,title,content){
        $("#id").val(id);
        $("#title").val(title); 
        $("#content").val(content);
        $("#ex1").modal('show');
    }
</script>
@stop