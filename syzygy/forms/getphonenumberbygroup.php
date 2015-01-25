<?php
include_once "../config.php";
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db("smsportal", $cn);
$groupname = mysql_real_escape_string($_POST['groupname']);
$userid = $_POST['userid'];
$qr = "select contactlist.contactlisid,contactlist.mobileno,contactlist.name,contactlist.email from contactlist,smsportal.group where group.userid = $userid and group.groupid = contactlist.groupid and group.groupname = '$groupname'";
$result = mysql_query($qr,$cn);
$value="";
if(mysql_affected_rows()>=1){
	while($row = mysql_fetch_array($result))
	{
		//$results[] = $row['mobileno'];
		$value.=$row['contactlisid'].",".$row['mobileno'].",".$row['name'].",".$row['email']."&";
	}
	//echo $val =json_encode($results);
	echo $value;
}
else echo mysql_error();

?>
