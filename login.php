<?php
include dirname(__FILE__) . '/src/Users.php';
	
	if(isset($_SESSION['user_id']))
		header('Location:index.php');

	$users = new Users();
	if(isset($_POST['submit']))
	{
		$username = strip_tags($_POST['username']);
		$password = $_POST['password'];

		$login = $users->login($username, $password);

		if(isset($login['success']) && !$login['success'])
			$errors = $login['errors'];
		else
			header("Location:index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style type="text/css">
		#logincont {
			padding: 20px;
		}
	</style>
</head>
<body>
	<nav class="navbar bg-dark navbar-dark ">
    <a class="navbar-brand " href="index.php">Albums</a>
    <div class="pull-right">
	    <a href="login.php" class="btn btn-success pull-right">Login</a>
	    <a href="signup.php" class="btn btn-primary pull-right">Sign Up</a>
    	
    </div>
</nav>
	
	<?php 
		if(isset($errors))
			echo '<div class="alert alert-danger">' . $errors .'</div>';
	?>
	<div class="container" id="logincont">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form method="post" action="login.php">
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" name="username" required="required">
			  </div>
			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required="required">
			  </div>
			  <button type="submit" class="btn btn-primary" name="submit">Login</button>
			</form>
		</div>
	</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>