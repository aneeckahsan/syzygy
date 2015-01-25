<?php
$txtReference = $_SESSION["REFERENCE"];
$txtStatus = $_SESSION["STATUS"];
$txtDestination = $_SESSION["DESTINATION"];
$txtReason = $_SESSION["REASON"];
$txtTimestamp = $_SESSION["TIMESTAMP"];
$txtOperator = $_SESSION["OPERATOR"];

echo "Reference: ".$txtReference." Status: ".$txtStatus." Destination: ".$txtDestination." Reason: ".$txtReason." Timestamp: ".$txtTimestamp." Operator: ".$txtOperator;
?>