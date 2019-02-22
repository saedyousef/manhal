<?php
include dirname(__FILE__) . '/src/Users.php';
	
	$users = new Users();

	if(isset($_SESSION['user_id']))
		header('Location:index.php');
	if(isset($_POST['signup']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$passwordConfirmation = $_POST['password_confirmation'];
		$email = $_POST['email'];
		$dateOfBirth = $_POST['date_of_birth'];
		//converte date format
		$dateOfBirth = date("Y-m-d", strtotime($dateOfBirth));
		$signup = $users->signup($username, $email, $password, $passwordConfirmation, $dateOfBirth);

		if(isset($signup['success']) && !$signup['success'])
			$errors = $signup['errors'];
	}
?>

<!DOCTYPE html>
<html>
<head>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

	<title>Sign Up</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style type="text/css">
		#signupContainer{
			padding: 20px;
		}
	</style>
</head>
<body>
	<nav class="navbar bg-dark navbar-dark ">
    <a class="navbar-brand " href="index.php">Home</a>
    <div class="pull-right">
	    <a href="login.php" class="btn btn-success pull-right">Login</a>
	    <a href="signup.php" class="btn btn-primary pull-right">Sign Up</a>
    	
    </div>
</nav>
	<?php 
		if(isset($errors))
			echo '<div class="alert alert-danger">' . $errors .'</div>';
	?>
	<div class="container" id="signupContainer">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<form method="post" action="signup.php">
			  <div class="form-group">
			    <label for="username">Username</label>
			    <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" name="username" required="required">
			  </div>

			  <div class="form-group">
			    <label for="username">Email</label>
			    <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username" name="email" required="required">
			  </div>

			  <div class="form-group">
			    <label for="exampleInputPassword1">Password</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required="required">
			  </div>

			  <div class="form-group">
			    <label for="exampleInputPassword1">Password Confirmation</label>
			    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password_confirmation" required="required">
			  </div>

			   <div class="form-group">
			    	<label for="exampleInputPassword1">Date of birth</label>
 			  		<input type="text" class="form-control" id="workOrderCompletedDate" placeholder="Select Date" name="date_of_birth" required="required">
 				</div>

			  
			  <button type="submit" class="btn btn-primary" name="signup">Signup</button>
			</form>
		</div>
	</div>
	</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
	$(function() {
	  
		 $("#workOrderCompletedDate").datepicker({
            autoclose: true,
            todayHighlight: true,
            orientation: "top auto"
        }).on("change", function () {

        });
	});
</script>
</body>
</html>