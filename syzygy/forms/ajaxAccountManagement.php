<?php
include_once "../config.php";
$txtNewAccountName = $_POST['txtNewAccountName'];
$txtCreditBalance = $_POST['txtCreditBalance'];
$masks = json_decode(stripslashes($_POST['masks']));

$noOfMask = sizeof($masks)-1;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

//Check whether SUPER-ADMIN has sufficient balance
/*$qry = "SELECT * FROM account WHERE accountID = 1";//.$SUPERADMIN_ACCOUNTID;
$rs = mysql_query($qry,$cn);
$dt = mysql_fetch_array($rs);
$super_balance = $dt['balance'];echo $qry.$super_balance; exit;*/

//if($super_balance >= $txtCreditBalance){
	$sql = "insert into account (accountName, balance, noofMask) values('$txtNewAccountName', $txtCreditBalance, $noOfMask)";
	$result = mysql_query($sql,$cn);
	if(mysql_affected_rows()==1){
		$sql2 = "select * from account where accountName='$txtNewAccountName'";
		$result = mysql_query($sql2,$cn);
		$row = mysql_fetch_array($result);
		$id = $row['accountID'];
		echo 1;
	}	
	else echo 0;
//}
//else echo "SUPER-ADMIN has insufficient balance.";
?>