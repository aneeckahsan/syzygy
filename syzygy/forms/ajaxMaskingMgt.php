<?php
$masks = json_decode(stripslashes($_POST['data']));
$true = 1;
foreach($masks as $d){
	if($d!=""){
		$cn = mysql_connect("127.0.0.1","root","nopass");
		$db= mysql_select_db("smsportal", $cn);
		$INSERT_QRY="insert into Masking (MaskingText, LastUpdate,AccountID) values('$d',now(),3)";
		$result = mysql_query($INSERT_QRY,$cn);
		if(mysql_affected_rows()==1){
			$true = $true * 1;
		}
		else {
			$true=$true*0;
		}
	}
	//else echo mysql_error();
}
echo $true;

?>