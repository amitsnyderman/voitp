#!/usr/bin/php -q
<?php

require('/var/lib/asterisk/agi-bin/phpagi.php');

$agi = new AGI();

ob_start();
print_r($agi->request);
$agi->conlog(ob_get_contents());
ob_end_clean();

?>