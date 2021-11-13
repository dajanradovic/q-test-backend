@extends('base')

@section('content')

<h3 class="mb-4 font-weight-bold">Log in</h3>
<form method="POST" action="<?php echo ($_ENV['BASE_URL'] . '/login') ?>">
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" placeholder="Enter email">
      <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
    </div>
    <input type="hidden" name="csrf_token" value="{{$csrf}}">
    <input type="hidden" name="intended" value="{{$_GET['intended']}}">
      <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection