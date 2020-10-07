@extends('dashboard.dashboardlayout')
@section('title', 'Dashboard > Lead Washing')

@section('content')

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Profile</h1>
        @if(isset($status))
            <ol class="breadcrumb mb-4" style="background: orange;">
                <li class="breadcrumb-item active" style="color:#FFFFFF">Profile Updated</li>
            </ol>
        @endif
        
        <div class="card mb-4">
            <div class="card-header">Edit Profile</div>
            <div class="card-body">
                <div class="table-responsive">
                    <form class="form-horizontal" method="POST" action="{{ route('edit_profile') }}" >
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="campaign" class="col-md-4 control-label">Name</label>
                            <div class="col-md-6">
                                <input type="text" id="name"  class="form-control" name="name" value="{{$user->name}}" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="campaign" class="col-md-4 control-label">Email</label>
                            <div class="col-md-6">
                                <input type="text" id="email"  class="form-control" name="email" value="{{$user->email}}" required />
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="campaign" class="col-md-4 control-label">New Password</label>
                            <div class="col-md-6">
                                <input type="password" id="password"  class="form-control" name="password" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="campaign" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input type="password" id="confirm_password"  class="form-control" name="confirm_password" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edit Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>



@stop

@section('js')
<script>
    var password = document.getElementById("password")
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
@stop
