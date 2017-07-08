#!/usr/local/bin/php -d display_errors=STDOUT
<?php 
date_default_timezone_set('America/Los_Angeles'); 

//Connect to the database containing all the quizzes
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

    $field1 = "qname";
    $table = $_GET["qname"];

    //Get the quiz name
    $sql = "SELECT $field1 FROM $table ORDER BY ROWID ASC LIMIT 1";
    $result = $db->query($sql);

    while($record = $result->fetchArray())
    {
        print $record[$field1]; 
     }   
    print "~";

//Connect to the comment database
$database = "quizwizardcomment.db";          

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
    $checknewcomment = true;

    $table = $_GET["qname"];
    $table = "$table" . "co"; //All table comments end with co in the database
    $user = $_GET["user"];
    $comment = $_GET["comment"];
    $fixcomment = str_replace("'", "''", $comment); //Enter apostrophes correctly

    /*Check whether php needs to insert a new comment into the table or to load the comments*/
    if($user == "" && $comment == "")
    {
        $checknewcomment = false; //Indicate that the user doesn't have any comments to add
    }

    $ts = time(); //Time of when comment was posted

    $field1 = "name";
    $field2 = "message";
    $field3 = "ts";


    $sql= "CREATE TABLE IF NOT EXISTS $table (
    $field1 varchar(300),
    $field2 varchar(400),
    $field3 int
    )";
    $result = $db->query($sql);
    
    //Update the database with a new comment if checknewcomment is true
    if($checknewcomment)
    {
    $sql = "INSERT INTO $table ($field1, $field2, $field3) VALUES ('$user', '$fixcomment', $ts)";
    $result = $db->query($sql);
    }

    /* Order the data by newest timestamp first */
    $sql = "SELECT * FROM $table ORDER BY $field3 DESC";
    $result = $db->query($sql);

    /* Print out all the comments, commentors, and date */
    while($record = $result->fetchArray())
    {  
        print "Posted by $record[$field1]"; //Print out the poster's name
        print "/";
        print $record[$field2]; //Print out the comment
        print "/";
        $dayfix = $record[$field3]; 
        $dayfix = date("m-d-y \• g:ia", $dayfix); //Format the timestamp 
        print $dayfix; //Print out the date the comment was created
        print ";";

    }

?>