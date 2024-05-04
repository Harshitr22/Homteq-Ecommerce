<?php
$dbhost = '';   //Add the hosting refrence here 
$dbuser = '';   //add name of db user 
$dbpass = '';   // add the pasword to your db
$dbname = '';   //add the nameo of the database 
//create a DB connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//if the DB connection fails, display an error message and exit
if (!$conn)
{
 die('Could not connect: ' . mysqli_error($conn));
}
//select the database
mysqli_select_db($conn, $dbname);
?>