<?php
include_once "../config.php";

$accountID = $_POST['accountID'];
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db = mysql_select_db($MYDB, $cn);
$query = "select * from account where accountID='".$accountID."'";
$rs=mysql_query($query, $cn);

if(mysql_affected_rows()==1){
	$dt=mysql_fetch_array($rs);
	echo $dt['balance'].";".$dt['mask'].";".$dt['status'];
}
else 
	echo 0;
?>