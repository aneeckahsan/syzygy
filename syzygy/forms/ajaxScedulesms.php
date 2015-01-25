<?php
include_once "../config.php";
$scheduleid = $_POST['scheduleid']; 
$userid = $_POST['userid'];
$txtScheduleDate = $_POST['txtScheduleDate'];
$txtScheduleTime = $_POST['txtScheduleTime'];
$scheduletype = $_POST['scheduletype'];
$enddate=$_POST['enddate'];
if(!strcmp($scheduletype,'auto')){
$timeinterval = $_POST['timeinterval'];
}
else{
$timeinterval = NULL;
}
$time=date('H:i:s', strtotime($txtScheduleTime));
$locktime=$_POST['locktime'];

date_default_timezone_set("Asia/Dhaka");
$currentdate = date('Y-m-d'); 

$true = 0;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);
$msg=mysql_real_escape_string($_POST['msg']);//mysql_real_escape_string works only after connection is set!

if(!empty($scheduleid)){//edit
	$sql = "update smsportal.schedulesms set msg = '$msg',locktime = $locktime, lastupdate = now() where scheduleid = $scheduleid";

	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$sql = "delete from schedulesmsdetails where scheduleid = $scheduleid";
		$result = mysql_query($sql,$cn);
		if(mysql_affected_rows()>=1){
			$true = $true*1;		
			////////////////////////////////////////////////////////////////////
			$destnos = json_decode(stripslashes($_POST['destnos']));
			$INSERT_QRY="insert into schedulesmsdetails (scheduleid,destno) values";
			$sql = array(); 
			foreach($destnos as $d => $v)
			{
				if($v!=""){
					//$INSERT_QRY.=" ('$names[$x]','$x','$emails[$x]',$lastinsertid,now());";	
					$sql[] = '('.$scheduleid.', "'.mysql_real_escape_string($d).'")';	//		
				}
			} 
			mysql_query('insert into schedulesmsdetails (scheduleid,destno) values '.implode(',', $sql));	
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
					$INSERT_QRY="insert into schedulesmsdetails (scheduleid,groupid) values($scheduleid,$d)";
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
			$sql = "update schedulesmsschedule set scheduledate = '$txtScheduleDate', scheduletime = '$time', scheduletype = '$scheduletype', occursoption = '$timeinterval',
					lastupdate = now(),enddate = '$enddate' where scheduleid = $scheduleid";

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
	$sql = "insert into smsportal.schedulesms (userid, msg, isactive, dateofcreation, lastsenddate, locktime, lastupdate) 
			values($userid, '$msg',1,now(),NULL,$locktime,now())";

	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$true = $true*1;
		/////////////////get the scheduleid just inserted////////////
		$qry="select LAST_INSERT_ID()";
		$rs = mysql_query($qry,$cn);
		$row=mysql_fetch_array($rs);
		$scheduleid=$row[0];echo "ccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccc".$scheduleid;
		////////////////////////////////////////////////////////////////////
		$destnos = json_decode(stripslashes($_POST['destnos']));
		$INSERT_QRY="insert into schedulesmsdetails (scheduleid,destno) values";
		$sql = array(); 
		foreach($destnos as $d => $v)
		{
			if($v!=""){
				//$INSERT_QRY.=" ('$names[$x]','$x','$emails[$x]',$lastinsertid,now());";	
				$sql[] = '('.$scheduleid.', "'.mysql_real_escape_string($d).'")';	//		
			}
		} 
		mysql_query('insert into schedulesmsdetails (scheduleid,destno) values '.implode(',', $sql));	
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
				$INSERT_QRY="insert into schedulesmsdetails (scheduleid,groupid) values($scheduleid,$d)";
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
		$sql = "insert into schedulesmsschedule (scheduleid, userid, scheduledate, scheduletime, scheduletype, occursoption, lastupdate,enddate) 
				values($scheduleid, $userid, '$txtScheduleDate', '$time','$scheduletype','$timeinterval',now(),'$enddate')";

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