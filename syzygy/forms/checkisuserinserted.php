<?php
include_once "../config.php";
$email = $_POST['email'];
$userid = $_POST['user'];

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db("smsportal", $cn);
if($userid == 0){
$qr = "select userid from user where email = '$email'";
}
else{
$qr = "select userid from user where email = '$email' and userid != $userid";

}

$result = mysql_query($qr,$cn);
$value="";
if(mysql_affected_rows()>=1){
	echo '1';
}
else echo '0';
//else echo mysql_error();

?>
