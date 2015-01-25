<?php
include_once "../commonlib.php";

$roleid = $_POST['roleid'];
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db = mysql_select_db($MYDB, $cn);
$query = "select privilegeids from role where roleid='".$roleid."'";

$rs=mysql_query($query, $cn);
if(mysql_affected_rows()==1){
	$dt=mysql_fetch_array($rs);
	$privilegeids = explode(",", $dt[0]);
	for($j = 0; $j < sizeof($privilegeids); $j++){
		$query1 = "select * from privilege where id='".trim($privilegeids[$j])."'";
		$rs=mysql_query($query1, $cn);
		if(mysql_affected_rows()==1){
			$dt1=mysql_fetch_array($rs);
			echo("<option value='".$dt1['id']."'>".$dt1['privilege']."</option>");
		}
	}
}
else
	echo 0;
?>