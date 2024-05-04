<?php
$pagename = "signup"; //Create and populate a variable called $pagename
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>"; //Call in stylesheet
echo "<title>" . $pagename . "</title>"; //display name of the page as window title
echo "<body>";
include("headfile.html"); //include header layout file
echo "<h4>" . $pagename . "</h4>"; //display name of the page on the web page
//display random text

echo "<form action=signup_process.php  method=post> ";

echo "<table id='baskettable'>";

echo "<tr>";
echo "<td>Enter your first name : </td>";
echo "<td><input type=text name=fname size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your last name : </td>";
echo "<td><input type=text name=lname size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your Email address : </td>";
echo "<td><input type=text name=mail size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your password : </td>";
echo "<td><input type=text name=pwd size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your Address : </td>";
echo "<td><input type=textbox name=addrs size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your post code : </td>";
echo "<td><input type=text name=pstcde size=20 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td>Enter your telephone number : </td>";
echo "<td><input type='number' pattern='[0-9]{10}' name=telnmb size=100 ></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input type=submit value=Signup id=submitbtn></td>";
echo "<td><input type=reset name=Clear form id=submitbtn></td>";
echo "</tr>";

echo "</table>";

echo "</form>";



echo "</body>";
?>