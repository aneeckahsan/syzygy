<?php
include_once "../commonlib.php";
$accountid = $_POST['accountID'];
$balance = $_POST['balance'];//echo $balance;
$query = "update account set balance = balance - ".$balance." where accountid = ".$accountid;
//echo $query;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

$result = mysql_query($query,$cn);
if(mysql_affected_rows()>=1)
	echo "1";
else
	echo mysql_error();
?>