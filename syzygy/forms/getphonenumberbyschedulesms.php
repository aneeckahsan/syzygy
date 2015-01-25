<?php
include_once "../config.php";
$userid = $_POST['userid'];
$scheduleid = $_POST['scheduleid'];
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db("smsportal", $cn);

$qry ="select destno from smsportal.schedulesmsdetails where scheduleid = $scheduleid and destno is not null";
$rs = mysql_query($qry,$cn);

$value="";
if(mysql_affected_rows()>=1){
	while($row = mysql_fetch_array($rs))
	{
		//$results[] = $row['mobileno'];
		$value.=$row['destno']."&";
	}
	//echo $val =json_encode($results);
	echo $value;
}
else echo mysql_error();

?>
