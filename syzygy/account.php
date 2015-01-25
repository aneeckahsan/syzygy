<?php 
$action = (isset($_REQUEST['action']) && !empty($_REQUEST['action']))?$_REQUEST['action']: NULL;
if(empty($action)) {
	session_start(); 
	include_once "commonlib.php";
	scatterVars($_SESSION);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Doze</title>
<link href="css/style2.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="livetable/style.css" />
<script type="text/javascript" src="livetable/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="livetable/script.js"></script>

<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="ie8.css" />
<![endif]-->
</head>
<body>
<?php include("header.php"); ?>
<div class="conarea">
  <div class="contentarea">
    <div class="aboutbl">
		<div id="outer_container">
			<div id="loader"><img src="livetable/loader.gif"></div>
			<div id="data" style="position:relative;">
			<?php } ?>
			<?php if(empty($action)) {?>
			</div>
			</div>
			</div>
			</div>
			<?php include("footer.php"); ?>
			</body>
			</html>
			<?php }
			if($action == 'ajax' || $action == 'update' || $action == 'delete') {
				require_once 'livetable/database.php';
				$db = new Database;
				function getTable() {
					GLOBAL $db;
					$data = '<form><table width="90%" cellspacing="0" cellpadding="2" align="center" border="0" id="data_tbl">
							<thead>
							<tr>
							<th width="5%"><input type="checkbox" class="selall"/></th>
							<th width="20%">Name</th>
							<th width="25%">Email</th>
							<th width="17%">Country</th>
							<th width="18%">Mobile</th>
							<th width="15%">Action</th>
						  </tr>
						 </thead>
						 <tbody>';
					$i = 1;
					$cls = false;
					foreach ($db->get_users() as $value) {
						$bg = ($cls = !$cls) ? '#ECEEF4' : '#FFFFFF';
						$data .='<tr style="background:'.$bg.'">
							<td><input type="checkbox" class="selrow" value="'.$value['id'].'"/>
								<input type="hidden" value="'.$value['id'].'" name="id" />
							</td>
							<td><span class="name">'.$value['name'].' </span></td>
							<td><span class="email">'.$value['email'].'</span></td>
							<td><span class="country">'.$value['country'].'</span></td>
							<td><span class="mobile">'.$value['mobile'].'</span></td>
							<td align="center">
								<img src="livetable/edit.png" class="updrow" title="Update"/>&nbsp;
								<img src="livetable/delete.png" class="delrow" title="Delete"/>
							</td>
						  </tr>';
						$i++;
					}
					$data .='</tbody>
						</table></form>
						<div id="paginator">'.$db->paginate().'<button class="delall">Delete Selected</button>'.'</div>';
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
				}
			}
			?>
		</div>	
	</div>
   <div class="cls">
  </div>
</div>
