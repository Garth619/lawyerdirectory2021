<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title></title>
	<meta http-equiv="content-type"
    	content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<link rel="icon" href="data:;base64,iVBORw0KGgo=">
</head>
<body>

<?php
	
	
	// create a table and put all of the address post meta in there to send to U.S. Census API. I also need to allow for a new coulum that checks off completed posts. This will be my reference so the cron job can pick up where it left off. Also I dont want to disrupt the columns in wp_postmeta. Plus I don't want to make wp_postmeta more bloated than it already is. Run these commands below ONE TIME ONLY. Everything else gets hadled from cron.php repeatedly.
	
	// connect to database
	
  



/*
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'lawyersdbtwo');

  $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }
		
	// create table
	
	$sql_gmoney_postmeta = "CREATE TABLE IF NOT EXISTS gmoney_postmeta (
		post_id BIGINT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		meta_value LONGTEXT NULL,
		conversion_completed VARCHAR(100) DEFAULT 'Not Completed' NOT NULL)";
		
		$conn->query($sql_gmoney_postmeta);
		
		if ($conn->query($sql_gmoney_postmeta) === TRUE) {
    	echo "Table gmoney_postmeta created successfully <br/>";
		} else {
    	echo "Error creating geocode table: " . $conn->error ."<br/>";
		}
	
	
	// copy just what I need from wp_postmeta over to my new table
	
	
	
	$sql_copy_wp_postmeta = "INSERT INTO gmoney_postmeta(post_id,meta_value)
		SELECT 
	 		post_id,
	 		meta_value
   FROM 
    wp_postmeta
   WHERE
  	meta_key='lawyer_address'";

   if ($conn->query($sql_copy_wp_postmeta) === TRUE) {
    	echo "wp_postmeta columns copied to table gmoney_postmeta successfully <br/>";
		} else {
    	echo "Error creating geocode table: " . $conn->error ."<br/>";
		}

	
	$conn->close(); 





?>
	
	
</body>
</html>


