<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) . '/src/Albums.php';

$obj = new Albums();

$images = [
	'googlecom',
	'facebookcom',
	'githubcom',
];
$save = $obj->saveAlbum(1, 'Test', 'Desc', 'thumbnail.com', $images);
