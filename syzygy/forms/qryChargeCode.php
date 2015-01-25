<?php
$INSERT_QRY="insert into ChargeCode ([ChargeCode], [Amount], [UserID], [LastUpdate]) values ('$txtChargeCode', '$txtAmount', '$txtUserID', '$txtLastUpdate')";
$UPDATE_QRY="update ChargeCode set [ChargeCode]='$txtChargeCode', [Amount]='$txtAmount', [UserID]='$txtUserID', [LastUpdate]='$txtLastUpdate' where ChargeCode='$txtChargeCode'";
$DELETE_QRY="delete from ChargeCode where ChargeCode='$ChargeCode'";
$LOAD_QRY="select [ChargeCode], [Amount], [UserID], [LastUpdate] from ChargeCode where ChargeCode='$ChargeCode'";
?>