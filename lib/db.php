<?php

require_once('config.php');

$db = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
mysql_select_db(DB_NAME, $db) or die(mysql_error());