<?php session_start();


/*$qry ="'select * from user where UserID = '$LoggedInUserID'";
$rs=Sql_exec($cn,$qry);
$=$row["MobileNo"];
*/

/*	$sendsinglesms ="http://50.97.253.164/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&text=$txtDestNo|$txtMsg"*/
/*echo $txtDestNo;
	$INSERT_QRY = '';
*/	


$txtDestNo = $_POST['txtDestNo'];
$txtMsg = $_POST['txtMsg'];
$LoggedInUserID = $_SESSION["LoggedInUserID"];


$sendsinglesms = "http://localhost/smsgw/SendSMS/SendSingleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&LoggedInUserID=$LoggedInUserID&text=$txtDestNo|$txtMsg";
	$sendsinglesms=str_replace(" ","%20",$sendsinglesms);
	$sendsinglesms=str_replace("__","%20",$sendsinglesms);
	$resultsendurl=file_get_contents($sendsinglesms) or die("Can't open URL");
	
	if ($resultsendurl =='Successfully inserted to smsoutbox')
	{
		$res = "The SMS will be sending to $txtDestNo";	
		//echo $resultsendurl;

		header("Location: /index.php?FORM=forms/frmsinglesms.php&INITFILE=forms/qrysinglesms.php&res=$res");
		//header("Location: /index.php?FORM=forms/frmsinglesms.php");
	}


?>