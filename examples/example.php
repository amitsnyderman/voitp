<?php

/*
// Error Reporting 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true); 

// Retrive DB Info 
//require_once("info.php");

// Database Connectivity
$dbhost = 'itp.nyu.edu';
$dbuser = 'au319';
$dbpass = 'qOgZAn-';
$dbname = 'lifestream';

// Local Connectivity
/*
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'redial';
*/

/*
// Connect to the DB
$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname);
*/


  
if (!empty($_REQUEST)) {
	
	$phone_number = $_REQUEST['phone_number'];
	
		// SELECT id
		// FROM experts
		// WHERE phone_number = $phone_number
	
	if (!$id) {
		
		// INSERT INTO experts (first_name, last_name, created_on)
		// VALUES ($first_name, $last_name, NOW())
		
		$id = mysql_insert_id();
	}
	
	// Delete specialties
	
	// DELETE FROM `experts_specialties` WHERE `expert_id` = $id;
	
	// Insert new specialties
	
	foreach ($_REQUEST['specialties'] as $specialty_id) {
		// INSERT INTO experts_specialties (expert_id, specialty_id)
		// VALUES ($id, $specialty_id)
	}
	
	// Delete availability
	
	// DELETE FROM `availability` WHERE `expert_id` = $id;
	
	// Insert new availability
	
	foreach ($_REQUEST['availability'] as $key => $day) {
		if (!$day['checked']) continue;
		
		if ($day['allday']) {
			$allday = true;
			$from = null;
			$through = null;
		} else {
			$allday = false;
			$from = $day['from'];
			$through = $day['through'];
		}
		
		// INSERT INTO availability (expert_id, day, from, through, allday)
		// VALUES ($id, $key, $from, $through, $allday)
	}
}

?>

<html>
	<head>
		<title>Register for ITP Tips</title>
	</head>
<body>

<!-- for testing only -->
<pre><?php print_r($_REQUEST); ?></pre>

<form action="" method="post">

<label>First Name: </label><input type="text" name="first_name" value="" /><br/>
<label>Last Name:  </label><input type="text" name="last_name" value="" /><br/>
<label>Phone Number: </label><input type="text" name="phone_number" value="" /><br/>
<h2>AREA OF EXPERTISE:</h2>
<input type="checkbox" name="specialties[]" value="1" /> Physical Computing<br/>
<input type="checkbox" name="specialties[]" value="2" /> Processing<br/>
<input type="checkbox" name="specialties[]" value="3" /> HTML/CSS<br/>
<input type="checkbox" name="specialties[]" value="4" /> Python<br/>
<input type="checkbox" name="specialties[]" value="5" /> Thesis<br/>
<p></p>
<h2>AVAILABILITY:</h2>
<p><em>Please check all that apply</em></p>

<input type="checkbox" name="availability[1][checked]" value="1" /> Mondays from
<select name="availability[1][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
</select> until
<select name="availability[1][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 
<br/>
<input type="checkbox" name="availability[2][checked]" value="1" /> Tuesdays from
<select name="availability[2][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
</select> until
<select name="availability[2][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
	</select>
or ALL DAY <input type="checkbox" name="availability[2][allday]" value="1" /> 
<br/>
<input type="checkbox" name="availability[3][checked]" value="1" /> Wednesdays from
<select name="availability[3][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
</select>
<select name="availability[3][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[4][checked]" value="1" /> Thursdays from
<select name="availability[4][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
	</select>
<select name="availability[4][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
	</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[5][checked]" value="1" /> Fridays from
<select name="availability[5][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
	</select>
<select name="availability[5][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
	</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[6][checked]" value="1" /> Saturdays from
<select name="availability[6][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
</select>
<select name="availability[6][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[7][checked]" value="1" /> Sundays from
<select name="availability[7][from]">
	<option value="10:00:00">10:00 AM</option>
	<option value="11:00:00">11:00 AM</option>
	<option value="12:00:00">12:00 PM</option>
	<option value="13:00:00">1:00 PM</option>
	<option value="14:00:00">2:00 PM</option>
	<option value="15:00:00">3:00 PM</option>
	<option value="16:00:00">4:00 PM</option>
	<option value="17:00:00">5:00 PM</option>
	<option value="18:00:00">6:00 PM</option>
	<option value="19:00:00">7:00 PM</option>
	<option value="20:00:00">8:00 PM</option>
	<option value="21:00:00">9:00 PM</option>
	<option value="22:00:00">10:00 PM</option>
	<option value="23:00:00">11:00 PM</option>
</select>
<select name="availability[7][through]">
	<option value="10:00:00">10:30 AM</option>
	<option value="11:00:00">11:30 AM</option>
	<option value="12:00:00">12:30 PM</option>
	<option value="13:00:00">1:30 PM</option>
	<option value="14:00:00">2:30 PM</option>
	<option value="15:00:00">3:30 PM</option>
	<option value="16:00:00">4:30 PM</option>
	<option value="17:00:00">5:30 PM</option>
	<option value="18:00:00">6:30 PM</option>
	<option value="19:00:00">7:30 PM</option>
	<option value="20:00:00">8:30 PM</option>
	<option value="21:00:00">9:30 PM</option>
	<option value="22:00:00">10:30 PM</option>
	<option value="23:00:00">11:30 PM</option>
</select>
or ALL DAY <input type="checkbox" name="availability[1][allday]" value="1" /> 

<br/>

<p><input type="submit" value="Go" /></p>
</form>

</body>
</html>
