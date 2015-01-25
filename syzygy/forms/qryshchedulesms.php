<?php
$INSERT_QRY="insert into schedulesms (ID, UserID, DestNo, Msg, ScheduleDate, Status, LastUpdate) values('', '$LoggedInUserID', '$txtDestNo', '$txtMsg', '$txtScheduleDate','QUE', now())";

$UPDATE_QRY="update schedulesms set DestNo='$txtDestNo', Msg = '$txtMsg', ScheduleDate = '$txtScheduleDate', LastUpdate=now() where ID='$txtID' AND UserID = '$LoggedInUserID'";

//echo $UPDATE_QRY;
$DELETE_QRY="delete from schedulesms where ID='$ID' AND UserID = '$LoggedInUserID'";

//echo $txtID;

$LOAD_QRY="select ID, UserID, DestNo, Msg, ScheduleDate from schedulesms where ID='$ID' AND Status = 'QUE'";
?>