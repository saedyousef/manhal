<?php

include dirname(__FILE__) . '/Components/GoogleComponents.php';
include dirname(__FILE__) . '/src/Users.php';

	if(!isset($_GET['code'])){
		header("Location:index.php");
	}
	$gc = new GoogleComponents();
	$userinfo = $gc->getUserInfo($_GET['code']);

	$email = $userinfo['user_info'];
	$users = new Users();
	$googleLogin = $users->googleLogin($email);