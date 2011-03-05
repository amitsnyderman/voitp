<?php

include_once(); // path to passwords

$connect=mysql_connect("db_host","db_user","db_password");
mysql_select_db("db_name",$connect) or die (mysql_errno().":<b> ".mysql_error()."</b>");

$insert_query = 'insert into 	experts (
					first name,
					last name,
					email,
					phone_number_1,
					phone_number_2,
					phone_number_3,
										) 
					values
					(
					"' . $_POST['name'] . '", 
					"' . $_POST['email'] . '",
					"' . $_POST['phone_number'] . '",
					"' . $_POST['expertise'] . '",
					"' . $_POST['availability'] . '",
					)';

mysql_query($insert_query);

?>