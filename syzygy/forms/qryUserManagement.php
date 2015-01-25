<?php


session_start();
$LoggedInUserID = $_SESSION["LoggedInUserID"];
$INSERT_QRY="insert into contactlist (ID, UserID, MobileNo, ContactGroup, FirstName, LastName, Email, LastUpdate) values('', '$LoggedInUserID', '$txtMobileNo', '$txtContactGroup', '$txtFirstName','$txtLastName', '$txtEmail', now())";

$UPDATE_QRY="update contactlist set MobileNo='$txtMobileNo', ContactGroup='$txtContactGroup', FirstName = '$txtFirstName', LastName = '$txtLastName', LastUpdate=now(), Email = '$txtEmail' where ID='$txtID'";

//echo $UPDATE_QRY;
$DELETE_QRY="delete from contactlist where ID='$ID'";

//echo $txtID;

$LOAD_QRY="select ID, FirstName, LastName, MobileNo, Email, ContactGroup from contactlist where ID='$txtID'";
?>