<?php

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

<pre><?php print_r($_REQUEST); ?></pre>

<form action="" method="post">
	<input type="text" name="phone_number" value="" /><br/>
<input type="text" name="first_name" value="" /><br/>

<input type="checkbox" name="specialties[]" value="1" /> Processing<br/>
<input type="checkbox" name="specialties[]" value="2" /> Python<br/>

<input type="checkbox" name="availability[1][checked]" value="1" /> Monday
<select name="availability[1][from]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<select name="availability[1][through]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<input type="checkbox" name="availability[1][allday]" value="1" /> All day
<br/>
<input type="checkbox" name="availability[2][checked]" value="1" /> Tuesday
<select name="availability[2][from]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<select name="availability[2][through]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<input type="checkbox" name="availability[2][allday]" value="1" /> All day
<br/>
<input type="checkbox" name="availability[3][checked]" value="1" /> Wednesday
<select name="availability[3][from]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<select name="availability[3][through]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<br/>
<input type="checkbox" name="availability[4][checked]" value="1" /> Thursday
<select name="availability[4][from]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<select name="availability[4][through]">
	<option value="00:00:00">12am</option>
	<option value="01:00:00">1am</option>
</select>
<br/>


<p><input type="submit" value="Go" /></p>
</form>