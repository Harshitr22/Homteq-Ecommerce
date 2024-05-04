<?php
session_start();
include("db.php");
$pagename = "login results"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page
//display random text

$email = $_POST['useremail']; //variable of type string  it get s assignbed vakuye that is piseted that is piste that hrought the form and ithat points at the line. 
$pwd = $_POST['userpwd'];


if (empty($email) or empty($pwd)) {
    echo "<p class='UpdateInfo'> <b>Login Failed!</b></p>";
    echo "<p class='UpdateInfo'><br>Login Form Incomplete<br>Make sure you provide all the required details. </p>";
    echo "<p class='UpdateInfo'>Go back to <a href= login.php>Login </a></p>";
} else {

    //echo "<p>Entered email:" . $email . "</p>";

    $SQL = "
    SELECT userId, userType, userFname, userSname, userEmail, userPassword	
    FROM Users
    WHERE userEmail = '" . $email . "'";

    $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

    $arrayThisUser = mysqli_fetch_array($exeSQL);

    // 
    $nbOfRecs = mysqli_num_rows($exeSQL); // retrieves the number of records, it can only contain 1 or 0. 

    //echo "<p>Number of user found:" . $nbOfRecs . " </p>";

    if ($nbOfRecs == 0) {

        echo "<p class='UpdateInfo'> <b>Login Failed!</b></p>";
        echo "<p class='updateInfo'>Email not recogonised</p>";
        echo "<p class='updateInfo'>Go back to <a href= login.php>Login </a></p>";

    } else {
        //echo "<p>User found</p>";
        if ($arrayThisUser['userPassword'] != $pwd) {
            echo "<p class='UpdateInfo'> <b>Login Failed!</b> </p>";
            echo "<p class='UpdateInfo'>Password not valid</p>";
            echo "<p class='UpdateInfo'>Go back to <a href= login.php>Login </a></p>";

        } else {
            echo "<p class='updateInfo'><b>Login success</b></p>";
            $_SESSION['userId'] = $arrayThisUser['userId'];
            $_SESSION['userType'] = $arrayThisUser['userType'];
            $_SESSION['userFname'] = $arrayThisUser['userFname'];
            $_SESSION['userSname'] = $arrayThisUser['userSname'];
            $_SESSION['userEmail'] = $arrayThisUser['userEmail'];


            echo "<p class='updateInfo'><br>Welcome " . $arrayThisUser['userFname']." ".$arrayThisUser['userSname'] . "!</p>";
            echo "<p class='updateInfo'>User Type: homteq ".$arrayThisUser['userType']."</p>";
            echo "<p class='updateInfo'>Continue Shopping for <a href=index.php>Home Tech</a></p>";
            echo "<p class='updateInfo'>View your <a href=basket.php>Smart Basket</a></p>";
        }
    }
}

include("footfile.html"); //include head layout
echo "</body>";
?>