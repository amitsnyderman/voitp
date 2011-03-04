#!/usr/bin/php -q
<?php

require('/var/lib/asterisk/agi-bin/phpagi.php');

$agi = new AGI();

// Collect call information

$context = $agi->request['agi_context'];
$extension = $agi->request['agi_extension'];

// TODO Establish DB connection

// TODO Build SQL query
// Select expert with following criteria
// * Has specialties w/context and extension
// * Has availability matching now!
// * Least recently called of those experts

$sql = 'SELECT phone_number FROM experts LIMIT 1'; // fake

// TODO Execute SQL query to get expert

$phone_number = '12125551212'

// Initiate call

$agi->exec_dial('SIP', "itp_jnctn/$phone_number", null, 10);

?>