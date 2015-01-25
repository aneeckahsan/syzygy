<div class="cls"></div>
<div class="smsbox">
<h6>WELCOME to CMP PORTAL</h6>
<?php	
	//$qry = "SELECT SMSBalance from smsgw_2_0.user where UserName = '$LoggedInUserID' LIMIT 1";
	$qry = "SELECT * FROM account where accountID = ".$_SESSION["LoggedInAccountID"];
	$rs=Sql_exec($cn,$qry); 
	$row=Sql_fetch_array($rs);
	$accountName = $row["accountName"];
	$SMSBalance=$row["balance"];
	//$SMSBalance=$row["SMSBalance"];
?>
<h6>Balance of <?php echo $accountName?> account is: <?php echo number_format($SMSBalance, 2, '.', '');?> SMS Credit</h6>
<div class="cls"></div>
<h9>TODAYS TRANSACTION</h9>
<?php	
	$qry2 = "select dstMN, msg, sentTime, msgStatus, Remarks from smsgw_2_0.smsoutbox where refID = '$LoggedInUserID' and DATE(sentTime)= DATE(now()) order by sentTime desc";
	$rs2=Sql_exec($cn,$qry2); 
	$row2=Sql_fetch_array($rs2);
	$cnt2=Sql_Num_Rows($rs2);
	//$SMSBalance=$row["SMSBalance"];
	
	if ($cnt2 != 0) {
		echo "<form id='sampleform' method='post' action='$ACTION'>
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		<thead>
		<tr>
		<td>Recipient</td>
		<td>Message</td>
		<td>Sent Time</td>
		<td>Status</td>
		<td>Remarks</td>
		</tr></thead>";
		
		showList($cn, $qry2,"$LoggedInUserID");
		
		echo "</table>
		</form>";
	}	
	else
		echo "<div>No transaction for today</div>";
?>
</div>