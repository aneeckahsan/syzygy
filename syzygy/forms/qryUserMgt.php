<?php
$INSERT_QRY="insert into $TBL_USER (UserID, Password, UserType, ReferenceInfo, LastModifiedUserID, LastUpdate) values('$txtUserID', '$txtPassword', '$txtUserType', '$txtReferenceInfo','$LoggedInUserID', now())";
if($SavePassword=="YES")
	$UPDATE_QRY="update $TBL_USER set Password='$txtPassword', UserType='$txtUserType', ReferenceInfo='$txtReferenceInfo', LastUpdate=now(), LastModifiedUserID='$LoggedInUserID' where UserID='$txtUID'";
else
	$UPDATE_QRY="update $TBL_USER set UserType='$txtUserType', ReferenceInfo='$txtReferenceInfo', LastUpdate=now(), LastModifiedUserID='$LoggedInUserID' where UserID='$txtUID'";

$DELETE_QRY="delete from $TBL_USER where UserID='$UserID'";

//echo $UserID;
$LOAD_QRY="select UserID, UserType, ReferenceInfo, Password, LastModifiedUserID, LastUpdate from $TBL_USER where UserID='$UserID'";
?>