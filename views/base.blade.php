<?php

/*if(!isset($_SESSION)){
    session_start();
}*/

?>

<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		@stack('scripts')
	</head>
	<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="<?php echo ($_ENV['BASE_URL'] . '/') ?>">{{$_ENV['APP_NAME']}}</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
		  <ul class="navbar-nav mr-auto">
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo ($_ENV['BASE_URL'] . '/books') ?>">Add book</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="<?php echo ($_ENV['BASE_URL'] . '/authors') ?>">Authors</a>
			</li>
		  </ul>
		  <span class="navbar-text">
			  @if(isset($_SESSION['user']))
					{{$_SESSION['user']['name']}}
				<form method="POST" action="<?php echo ($_ENV['BASE_URL'] . '/logout') ?>">
							<input type="submit" class="text-danger ml-4"  value="Log out" ?>
				</form>
			  @else
				<span>
					<a class="nav-link" href="<?php echo ($_ENV['BASE_URL'] . '/login') ?>">Log in</a>
				</span>
			 @endif
		 </span>
		</div>
	  </nav>

	 <div class="container">
				@yield('content')
	 </div>
	</body>
</html>
