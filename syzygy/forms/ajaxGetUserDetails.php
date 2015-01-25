<?php
include_once "../commonlib.php";

$userID = $_POST['userID'];
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db = mysql_select_db($MYDB, $cn);
$query = "select * from user where userid='".$userID."'";
$rs=mysql_query($query, $cn);

if(mysql_affected_rows()==1){
	$dt=mysql_fetch_array($rs);
	$result = array();
	foreach ($dt as $key=>$value)
		$result[$key] = $value;
	$result['password'] = decrypt($result['password']);
	// json_encode is available in PHP 5.2 and above, or you can install a PECL module in earlier versions
	echo json_encode($result);
}
else 
	echo 0;
?>

