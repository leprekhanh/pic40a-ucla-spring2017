#!/usr/local/bin/php -d display_errors=STDOUT
<?php 
	print '<?xml version = "1.0" encoding="utf-8"?>'; 
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
<title>Calendar</title>
    <link rel="stylesheet" type="text/css" href="calendar2.css" />

</head>
<body>
<div class="container">
    
<?php 
	date_default_timezone_set('America/Los_Angeles'); 
    
    //Print out the hour in H:00 am/pm format
    function get_hour_string($timestamp)
    {
        $date = date('g.00a', $timestamp);
        return $date;
    }
    
    //Get timestamp for the current time without the minutes and seconds
    function get_ts($timestamp)
    {
        $day = date('m-d-Y',$timestamp);
        $hr = date('G', $timestamp);
        
        $d_array = explode("-",$day);
        $hr_array = explode(".",$hr);
        
        $tss = mktime ($hr_array[0],0,0,$d_array[0],$d_array[1],$d_array[2]); 
        return $tss;
    }
    
    //Obtain info from database and return a string of events for a person in a specific timestamp
    function get_events($person, $ts){
            
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
        
        $table = "event_table";
        $field1 = "time";
        $field2 = "person";
        $field3 = "event_title";
        $field4 = "event_message";

        $sql = "SELECT * FROM $table";
        $result = $db->query($sql);
        
        $count_events = 0;
        $all_events = "";
    
            while($record = $result->fetchArray())
            {  
                if ($record[$field2] == $person && $record[$field1] == $ts)
                {
                    $count_events++; //Record how many events are there
                    
                    if ($count_events == 1)
                    {
                       $all_events = "$record[$field3]: $record[$field4]";
                    }
                    else //Create a string of multiple events if there are multiple ones on the same slot
                    {
                       $all_events = "$all_events <br /> $record[$field3]: $record[$field4]";
                    }
            
                }

            }
        
        return $all_events; //Return a string of all events

        }
    
     
     $prev_or_next = false; 
     $url_timestamp = $_GET["time_stamp"]; //Get the query string for time_stamp
     $adjust_twelve = 3600 * 12;
    
        /*Adjust the $next and $prev variables to the according timestamps*/
        if ($url_timestamp > 0) //If the query string for time_stamp isn't empty, the user pressed next or previous
        {
        $prev_or_next = true;
        echo "<h1>The Golden Trio Schedule for " . date('D, M, j, Y, g:i a', $url_timestamp) . "</h1>";
        $next = $url_timestamp + $adjust_twelve;
        $prev = $url_timestamp - $adjust_twelve; 
        }
        else //The user is on the today page
        {
        echo "<h1>The Golden Trio Schedule for " . date('D, M, j, Y, g:i a') . "</h1>";
        $next = time() + $adjust_twelve;
        $prev = time() - $adjust_twelve;
        }
    
	echo "<table id='event_table'>";
	echo "<tr><th class='hr_td'>&nbsp;</th>";
    echo "<th class='table_header'>Harry</th>";
    echo "<th class='table_header'>Ron</th>";
    echo "<th class='table_header'>Hermione</th></tr>";

    $hours_to_show = 12; 
    
    for ($starting = 0; $starting <= $hours_to_show; $starting++)
    {
     
        $adjust = $starting * 3600;
        
        if ($prev_or_next)
        {
        $timestamp = $url_timestamp + $adjust;        
        }
        else
        {
        $timestamp = time() + $adjust;
        }

        $date = get_hour_string($timestamp);
        $tss = get_ts($timestamp);

        //Print the correct color depending on even or odd row
        if ($starting%2 ==0)
        {
            echo "<tr class='even_row'>";
        }
        else
        {
            echo "<tr class='odd_row'>";
        }
        
        echo "<td class='hr_td'>" . $date . "</td>";
        
        //Check events for each person
        $person = "Harry";
        echo "<td class='ctr'>";
        echo get_events($person, $tss);
        echo "</td>";
    
        $person = "Ron";
        echo "<td class='ctr'>";
        echo get_events($person, $tss);
        echo "</td>";
        
        $person = "Hermione";
        echo "<td class='ctr'>";
        echo get_events($person, $tss);
        echo "</td></tr>";
        
    }
   
    echo "</table>";
    echo "<div>";
	echo "<form id='prev' method='get' action='calendar2.php'>";
    echo "<p><input type='hidden' name='time_stamp' value='$prev' />";
    echo "<input type='submit' value='Previous twelve hours'/></p>";
    echo "</form>";
    
    echo "<form id='today' method='get' action='calendar2.php'>";
    echo "<p><input type='submit' value='Today'/></p>";
    echo "</form>";
    
    echo "<form id='next' method='get' action='calendar2.php'>";
    echo "<p><input type='hidden' name='time_stamp' value='$next' />";
    echo "<input type='submit' value='Next twelve hours'/></p>";
    echo "</form>";
    echo "</div>";
    
?> 

</div>
    <p>
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>
</body>
</html>