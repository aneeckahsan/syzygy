<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery UI Autocomplete - Default functionality</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<script type="text/javascript">

function formsubmission(){
var formVals = $('#form1').serializeArray();
  var jsonObj = {};

  for (i in formVals){
    jsonObj[formVals[i].name] = formVals[i].value;
	//alert(formVals[i].name + " " + formVals[i].value);
	}
	var submitVals = JSON.stringify(jsonObj); ;
  //var submitVals = $.toJSON({ "data": jsonObj });
//alert(submitVals);

$.ajax({
   type: "POST",
   url: "<?php echo $ROOTURL; ?>" + "forms/ajaxUserManagement.php",
   async: false,
   data: {data:submitVals},
   success: function(data){
		$('#form1').find('.form_result').html(data);
		//obj = JSON && JSON.parse(data) || $.parseJSON(data);alert(obj.txtMobileNo);
		

		//$('#form1').find('.form_result').html(obj.txtMobileNo);
		$.each(obj, function(key, val) {
			//alert(val);
		});
      
	
   },
   complete: function() {},
   error: function(xhr, textStatus, errorThrown) {
     console.log('ajax loading error...');
     return false;
   }
});

}
$(function() {
var availableTags = [];
$( "#tags" ).autocomplete({
source: availableTags
});
});
</script>
</head>
<body>
<table>
<tr>
<td><input id="groupinputbox"></td>
<td><input id="mobileinputbox"></td>
</tr>

<tr>
<td><div style="width:200px;height:300px;overflow:auto;"><li>ahsan</li><li>habib</li></div></td>
<td><div style="width:200px;height:300px;overflow:auto;"><li>ahsan</li><li>habib</li></div></td>
</tr>
</table>
<div class="ui-widget">
<!--<label for="tags">Tags: </label>
<input id="tags">-->
</div>
</body>
</html>