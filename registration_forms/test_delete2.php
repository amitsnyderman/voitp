<?php
//this is another controller

# Get our DB info
require "info.php";

#########################################################
# Connect to the database.
#########################################################
$connection = mysql_connect($mySqlHostname, $mySqlUsername, $mySqlPassword);
if (!$connection)
  die("Error " . mysql_errno() . " : " . mysql_error());

# Select the DB
$db_selected = mysql_select_db($mySqlDatabase, $connection);
if (!$db_selected)
  die("Error " . mysql_errno() . " : " . mysql_error());


//GET THE ID OF THE POST TO EDIT
$id = $_REQUEST['id'];

//IF THE USER SUBMITTED A POST, PROCESS IT BEFORE SHOWING ANYTHING
//make sure the data is sanitized before putting it in the database
$author = sanitizeData($_REQUEST['author']);
$title = sanitizeData($_REQUEST['title']);
$body = sanitizeData($_REQUEST['body']);



//check to make sure the user submitted data for the post
if (!empty($author) || !empty($title) || !empty($body)) {
	//update the post in the database
	
	function updatePost($id, $author, $title, $body) {

	//store SQL query in a variable called myQuery
	$myQuery = "update bsheldon_messages set author='{$author}' title='{$title}', message='{$body}' where id={$id} 	";

	//perform the query
	$result = mysql_query($myQuery);

	//return the result of the query
	return $result;
}

	updatePost($id, $title, $body);
  
	//redirect to the main page
	header("Location: index.php");
	exit(); //quit script;
}
elseif (is_numeric($id)) {
  //load the post this user wants to edit
  
  function readPost($id) {
	//SELECT ALL POSTS WITH THE SPECIFIED ID
	$myQuery = "select * from bsheldon_messages where id={$id}";

	//run the query
	$result = mysql_query($myQuery);

	if ($result) {
		//loop through the results returned from the database here
		while($row = mysql_fetch_array($result)) {
      //we expect to get only one result, so put it in a variable called post
      $post = $row;
		}
	} //end if results
	
	//return the array of posts
	return $post;
}

  $post = readPost($id);
}



include("update_post.php");

<?php
#########################################################
# Disconnect from the database.
#########################################################
# Always the last thing you do before exiting your script
mysql_close($connection);



?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>Message Board</title>
		<link rel="stylesheet" type="text/css" href="styles/newpost.css"/>
	</head>
	<body>
    <div id="container">

      <h1>Edit Post</h1>
       
	  <form action="update.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $post['id'] ?>" />
        
        <p><label for="name">Name</label>
		<input type="text" id="author" name="author" />
		</p>

      	
      	<label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= $post['title'] ?>" />        
      	<br/>
      	<br/>
      	
   		<label for="body">Body:</label>
      	<br/>
      	<br/>
        <textarea id="body" name="body" cols=77 rows=21><?= $post['body'] ?></textarea>
      	<br/>
      	<input type="submit" value="Submit!" />
      </form>
	  </p>

    </div><!-- end container -->
	</body>
</html>