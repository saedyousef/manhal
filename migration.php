<?php

include dirname(__FILE__) . '/Database/Migration.php';

$migration = new Migration();

$migrate = $migration->initialize();
header("Location:index.php");
