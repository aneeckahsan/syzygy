<?php
include_once "../commonlib.php";

$accountID = $_POST['accountID'];
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db = mysql_select_db($MYDB, $cn);
$query = "select * from role where accountID='".$accountID."'";
buildDropDownFromMySQLQuery($cn, $query, 'roleid', 'rolename');
?>