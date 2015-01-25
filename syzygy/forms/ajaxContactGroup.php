<?php
include_once "../config.php";
$true = 1;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

$groupname=mysql_real_escape_string($_POST['GroupName']);
$groupid=$_POST['GroupId'];
$nos=json_decode(stripslashes($_POST['nosajax']),true);
$names=json_decode(stripslashes($_POST['namesajax']),true);
$emails=json_decode(stripslashes($_POST['emailsajax']),true);
$userid=$_POST['userid'];

//$userid=$_SESSION["LoggedInUserID"];
date_default_timezone_set("Asia/Dhaka");
$currentdate = date('Y-m-d');
echo "ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss".$userid.sizeof($nos).sizeof($names).sizeof($userid);
if(!empty($groupid)){
	$sql = "delete from contactlist where groupid=$groupid";
	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()>=1){
		$INSERT_QRY="insert into contactlist (name,mobileno,email,groupid,lastupdate) values";
		$sql = array(); 
		foreach ($nos as $x => $v) 
		{
			if($nos[$x]!=""){
				$sql[] = '("'.mysql_real_escape_string($names[$x]).'", "'.mysql_real_escape_string($x).'","'.mysql_real_escape_string($emails[$x]).'",'.$groupid.',now())';			
			}
		} 
		mysql_query('INSERT INTO contactlist (name,mobileno,email,groupid,lastupdate) VALUES '.implode(',', $sql));			

		//$result = mysql_query($INSERT_QRY,$cn);
		if(mysql_affected_rows()>=1){
			$true = $true * 1;
		}
		else {
			$true=$true*0;
			echo "line35".mysql_error();
		}
	}
}
else{
//echo "debug39".$groupname.$_POST['userid'];

$sql = "insert into smsportal.group (groupname,userid,lastupdate) values('".$groupname."',".$_POST['userid'].",'".$currentdate."')";
echo $sql;
	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()>=1){
		$true = $true*1;
		//$qry ="select groupid from smsportal.group where userid = $userid and groupname='$groupname'";
		$qry="select LAST_INSERT_ID()";
		$rs = mysql_query($qry,$cn);
		$row=mysql_fetch_array($rs);
		$lastinsertid=$row[0];
		$INSERT_QRY="insert into contactlist (name,mobileno,email,groupid,lastupdate) values";
		//for ($x=0; $x<sizeof($nos); $x++)
		$sql = array(); 
		foreach ($nos as $x => $v) 
		{
			if($nos[$x]!=""){
				//$INSERT_QRY.=" ('$names[$x]','$x','$emails[$x]',$lastinsertid,now());";	
				$sql[] = '("'.mysql_real_escape_string($names[$x]).'", "'.mysql_real_escape_string($x).'","'.mysql_real_escape_string($emails[$x]).'",'.$lastinsertid.',now())';			
			}
		} 
		mysql_query('INSERT INTO contactlist (name,mobileno,email,groupid,lastupdate) VALUES '.implode(',', $sql));			

		//$result = mysql_query($INSERT_QRY,$cn);
		if(mysql_affected_rows()>=1){
			$true = $true * 1;
		}
		else {
			$true=$true*0;
			echo "line69".mysql_error();
		}
	}	
	else {
		$true=$true*0;echo "line73".mysql_error();
	}
	
}
echo $true;

?>
