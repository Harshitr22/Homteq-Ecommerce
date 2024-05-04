<?php
include("db.php");
$pagename = "signup completed!"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page
//display random text

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['mail'];
$pass = $_POST['pwd'];
$address = $_POST['addrs'];
$postcode = $_POST['pstcde'];
$telephone = $_POST['telnmb'];

$SQL = "INSERT INTO Users(userType, userFname, userSname, userAddress, userPostCode, userTelNo, userEmail , userPassword)
        VAlUES('Customer', '" . $fname . "', '" . $lname . "', '" . $address . "', '" . $postcode . "', '" . $telephone . "', '" . $email . "', '" . $pass . "') ";

$exeSQL = mysqli_query($conn, $SQL);


echo "<p class=updateInfo>Congratulations! " . $fname . "" . $lname . " </p>";
echo "<p class=updateInfo> Your Account has been created. </p>";
echo "<p class=updateInfo><a href= login.php>Login here</a></p>";

echo "</body>";
?>