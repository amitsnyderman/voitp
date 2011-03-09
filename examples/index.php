<?php

// Error Reporting 
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', true); 

// Retrive DB Info 
require_once("info.php");

$days = array(null, 'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT');

// Connect to the DB
$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');
mysql_select_db($dbname, $connect);

// Get specialties grouped by topic

$specialty_query =<<<SQL
	SELECT s.id, s.name, t.name AS topic_name
	FROM specialties s
	LEFT JOIN topics t
	ON s.topic_id = t.id
	ORDER BY t.name,s.name
SQL;

$topics = array();
$result = mysql_query($specialty_query, $connect);
while ($row = mysql_fetch_assoc($result)) {
	if (!isset($topics[$row['topic_name']]))
		$topics[$row['topic_name']] = array();
	array_push($topics[$row['topic_name']], $row);
}

// Handle user input
  
if (!empty($_POST)) {
	
	$phone_number = $_POST['phone_number'];
	
	$get_phone = "SELECT id	FROM experts WHERE phone_number = '$phone_number'";
	
	$result = mysql_query($get_phone, $connect);
	
	$row = mysql_fetch_array($result);

	$id = $row['id'];
	
	if (!$id) {
	
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
				
		$get_id = "INSERT INTO experts (first_name, last_name, phone_number, created_on) VALUES ('$first_name', '$last_name', '$phone_number', NOW())";
		
		//echo $get_id;
						
		mysql_query($get_id, $connect);
		

		$id = mysql_insert_id();		
		
	}
	
	// Delete specialties
		
	$specialties = $_POST['specialties'];

	$remove_specialties = "DELETE FROM experts_specialties WHERE expert_id = $id";
	
	//echo $remove_specialties;
	
	mysql_query($remove_specialties, $connect);

	
	// Insert new specialties
	
	foreach ($_POST['specialties'] as $specialty_id) {
		
		$add_specialties = "INSERT INTO experts_specialties (expert_id, specialty_id) VALUES ($id, $specialty_id)";
		
		//echo $add_specialties;
		
		mysql_query($add_specialties, $connect);
	}
	
	// Delete availability
	
	$remove_availability = "DELETE FROM availability WHERE expert_id = $id";
	
	//echo $remove_availability;
	
	mysql_query($remove_availability, $connect);

	
	// Insert new availability
	
	foreach ($_POST['availability'] as $key => $day) {
		if (!$day || !$day['checked']) continue;
		
		if (!empty($day['allday'])) {
			$allday = true;
			$from = null;
			$through = null;
			
		} else {
			
			$allday = false;
			$from = $day['from'];
			$through = $day['through'];
		}
		
		$add_availability = "INSERT INTO availability (`expert_id`, `day`, `from`, `through`, `allday`) VALUES ($id, '$key', '$from', '$through', '$allday')";
		
		//echo $add_availability;
		
		mysql_query($add_availability, $connect);
	}
	
	header('location: http://itp.nyu.edu/~as860/que/thankyou.php');	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Register for que?</title>
	<link href="voitp.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>

<h1>Que?</h1>

<form action="" method="post">

<p>que? is an awesome Redial project that connects ITP experts on a variety of topics with students in need of some quick assistance.</p>
<p>Whenever the floor is open, just pick up the black phone located in the hallway heading towards the Shop and automatically get connected to someone who can help with questions related to Physical Computing, Processing, HTML/CSS, Python or Thesis.</p>
<p>Experts will have up to two minutes to answer questions and direct callers to other resources to help solve their problem. After two minutes, the call will automatically disconnect, so think quick!</p>
<p>Want to help your fellow students? To register as an expert, please fill out the below form indicating the phone number where you would like to be called as well as the days and time window when are available to receive calls. If you do not pick up the call, it will try another expert on the list.</p>
<p>To update or change your preferences, just fill out the form again using the same telephone number with which you first registered.</p>

<hr/>
			 
<label>First Name</label>
<input type="text" name="first_name" maxlength="255" size="8" value="" />

<label>Last Name</label>
<input type="text" name="last_name" maxlength="255" size="14" value="" /><br/>

<label>Phone Number <em>(e.g. 2125551212)</em></label>
<input type="text" name="phone_number" size="12" maxlength="10" value="" /><br/>

<h2>Area of Expertise</h2>
<div id="specialties">
<?php foreach ($topics as $key => $topic): ?>
	<h3><?= $key ?></h3>
	<div>
	<?php foreach ($topic as $row): ?>
		<label><input type="checkbox" name="specialties[]" value="<?= $row['id'] ?>" /> <?= $row['name'] ?></label>
	<?php endforeach; ?>
	</div>
<?php endforeach; ?>
</div>

<h2>Availability</h2>
<p><em>Please check all that apply</em></p>
<div id="availability">
<?php for ($day = 1; $day <= 7; $day++): ?>
	<span class="item">
	<label><input type="checkbox" name="availability[<?= $day ?>][checked]" value="1" /> <?= $days[$day] ?></label>
	from
	<select name="availability[<?= $day ?>][from]">
		<option value="00:00:00">12:00 AM</option>
		<option value="01:00:00">1:00 AM</option>
		<option value="02:00:00">2:00 AM</option>
		<option value="03:00:00">3:00 AM</option>
		<option value="04:00:00">4:00 AM</option>
		<option value="05:00:00">5:00 AM</option>
		<option value="06:00:00">6:00 AM</option>
		<option value="07:00:00">7:00 AM</option>
		<option value="08:00:00">8:00 AM</option>
		<option value="09:00:00">9:00 AM</option>
		<option value="10:00:00" selected="selected">10:00 AM</option>
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
	until
	<select name="availability[<?= $day ?>][through]">
		<option value="00:00:00">12:00 AM</option>
		<option value="01:00:00">1:00 AM</option>
		<option value="02:00:00">2:00 AM</option>
		<option value="03:00:00">3:00 AM</option>
		<option value="04:00:00">4:00 AM</option>
		<option value="05:00:00">5:00 AM</option>
		<option value="06:00:00">6:00 AM</option>
		<option value="07:00:00">7:00 AM</option>
		<option value="08:00:00">8:00 AM</option>
		<option value="09:00:00">9:00 AM</option>
		<option value="10:00:00">10:00 AM</option>
		<option value="11:00:00"selected="selected">11:00 AM</option>
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
	</span>
<?php endfor; ?>
</div>

<p><input type="submit" value="Sign Up" /></p>
</form>

</body>
</html>