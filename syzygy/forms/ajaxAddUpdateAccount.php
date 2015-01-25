<?php
include_once "../config.php";
$accountID = $_POST['accountID'];
if($accountID == 0) $txtNewAccountName = $_POST['accountName'];
$txtCreditBalance = $_POST['balance'];
$masks = stripslashes($_POST['mask']);
$status = $_POST['status'];

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

//Check whether SUPER-ADMIN has sufficient balance
$qry = "SELECT * FROM account WHERE accountID = ".$SUPERADMIN_ACCOUNTID;
$rs = mysql_query($qry,$cn);
$dt = mysql_fetch_array($rs);
$super_balance = $dt['balance'];

if($accountID>0){ 
		$sql = "UPDATE account SET mask = '".$masks."', status = ". $status ." WHERE accountID = ".$accountID;
		$result = mysql_query($sql,$cn);
		if(mysql_affected_rows()==1) echo "Successfully updated";
		elseif(mysql_affected_rows()==0) echo "Nothing to update";
		else echo "Updating failed";
}
else{
	if($super_balance >= $txtCreditBalance){

		$sql = "insert into account (accountName, balance, mask, status) values('$txtNewAccountName', $txtCreditBalance, '$masks', $status)";

		$result = mysql_query($sql,$cn);
		if(mysql_affected_rows()==1){
			$qry = "UPDATE account SET balance = balance - ".$txtCreditBalance." WHERE accountID = ".$SUPERADMIN_ACCOUNTID;
			$rs = mysql_query($qry,$cn);
			if(mysql_affected_rows()==1) echo "Successfully inserted";
				else echo "SUPER-ADMIN balance deduction failed";
		}	
		else echo "Account insertion failed";
	
	}
	else echo "SUPER-ADMIN has insufficient balance.";
}
?>