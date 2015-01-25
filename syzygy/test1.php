<?php
session_start();
include "commonlib.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SMS Doze</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript">
	function attach(){
		document.getElementById('fileinput').addEventListener('change', readSingleFile, false);
	}
	function readSingleFile(evt){
		var f = evt.target.files; 
		var lastindex = f.length - 1;
		var f = evt.target.files[lastindex];
    		if (f){
			var r = new FileReader();
        		r.onload = function(e){document.getElementById('txtContactList').value = e.target.result;}
			r.readAsText(f);
    		}
		else
			alert("Failed to load file");
	}
	function submitfile(){
		$("#loader").fadeIn('slow');

		$.ajax({		
			type: "POST",
			url: "<?php echo $ROOTURL ?>" + "test.php",
			data: {txtContactList:$('#txtContactList').val(),userid:"<?php echo $_SESSION["LoggedInUserID"];?>"},
			async:false,
			success: function(value){
				//if(value!="0") document.getElementById("role").innerHTML += value;
				//else 
				alert("In success.");
			},
			error: function(value) {alert("Error occurred: "+value);}
		});
		$("#loader").fadeOut('slow'); 

	}
</script>
	
</head>
<body onload="attach();">
	<form ><!--method="post" action="test.php"-->
		<input type="file" id="fileinput" name="files[]"  multiple /><br />
		<textarea name="txtContactList"  id="txtContactList" cols="30" rows="5"></textarea><br />
		<input type="button" value="Submit Form" onclick="submitfile();"/>
	</form>
</body>
</html>