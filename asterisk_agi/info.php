#!/usr/bin/php -q
<?php

require('/var/lib/asterisk/agi-bin/phpagi.php');

$agi = new AGI();

// Note: `conlog` doesn't seem to work when having hung up

// $agi->conlog(print_r($agi->request, true));
// $agi->conlog(print_r($_SERVER, true));
// $agi->conlog(print_r($_REQUEST, true));
// $agi->conlog(print_r($argv, true));
// $agi->conlog($agi->get_variable('CDR(duration)'));

print $agi->request['agi_arg_1'];
// print_r($_REQUEST);
// print_r($argv[1]);
// print $agi->get_variable('CDR(duration)');

?>