#!/usr/local/bin/php -d display_errors=STDOUT
<?php
  // begin this XHTML page
  print('<?xml version="1.0" encoding="utf-8"?>');
  print("\n");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<title>Updating the Calendar Database</title> 
</head>
<body>
<p>
<?php 
	date_default_timezone_set('America/Los_Angeles'); 

    $database = "dbleprekhanh.db";          

    try  
    {     
         $db = new SQLite3($database);
    }
    catch (Exception $exception)
    {
        echo '<p>There was an error connecting to the database!</p>';

        if ($db)
        {
            echo $exception->getMessage();
        }

    }

    // define tablename and field names for a SQLite3 query 
    $table = "event_table";
    $field1 = "time";
    $field2 = "person";
    $field3 = "event_title";
    $field4 = "event_message";


    // Create the table if it doesn't exist
    $sql= "CREATE TABLE IF NOT EXISTS $table (
    $field1 int(12),
    $field2 varchar(100),
    $field3 varchar(300),
    $field4 varchar(300)
    )";
    $result = $db->query($sql);
    

    $date = $_POST["date"]; //obtain the date in format of MM-DD-YYYY
    $date_array = explode("-",$date); 

    $hour = $_POST["time"]; //obtain the time in format of H:mm
    $hour_array = explode(":",$hour);
    
    //create the corresponding timestamp using the date and hour inputs excluding the minute input
    $time  = mktime($hour_array[0],0,0,$date_array[0],$date_array[1],$date_array[2]);    

    $person = $_POST["person"]; //obtain person's name
    $title  = $_POST["event_title"]; //obtain event's title
    $msg = $_POST["event_message"]; //obtain event's message

    //Insert the event into database
    $sql = "INSERT INTO $table ($field1,$field2,$field3,$field4) VALUES ($time,'$person','$title','$msg')";
    $result = $db->query($sql);

    //Check to see if the call to query was successful
    if ($result) 
    {
        echo "Database successfully updated";
    }
    else
    {
        echo "Database was not able to update - check the format of your inputs!";
    }

    echo '<br /><a href="http://pic.ucla.edu/~leprekhanh/calendar2.php"> Click here to see the calendar </a>';

?>
    </p>
    <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
</body>
</html>