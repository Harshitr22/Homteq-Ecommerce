<?php
session_start();
include("db.php");
mysqli_report(MYSQLI_REPORT_OFF);
$pagename = "checkout"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
include("detectlogin.php");
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page

//display random text

$currentdatetime = date("Y-m-d H:i:s", time());

$userID = $_SESSION['userId'];

$totala = $_SESSION['total'];

$sql = "INSERT INTO Orders (userId, orderDateTime, orderTotal, orderStatus)
        VALUES ('" . $userID . "', '" . $currentdatetime . "', '" . $totala . "', 'Placed' )
        ";

$exesql = mysqli_query($conn, $sql) or die(mysqli_error($conn));

if ($exesql) {
    echo "<p class='updateInfo'><b>Order Successfully Placed!</b></p>";

    $query = "SELECT orderNo FROM Orders WHERE userId =" . $userID . " ";
    $execution = mysqli_query($conn, $query);
    $catching = mysqli_fetch_array($execution);

    echo "<p class=updateInfo> Order No. <b>" . $catching['orderNo'] . "</b></p>";

    $total = 0;
    if (isset($_SESSION['basket'])) {

        echo "<p><table id='baskettable'>";
        echo "<tr>";
        echo "<th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>";
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
            echo "</tr>";
            $total += $subTotal;

            $query2 = " INSERT INTO Order_Line(orderNo, prodId, quantityOrdered, subTotal)
            VAlUES('" . $catching['orderNo'] . "', '" . $arrayCart['prodId'] . "', '" . $value . "', '" . $subTotal . "')
            ";

            $runninng = mysqli_query($conn, $query2);

            $remainQuan = $arrayCart['prodQuantity'] - $value;

            $updatesql = "UPDATE Product SET prodQuantity = '" . $remainQuan . "' WHERE prodId = " . $key;
            mysqli_query($conn, $updatesql);
        }

        echo "<tr>";
        echo "<td colspan = 3 >TOTAL</td>";
        echo "<td>&pound" . number_format($total, 2) . "</td>";
        echo "</tr>";
        echo "</table>";
    } else {
        echo "<p class='updateInfo'>Basket is empty.</p>";
    }



} else {
    echo "<p class='updateInfo'>Order Error</p>";
}

// INSERT INTO `table_name` (`column1`, `column2`, `column3`)
// VALUES ('value1', 'value2', 'value3');

echo "</body>";
?>