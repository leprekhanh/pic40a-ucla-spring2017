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


// define tablename and field names 
    $table = $_GET["qname"];
    $field1 = "qname";
    $field2 = "user";
    $field3 = "ts";
    $field4 = "questions";
    $field5 = "answers";
    
// select the quiz name
$sql = "SELECT $field1 FROM $table ORDER BY ROWID ASC LIMIT 1";
$result = $db->query($sql);

// print out the quiz name
while($record = $result->fetchArray())
{  
   print $record[$field1] . "|";
}

// select all the quiz questions
$sql = "SELECT * FROM $table  WHERE $field1='question'";
$result = $db->query($sql);

// print out all the quiz questions
while($record = $result->fetchArray())
{  
   print $record[$field4] . "|";
}
?> 
    