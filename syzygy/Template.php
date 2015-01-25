<?php
echo 'testing'; exit;
/*session_start();
if(!isset($_SESSION["LoggedInUserID"])) header('Location: index.php');

//include_once "commonlib.php";

checkPrivilegePermission($Template);
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
mysql_select_db($MYDB);

$tableName = 'template';
$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action']))?$_REQUEST['action']: NULL;*/
if(empty($action)) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>SMS Doze</title>

<!--MY CONSTANTS and COMMON JS FILES-->
<script type="text/javascript" src="js/constants.js"></script>
<script type="text/javascript" src="js/common.js"></script>

<!--Bootstrap-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/sb-admin.css" rel="stylesheet">
<link href="css/plugins/morris.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="wapper">
	<div class="topmenu">
		<ul>
			<li>Welcome <?php echo $_SESSION["LoggedInUserName"]; ?></li>
			<li>|</li>
			<li><a href="log-out.php">Log Out</a></li>
		</ul>
	</div>
	<!--div class="nav">
		<div class="logo"><a href="home.php"><img src="images/logo.png" width="151" height="76" border="0" /></a></div>
		<div class="menu">
			<ul>
			  	<?php 
				/*session_start();
	  			if ($IsLoggedIn == 'YES'){
	  				echo "<li ";
	  				if($curent_file_name=='index.php') { 
	  					echo "class='current'" ;
	  					$LoggedInUserID =  $_SESSION["LoggedInUserID"];
	  				} 		  		
	  				echo "><a href='index.php'>Home</a></li>";
	  			}	  	
	  			else{
	  				echo "<li ";
	  				if($curent_file_name=='home.php') { 
	  					echo "class='current'" ;
	  				} 			  		
	  				echo "><a href='home.php'>Home</a></li>";
	  			}*/
				?>
				<li <?php //if($curent_file_name=='about-us.php') { ?>class="current" <?php } ?>><a href="about-us.php">About Us</a></li>
				<li <?php //if($curent_file_name=='rates-coverage.php') { ?>class="current" <?php } ?>><a href="rates-coverage.php">Rates & Coverage </a></li>
				<li <?php //if($curent_file_name=='services.php') { ?>class="current" <?php } ?>><a href="services.php">Services</a></li>
				<li <?php //if($curent_file_name=='api-demo.php') { ?>class="current" <?php } ?>><a href="api-demo.php">API & Demo </a></li>
				<li <?php //if($curent_file_name=='contact.php') { ?>class="current" <?php } ?>><a href="contact.php">Contact</a></li>
			</ul>
		</div>
	</div-->
	<div class="shadwow"><img src="images/banner-top-shadow.png" width="960" height="27" /></div>
	<div class="cls"></div>
</div>
<div class="conarea">
	<div class="contentarea">
		<div class="contentarea conadmin">
			<div class="adminnav">  
				<?php
				//include $MENU;
				//include("menu1.php");
				?>
			</div>
			<div class="outer_border">
				<div id="outer_container">
					<div id="loader" ><img src="livetable/loader.gif"></div>
					<div id="data" style="position:relative;">
						<?php } ?>

						<?php if(empty($action)) {?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php //include("footer.php"); ?>
</body>
</html>
<?php }

if($action == 'ajax' || $action == 'update' || $action == 'delete' || $action == 'insert') {
	require_once 'livetable/database.php';
	$db = new Database;
	$db->setTable($tableName);
	$columns = $db->getColumns();
	function getTable() {
		GLOBAL $db, $columns;	
	$data = '<button class="delall">Delete Selected</button><button class="addnew">Add New</button>
		<form><table width="100%" cellspacing="0" cellpadding="2" align="center" border="0" id="data_tbl">
			<thead>
			  <tr>
			    <th width="5%" name="'.$columns[0].'"><input type="checkbox" class="selall"/></th>				
				<th width="85%" name="'.$columns[1].'">'.strtoupper($columns[1]).'</th>			
				<th width="10%">Action</th>
			  </tr>
			 </thead>
			 <tbody>';
		$i = 1;
		$cls = false;
		foreach ($db->getByColumn(3,$_SESSION["LoggedInUserID"]) as $value) {
			$bg = ($cls = !$cls) ? '#ECEEF4' : '#FFFFFF';
			$data .='<tr style="background:'.$bg.'">
			    <td><input type="checkbox" class="selrow" value="'.$value[$columns[0]].'"/>
					<input type="hidden" value="'.$value[$columns[0]].'" name="'.$columns[0].'" />
				</td>				
			    <td><span class="'.$columns[1].'">'.$value[$columns[1]].' </span></td>						
				<td align="center">
					<img src="livetable/edit.png" class="updrow" title="Update"/>&nbsp;
					<img src="livetable/delete.png" class="delrow" title="Delete"/>
				</td>
			  </tr>';
			$i++;
		}
		$data .='</tbody>
			</table></form>
			<div id="paginator">'.$db->paginate().'</div>';
		return $data;
	}

	if($action == 'ajax') {
		echo getTable();
	} else if($action == 'delete') {
		$db->delete($_REQUEST['id']);
		echo getTable();
	} else if($action == 'update') {
		unset($_REQUEST['action']);
		$db->update($_REQUEST);
	} else if($action == 'insert') {
		unset($_REQUEST['action']);
		$db->insert($_REQUEST);
		echo getTable();
	}
}
?>

