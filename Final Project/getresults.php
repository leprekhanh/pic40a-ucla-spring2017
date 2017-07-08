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
<title>Quiz Results</title>
    <link rel="stylesheet" type="text/css" href="quizwizard.css" />

</head>
<body>
    <div class="container">
        
    <?php 
    
	date_default_timezone_set('America/Los_Angeles'); 

    $database = "quizwizard.db";          

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

    // define tablename and field names for a SQLite3 query to create a table in a database
        $table = $_GET["qname"]; //Get the qname from query string
        $field1 = "qname";
        $field2 = "user";
        $field3 = "ts";
        $field4 = "questions";
        $field5 = "answers";
    
    // Create $array_key to hold all the correct answers and $array_input to hold all the user's inputs
        $array_key = array(); 
        $array_input = array(); 

    $sql = "SELECT $field5 FROM $table WHERE $field1 = 'question'";
    $result = $db->query($sql);
    
    $try = 1;
    $correct = 0;
    
    while($record = $result->fetchArray())
    {
        //Convert everything to lowercase to make comparison more fair
        $input = strtolower($_GET[$try]);
        $key = strtolower($record[$field5]);
        
        //Add the respective values to the two arrays
        array_push($array_input, $input);
        array_push($array_key, $key);

        $try++;
    }
            
        $total = sizeOf($array_key);
        
        /* Count the total number of questions they got right */
        for ($i = 0; $i < sizeOf($array_key); $i++)
        {

            if($array_key[$i] == $array_input[$i])
            {
                $correct++;
            }
        }
    
        //Calculate the final score
        $score = round(100 * ($correct/$total), 2);
    
    //Connect to the high score database
    $database2 = "quizwizardhs.db"; 
    
     try  
     {     
        $db = new SQLite3($database2);
     }
        catch (Exception $exception)
        {
        echo '<p>There was an error connecting to the database!</p>';

            if ($db)
            {
                echo $exception->getMessage();
            }
        }
    
    $user = $_GET["user"]; //Get the name of the person who took the quiz
    $user = str_replace("'", "''", $user);


    if ($user == "")
    {
        $user = "Anonymous";
    }
    
    $tablehs = $table . "hs"; //All high score tables end in hs
    $field1 = "user";
    $field2 = "score";
    $field3 = "ts";
    
    $sql= "CREATE TABLE IF NOT EXISTS $tablehs (
    $field1 varchar(100),
    $field2 int,
    $field3 varchar(300)
    )";
    $result = $db->query($sql);
        
    $ts = time(); //Get the timestamp of when they took the quiz
   
    //Keep a table of all the scores
    $sql = "INSERT INTO $tablehs ($field1,$field2,$field3) VALUES ('$user', $score, $ts)";
    $result = $db->query($sql);
    
     print "Your results: $score%! Click here to <a href='http://pic.ucla.edu/~leprekhanh/final_project/viewhs.html?hs=$tablehs'>view</a> the high score chart!";  
?> 
    </div></body></html>