#!/usr/bin/php -q
<?php

require('/var/lib/asterisk/agi-bin/phpagi.php');

$agi = new AGI();

// Collect call information

$context = $agi->request['agi_context'];
$extension = $agi->request['agi_extension'];

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

$phone_number = '12125551212';

// Initiate call

$agi->exec_dial('SIP', "itp_jnctn/$phone_number", null, 10);

?>