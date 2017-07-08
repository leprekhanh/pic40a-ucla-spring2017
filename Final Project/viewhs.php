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

$table = $_GET["hs"];
$field1 = "qname";
$table = substr($table, 0, -2);

$sql = "SELECT $field1 FROM $table ORDER BY ROWID ASC LIMIT 1";
$result = $db->query($sql);

while($record = $result->fetchArray())
{
    print $record[$field1]; //Print out the quiz's name
}   

print "~";

//Switch to the high score database
$database = "quizwizardhs.db";          

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
$table = $_GET["hs"];
$field1 = "user";
$field2 = "score";
$field3 = "ts";

$sql= "CREATE TABLE IF NOT EXISTS $table (
$field1 varchar(300),
$field2 int,
$field3 int
)";
$result = $db->query($sql);

// Select all the scores sorted by highest score, then oldest date taken
$sql = "SELECT * FROM $table ORDER BY $field2 DESC, $field3 ASC";
$result = $db->query($sql);

/* Print out the name of the person who took the quiz, their score, and the time they took it */
while($record = $result->fetchArray())
{   
    print $record[$field1];
    print "/";
    print $record[$field2];
    print "%/";
    
    $dayfix = $record[$field3];
    $dayfix = date("m-d-y \o\\n g:ia", $dayfix);
    print $dayfix;
    
    print "/";
    print ";";
 
}

?>