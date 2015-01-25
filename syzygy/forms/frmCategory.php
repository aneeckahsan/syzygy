Category Entry
<form method="post" action="<?php echo($ACTION);?>">
<table>
<tr>
	<td>CategoryID: </td><td><input type="text" name="txtCategoryID" value="<?php echo($txtCategoryID);?>"></td>
	</tr><tr>
	<td>ParentID: </td><td><input type="text" name="txtParentID" value="<?php echo($txtParentID);?>"></td>
	</tr><tr>
	<td>Prompt: </td><td><input type="text" name="txtPrompt" value="<?php echo($txtPrompt);?>"></td>
	</tr><tr>
	<td>Pre-Prompt: </td><td><input type="text" name="txtPre-Prompt" value="<?php echo($txtPre-Prompt);?>"></td>
	</tr><tr>
	<td>Post-Prompt: </td><td><input type="text" name="txtPost-Prompt" value="<?php echo($txtPost-Prompt);?>"></td>
	</tr><tr>
	<td>IVR-String: </td><td><input type="text" name="txtIVR-String" value="<?php echo($txtIVR-String);?>"></td>
	</tr><tr>
	<td>DisplayOrder: </td><td><input type="text" name="txtDisplayOrder" value="<?php echo($txtDisplayOrder);?>"></td>
	</tr><tr>
	<td>Status: </td><td><input type="text" name="txtStatus" value="<?php echo($txtStatus);?>"></td>
	</tr><tr>
	<td>ActivationDate: </td><td><input type="text" name="txtActivationDate" value="<?php echo($txtActivationDate);?>"></td>
	</tr><tr>
	<td>DeactivationDate: </td><td><input type="text" name="txtDeactivationDate" value="<?php echo($txtDeactivationDate);?>"></td>
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
<td>CategoryID</td><td>ParentID</td><td>Prompt</td><td>Pre-Prompt</td><td>Post-Prompt</td><td>IVR-String</td><td>DisplayOrder</td><td>Status</td><td>ActivationDate</td><td>DeactivationDate</td><td>UserID</td><td>LastUpdate</td>
</tr>
<?php 
showEntryList($cn, "select CategoryID, ParentID, Prompt, Pre-Prompt, Post-Prompt, IVR-String, DisplayOrder, Status, ActivationDate, DeactivationDate, UserID, LastUpdate from Category","CategoryID");
?>
</table>
