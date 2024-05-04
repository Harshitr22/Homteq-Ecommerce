<?php
session_start();
include("db.php"); //include db.php file to connect to DB
$pagename = "a smart home for a smart buy"; //create and populate variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
include("headfile.html");
include('detectlogin.php');

echo "<h4>" . $pagename . "</h4>";

$prodid = $_GET['u_pid'];

$SQL = "
SELECT prodId, prodName, prodPicNameLarge, prodDescripLong, prodPrice,prodQuantity  
FROM Product
WHERE prodId=" . $prodid;

$exeSQL = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
echo "<table style='border: 0px'>";

$arrayThisProd = mysqli_fetch_array($exeSQL);
echo "<tr>";
echo "<td style='border: 0px'>";
echo "<p class='updateInfo'><img src=images/" . $arrayThisProd['prodPicNameLarge'] . " height=400  width=450 ></p>";
echo "</td>";

echo "<td style='border: 0px'>";
echo "<h5>" . $arrayThisProd['prodName'] . "</h5>";
echo "<p class='updateInfo'><br><br>" . $arrayThisProd['prodDescripLong'] . "</p>";
echo "<p class='updateInfo'>&pound" . $arrayThisProd['prodPrice'] . "</p>";
echo "<p class='updateInfo'>Number left in stock: " . $arrayThisProd['prodQuantity'] . "</p>";

echo "<p class='updateInfo'>Number to be purchased: </p>";

echo "<form action='basket.php' method='post'>";
echo "<p class='updateInfo'><select name='p_nbitems'>";
for ($i = 1; $i <= $arrayThisProd['prodQuantity']; $i++) {
    echo "<option value=" . $i . ">" . $i . "</option>";
}
echo "</select>";

echo "<input type='submit' name='submitbtn' value='ADD TO BASKET' id='submitbtn'>";
echo "<input type='hidden' name='h_prodid' value=" . $prodid . ">";

echo "</form>";
echo "</p>";

echo "</td>";
echo "</tr>";
echo "</table>";



include("footfile.html");
echo "</body>";
?>