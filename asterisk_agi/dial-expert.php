#!/usr/bin/php -q
<?php


// Collect call information

$context = $argv[1];
$extension = $argv[2];

// TODO Establish DB connection

// Build SQL query
// Select expert with following criteria
// * Has specialties w/context and extension
// * Has availability matching now!
// * Least recently called of those experts

$sql =<<<SQL
	SELECT DISTINCT(e.id), e.phone_number
	FROM experts e
	INNER JOIN experts_specialties es
		ON e.id = es.expert_id
	INNER JOIN specialties s
		ON es.specialty_id = s.id
		AND s.context = '$context'
		AND s.extension = '$extension'
	INNER JOIN availability a
		ON e.id = a.expert_id
		AND a.day IN (DAYOFWEEK(CURRENT_DATE()))
		AND ((CURTIME() BETWEEN a.from AND a.through) OR a.allday = TRUE)
	LEFT JOIN calls c
		ON e.id = c.expert_id
	ORDER BY c.created_on ASC
	LIMIT 1
SQL;


// TODO Execute SQL query to get expert

$phone_number = '12069471415';

// Initiate call

echo $phone_number;

?>