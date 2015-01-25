<?php
include_once "../config.php";
$true = 1;

//Hardcoded SUPER-ADMIN account id
$sourceAccount = $SUPERADMIN_ACCOUNTID;

$destinationAccount = $_POST['destinationAccount'];
$txtCreditAmount = $_POST['txtCreditAmount'];

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

if($sourceAccount == $destinationAccount){//superadmin
	$sql = "Update account set balance = balance + ".$txtCreditAmount." where accountID='".$destinationAccount."'";
	$result = mysql_query($sql,$cn);

	if(mysql_affected_rows()==1){
		$true = $true*1;
	}
	else $true = $true*0;

}
else{
	$sql = "Update account set balance = balance - ".$txtCreditAmount." where accountID='".$sourceAccount."'";
	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$sql = "Update account set balance = balance + ".$txtCreditAmount." where accountID='".$destinationAccount."'";
		$result = mysql_query($sql,$cn);

		if(mysql_affected_rows()==1){
			$true = $true*1;
		}
		else $true = $true*0;
	}
	else $true = $true*0;
}
echo $true;
?>