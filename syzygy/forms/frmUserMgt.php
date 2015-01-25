
User Management
<form method="post" action="<?php echo($ACTION);?>">
<table>
<tr>
<td> User ID</td> <td> <input type="text" name="txtUserID" value="<?php echo($txtUserID);?>"></td>
</tr>

<tr>
<td> User Type</td> <td> <input type="text" name="txtUserType" value="<?php echo($txtUserType);?>"></td>
</tr>

<tr>
<td> Reference</td> <td> <input type="text" name="txtReferenceInfo" value="<?php echo($txtReferenceInfo);?>"></td>
</tr>
<tr>
<td> Password</td> <td> <input type="password" name="txtPassword" value="<?php echo($txtPassword);?>"> 
<?php if($MODE=="LOAD") {?> 
<input type="checkbox" value="YES" name="SavePassword"> Save Password</td>
<?php
}
?>
</tr><tr>
<td> &nbsp</td> <td> <input type="submit" value="Save"></td>
</tr>
</table>
</form>

<table>
<tr>
<td>UserID</td>
<td>User Name</td>
<td>Email</td>
</tr>
<?php 
showEntryList($cn, "select UserID, UserType, ReferenceInfo, LastModifiedUserID, LastUpdate from $TBL_USER","UserID");
?>
</table>
