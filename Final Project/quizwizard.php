#!/usr/local/bin/php -d display_errors=STDOUT
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

// Display the quizzes in alphabetical order
 $tablesquery = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name ASC;");
    $field1 = "qname";
    $field2 = "user";
    $field3 = "ts";
    $field4 = "questions";
    $field5 = "answers";

/* Select all tables from this database and print out the quiz name's, creation date, and creator name */
    while ($tble = $tablesquery->fetchArray(SQLITE3_ASSOC)) {
        $t = $tble['name'];
        $sql = "SELECT * FROM $t";
        $result = $db->query($sql);
       
        $record = $result->fetchArray();
         
        $dayfix = $record[$field3];
        $dayfix = date("m-d-y \o\\n g:ia", $dayfix);
        
        //Print table name
        print $t . "/";
        
        //Print the quiz name
        print $record[$field1] . "/";
        
        // Print creator name
        if ($record[$field2] == " ") {
            print "anonymous/";
        }
        else {
            print $record[$field2] . "/";
        }
        
        print $dayfix . "/,"; //Print the creation date

       }

?>