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
    <link rel="stylesheet" type="text/css" href="calendar.css" />

</head>
<body>
<div class="container">
    
<?php 
	date_default_timezone_set('America/Los_Angeles'); 

    /* Format the timestamp to Hour.00am or pm */
    function get_hour_string($timestamp)
    {
        $date = date('g.00a', $timestamp);
        return $date;
    }
    
    echo "<h1>Golden Trio Schedule for " . date('D, M, j, Y, g:i a') . "</h1>";
    
	echo "<table id='event_table'>";
	echo "<tr><th class='hr_td'>&nbsp;</th>";
    echo "<th class='table_header'>Harry</th>";
    echo "<th class='table_header'>Ron</th>";
    echo "<th class='table_header'>Hermione</th></tr>";

    /* Adjusting this variable will adjust the total number of rows outputted */
    $hours_to_show = 12; 
    
    for ($starting = 0; $starting <= $hours_to_show; $starting++)
    {
        $adjust = $starting * 3600;
        $timestamp = time() + $adjust;
        $date = get_hour_string($timestamp);
        
        if ($starting%2 ==0)
        {
            echo "<tr class='even_row'>";
        }
        else
        {
            echo "<tr class='odd_row'>";
        }
        
        echo "<td class='hr_td'>" . $date . "</td> <td></td><td> </td><td> </td> </tr>";
        
    }
	
	echo "</table>";
?> 
    
    
</div>
</body>
</html>