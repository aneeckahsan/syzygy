<?php
include "commonlib.php";
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
mysql_select_db('smsportal');
//$username = "ahsan";
$qry = 'LOAD DATA INFILE "../../www/html/smsportal/importedfiles/user1/user1.txt" INTO TABLE contentoutbox(MSISDN)';
echo $qry.$MYSERVER;
$rs = mysql_query($qry,$cn);
echo "affect: ".mysql_affected_rows();
echo "error".mysql_error();
?>
