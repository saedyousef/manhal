<?php

session_start();

include dirname(__FILE__) . '/src/Albums.php';

	if(!isset($_SESSION['user_id']))
		header("Location:login.php");

	if(isset($_POST['create']))
	{
		$title 		 = strip_tags($_POST['title']);
		$descreption = strip_tags($_POST['descreption']);

		$fullPath = dirname(__FILE__);
		$thumbnailsDirectory = '/Albums/thumbnails/';
		$imagesDirectory 	 = '/Albums/images/';

		if(!is_writable($fullPath . $thumbnailsDirectory)){
		    $errors = 'Thumbnails directory is not writeable';
		}else
		{
			$extensions = ["jpeg", "jpg", "png"];
			if(!isset($_FILES['thumbnail']) || !empty($_FILES['thumbnail']['error']))
			{
				$errors = 'Something went wrong uploading thumbnail';
			}else
			{
				$file_name = $_FILES["thumbnail"]["name"];
				$thumbnailExt = pathinfo($file_name, PATHINFO_EXTENSION);
				if(!in_array($thumbnailExt, $extensions))
					$errors = 'The image type is not allowed to be uploaded';
				else{
					if(!file_exists($fullPath . $thumbnailsDirectory . $file_name)){
						move_uploaded_file($_FILES["thumbnail"]['tmp_name'], $fullPath . $thumbnailsDirectory . $file_name);
						$thumbnail = $thumbnailsDirectory . $file_name;
					}else
					{
						$filename = basename($file_name, $thumbnailExt);
	                    $newFileName = $filename.time().".".$thumbnailExt;

	                    move_uploaded_file($_FILES["thumbnail"]['tmp_name'], $fullPath . $thumbnailsDirectory . $newFileName);
						$thumbnail = $thumbnailsDirectory . $newFileName;
					}
				}
			}

			if(!isset($thumbnail))
				$errors = 'Something went wrong';
			else
			{
				if(empty($_FILES['images']['tmp_name'][0]) || !is_writable($fullPath . $imagesDirectory)){
					$images = null;
				}
				else{
					$imagesFiles = $_FILES['images'];
					$images = [];
					foreach ($imagesFiles['tmp_name'] as $key => $image) {
						if($imagesFiles['error'][$key] == 0 && in_array(pathinfo($imagesFiles['name'][$key], PATHINFO_EXTENSION), $extensions))
						{
							if(!file_exists($fullPath . $imagesDirectory . $imagesFiles['name'][$key])){
								move_uploaded_file($imagesFiles['tmp_name'][$key], $fullPath . $imagesDirectory . $imagesFiles['name'][$key]);
								$images[$key] = $imagesDirectory . $imagesFiles['name'][$key];
							}else
							{
								$filename = basename($imagesFiles['name'][$key], pathinfo($imagesFiles['name'][$key], PATHINFO_EXTENSION));
			                    $newFileName = $imagesFiles['name'][$key].time().".".pathinfo($imagesFiles['name'][$key], PATHINFO_EXTENSION);

			                    move_uploaded_file($imagesFiles['tmp_name'][$key], $fullPath . $imagesDirectory . $newFileName);
								$images[$key] = $imagesDirectory . $newFileName;
							}
						}
					}
				}
				$albums = new Albums();
				$save = $albums->saveAlbum($_SESSION['user_id'], $title, $descreption, $thumbnail, $images);

				if(isset($save['success']) && !$save['success'])
					$errors = $save['errors'];
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

	<title>Add Album</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<style type="text/css">
		#signupContainer{
			padding: 20px;
		}
	</style>
</head>
<body>
	<nav class="navbar bg-dark navbar-dark ">
    <a class="navbar-brand " href="index.php">Albums</a>
    <div class="pull-right">
	    <a href="logout.php" class="btn btn-danger pull-right">Logout</a>
    	
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
			<form method="post" action="add_album.php" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="title">Title</label>
			    <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" required="required">
			  </div>

			  <div class="form-group">
			    <label for="descreption">Descreption</label>
			    <input type="text" class="form-control" id="descreption"  placeholder="Enter descreption" name="descreption" required="required">
			  </div>

			  <div class="form-group">
			    <label for="Thumbnail">Thumbnail</label>
			    <input type="file" class="form-control" id="Thumbnail"  name="thumbnail"  required="required" enctype="multipart/form-data"  accept=".png, .jpg, .jpeg">
			  </div>

			  <div class="form-group">
			    <label for="Images">Images</label>
			    <input type="file" class="form-control" id="Images"  name="images[]"  multiple enctype="multipart/form-data">
			  </div>


			  
			  <button type="submit" class="btn btn-primary" name="create">Create</button>
			</form>
		</div>
	</div>
	</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>