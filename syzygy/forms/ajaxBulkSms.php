<?php
//error_reporting(E_ERROR | E_PARSE);
include_once "../config.php";
$true = 1;
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
$db= mysql_select_db($MYDB, $cn);

$msg=$_POST['msg'];
$mask=$_POST['mask'];
$nos=$_POST['nosajax'];
$userid=$_POST['userid'];
$msg = utf8_encode($msg);
$concatedstringofphonenumbers = ''; 
$sql = array();
mysql_query('INSERT INTO singleandbulksms (msg,mask,type,dateofcreation) VALUES("'.mysql_real_escape_string($msg).'","'.$mask.'","bulk"," ")');
if(mysql_affected_rows()>=1){
					}
		else {
			echo "line22".mysql_error();
		}

$qry="select LAST_INSERT_ID()";
$rs = mysql_query($qry,$cn);
$row=mysql_fetch_array($rs);
$lastinsertid=$row[0];

foreach ($nos as $x => $v) 
{
	if($nos[$x]!=""){
		$sql[] = $x;
		$sql2[] = '('.$lastinsertid.',"'.mysql_real_escape_string($x).'"," "," "," ")';
		//$concatedstringofphonenumbers.=$x.',';
	}
	
} 
$concatedstringofphonenumbers = implode(",", $sql);
mysql_query('INSERT INTO singleandbulksmsdetails (smsid,destno,status,reason,dateofdelivery) VALUES '.implode(',', $sql2));
if(mysql_affected_rows()>=1){
					}
		else {
			echo "line42".mysql_error();
		}
$url = "http://api.silverstreet.com/send.php?username=ssdhq&password=q01J2GAW";
$url .= "&destination=" . urlencode($concatedstringofphonenumbers);
$url .= "&sender=" . urlencode($mask);
$url .= "&body=" . urlencode($msg);
$url .= "&dlr=1";
//$url = htmlspecialchars($url);
//echo $url;
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);

$context = stream_context_create($opts);
$fp = fopen($url, 'r', false, $context);
//fpassthru($fp);
 $response = stream_get_contents($fp);
echo $response;
fclose($fp);
		
?>
