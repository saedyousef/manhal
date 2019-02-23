<?php
session_start();
include dirname(__FILE__) . '/Components/GoogleComponents.php';
	
	//print_r($_SESSION['user_id']);die;
	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
		header("Location:index.php");
		exit();
	}

	$gc = new GoogleComponents();
	$url = $gc->authentication();
	if(!$url){
		header("Location:index.php");
	}

	header('Location:'.$url);
