#!/usr/bin/php -q
<?php

if (count($argv) != 4) {
	print "Usage: % hangup.php phone_number expert_number duration\n";
	exit(1);
}

require_once(dirname(__FILE__).'/../lib/config.php');
require_once(dirname(__FILE__).'/../lib/db.php');

// Collect call information

list($phone_number, $expert_number, $call_duration) = array_slice($argv, 1);

// Build and execute SQL query

$sql =<<<SQL
	INSERT INTO `calls` (`expert_id`,`phone_number`,`call_duration`,`created_on`)
	VALUES ((
		SELECT id
		FROM experts
		WHERE phone_number = '%s'
	),'%s','%s',NOW())
SQL;

$sql = sprintf(
	$sql,
	mysql_real_escape_string($expert_number),
	mysql_real_escape_string($phone_number),
	mysql_real_escape_string($call_duration)
);

mysql_query($sql, $db);

?>