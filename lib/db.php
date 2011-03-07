<?php

require_once('config.php');

$db = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die ('Error connecting to mysql');
mysql_select_db(DB_NAME, $db);