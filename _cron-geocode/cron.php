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
	
	// connect to database
	
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'lawyersdbtwo');

  $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }
	
	// grab desired list of entries
	
	
	$acfaddress = "SELECT post_id, meta_value FROM gmoney_postmeta WHERE conversion_completed='Not Completed' ORDER BY post_id ASC LIMIT 500";
	
	//$acfaddress = "SELECT post_id, meta_value FROM gmoney_postmeta LIMIT 5"; // debug php without running down the primary keys 
	
	
	$acfresult = $conn->query($acfaddress);
	
/*
	$address_id = array();
	$address_array = array();
	
	$address_id_error = array();
	$address_array_error = array();
*/ 	
	
	// loop through results
	
  while($addressrow = $acfresult->fetch_assoc()) {
	  
	 // if address has exactly three commas then its a candidate for a possible address conversion and can get added to _csv-input.csv 
	 
	 // street address, city, State, zipcode
	  
	 if (preg_match("/^([^,]*,){3}[^,]*$/", $addressrow["meta_value"])) {
			
			$address_id[] = $addressrow["post_id"]; 
			$address_array[] = $addressrow["meta_value"];
		
		}
		
		// if theres more or less than three commas, its most likely a faulty address and will break _csv-input.csv, so skip it, 		
		
		else {	
			
			$address_id_error[] = $addressrow["post_id"]; 
			$address_array_error[] = $addressrow["meta_value"];
			
			// send it to error log and manually look at the address at a later time
			
			$txt = '"' . $addressrow["post_id"] . '","Address Error: ' .$addressrow["meta_value"] . '"';
			$myfile = file_put_contents('/Applications/MAMP/htdocs/lawyer-directory--just-lawyers/_cron-geocode/_address_errors.log', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);			
		
		}

  }
  
  // update successful address candidate as 'Completed'
  
  $fromselect = join("','", array_map("intval", $address_id)); 
  print_r($fromselect);
									 
	$acfcompleted="UPDATE gmoney_postmeta SET conversion_completed='Completed' WHERE post_id IN ('".$fromselect."')";
	
	$conn->query($acfcompleted);
	
	// mark faulty addresses as 'Error'
	
	$fromselect_error = join("','", array_map("intval", $address_id_error)); 
  print_r($fromselect_error);
									 
	$acfcompleted_error="UPDATE gmoney_postmeta SET conversion_completed='Error' WHERE post_id IN ('".$fromselect_error."')";
	
	$conn->query($acfcompleted_error);

	// build array 

	$data = array_map(null, $address_id,$address_array);

	// create csv (required to do bulk addresses with U.S. Census Api

	$fh = fopen("/Applications/MAMP/htdocs/lawyer-directory--just-lawyers/_cron-geocode/_csv-input.csv","w");
	
	// add csv rows

	foreach($data as $fields) {
	
		//fputcsv($fh, $fields);
	
		fputs($fh, implode(',', $fields)."\n"); // removes quotes bc thats how u.s. census wants them

	}

	fclose($fh);

	// create a curl file attachment for POSTing
	
	$cfile = curl_file_create('/Applications/MAMP/htdocs/lawyer-directory--just-lawyers/_cron-geocode/_csv-input.csv');
	
	// set up query parameters 
	
	$post_options = array
	(
		'benchmark' => 'Public_AR_Current',
		'addressFile' => $cfile
	);
	
	// query u.s. census using cURL 
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://geocoding.geo.census.gov/geocoder/locations/addressbatch');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_options);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$result = curl_exec($ch);
	curl_close ($ch);
	
	// create and pump the results out to a output csv
	
	$outFile = fopen('/Applications/MAMP/htdocs/lawyer-directory--just-lawyers/_cron-geocode/_csv-output.csv', 'w');
	
	fwrite($outFile, $result);

	// create temp file to upload _csv-output.csv to (this will drop itself after each cron is completed)

	$sql = "CREATE TABLE IF NOT EXISTS gmoney_geocode (
		post_id BIGINT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		original_address LONGTEXT,
		us_match VARCHAR(100),
		us_match_type VARCHAR(100),
		updated_address LONGTEXT,
		lat_long VARCHAR(100),
		region LONGTEXT,
		side_of_road VARCHAR(50))";
		
	if ($conn->query($sql) === TRUE) {
    echo "Table Gmoney Geocode created successfully or currently exists <br/>";
	} else {
    echo "Error creating table: " . $conn->error . "<br/>";
	}
	
	// upload _csv-output.csv to mysql, very quickly with LOAD DATA INFILE

	$sqltwo = "LOAD DATA INFILE '/Applications/MAMP/htdocs/lawyer-directory--just-lawyers/_cron-geocode/_csv-output.csv' 
		INTO TABLE gmoney_geocode 
		FIELDS TERMINATED BY ',' 
		ENCLOSED BY '\"'
		LINES TERMINATED BY '\n'
		(post_id, original_address, us_match, @us_match_type, @updated_address, @lat_long, @region, @side_of_road)
		SET
			us_match_type = nullif(@us_match_type,''),
			updated_address = nullif(@updated_address,''),
			lat_long = nullif(@lat_long,''),
			region = nullif(@region,''),
			side_of_road = nullif(@side_of_road,'')
		";
		

	if ($conn->query($sqltwo) === TRUE) {
    	echo "Table Gmoney uploaded output file successfully <br/>";
	} else {
    	echo "Error uploading gmoney_gecode table with _csv-output.csv: " . $conn->error . "<br/>";
	}
	
	$conn->close(); 
	
?>

	
</body>
</html>


