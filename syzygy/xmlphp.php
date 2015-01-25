<?php
$url="http://api.silverstreet.com/creditcheck.php?username=ssdhq&password=q01J2GAW";

$xmlinfo = simplexml_load_file($url);

echo $xmlinfo->balance;
?>