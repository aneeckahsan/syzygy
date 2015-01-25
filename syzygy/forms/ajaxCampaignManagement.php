<?php
include_once "../config.php";
$campaignid = $_POST['campaignid']; 
$userid = $_POST['userid'];
$txtScheduleDate = $_POST['txtScheduleDate'];
$txtScheduleTime = $_POST['txtScheduleTime'];
$scheduletype = $_POST['scheduletype'];
$enddate=$_POST['enddate'];
$status = $_POST['status'];
if($scheduletype == 'manual')$enddate=$txtScheduleDate;

if(!strcmp($scheduletype,'auto')){
$timeinterval = $_POST['timeinterval'];
}
else{
$timeinterval = NULL;
}
$time=date('H:i:s', strtotime($txtScheduleTime));
$locktime=$_POST['locktime'];
if(empty($locktime)) $locktime = 0;

date_default_timezone_set("Asia/Dhaka");
$currentdate = date('Y-m-d'); 

$true = 0;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);
mysql_query('SET CHARACTER SET utf8');
mysql_query("SET SESSION collation_connection ='utf8_general_ci'") or die (mysql_error());
$msg=mysql_real_escape_string($_POST['msg']);//mysql_real_escape_string works only after connection is set!

if(!empty($campaignid)){//edit
	$sql = "update smsportal.campaign set msg = '$msg', isactive = $status, locktime = $locktime, lastupdate = now() where campaignid = $campaignid";

	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$sql = "delete from campaigndetails where campaignid = $campaignid";
		$result = mysql_query($sql,$cn);
		if(mysql_affected_rows()>=1){
			$true = $true*1;		
			////////////////////////////////////////////////////////////////////
			$destnos = json_decode(stripslashes($_POST['destnos']));
			$INSERT_QRY="insert into campaigndetails (campaignid,destno) values";
			$sql = array(); 
			foreach($destnos as $d => $v)
			{
				if($v!=""){
					//$INSERT_QRY.=" ('$names[$x]','$x','$emails[$x]',$lastinsertid,now());";	
					$sql[] = '('.$campaignid.', "'.mysql_real_escape_string($d).'")';	//		
				}
			} 
			mysql_query('insert into campaigndetails (campaignid,destno) values '.implode(',', $sql));	
			if(mysql_affected_rows()==1){
				$true = $true * 1;
			}
			else {
				$true=$true*0;
				echo mysql_error();
			}
				
			
			$groupids = json_decode(stripslashes($_POST['groupids']));
			foreach($groupids as $d){
				if($d!=""){
					$INSERT_QRY="insert into campaigndetails (campaignid,groupid) values($campaignid,$d)";
					$result = mysql_query($INSERT_QRY,$cn);
					if(mysql_affected_rows()==1){
						$true = $true * 1;
					}
					else {
						$true=$true*0;
						//echo mysql_error();
					}
				}
				//else echo mysql_error();
			}
			$sql = "update campaignschedule set scheduledate = '$txtScheduleDate', scheduletime = '$time', scheduletype = '$scheduletype', occursoption = '$timeinterval',
					lastupdate = now(),enddate = '$enddate' where campaignid = $campaignid";

			$result = mysql_query($sql,$cn);
			if(mysql_affected_rows()==1){
				$true = $true*1;
			}	
			else {
				$true=$true*0;echo mysql_error();
			}
		}	
		else {
			$true=$true*0;echo mysql_error();
		}
	}
}
else{
	$sql = "insert into smsportal.campaign (userid, msg, isactive, dateofcreation, lastsenddate, locktime, lastupdate) 
			values($userid, '$msg',$status,now(),NULL,$locktime,now())";

	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$true = $true*1;
		/////////////////get the campaignid just inserted////////////
		$qry="select LAST_INSERT_ID()";
		$rs = mysql_query($qry,$cn);
		$row=mysql_fetch_array($rs);
		$campaignid=$row[0];echo "ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc".$campaignid;
		////////////////////////////////////////////////////////////////////
		$destnos = json_decode(stripslashes($_POST['destnos']));
		$INSERT_QRY="insert into campaigndetails (campaignid,destno) values ";
		$sql = array(); 
		foreach($destnos as $d => $v)
		{
			if($v!=""){
				//$INSERT_QRY.=" ('$names[$x]','$x','$emails[$x]',$lastinsertid,now());";	
				$sql[] = '('.$campaignid.', "'.mysql_real_escape_string($d).'")';	//		
			}
		} 
		mysql_query('insert into campaigndetails (campaignid,destno) values '.implode(',', $sql));	
		if(mysql_affected_rows()==1){
			$true = $true * 1;
		}
		else {
			$true=$true*0;
			//echo mysql_error();
		}
			
		
		$groupids = json_decode(stripslashes($_POST['groupids']));
		foreach($groupids as $d){
			if($d!=""){
				$INSERT_QRY="insert into campaigndetails (campaignid,groupid) values($campaignid,$d)";
				$result = mysql_query($INSERT_QRY,$cn);
				if(mysql_affected_rows()==1){
					$true = $true * 1;
				}
				else {
					$true=$true*0;
					//echo mysql_error();
				}
			}
			//else echo mysql_error();
		}
		$sql = "insert into campaignschedule (campaignid, userid, scheduledate, scheduletime, scheduletype, occursoption, lastupdate,enddate) 
				values($campaignid, $userid, '$txtScheduleDate', '$time','$scheduletype','$timeinterval',now(),'$enddate')";

		$result = mysql_query($sql,$cn);
		if(mysql_affected_rows()==1){
			$true = $true*1;
		}	
		else {
			$true=$true*0;echo mysql_error();
		}
	}	
	else {
		$true=$true*0;
	}
}
//echo $true;

//echo mysql_error();
echo $true;
?>