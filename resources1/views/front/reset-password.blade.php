<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Change Password</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid d-flex-inline " style="height:100vh;">
	    <form action="{{url('api/reset')}}" method="post" enctype="mulyipart/form-data">
	        @csrf
		<div class="row" >
			<div class="col-sm-4 bg-light text-center pt-4 pb-5 mt-4" style="margin:auto;">
			    @if(session()->has("error"))
			     {{session("error")}}
			    @endisset
			    @if(session()->has("msg"))
			    <p class="alert alert-warning">{{session('This password reset token is invalid.')}}</p>
			    @endif
			     <input type="hidden" value="{{ $passwordReset["token"]}}" name="token">
			      <input type="hidden" value="{{ $passwordReset["email"]}}" name="email">
				<h4>Change Password</h4><hr>
             <div class="form-group">
             	<label>New Password</label>
             	<input type="password" name="password" class="form-control">
             </div>
              <div class="form-group">
             	<label>Confirm Password</label>
             	<input type="password" name="cpassword" class="form-control">
             </div>
             <div class="form-group ">
             	<button class="btn btn-dark btn-sm">Reset Password</button>
             </div>
			</div>
		</div>
		</form>
	</div>
</body>
</html>