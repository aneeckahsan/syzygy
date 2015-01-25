<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>DIGICON : CQ Audit System</title>
<script src="script/jquery.tools.1.2.6.full.min.js"></script>
<script type="text/javascript" src="/script/jquery.watermarkinput.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link href="css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/admin.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link rel="stylesheet" media="screen" type="text/css" href="css/datepicker.css" />
<link rel="stylesheet" href="development-bundle/themes/cupertino/jquery.ui.all.css">
<script src="js/jquery-1.8.0.js"></script>
<script src="development-bundle/ui/jquery.ui.core.js"></script>
	
<script src="development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="development-bundle/demos/demos.css">
<script type="text/javascript" src="js/datepicker.js"></script>
<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript" src="js/datetimepicker.js"></script>
<script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" language="javascript">

		$(function() {
		$( "#FromDate" ).datepicker({
			options : true,
			dateFormat : "yy-mm-dd 00:00:00"});
		$( "#ToDate" ).datepicker({
			options : true,
			dateFormat : "yy-mm-dd 00:00:00"});
		
	});
        $(document).ready(function() {
            $("#testButton").click(function() {
                alert("Test");
            });
            $("#tabs").tabs();
            $('#minimalist-table1').dataTable({
                "sDom": 'T<"top"lp>rt<"bottom"i><"clear">',
                "oTableTools": {
                    "aButtons": [
							"copy",
							"print",
							{
							    "sExtends": "collection",
							    "sButtonText": "Save",
							    "aButtons": ["csv", "xls", "pdf"]
							}
						]
                }
            });
            $('#minimalist-table2').dataTable(
        {
            "sDom": 'T<"top"lp>rt<"bottom"i><"clear">',
            "oTableTools": {
                "aButtons": [
							"copy",
							"print",
							{
							    "sExtends": "collection",
							    "sButtonText": "Save",
							    "aButtons": ["csv", "xls", "pdf"]
							}
						]
            }
        });
        });
    </script>
</head>
<body class="bg">
<div id="overall" class="admin">
<div id="header" style="padding-top:0;height:105px;">
  <div class="clear" id="hm_menu"> <a href="/"><img src="img/logo.jpg" width="133" height="60" alt="logo" class="left" style="margin:24px 0 0 30px;" /></a>
    <div class="right" style="margin:30px 30px 0 0;"> 
	<span class="txt_bold txt_black">Welcome <?php echo $Logname; ?></span> | <a href="<?php echo $logoutAction ?>" class="txt_adminLinks">sign out</a>
	 </div>
  </div>
  <div style="background-color:#003300;height:5px;"></div>
  <div style="background:url(img/share_shadow.png) repeat-x #FFF;height:5px;"></div>
</div>
<div id="mid_container" class="clear">
<div class="top_info">
  <div id="breakcrumb"><a href="DailyHeader.php" class="txt_adminLinks">home</a> | call audit system</div>
</div>
<div id="mid_info" class="clear" style="padding-bottom:50px;overflow:auto;">

 </div>

<div id="colright">
 <h2>SMS Portal</h2>
<div>

<?php
include $MENU;
?>

</div>

<div>
<?php
include $FORM;
?>

</div>
 <div style="padding-bottom:50px;overflow:auto;">

<div style="padding-bottom:50px;overflow:auto;">  

  </div>
  </div>
  </div>
  <div id="footer" class="clear"> <img src="img/f_left.png" alt="" width="4" height="72" class="left" />
    <div class="left fm_info">
      <div style="height:20px;"></div>
      <div class="copyright clear">© 2012 Digicon Technologies Ltd. All rights reserved.</div>
    </div>
    <img src="img/f_right.png" alt="" width="4" height="72" class="right" /> </div>

</div>

</body>
</html>

