Charge Code Entry
<form method="post" action="<?php echo($ACTION);?>">
<table>
<tr>
	<td>ChargeCode: </td><td><input type="text" name="txtChargeCode" value="<?php echo($txtChargeCode);?>"></td>
	</tr><tr>
	<td>Amount: </td><td><input type="text" name="txtAmount" value="<?php echo($txtAmount);?>"></td>
	</tr><tr>
	<td>UserID: </td><td><input type="text" name="txtUserID" value="<?php echo($txtUserID);?>"></td>
	</tr><tr>
	<td>LastUpdate: </td><td><input type="text" name="txtLastUpdate" value="<?php echo($txtLastUpdate);?>"></td>
	</tr>

<tr>
<td> &nbsp</td> <td> <input type="submit" value="Save"></td>
</tr>
</table>
</form>

<table>
<tr>
<td>ChargeCode</td><td>Amount</td><td>UserID</td><td>LastUpdate</td>
</tr>
<?php 
showEntryList($cn, "select ChargeCode, Amount, UserID, LastUpdate from ChargeCode","ChargeCode");
?>
</table>
