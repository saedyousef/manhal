<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) . '/src/Albums.php';
	
	$loggedIn = true;
	if(!isset($_SESSION['user_id'])){
		header('Location:login.php');
		$loggedIn = false;
	}

	if(!isset($_GET['aid']))
		header('Location:index.php?wrongId=1');

	$album = new Albums();
	$albumsDetails = $album->alubmDetails($_GET['aid']);
	$albums = $albumsDetails['images'];

?>


<!DOCTYPE html>
<html>
<head>
	<title>Albums</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<style type="text/css">
	.thumbnail {
		background: no-repeat center;
    	width: 100%;
    	height: 300px;
    	background-size: cover;
    	text-align:center;
	}

	.deletebtns{
		float: right;
	}
	.thumbnail-title{
		background-color: white;
		color: black;
		width: 100%;
		height: 100px;  

	}

	</style>
</head>
<body>
	<nav class="navbar bg-dark navbar-dark ">
    <a class="navbar-brand " href="index.php">Albums</a>
     <?php if(!$loggedIn){?>
    <div class="pull-right">
	    <a href="login.php" class="btn btn-success pull-right">Login</a>
	    <a href="signup.php" class="btn btn-primary pull-right">Sign Up</a>
    	
    </div>
    <?php }
    	else{ ?>

    		<a href="add_album.php" class="btn btn-primary pull-right">Add Album</a>
    		<a href="logout.php" class="btn btn-danger pull-right logout">Logout</a>
    	<?php
    	}
    ?>
</nav>
	
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<h5>Title:</h5>
				<h5>Description:</h5>
				<h5>Created Time:</h5>
			</div>
			<div class="col-md-6">
				<h5> <?php echo $albumsDetails['album']['title']; ?> </h5>
				<h5> <?php echo $albumsDetails['album']['descreption']; ?> </h5>
				<h5> <?php echo $albumsDetails['album']['created']; ?> </h5>
			</div>
		</div>
	</div>
	
		<?php
			if(isset($_GET['wrongId']))
				echo '<div class="alert alert-danger"> Invalid ID </div>';
			if(!empty($albums))
			{
				$numOfCols = 3;
				$rowCount = 0;
				$bootstrapColWidth = 12 / $numOfCols;
				?>
				<div class="row">
				<?php
				foreach ($albums as $key => $row){
				?>  
				        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
				            <div class="thumbnail"  style="background-image: url('<?php echo $row['image_url']; ?>')">
				                <a class="btn btn-danger pull-right deletebtns" href="image_delete.php?imageid=<?php echo $row['id'];?>" onclick="confirm('Are you sure you want to Delete this image?');"><i class="fa fa-trash" aria-hidden="true"></i></a>

				            </div>
				        </div>
				<?php
				    $rowCount++;
				    if($rowCount % $numOfCols == 0) echo '</div><div class="row">';
				}
			}else
				echo '<div class="alert alert-danger"> No images found in this album</div>';
		?>
				</div>



	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
