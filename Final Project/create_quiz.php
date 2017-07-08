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

    $checkname = true;
    $qtotal = $_GET["totalq"];
    $qname = $_GET["qname"];
        
    $symbols = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=", ";", ":", ".", "<", ">", ",", "?", "/", "'", " ", "[", "]", "{", "}");
    $table = str_replace($symbols, "", $qname); /*Remove all the symbols from the quizname*/
    $table = strtolower($table);
        
    if ($table == "")
    {
        print "Please try again - you didn't include a name for the quiz!";
        $checkname = false;
    }
    
    /* Check if the same name has already been used */
    $tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
     while ($tble = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
        $t = $tble['name'];
       if  ($t == $table)
       {
           print "Please try again - there is already a quiz created with this name!";
           $checkname = false;
           break;
       }
    
    }
    
    /* Add values into the table if the inputs are okay */
    if ($checkname) {
        $field1 = "qname";
        $field2 = "user";
        $field3 = "ts";
        $field4 = "questions";
        $field5 = "answers";

        $sql= "CREATE TABLE IF NOT EXISTS $table (
        $field1 varchar(400),
        $field2 varchar(100),
        $field3 int,
        $field4 varchar(300),
        $field5 varchar(300)
        )";
        $result = $db->query($sql);

    
        $timecreated = time(); //ts of when the quiz was created
        $usern = $_GET['fname'] ." ". $_GET['lname']; //Combine first and last name together

        //Fix the apostrophes
        $fixqname = str_replace("'", "''", $qname);
        
        $sql = "INSERT INTO $table ($field1, $field2, $field3) VALUES ('$fixqname', '$usern', $timecreated)";
        $result = $db->query($sql);
    
            //Loop through all the questions to get the inputs
            for($i = 1; $i <= $qtotal; $i++)
            {
                //This gives the value to use in the $_GET function
                $currentq = "question$i";
                $currenta = "answer$i";

                $qcurrent = $_GET["$currentq"]; //get question1, question2, etc.
                
                /* Fix apostrophes and | because | is used to split the questions when trying to display them in
                takequiz.html and takequiz.php*/
                $fixq = str_replace("'", "''", $qcurrent); 
                $fixq = str_replace("|", "", $fixq);

                $acurrent = $_GET["$currenta"]; //get answer to question1, question2, etc.                
                $acurrent = str_replace("'", "''", $acurrent); //fix apostrophes

                $sql = "INSERT INTO $table ($field1,$field4,$field5) VALUES ('question','$fixq', '$acurrent')";
                $result = $db->query($sql);

            }
        
        print "Yay! Your quiz was successfully created! <br />";   
    
    }
?>  
    <p><a href='http://pic.ucla.edu/~leprekhanh/final_project/quizwizard.html'>
        <button>Go back to the forum</button></a>
    <a href='http://pic.ucla.edu/~leprekhanh/final_project/create_quiz.html'>
        <button>Create a new quiz</button></a></p>
       
        
    </div>
</body>
</html>