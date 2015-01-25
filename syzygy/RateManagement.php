<?php
include_once "commonlib.php";
session_start(); //echo $_SESSION["LoggedInUserID"].", ".$_SESSION["LoggedInAccountID"].", ".$SUPERADMIN_ACCOUNTID;exit;
if(!isset($_SESSION["LoggedInUserID"]))header('Location: index.php');
if($_SESSION["LoggedInAccountID"] != $SUPERADMIN_ACCOUNTID) header('Location: index.php'); 

$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
mysql_select_db($MYDB);

$tableName = 'rate';
$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action']))?$_REQUEST['action']: NULL;
if(empty($action)) {

	//scatterVars($_SESSION);
?>

<?php include 'templates/header.php';?>
<div id="loader" ><img src="livetable/loader.gif"></div>
<div id="page-wrapper">
<div class="container-fluid">
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Rate
		</h1>
		<ol class="breadcrumb">
			<li><a href="http://localhost/syzygy/index.php">Dashboard</a></li>
			<li class="active">Rate</li>
		</ol>
	</div>
</div>
<div id="data" style="position:relative;">
						<?php } ?>

						<?php if(empty($action)) {?>
	</div>
	</div>
	</div>
	</div>
	<!--</div>
	</div>-->
	<?php include("footer.php"); ?>
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
			    <th width="5%"><input type="checkbox" class="selall"/></th>
				
				<th width="25%">'.strtoupper($columns[1]).'</th>
			    <th width="25%">'.strtoupper($columns[2]).'</th>
			    <th width="17%">'.strtoupper($columns[3]).'</th>
				
				<th width="10%">Action</th>
			  </tr>
			 </thead>
			 <tbody>';
		$i = 1;
		$cls = false;
		foreach ($db->get() as $value) {
			$bg = ($cls = !$cls) ? '#ECEEF4' : '#FFFFFF';
			$data .='<tr style="background:'.$bg.'">
			    <td><input type="checkbox" class="selrow" value="'.$value[$columns[0]].'"/>
					<input type="hidden" value="'.$value[$columns[0]].'" name="'.$columns[0].'" />
				</td>
				
			    <td class="editable"><span class="'.$columns[1].'">'.$value[$columns[1]].' </span></td>
			    <td class="editable"><span class="'.$columns[2].'">'.$value[$columns[2]].'</span></td>
			    <td class="editable"><span class="'.$columns[3].'">'.$value[$columns[3]].'</span></td>

						
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

