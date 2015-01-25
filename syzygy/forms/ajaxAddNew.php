<?php
include_once "../config.php";

$tableName = 'account';
$tableColumns = 'accountName, balance, mask';
$values = $_POST['values'];

$true = 1;

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);
$INSERT_QRY="insert into ".$tableName." (".$tableColumns.") values (".$values.")";

$result = mysql_query($INSERT_QRY,$cn);
if(mysql_affected_rows()==1){
	$true = $true * 1;
}
else {
	$true=$true*0;
}
echo $true;

?>