<?php

session_start();
include dirname(__FILE__) . '/src/Albums.php';

	if(!isset($_SESSION['user_id'])){
		header("Location:login.php");
		exit();
	}

	if(!isset($_GET['aid'])){
		header("Location:index.php?wrongId=1");
		exit();
	}

	$Albums = new Albums();

	if($Albums->deleteAlbum($_GET['aid'])){
		header("Location:index.php");
		exit();
	}

	header("Location:index.php?wrongId=1");
?>