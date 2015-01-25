<div class="cls"></div>
<h9>SMS TRANSACTION HISTORY</h9>
<div class="cls"></div>
<?php

	
	$qry2 = "select dstMN, msg, sentTime, msgStatus, Remarks from smsgw_2_0.smsoutbox where refID = '$LoggedInUserID' order by sentTime desc";
	$rs2=Sql_exec($cn,$qry2); 
	$row2=Sql_fetch_array($rs2);
	$cnt2=Sql_Num_Rows($rs2);
	//$SMSBalance=$row["SMSBalance"];
	
	if ($cnt2 != 0)
	{
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
		echo "<div>No transaction History</div>";
	

?>