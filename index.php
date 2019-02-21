<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include dirname(__FILE__) . '/Database/Migration.php';

$migration = new Migration();
echo'<pre>';print_r ($migration->initialize());

