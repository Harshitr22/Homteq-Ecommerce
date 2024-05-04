<?php
session_start();
include ("db.php"); //include db.php file to connect to DB

$pagename = "make your home smart"; //create and populate variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";

echo "<title>" . $pagename . "</title>";

echo "<body>";
include ("headfile.html");
include ('detectlogin.php');

echo "<h4>" . $pagename . "</h4>";

if (isset($_POST['del_orderid'])) {
    $del_orderid = $_POST['del_orderid'];
    $delorderSQL = "DELETE FROM Orders
WHERE orderNo = " . $del_orderid;
    //echo "<p>SQL delete query is ".$delorderSQL;
    $exedelorderSQL = mysqli_query($conn, $delorderSQL) or die(mysqli_error($conn));
}
if (isset($_POST['h_orderid'])) {
    $updt_orderid = $_POST['h_orderid'];
    $updtSQL = "UPDATE Orders
SET orderStatus='" . $_POST['ordstatus_drpdwn'] . "'
WHERE orderNo = " . $updt_orderid;
    $exeupdtSQL = mysqli_query($conn, $updtSQL) or die(mysqli_error($conn));
}
//four-way join SQL query
$SQL = "SELECT U.userId AS userId, U.userFName AS userFName, U.userSName AS userSName,
U.userAddress AS userAddress, U.userPostCode AS userPostCode, U.userTelNo AS userTelNo,
U.userEmail AS userEmail,
O.orderNo AS orderNo, O.orderDateTime AS orderDateTime, O.orderTotal AS orderTotal,
O.shippingDate AS shippingDate, O.orderStatus AS orderStatus,
OL.quantityOrdered AS quantityOrdered, OL.prodId AS prodId,
P.prodName AS prodName
FROM Users U
JOIN Orders O ON U.userId = O.userId
JOIN Order_Line OL ON O.orderNo = OL.orderNo
JOIN Product P ON P.prodId = OL.prodId
order by orderDateTime";
//Run Query
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

echo "<p class='updateInfo'><table>";
//Initialise last order no to zero
$lastorderno = 0;
//Create an array of records to fetch the results the SQL JOIN queries and iterate through it
while ($arrayo = mysqli_fetch_array($exeSQL)) {
    //if current order no does not match last order no, display header and 1st row with order details
    if ($arrayo['orderNo'] <> $lastorderno) {
        echo "<tr>";
        echo "<td colspan=8></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Order</th>";
        echo "<th>Order Date Time</th>";
        echo "<th>User Id</th>";
        echo "<th>Customer Name</th>";
        echo "<th>Customer Address</th>";
        echo "<th>Estimated Shipping Date </th>";
        echo "<th colspan=2>Process Order</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><b>No: " . $arrayo['orderNo'] . "</b></td>";
        echo "<td>" . $arrayo['orderDateTime'] . "</td>";
        echo "<td>" . $arrayo['userId'] . "</td>";
        echo "<td>" . $arrayo['userFName'] . " " . $arrayo['userSName'] . "</td>";
        echo "<td>" . $arrayo['userAddress'] . ", " . $arrayo['userPostCode'] . "</td>";
        //Calculate the shipping date by adding 2 days to the order date and time.
//Convert the order date and time to a nb of seconds since 01 Jan 1970 with strtotime
//Add 2 days then reconvert back to date. Only keep the date not the time buy using Y-m-d.
        $shippingdate = date('Y-m-d', strtotime($arrayo['orderDateTime'] . " +2day "));
        echo "<td>" . $shippingdate . "</td>";
        //echo "<td>".$arrayo['orderStatus']."</td>";
//orders to process orders
        echo "<form action=processorders.php method=post id=form1>";
        echo "<td>";
        //if order status is Placed
        if ($arrayo['orderStatus'] == 'Placed') {
            //create a drop-down with 2 options: Placed or Ready
            echo "<select name=ordstatus_drpdwn>";
            echo "<option value='Placed' selected>Placed</option>";
            echo "<option value='Ready'>Ready to Ship</option>";
            echo "</select>";
            echo "<input type=submit value='Update' id='submitbtn'>";
            echo "<input type=hidden name=h_orderid value=" . $arrayo['orderNo'] . ">";
        }
        //if order status is Ready
        if ($arrayo['orderStatus'] == 'Ready') {
            //create a drop-down with 2 options: Ready or Shipped
            echo "<select name=ordstatus_drpdwn>";
            echo "<option value='Ready' selected>Ready to Ship</option>";
            echo "<option value='Shipped'>Shipped</option>";
            echo "</select>";
            echo "<input type=submit value='Update' id='submitbtn'>";
            echo "<input type=hidden name=h_orderid value=" . $arrayo['orderNo'] . ">";
        }
        //if order status is shipped
        if ($arrayo['orderStatus'] == 'Shipped') {
            //Display the status as Shipped
            echo "<b>Order " . $arrayo['orderStatus'] . "</b>";
            $shipdtSQL = "UPDATE Orders
SET shippingDate='" . $shippingdate . "'
WHERE orderNo = " . $arrayo['orderNo'];
            $exeshipdtSQL = mysqli_query($conn, $shipdtSQL) or die(mysqli_error($conn));
        }
        echo "</td>";
        echo "</form>";
        //form to delete orders
        echo "<form action=processorders.php method=post id=form2>";
        //Delete button and hidden field
        echo "<td><input type=submit value='Delete' id='submitbtn'>";
        echo "<input type=hidden name=del_orderid value=" . $arrayo['orderNo'] . "></td>";
        echo "</form>";
        echo "</tr>";
    }
    //display product name and quantity ordered, as many times as required
    echo "<tr>";
    echo "<td colspan=5>" . $arrayo['prodName'] . "</td>";
    echo "<td>" . $arrayo['quantityOrdered'] . " items</td>";
    echo "</tr>";
    //grab the last order number
    $lastorderno = $arrayo['orderNo'];
}
echo "</table></p>";


$SQL = "SELECT U.userId AS userId, U.userFName AS userFName, U.userSName AS userSName,
U.userAddress AS userAddress, U.userPostCode AS userPostCode, U.userTelNo AS userTelNo,
U.userEmail AS userEmail,
O.orderNo AS orderNo, O.orderDateTime AS orderDateTime, O.orderTotal AS orderTotal,
O.shippingDate AS shippingDate, O.orderStatus AS orderStatus,
OL.quantityOrdered AS quantityOrdered, OL.prodId AS prodId,
P.prodName AS prodName
FROM Users U
JOIN Orders O ON U.userId = O.userId
JOIN Order_Line OL ON O.orderNo = OL.orderNo
JOIN Product P ON P.prodId = OL.prodId
order by orderDateTime";
//Run Query
$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
echo "<p class='updateInfo'><table>";
//Initialise last order no to zero
$lastorderno = 0;
echo "<h2 class='h2'>The Product List:</h2>";
//Create an array of records to fetch the results the SQL JOIN queries and iterate through it
while ($arrayo = mysqli_fetch_array($exeSQL)) {
    //if current order no does not match the last order no, display header and 1st row with order details
    if ($arrayo['orderNo'] <> $lastorderno) {
        echo "<tr>";
        echo "<td colspan=8></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Order</th>";
        echo "<th>Order Date Time</th>";
        echo "<th>User Id</th>";
        echo "<th>Customer Name</th>";
        echo "<th>Customer Address</th>";
        echo "<th>Estimated Shipping Date </th>";
        echo "<th colspan=2>Process Order</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td><b>No: " . $arrayo['orderNo'] . "</b></td>";
        echo "<td>" . $arrayo['orderDateTime'] . "</td>";
        echo "<td>" . $arrayo['userId'] . "</td>";
        echo "<td>" . $arrayo['userFName'] . " " . $arrayo['userSName'] . "</td>";
        echo "<td>" . $arrayo['userAddress'] . ", " . $arrayo['userPostCode'] . "</td>";
        //Calculate the shipping date by adding 2 days to the order date and time.
//Convert the order date and time to a nb of seconds since 01 Jan 1970 with strtotime
//Add 2 days then reconvert back to date. Only keep the date not the time buy using Y-m-d.
        $shippingdate = date('Y-m-d', strtotime($arrayo['orderDateTime'] . " +2day "));
        echo "<td>" . $shippingdate . "</td>";
        echo "<td>" . $arrayo['orderStatus'] . "</td>";
        echo "</tr>";
    }
    //display product name and quantity ordered, as many times as required
    echo "<tr>";
    echo "<td colspan=5>" . $arrayo['prodName'] . "</td>";
    echo "<td>" . $arrayo['quantityOrdered'] . " items</td>";
    echo "</tr>";
    //grab the last order number
    $lastorderno = $arrayo['orderNo'];
}
echo "</table></p>";

include ("footfile.html");
echo "</body>";
?>