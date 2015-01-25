<head>
<?php 
include("included/checkboxtreeandjpages.php");

checkPrivilegePermission($ViewScheduleSms);
?>
<style type="text/css">
#finalList{
	/*border-style:solid;
	border-width:2px;
	vertical-align:middle;*/
}
</style>  
</head>

<div class="cls"></div>
<div id="viewschedule">
<?php 
		$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
		$query = "select * from schedulesmsschedule where userid= '$LoggedInUserID' and scheduletype='auto'";
		$rs=mysql_query($query, $cn);
		
?>
	<ul>
		<li style="width: 15em; display: inline-block;"><h1>Schedule Date</h1></li>
		<li style="width: 19em; display: inline-block;"><h1>Schedule Time</h1></li>
		<li style="width: 15em; display: inline-block;"><h1>Interval</h1></li>
		<li style="width: 20em; display: inline-block;"><h1></h1></li>
	</ul>
	
	<ul id="finalList">
		<?php 
		while($dt=mysql_fetch_array($rs)){
		?>
	<ul>

		<li style="width: 15em;"><p style="font-family:verdana;"><?php echo $dt['scheduledate'];?></p></li>
		<li style="width: 15em;"><p style="font-family:verdana;"><?php echo $dt['scheduletime'];?></p></li>
		<li style="width: 15em;"><p style="font-family:verdana;"><?php echo $dt['occursoption'];?></p></li>
		<li style=""><a href='<?php echo $ROOTURL ?>index.php?FORM=forms/frmScheduleSms.php&mode=edit&scheduleid=<?php echo $dt['scheduleid'];?>' onclick="">Modify</a></li>
	</ul>		
	<?php }?>			
	</ul>
	<div class="holder"></div>		
</div>
<!--<input type="button" class="sbtn" value="Add" onclick="clickonaddbutton();"/>-->

<script>
$(document).ready(function() {
	$("div.holder").jPages({
        containerID: "finalList",
        perPage: 5,
        keyBrowse: true,
        scrollBrowse: true,
        animation: "bounceInUp",
       
    });
});


</script>