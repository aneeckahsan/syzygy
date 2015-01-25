User List
<table>
<tr>
<td>User ID</td>
<td>User Type</td>
<td>Reference Info</td>
</tr>
<?php
$qry="SELECT UserID, UserType, ReferenceInfo FROM $TBL_USER";
$out=showList($cn, $qry, $PageNo, 2, "index.php?FORM=forms/report1.php&PageNo=");
?>
</table>
<?php 
echo($out);
?>