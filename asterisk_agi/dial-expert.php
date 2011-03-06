#!/usr/bin/php -q
<?php

if (count($argv) != 4) {
	print "Usage: % dial-expert.php context extension offset\n";
	exit(1);
}

require_once(dirname(__FILE__).'/../lib/config.php');
require_once(dirname(__FILE__).'/../lib/db.php');

// Collect call information

list($context, $extension, $offset) = array_slice($argv, 1);

// Build SQL query
// Select expert with following criteria
// * Has specialties w/context and extension
// * Has availability matching now!
// * Least recently called of those experts

$sql =<<<SQL
	SELECT DISTINCT(e.phone_number)
	FROM experts e
	INNER JOIN experts_specialties es
		ON e.id = es.expert_id
	INNER JOIN specialties s
		ON es.specialty_id = s.id
		AND s.context = '%s'
		AND s.extension = '%s'
	INNER JOIN availability a
		ON e.id = a.expert_id
		AND a.day IN (DAYOFWEEK(CURRENT_DATE()))
		AND ((CURTIME() BETWEEN a.from AND a.through) OR a.allday = TRUE)
	LEFT JOIN calls c
		ON e.id = c.expert_id
	ORDER BY c.created_on ASC
	LIMIT %d,1
SQL;

$sql = sprintf(
	$sql,
	mysql_real_escape_string($context),
	mysql_real_escape_string($extension),
	$offset
);

// Get the expert's #
// We're not storing the leading 1 so prepend it

$result = mysql_query($sql, $db);
$row = mysql_fetch_assoc($result);

echo $row['phone_number'];

?>