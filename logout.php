<?php
session_start();
$pagename = "logout"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
include("detectlogin.php");
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page
//display random text

echo "<p class='updateInfo'> Thank you, " . $_SESSION['userFname'] . " " . $_SESSION['userSname'] . " </p>";

$_SESSION['userId'] = 0;
// unsetting session
session_unset();

//destroying session 
session_destroy();
session_abort();

echo "<p class='updateInfo'> You have been logged out.</p>";


echo "</body>";
?>