<?php

if (isset($_SESSION['userId'])) {

    echo "<p style='float: right'><i><b>" . $_SESSION['userFname'] . " " . $_SESSION['userSname'] . " | " . $_SESSION['userType'] . "</b></i></p>";
}

?>