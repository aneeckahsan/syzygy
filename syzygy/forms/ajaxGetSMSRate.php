<?php
include_once "../config.php";

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db = mysql_select_db($MYDB, $cn);
$query = "select * from rate";
$rs=mysql_query($query, $cn);
$returnString = "";
//echo mysql_affected_rows();
if(mysql_affected_rows()>0){
	while($dt=mysql_fetch_array($rs))
		$returnString .= $dt['operator'].",".$dt['prefix'].",".$dt['charge'].";";
}

echo $returnString;

?>