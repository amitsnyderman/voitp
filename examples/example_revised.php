<?php


// Error Reporting 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true); 

// Retrive DB Info 
require_once("info.php");


// Connect to the DB
$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname, $connect);

  
if (!empty($_REQUEST)) {
	
	$phone_number = $_REQUEST['phone_number'];
	
	$get_phone = "SELECT id	FROM experts WHERE phone_number = '$phone_number'";
	
	$result = mysql_query($get_phone, $connect);
	
	$row = mysql_fetch_array($result);

	$id = $row['id'];
	
	if (!$id) {
	
		$first_name = $_REQUEST['first_name'];
		$last_name = $_REQUEST['last_name'];
				
		$get_id = "INSERT INTO experts (first_name, last_name, phone_number, created_on) VALUES ('$first_name', '$last_name', '$phone_number', NOW())";
		
		//echo $get_id;
						
		mysql_query($get_id, $connect);
		

		$id = mysql_insert_id();		
		
	}
	
	// Delete specialties
		
		$specialties = $_REQUEST['specialties'];

		$remove_specialties = "DELETE FROM experts_specialties WHERE expert_id = $id";
		
		echo $remove_specialties;
		
		mysql_query($remove_specialties, $connect);

	
	// Insert new specialties
	
	foreach ($_REQUEST['specialties'] as $specialty_id) {
		
		$add_specialties = "INSERT INTO experts_specialties (expert_id, specialty_id)
		VALUES ($id, $specialty_id)";
		
		//echo $add_specialties;
		
		mysql_query($add_specialties, $connect);

	}
	
	// Delete availability
	
		$remove_availability = "DELETE FROM availability WHERE expert_id = $id";
		
		//echo $remove_availability;
		
		mysql_query($remove_availability, $connect);

	
	// Insert new availability
	
	foreach ($_REQUEST['availability'] as $key => $day) {
		if (!$day && !$day['checked']) continue;
		
		if (isset($day['allday'])) {
			$allday = true;
			$from = null;
			$through = null;
			
		} else {
			
			$allday = false;
			$from = $day['from'];
			$through = $day['through'];
		}
		
		$add_availability = "INSERT INTO availability (expert_id, day, from, through, allday) VALUES ($id, '$key', '$from', '$through', '$allday')";
		
		//echo $add_availability;
		
		mysql_query($add_availability, $connect);

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

<form action="http://www.itp.nyu.edu/~au319/redial/thankyou.php" method="post">
	<p>ITP Tips is a Redial project that connects ITP experts on a variety of topics with students in need of some quick assistance.</p> 
	<p>Once you register as an expert in one of the fields below, you will be added to a list of potential experts who may be called upon by students seeking quick counsel.</p>
	<p>If you receive a call, you will have up to two minutes to answer questions and direct the caller to other resources that may help address their problem. After two minutes, the call will automatically disconnect.</p>
	<p>Using the below form, please indicate the phone number where you would like to be called as well as the dates and time window when are available to receive calls.</p>
			 
<label>First Name: </label><input type="text" name="first_name" maxlength="255" size="8" value="" /><br/>

<label>Last Name:  </label><input type="text" name="last_name" maxlength="255" size="14" value="" /><br/>

<label>Phone Number: <em>(e.g. 2125551212)</em></label><input type="text" name="phone_number" size="12" maxlength="10" value="" /><br/>

<h2>AREA OF EXPERTISE:</h2>
<input type="checkbox" name="specialties[]" value="1" /> Physical Computing<br/>
<input type="checkbox" name="specialties[]" value="2" /> Processing<br/>
<input type="checkbox" name="specialties[]" value="3" /> HTML/CSS<br/>
<input type="checkbox" name="specialties[]" value="4" /> Python<br/>
<input type="checkbox" name="specialties[]" value="5" /> Thesis<br/>

<p></p>

<h2>AVAILABILITY:</h2>
<p><em>Please check all that apply</em></p>

<input type="checkbox" name="availability[2][checked]" value="1" /> MON from
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
<input type="checkbox" name="availability[3][checked]" value="1" /> TUE from
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
</select> until
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
or ALL DAY <input type="checkbox" name="availability[3][allday]" value="1" /> 
<br/>
<input type="checkbox" name="availability[4][checked]" value="1" /> WED from
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
</select> until
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
or ALL DAY <input type="checkbox" name="availability[4][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[5][checked]" value="1" /> THU from
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
	</select> until
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
or ALL DAY <input type="checkbox" name="availability[5][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[6][checked]" value="1" /> FRI from
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
	</select> until
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
or ALL DAY <input type="checkbox" name="availability[6][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[7][checked]" value="1" /> SAT from
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
</select> until
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
or ALL DAY <input type="checkbox" name="availability[7][allday]" value="1" /> 

<br/>
<input type="checkbox" name="availability[1][checked]" value="1" /> SUN from
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

<p><input type="submit"  value="Go" /></p>
</form>

</body>
</html>