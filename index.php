<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) . '/src/Users.php';

$users = new Users();
$signup = $users->signup('saedyouseff', 'saedf.alzaben@gmail.com', 'Saed1234', 'Saed1234', '1993-12-12');
echo "<pre>";print_r($signup);



/*echo "<pre>";print_r($_SESSION['user_id']);*/