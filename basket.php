<?php
session_start(); // it need to be right next to php session.
include("db.php"); //include db.php file to connect to DB
$pagename = "smart basket"; //create and populate variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>Smart basket</title>";

echo "<body>";
include("headfile.html");
include('detectlogin.php');

echo "<h4>" . $pagename . "</h4>";

//capture the ID of selected product using the POST method and the $_POST superglobal variable
//and store it in a new local variable called $newprodid

//check whether you arree deleting/removing an item from the basket 
if (isset($_POST['del_prodid'])) {
    $delprid = $_POST['del_prodid'];
    unset($_SESSION['basket'][$delprid]);
    echo "<p class='updateInfo'><b>1 items removed from the basket.</b></p>'";
}


// check whether you are adding a roduct to the basket 
if (isset($_POST['p_nbitems'])) {
    $prid = $_POST['h_prodid']; // capture the values posted through the hidden field called h _prodid and assign it to a new local variable called $prid
    $nbitems = $_POST['p_nbitems']; // capture the values the number of produicts user wanted to buy using the POST method and the $_POST superglobal variable.

    // echo "<p>Posted product Id: " . $prid . "</p>";   // testing whethr it throw the correct vakues that we werte expecting 
    // echo "<p>Posted Number of items: " . $nbitems . "</p>";

    $_SESSION['basket'][$prid] = $nbitems;  // creates a key vakues pair of session array to store nb items i the basket using product id 
    echo "<p class = 'updateInfo'>1 product added to the smart cart</p>"; /// testing if whether the product is added to the smart cart
} else {
    echo "<p class='updateInfo'> Basket Unchnaged </p>";
}

$total = 0;

if (isset($_SESSION['basket'])) {

    echo "<p><table id='baskettable'>";
    echo "<tr>";
    echo "<th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Remove</th>";
    echo "</tr>";

    foreach ($_SESSION['basket'] as $key => $value) {
        // echo "<p class='updateInfo'>In-cart product Id: " . $prid . "</p>";  //testing that proves that we have succesfully creaed the sessiona rray athat sstores the data as long as not refreshed 
        // echo "<p class='updateInfo'>In-cart Number of items: " . $nbitems . "</p>";

        $SQL = "
        SELECT prodId, prodName, prodPrice,prodQuantity  
        FROM Product
        WHERE prodId=" . $key;

        $exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
        $arrayCart = mysqli_fetch_array($exeSQL);

        echo "<tr>";
        echo "<td>" . $arrayCart['prodName'] . "</td>";
        echo "<td>&pound" . number_format($arrayCart['prodPrice'], 2) . "</td>";
        echo "<td>" . $value . "</td>";
        $subTotal = $value * $arrayCart['prodPrice'];
        echo "<td>&pound" . number_format($subTotal, 2) . "</td>";
        echo "<form action =basket.php  method =post>";
        echo "<td>";
        echo "<input type= 'submit' value = 'REMOVE' id='submitbtn'>";
        echo "<input type = 'hidden' name=del_prodid value = " . $key . ">";
        echo "</td>";
        echo "</form>";
        echo "</tr>";
        $total += $subTotal;
        $_SESSION['total'] = $total;

    }

    echo "<tr>";
    echo "<td colspan = 4 >TOTAL</td>";
    echo "<td>&pound" . number_format($total, 2) . "</td>";
    echo "</tr>";
    echo "</table>";
} else {
    echo "<p class='updateInfo'>Basket is empty.</p>";
}


if (isset($_SESSION['basket'])) {
    echo "<p class='updateInfo'><a href ='clearbasket.php'>CLEAR BASKET</a></p>";
    if (isset($_SESSION['userId'])) {
        echo "<p class='updateInfo'><a href=checkout.php>CHECKOUT</a></p>";
    } else {
        echo "<p class='updateInfo'>New homteq customers: <a href='signup.php'>Sign up</a></p>";
        echo "<p class='updateInfo'>Returning homteq customers: <a href='login.php'>Login</a></p>";
    }
}

include("footfile.html");
echo "</body>";
?>