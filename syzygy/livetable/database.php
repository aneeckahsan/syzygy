<?php

//include_once "config.php";

class Database {
	const DB_HOST = 'localhost';
	const DB_USER = 'root';
	const DB_PASSWORD = 'nopass';
	const DB_NAME = 'syzygy';
	private $_dbconnect = NULL;
	private $_table;
	private $_adj = 4;
	private $_tpages = 0;
	private $_limit = 2;
	private $_offset= 0;
	private $_page = 1;
	public $_startdate;
	public $_enddate;
	private $_prev_lbl = '&lsaquo; Prev';
	private $_next_lbl = 'Next &rsaquo;';
	private $_rulespath = "/ismp/test/GPCallFiltering/";

	private $_db_table_details = array(
		"user"=>array("userid","username","password","email","mobileno","accountid","roleid","active","lastupdate"),
		"account"=>array("accountID", "accountName", "balance", "mask", "status"),
		"rate"=>array("id", "prefix", "operator", "charge"),

		"cells"=>array("id","cellid","userid","username","updated"),
		"geo_locations"=>array("id","gloc_id","userid","username","updated"),
		"locations"=>array("id","loc_no","userid","username","updated"),
		"status"=>array("id","status","userid","updated"),
		"vlrs"=>array("id","vlr_no","userid","updated"),
		"rules"=>array("id","ano","bno","state","vlr","Decission"),
		"CallLog"=>array("id","MsgID","Ano","Bno","ATIRequestTime","ATIResponseTime","VLRNumber","State","Response","Reason")
	);
	
	
	public function getColumns(){
		$result = array();
		for($i=0; $i<count($this->_db_table_details[$this->_table]); $i++){
			$result[$i] = $this->_db_table_details[$this->_table][$i];
		}
		return $result;
	}
	
	public function setTable($table){
		$this->_table = $table;
	}
	
	public function __construct() {
	
		$this->_dbconnect = mysql_connect(self::DB_HOST,self::DB_USER,self::DB_PASSWORD);
		if ($this->_dbconnect) {
			$db =  mysql_select_db(self::DB_NAME,$this->_dbconnect);
		} else {
			die(mysql_error());
		}
		$this->_page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$this->_offset = ($this->_page - 1) * $this->_limit;
   //echo "requestdate:".$_REQUEST['startdate'].$_REQUEST['enddate'].$_REQUEST['page'];
    $this->_startdate = (isset($_REQUEST['startdate']) && !empty($_REQUEST['startdate']))?$_REQUEST['startdate']:null;
    $this->_enddate = (isset($_REQUEST['enddate']) && !empty($_REQUEST['enddate']))?$_REQUEST['enddate']:null;
    //echo $this->_startdate.$this->_enddate;
	}
	
	private function total() {
		
		if($this->_table == 'rules'){
			$pk = $this->_db_table_details[$this->_table][0];
			$whereColumn = $this->_db_table_details[$this->_table][3];

			$query = "SELECT COUNT(*) total from rules a JOIN status b ON a.state = b.id 
									JOIN vlrs f ON a.vlr = f.id";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			return $row['total'];
		}
		else if($this->_table == 'CallLog'){
				if($this->_startdate == null && $this->_enddate == null){
					$query = "SELECT COUNT(*) total from CallLog";
				}
				  else{
					$query = "SELECT COUNT(*) total from CallLog where ATIRequestTime >= '$this->_startdate' && ATIRequestTime <= '$this->_enddate'";
				  }
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			return $row['total'];
		}
   else if($this->_table == 'dailysummary'){
      if($this->_startdate == null && $this->_enddate == null){
			  $query = "SELECT COUNT(*) total from dailysummary";
      }
      else{
        $query = "SELECT COUNT(*) total from dailysummary where date >= '$this->_startdate' && date <= '$this->_enddate'";
      }
		 
      $result = mysql_query($query);
			$row = mysql_fetch_array($result);
			return $row['total'];
   }
		else{		
			$pk = $this->_db_table_details[$this->_table][0];
			$query = "SELECT COUNT($pk) AS total FROM $this->_table";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			return $row['total'];
		}
	}
	
	public function get() {
		$orderByColumns = $this->_db_table_details[$this->_table][0];
		if($this->_table == 'rate'){
			$query = mysql_query("SELECT * FROM rate ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		if($this->_table == 'cells'){
			$query = mysql_query("SELECT c.id,c.cellid,c.userid,u.username,c.updated FROM cells c,user u where c.userid = u.userid ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		elseif($this->_table == 'geo_locations'){
			$query = mysql_query("SELECT c.id,c.gloc_id,c.userid,u.username,c.updated FROM geo_locations c,user u where c.userid = u.userid ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		elseif($this->_table == 'locations'){
			$query = mysql_query("SELECT c.id,c.loc_no,c.userid,u.username,c.updated FROM locations c,user u where c.userid = u.userid ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		elseif($this->_table == 'status'){
			$query = mysql_query("SELECT c.id,c.status,c.userid,u.username,c.updated FROM status c,user u where c.userid = u.userid ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		elseif($this->_table == 'vlrs'){
			$query = mysql_query("SELECT c.id,c.vlr_no,c.userid,u.username,c.updated FROM vlrs c,user u where c.userid = u.userid ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		elseif($this->_table == 'rules'){
			$query = mysql_query("SELECT a.id,a.ano,a.bno,b.status state,f.vlr_no vlr,a.Decission FROM 
									rules a JOIN status b ON a.state = b.id 
									JOIN vlrs f ON a.vlr = f.id
									ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		}
		else{
      //echo "startenddate".$this->_startdate.$this->_enddate;
      
      if($this->_startdate == null && $this->_enddate == null){
			  $query = mysql_query("SELECT * FROM $this->_table ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
      }
      else{
      //$this->_startdate = $this->_startdate." 00:00:00";
      //$this->_enddate = $this->_enddate." 24:00:00";
        $q = "SELECT * FROM $this->_table where DATE(ATIRequestTime) >= '$this->_startdate' && DATE(ATIRequestTime) <= '$this->_enddate' ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit";
       // echo $q;
        $query = mysql_query($q);
      }
		}
		$result = array();
		$i = 0;
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res;
			$i++;
		}
		return $result;
	}
  public function getSummaryReport(){
	 
		$result = array();
		$i = 0;
   if($this->_startdate == null){
      $this->_startdate = '1969-31-01';
   }
   if($this->_enddate == null){
      $this->_enddate = '2090-31-01';
   }
  // $this->_startdate = $this->_startdate." 00:00:00";
   //   $this->_enddate = $this->_enddate." 24:00:00";
  /*$query_raw="SELECT count(*) as total_continue FROM $this->_table where DATE(ATIRequestTime) >= '$this->_startdate' && DATE(ATIRequestTime) <= '$this->_enddate' && RESPONSE = 'CONTINUE'";
   	$query = mysql_query($query_raw);
   
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res['total_continue'];
		//	$i++;
		}
   
   $query = mysql_query("SELECT SUM(dailysummary.continue) AS continues FROM dailysummary where date >= '$this->_startdate' && date <= '$this->_enddate'");
   
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $result[$i] + $res['continues'];
			$i++;
		}
   $query = mysql_query("SELECT count(*) as total_release FROM $this->_table where DATE(ATIRequestTime) >= '$this->_startdate' && DATE(ATIRequestTime) <= '$this->_enddate' && RESPONSE = 'RELEASE'");
   while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res['total_release'];
		//	$i++;
		}
   $query = mysql_query("SELECT SUM(dailysummary.release) AS releases FROM dailysummary where date >= '$this->_startdate' && date <= '$this->_enddate'");
   
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $result[$i] + $res['releases'];
			$i++;
		}
   $result[$i] = $result[$i-1] + $result[$i-2];   
	 return $result;*/
   $q = "SELECT * FROM dailysummary where date >= '$this->_startdate' && date <= '$this->_enddate' ORDER BY date DESC LIMIT $this->_offset,$this->_limit";
        //echo $q;
    $query = mysql_query($q);
   	$result = array();
		$i = 0;
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res;
			$i++;
		}
		return $result;
   
	}
	public function getalldatabytablename($tablename){
		$query = mysql_query("SELECT * FROM $tablename");
		$result = array();
		$i = 0;
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res;
			$i++;
		}
		return $result;
	}
	
	public function getByColumn($colIndex, $colValue) {
		$orderByColumns = $this->_db_table_details[$this->_table][0];
		$whereColumn = $this->_db_table_details[$this->_table][$colIndex];
		$query = mysql_query("SELECT * FROM $this->_table WHERE $whereColumn = $colValue ORDER BY $orderByColumns DESC LIMIT $this->_offset,$this->_limit");
		$result = array();
		$i = 0;
		while($res = mysql_fetch_assoc($query)){
			$result[$i] = $res;
			$i++;
		}
		return $result;
	}
	
	public function delete($id){
	
		include "config.php";
		$ids = is_array($id) ? implode(',', $id) : $id;
		$pk = $this->_db_table_details[$this->_table][0];
		$query = mysql_query("DELETE FROM $this->_table WHERE $pk IN ($ids)");		
		return $this->result($query);
	}
	public function insert($data) {


		date_default_timezone_set("Asia/Dhaka");
		$currentdate = date('Y-m-d H:i:s');




		if($this->_table == 'rules'){
			$keys = implode(',', array_keys($data)).",created";	
			$values = "'" . implode("','", array_values($data)) . "','" . $currentdate. "'";
			//Filter out primary key column from both of key and value as PK id will auto increment 
			$keys = substr($keys, (strpos($keys,",")+1));
			$values = substr($values, (strpos($values,",")+1));
			$q = "INSERT INTO $this->_table ($keys) VALUES ($values)";
			$query = mysql_query($q);
			//echo "query:".$q;
			$this->writetofile();
			//return $this->result($query);
			
		}
		elseif($this->_table == 'cells' || $this->_table == 'geo_locations'|| $this->_table == 'locations'|| $this->_table == 'status'|| $this->_table == 'vlrs'){
			
			$keys = implode(',', array_keys($data)).",userid,updated";	
			$keys = substr($keys, (strpos($keys,",")+1));
			$values = "'" . implode("','", array_values($data))."','" . $_SESSION["LoggedInUserID"]. "'" . ",'" . $currentdate. "'";
			$values = substr($values, (strpos($values,",")+1));
			//echo "keys:".$keys."datas: ".$values;
			$q = "INSERT INTO $this->_table ($keys) VALUES ($values)";
			$query = mysql_query($q);
		//echo "query:".$q; exit($q);
			return $this->result($query);
		}
		else{
			$keys = implode(',', array_keys($data));
			$values = "'" . implode("','", array_values($data)) . "'";
			//Filter out primary key column from both of key and value as PK id will auto increment 
			$keys = substr($keys, (strpos($keys,",")+1));
			$values = substr($values, (strpos($values,",")+1));
			$q = "INSERT INTO $this->_table ($keys) VALUES ($values)";
			$query = mysql_query($q);
			//echo "query:".$q;
			//$query = mysql_query("INSERT INTO $this->_table ($keys) VALUES ($values)");
			return $this->result($query);
		}
	}
	
	public function update($data) {

		date_default_timezone_set("Asia/Dhaka");
		$currentdate = date('Y-m-d H:i:s'); 
		if($this->_table == 'rules'){
			$pk = $this->_db_table_details[$this->_table][0];
			$id = $data[$pk];
			unset($data[$id]);

			$query = "UPDATE $this->_table SET ";
			foreach ($data as $key => $value) {
				$params[] = $key." = '".trim($value)."'";
			}
			$params[] = 'updated'." = '".$currentdate."'";
			$query .= implode(',', $params)." WHERE $pk = $id";
			//echo $query;
			mysql_query($query);
			$this->writetofile();
			
		}
		if($this->_table == 'cells' || $this->_table == 'geo_locations'|| $this->_table == 'locations'|| $this->_table == 'status'|| $this->_table == 'vlrs'){
			$pk = $this->_db_table_details[$this->_table][0];
			$id = $data[$pk];
			unset($data[$id]);
			$query = "UPDATE $this->_table SET ";
			foreach ($data as $key => $value) {
				$params[] = $key." = '".$value."'";
			}
			$params[] = 'updated'." = '".$currentdate."'";
			$query .= implode(',', $params)." WHERE $pk = $id";
			return $this->result(mysql_query($query));
		}
		else{
			$pk = $this->_db_table_details[$this->_table][0];
			$id = $data[$pk];
			unset($data[$id]);
			$query = "UPDATE $this->_table SET ";
			foreach ($data as $key => $value) {
				$params[] = $key." = '".$value."'";
			}
			$query .= implode(',', $params)." WHERE $pk = $id";
			return $this->result(mysql_query($query));
			
		}
		
	}
	
	private function result($q) {
		return $q ? true : false;
	}
	
	public function paginate() {
 
		$this->_tpages = ceil($this->total()/$this->_limit);
   //echo "output".$this->_page.$this->_adj.$this->_tpages;
		$out = '<div class="pagin green">';
		if($this->_page == 1) {
			$out .= "<span>$this->_prev_lbl</span>";
		} else {
			$out .= "<a href='javascript:void(0);' id='".($this->_page-1)."'>$this->_prev_lbl</a>";
		}
		$out.= ($this->_page>($this->_adj+1)) ? "<a href='javascript:void(0);' id='1'>1</a>" : '';
		($this->_page>($this->_adj+2)) ? $out.= "...\n" : '';
		$pmin = ($this->_page>$this->_adj) ? ($this->_page-$this->_adj) : 1;
		$pmax = ($this->_page<($this->_tpages-$this->_adj)) ? ($this->_page+$this->_adj) : $this->_tpages;
    //echo "minmax".$pmin.$pmax;
		for($i=$pmin; $i<=$pmax; $i++) {
			if($i==$this->_page) {
				$out.= "<span class='current'>$i</span>";
			}else {
				$out.= "<a href='javascript:void(0);' id='$i'>$i</a>";
			}
		}
		($this->_page<($this->_tpages-$this->_adj-1)) ? $out.= "...\n" : '';
		($this->_page<($this->_tpages-$this->_adj))? $out.= "<a href='javascript:void(0);' id='$this->_tpages'>$this->_tpages</a>" : '';
		if($this->_page<$this->_tpages) {
			$out.= "<a href='javascript:void(0);' id='".($this->_page+1)."'>$this->_next_lbl</a>";
		}else {
			$out.= "<span>$this->_next_lbl</span>";
		}
		$out.= "</div>";
		return $out;
	}
	
}
?>