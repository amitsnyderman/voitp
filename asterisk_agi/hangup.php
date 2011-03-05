#!/usr/bin/php -q
<?php

require('/var/lib/asterisk/agi-bin/phpagi.php');

$agi = new AGI();

// Collect call information

$phone_number = $agi->request['agi_callerid'];
$call_duration = $agi->request['agi_arg_1'];

// TODO Establish DB connection

// Build SQL query

$sql = "INSERT INTO `calls` (`expert_id`,`phone_number`,`call_duration`,`created_on`) VALUES ('1','$phone_number','$call_duration',NOW())";

// TODO Execute SQL query to insert row

?>