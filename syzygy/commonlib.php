<?php

include_once "config.php";
include_once "bafconfig.php";
//include_once $COMMONPHP;

function connectDB()
{
	
	global $dbtype;
	global $MYSERVER;
	global $MYDB;
	global $MYUID;
	global $MYPASSWORD;

	if ($dbtype=="odbc")
	{ 
		$cn=odbc_connect("Driver={SQL Server};Server=$MYSERVER;Database=$MYDB","$MYUID", "$MYPASSWORD");
		if(!$cn){
			die("err+db (odbc) connection error+".odbc_errormsg());
		}
		else
			return $cn;
			
		return $cn;
	}
	else if($dbtype=="mssql")
	{
		$cn=mssql_connect("$MYSERVER","$MYUID", "$MYPASSWORD");
		$ret=mssql_select_db($MYDB);
			
		if(!$cn) 
			die("err+db (mssql) connection error");
		else
			return $cn;
			
		return $cn;
	}
	else
	{
		$cn=mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
		mysql_select_db($MYDB);
			
		if(!$cn) {
			die("err+db (mysql) connection error");
		}
		else
			return $cn;
			
		return $cn;
	}
}

function ClosedDBConnection($cn)
{
	global $dbtype;
	if($dbtype == 'odbc')
		odbc_close($cn);
	else if($dbtype == 'mssql')
		mssql_close($cn);
	else
		mysql_close();
}

function Sql_exec($cn,$qry)
{
	global $dbtype;

	if($dbtype == 'odbc')
	{
		$rs=odbc_exec($cn,$qry);
		if(!$rs)
			die("err+".$qry);
		else
			return $rs;
	}
	else if($dbtype == 'mssql')
	{
		$rs=mssql_query($qry, $cn);

		if(!$rs) {
			echo(mssql_get_last_message());
			die("err+".$qry);
		}
		else
			return $rs;
	}
	else
	{
		$rs=mysql_query($qry,$cn);
		if(!$rs)
			die("err+".$qry);
		else
			return $rs;
	}	
}

function Sql_fetch_array($rs)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_fetch_array($rs);
	else if($dbtype == 'mssql')
		return mssql_fetch_array($rs);
	else
		return mysql_fetch_array($rs);
}

function Sql_Result($rs,$ColumnName)
{
	global $dbtype;
	
	return $rs[$ColumnName];
}

function Sql_Num_Rows($result_count)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_num_rows($result_count);
	else if($dbtype == 'mssql')
		return mssql_num_rows($result_count);
	else	
		return mysql_num_rows($result_count);
	
}

function Sql_GetField($rs,$ColumnName)
{
	 global $dbtype;
	 
	 if($dbtype == 'odbc')
	  return odbc_result($rs, $ColumnName);
	 else if($dbtype == 'mssql')
	  return mssql_result($rs, 0, $ColumnName);
	 else
	  return mysql_result($rs, 0, $ColumnName);
}

function Sql_error()
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_errormsg();
	else if($dbtype == 'mssql')
		return mssql_get_last_message();
	else
		return mysql_error();
}

function Sql_Num_Fields($result_count)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_num_fields($result_count);
	else if($dbtype == 'mssql')
		return mssql_num_fields($result_count);
	else	
		return mysql_num_fields($result_count);
	
}

function Sql_Data_Seek($rs, $pos)
{
	global $dbtype;
	if($dbtype == 'odbc') {
		odbc_fetch_row($rs, $pos);
	}
	else if($dbtype == 'mssql')
		mssql_data_seek($rs, $pos);
	else	
		mysql_data_seek($rs, $pos);
	
}

function Sql_Fetch_Field($rs, $fld)
{
	global $dbtype;
	if($dbtype == 'odbc')
		return odbc_field_name($rs, $fld);
	else if($dbtype == 'mssql')
		return mssql_field_name($rs, $fld);
	else	
		return mysql_field_name($rs, $fld);
	
}

function showListMYSQL($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {
	$rs=mysql_query($qry, $cn);
	$n=mysql_num_fields($rs);

	$N=mysql_num_rows($rs);
	if($count==0) $count=$N;

	$start=$pageno*$count;
	$totalpage=ceil($N/$count)-1;
	mysql_data_seek($rs, $start);
	for($x=$start; $x<$start+$count && $x<$N; $x++){
		$dt=mysql_fetch_array($rs);
		echo($rowstart);
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("$colstart$val$colend");
		}
		echo($rowend);
	}
	$prev=$pageno-1;
	if($prev<0)$prev=0;
	$next=$pageno+1;
	if($next>=$totalpage) $next=$totalpage;
	$totalpage+=1; $pageno+=1;
	$pagingstring="<a href=$url$prev>Previous</a> Page $pageno/$totalpage <a href=$url$next>Next</a>";
	return $pagingstring;
}

function showEntryListMYSQL($cn, $qry, $key) {

	global	$MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=mysql_query($qry, $cn);

	$n=mysql_num_fields($rs);
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";

	while($dt=mysql_fetch_array($rs)) {
		echo("<tr>");
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("<td>$val</td>");
		}
		echo("<td><a href=$action".$dt[$key].">Edit</td>");
		echo("<td><a href=$delaction".$dt[$key].">Delete</td>");
		echo("</tr>");
	}
}

function showListMSSQL($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {

	$rs=Sql_exec($cn, $qry);
	$n=Sql_Num_fields($rs);

	$N=Sql_Num_Rows($rs);
	if($count==0) $count=$N;

	$start=$pageno*$count;
	$totalpage=ceil($N/$count)-1;
	Sql_Data_Seek($rs, $start);
	for($x=$start; $x<$start+$count && $x<$N; $x++){
		$dt=Sql_fetch_array($rs);
		echo($rowstart);
		for($i=0;$i<$n;$i++) {
			$val=Sql_GetField($rs, $i+1);
			echo("$colstart$val$colend");
		}
		echo($rowend);
	}
	$prev=$pageno-1;
	if($prev<0)$prev=0;
	$next=$pageno+1;
	if($next>=$totalpage) $next=$totalpage;
	$totalpage+=1; $pageno+=1;
	$pagingstring="<a href=$url$prev>Previous</a> Page $pageno/$totalpage <a href=$url$next>Next</a>";
	return $pagingstring;
}

function showEntryListMSSQL($cn, $qry, $key) {

	global	$MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=Sql_exec($cn, $qry);

	$n=Sql_Num_Fields($rs);
	
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";

	while($dt=Sql_fetch_array($rs)) {
		echo("<tr>");
		for($i=0;$i<$n;$i++) {
			$val=Sql_GetField($rs,$i+1);
			echo("<td>$val</td>");
		}
		echo("<td><a href=$action".Sql_GetField($rs, $key).">Edit</td>");
		echo("<td><a href=$delaction".Sql_GetField($rs,$key).">Delete</td>");
		echo("</tr>");
	}
}

function showEntryListSelectMYSQL($cn, $qry, $key) {

	global $MYNAME;
	global $FORM;
	global $INITFILE;
	global $KEYFIELD;

	$rs=mysql_query($qry, $cn);

	$n=mysql_num_fields($rs);
	$action="$MYNAME?MODE=LOAD&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";
	//$delaction="$MYNAME?CMD=DELETE&FORM=$FORM&INITFILE=$INITFILE&KEYFIELD=$KEYFIELD&$key=";

	while($dt=mysql_fetch_array($rs)) {
		echo("<tr>");
		for($i=0;$i<$n;$i++) {
			$val=$dt[$i];
			echo("<td>$val</td>");
		}
		echo("<td><a href=$action".$dt[$key].">Select</td>");
		//echo("<td><a href=$delaction".$dt[$key].">Delete</td>");
		echo("</tr>");
	}
}

function showEntryList($cn, $qry, $key) {
	global $dbtype;

	if($dbtype=="mysql")
		showEntryListMYSQL($cn, $qry, $key);
	else
		showEntryListMSSQL($cn, $qry, $key);
}

function showList($cn, $qry, $pageno=0, $count=0, $url="", $rowstart="<tr>", $rowend="</tr>", $colstart="<td>", $colend="</td>") {
	global $dbtype;

	if($dbtype=="mysql")
		showListMYSQL($cn, $qry, $pageno, $count, $url, $rowstart, $rowend, $colstart, $colend) ;
	else
		showListMSSQL($cn, $qry, $pageno, $count, $url, $rowstart, $rowend, $colstart, $colend) ;
}

function scatterVars($inp, $prefix=""){
	$keys=array_keys($inp);
	$n=count($keys);
	for($i=0;$i<$n;$i++) {
		$varname=$prefix.$keys[$i];
		global $$varname;
		$$varname=addslashes($inp[$varname]);
	}
}

function clearVars($inp, $prefix=""){
	$keys=array_keys($inp);
	$n=count($keys);
	for($i=0;$i<$n;$i++) {
		$varname=$prefix.$keys[$i];
		global $$varname;
		$$varname="";
	}
}

function scatterFields($rs, $prefix) {
	$n=Sql_Num_Fields($rs);
	$dt=Sql_fetch_array($rs);
	for($i=0; $i<$n; $i++) {
		$name=Sql_Fetch_Field($rs,$i);
		print_r($fld);
		$varname=$prefix.$name;
		global $$varname;
		$$varname=Sql_GetField($rs, $name);
	}
}

/*function buildDropDownFromMySQLQuery($cn, $query, $value, $text) {

	$rs=mysql_query($query, $cn);
	if(mysql_affected_rows()>=1){
		while($dt=mysql_fetch_array($rs))
		echo "<option value='".htmlentities($dt[$value])."'>".htmlentities($dt[$text])."</option>";
	}
	else
		echo 0;
}*/

function buildDropDownFromMySQLQuery($cn, $query, $value, $text) {

	$rs=mysql_query($query, $cn);
	if(mysql_affected_rows()>=1){
		if(strstr($value,',') >= 0) $val_arr = explode(",", $value);
		while($dt=mysql_fetch_array($rs)){
			if($val_arr){
				foreach($val_arr as $val)
					$valueString .= htmlentities($dt[$val]).",";
				$valueString = chop($valueString,",");				
			}
			else $valueString = htmlentities($dt[$val]);
				 
			echo "<option value='".$valueString."'>".htmlentities($dt[$text])."</option>";
			$valueString = "";
		}
	}
	else
		echo 0;
}

function encrypt($cleartext) {
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
	$key128 = "m!neSec&p@ss9052";
	$iv = "mY1vkeyw0rd73951";

	if (mcrypt_generic_init($cipher, $key128, $iv) != -1){
		$cipherText = mcrypt_generic($cipher, $cleartext);
		mcrypt_generic_deinit($cipher);
		$hexValue = bin2hex($cipherText);
		return $hexValue;
	}
	return null;
}

function decrypt($encrypted){
	$cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
	$key128 = "m!neSec&p@ss9052";
	$iv = "mY1vkeyw0rd73951";
	
	if (mcrypt_generic_init($cipher, $key128, $iv) != -1){
		$encrypted = hex2bin($encrypted); 	
		$cleartext = mdecrypt_generic($cipher, $encrypted );
		mcrypt_generic_deinit($cipher);
		$cleartext = preg_replace('/[^(\x20-\x7F)]*/','', $cleartext);
		return $cleartext;
	}
	else
		return "Decryption failed";
}

function checkPrivilegePermission($privilegeID){
	$privilegeIDText = ",".$privilegeID.",";
	if(strpos($_SESSION["PrivilegeIDs"],$privilegeIDText)===false){
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$ROOTURL.'index.php">';
		exit;
	}
}

?>
