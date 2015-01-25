<?php session_start();

//echo "please";
$txtMsg = $_POST['txtMsg'];
$txtrecipient = $_POST['txtrecipient'];

if($txtMsg != '')
{
	$LoggedInUserID = $_SESSION["LoggedInUserID"];


	$text = '';
	$cntmsg = 0;
	if(!empty($_POST['recipient']) || !empty($_POST['txtrecipient']) ) {
		foreach($_POST['recipient'] as $recipient) 
		{    	
			$info=explode("|",$recipient);
			$LastName=trim($info[0]);
			$FirstName=trim($info[1]);
			$MobileNo=trim($info[2]);
			
			$SMS = $txtMsg;
			$SMS = str_replace("{LastName}",$LastName,$SMS);
			$SMS = str_replace("{FirstName}",$FirstName,$SMS);
			//echo $LastName."<br /><br />";
			//echo $SMS."<br /><br />";
			
			$text = $text."|$MobileNo|$SMS";
			$cntmsg = $cntmsg + 1;
		}
		if(!empty($_POST['txtrecipient']) ) {
			
			
			$info=preg_split("/[\s,]+/",$txtrecipient);
			
			foreach($info as $recipient) 
			{	
				$MobileNo= $recipient;
				$SMS = $txtMsg;
				
				//echo $LastName."<br /><br />";
				//echo $SMS."<br /><br />";
				
				$text = $text."|$MobileNo|$SMS";
				$cntmsg = $cntmsg + 1;
			}
		}
		$text = substr($text, 1);

		//echo "http://localhost:8080/smsportal/smsgw/SendSMS/SendMultipleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&text=$text&NO=$cntmsg";

		$sendbulksms = "http://localhost/smsgw/SendSMS/SendMultipleSMS.php?UserName=TestSSDT&Password=Nopass1234&Sender=60166955265&operator=CTSSDT&LoggedInUserID=$LoggedInUserID&text=$text&NO=$cntmsg";
		$sendbulksms=str_replace(" ","%20",$sendbulksms);
		$sendbulksms=str_replace("__","%20",$sendbulksms);
		
		$resultsendurl=file_get_contents($sendbulksms) or die("Can't open URL");
		echo $resultsendurl;
		
		if ($resultsendurl=='Successfully inserted to smsoutbox')
		{
			//echo $resultsendurl;
			
			$res = "The SMS will be sending to all contacts";
			//return $res;
			
			header("Location: ../index.php?FORM=forms/frmbulksms.php&INITFILE=forms/qrybulksms.php&res=$res");
		}
		
		else
		{
			$res = "The SMS will be Failed to send. Please try again";
			//return $res;
			
			header("Location: ../index.php?FORM=forms/frmbulksms.php&INITFILE=forms/qrybulksms.php&res=$res");
		}
		
	}
}

?>