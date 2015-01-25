<?php
$qry="select MenuID, Parent, MenuLabel, URL, RootWidth, LabelWidth from menudef order by DisplayOrder";
$rs=Sql_exec($cn, $qry);
$n=Sql_Num_Rows($rs);
?>
<script language="JavaScript">
function changeColor() {
  var i,j=0,x,a=changeColor.arguments; 
  document.getElementById(a[0]).color=a[1];
}

function mmLoadMenus() {
<?php
//2b4b60
for($i=0; $i<$n; $i++) {
	$mnuItems=Sql_fetch_array($rs);
	if($mnuItems["Parent"]=="Root") {
		echo("window.".$mnuItems["MenuID"]." = new Menu(\"root\",".$mnuItems["RootWidth"].",20,\"$MENU_FONT\",12,\"$MENU_TXT\",\"$MENU_HOVER_TXT\",\"$MENU_BG\",\"$MENU_HOVER_BG\",\"left\",\"middle\",3,0,1000,-5,7,true,true,true,0,true,true);\r\n");
	}else {
		echo($mnuItems["Parent"].".addMenuItem(\"".$mnuItems["MenuLabel"]."\",\"location='".$mnuItems["URL"]."'\");\r\n");
	}
}

?>
  window.mm_dummy = new Menu("root",93,16,"Verdana, Arial, Helvetica, sans-serif",10,"<?php echo($MENU_TXT);?>","<?php echo($MENU_HOVER_TXT);?>","<?php echo($MENU_BG);?>","<?php echo($MENU_HOVER_BG);?>","left","middle",3,0,1000,-5,7,true,true,true,0,true,true);
  mm_dummy.addMenuItem("Dummy 1","location='#'");
  mm_dummy.addMenuItem("Dummy 2","location='#'");

  mm_dummy.writeMenus();
}
</script>
<script language="JavaScript1.2" src="mm_menu.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>
<table border="1" cellpadding="2" cellspacing="0" style="border-collapse: collapse" bordercolor="#FFE6A4" width="100%">
<tr>
<td bgcolor="<?php echo($MENU_BG);?>">
<table border="0" cellpadding="0" cellspacing="0">
  <tr>
<?php
Sql_Data_Seek($rs, 0);
for($i=0; $i<$n; $i++) {
	$mnuItems=Sql_fetch_array($rs);
	if($mnuItems["Parent"]=="Root") {
?>
<td bgcolor="<?php echo($MENU_BG);?>" height="30" width="<?php echo($mnuItems["LabelWidth"]);?>">
<a name="<?php echo($mnuItems["MenuID"]);?>" onMouseOut="changeColor('f<?php echo($mnuItems["MenuID"]);?>','<?php echo($MENU_TXT);?>');MM_startTimeout();" onMouseOver="MM_showMenu(window.<?php echo($mnuItems["MenuID"]);?>,0,24,null,'<?php echo($mnuItems["MenuID"]);?>');changeColor('f<?php echo($mnuItems["MenuID"]);?>','<?php echo($MENU_HOVER_TXT);?>');"><font id="f<?php echo($mnuItems["MenuID"]);?>" size="2" face="<?php echo($MENU_FONT);?>" color="<?php echo($MENU_TXT);?>"><?php echo($mnuItems["MenuLabel"]);?></font>
</a></td>
<?php	}
}
?>
  </tr>
</table>
</td>
</tr>
</table>