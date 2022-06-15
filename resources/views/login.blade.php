<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Żłobki</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<main class="login-form">
<div class="cotainer">
<div class="row justify-content-center">
<div class="col-md-4">
<div class="card">
<h3 class="card-header text-center">Login User</h3>
<div class="card-body">
  
    @if (session()->has('msg'))
    <div class="alert alert-success">{{ session()->pull('msg')}}</div>
    @endif
    @if (session()->has('jwt'))
    <div class="alert alert-success">{{ session()->pull('jwt')}}</div>
    @endif

<form action="{{ route('login') }}" method="POST">
<div class="form-group mb-3">
<input type="text" placeholder="Email" id="email_address" class="form-control"
name="email" required autofocus>
@if ($errors->has('email'))
<span class="text-danger">{{ $errors->first('email') }}</span>
@endif
</div>
<div class="form-group mb-3">
<input type="password" placeholder="Password" id="password" class="form-control"
name="password" required>
@if ($errors->has('password'))
<span class="text-danger">{{ $errors->first('password') }}</span>
@endif
</div>
<div class="form-group mb-3">
<div class="checkbox">
<label><input type="checkbox" name="remember"> Remember Me</label>
</div>
</div>
<div class="d-grid mx-auto">
    
<button type="submit" class="btn btn-dark btn-block">Sign in</button>
<a href="{{ route('registrationview') }}" class="btn btn-outline-primary">...Or sign up...</a>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</main>
</html>