<?php

include dirname(__FILE__) . '/src/Users.php';

	$loggedIn = false;
	if(isset($_SESSION['user_id']))
		$loggedIn = true;
?>


<!DOCTYPE html>
<html>
<head>
	<title>Albums</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style type="text/css">
		#logincont {
			padding: 20px;
		}
	</style>
</head>
<body>
	<nav class="navbar bg-dark navbar-dark ">
    <a class="navbar-brand " href="index.php">Home</a>
     <?php if(!$loggedIn){?>
    <div class="pull-right">
	    <a href="login.php" class="btn btn-success pull-right">Login</a>
	    <a href="signup.php" class="btn btn-primary pull-right">Sign Up</a>
    	
    </div>
    <?php }
    	else{ ?>

    		<a href="logout.php" class="btn btn-danger pull-right">Logout</a>
    	<?php
    	}
    ?>
</nav>

	<div class="container" id="logincont">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">

		</div>
	</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
