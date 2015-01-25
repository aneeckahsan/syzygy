<?php

//$recipient = $_POST['recipient'];
$Msg = $_POST['txtMsg'];
$text = "";
$cntmsg = 0;
if(!empty($_POST['recipient'])) {
    foreach($_POST['recipient'] as $recipient) 
	{    	
		$info=explode("|",$recipient);
		$LastName=trim($info[0]);
		$FirstName=trim($info[1]);
		$MobileNo=trim($info[2]);
		
		$SMS = $Msg;
		$SMS = str_replace("{LastName}",$LastName,$SMS);
		$SMS = str_replace("{FirstName}",$FirstName,$SMS);
		//echo $LastName."<br /><br />";
		//echo $SMS."<br /><br />";
		
		$text = $text."|$MobileNo|$SMS";
		$cntmsg = $cntmsg + 1;
	}
	
	$text = substr($text, 1);
	
	$sendbulksms = "http://localhost/smsgw/SendSMS/SendMultipleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&text=$text&NO=$cntmsg";
//$sendbulksms;
	$sendbulksms=str_replace(" ","%20",$sendbulksms);
	$sendbulksms=str_replace("__","%20",$sendbulksms);
	$resultsendurl=file_get_contents($sendbulksms);
	
	if ($resultsendurl=='Successfully inserted to smsoutbox')
	{
		//echo $resultsendurl;
		
		$res = "The SMS will be sending to the selected recipient";
		//return $res;
		//echo $res;
		header("Location: ../index.php?FORM=forms/frmpersonalizesms.php&res=$res");
	}
}

else
{
	$res = "Please select recipient";
	header("Location: ../index.php?FORM=forms/frmpersonalizesms.php&res=$res");
}
	
?>
