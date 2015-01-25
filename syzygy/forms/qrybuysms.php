<?php

$SMSBalance = $txtSMSBalance + $txtBuySMS;
$UPDATE_QRY="update smsgw_2_0.user set SMSBalance=$SMSBalance where CreatedBy = 'SMSPORTAL' AND UserID='$txtUserID'";
//echo $UPDATE_QRY;
//echo $UPDATE_QRY;
//$DELETE_QRY="delete from contactlist where ID='$ID'";

//echo $txtID;

$LOAD_QRY="SELECT UserID,UserName,MobileNo,SMSBalance FROM smsgw_2_0.user WHERE CreatedBy = 'SMSPORTAL' AND UserID = '$UserID'";
?>