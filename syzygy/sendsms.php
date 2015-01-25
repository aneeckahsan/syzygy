<?php
	
	require 'config.php';
	require 'common.php';
	require_once $CALLFLOWLIB;
	
	$name=$_GET['name'];
	$email=$_GET['email'];
	$srcno=$_GET['srcno'];
	$destno=$_GET['destno'];
	$msg=$_GET['msg'];
	
	$cn=ConnectDB();
	
	$insertqry = "INSERT INTO sendtestsms (id,name,Email,SrcNo,DestNo,LastUpdate,Msg) VALUES ('','$name','$email','$srcno','$destno',now(),'$msg')";
	$insertion = Sql_exec($cn,$insertqry);
	//echo "http://202.22.194.65/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&text=$destno|$msg";



	if ($insertion)
	{
	$sendsinglesms ="http://localhost/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&text=$destno|$msg";
	$sendsinglesms=str_replace(" ","%20",$sendsinglesms);
	$sendsinglesms=str_replace("__","%20",$sendsinglesms);
	$resultsendurl=file_get_contents($sendsinglesms);
	
	
	echo $resultsendurl;
	}
		
	
	else
	echo 'failed';
	 
	
	 
	/*$updateqry="select userid from contactlist where mobileno = '0127564765'";
	$updaters=Sql_exec($cn,$updateqry);
	
	
	if (!$updaters)
		echo 'error';
		
	else
		echo 'yeay';*/
		
	
	
	/*$table = 'sendtestsms';
	$fieldlist = 'id|name|Email|SrcNo|DestNo|LastUpdate';
	$valuelist =' |$name|$email|$srcno|$destno|$msg';
	
	$sendsms = insert($table,$fieldlist,$valuelist,$cn);*/
	

?>