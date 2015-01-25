<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Balance Check</title>
		<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
		<meta content="utf-8" http-equiv="encoding">
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

		
		<script type="text/javascript">
			function balanceCheck(){
				/*var url = "http://api.silverstreet.com/creditcheck.php?username=ssdhq&password=q01J2GAW";
				if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				  
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState==4 && xmlhttp.status==200){
						console.log("Response Text: " + xmlhttp.responseText);
					}
					else{
						console.log("Error occurred");
					}
				} 
				 
				xmlhttp.open("POST",url,false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.send();*/
				//xmlDoc=xmlhttp.responseXML;
				//console.log(xmlDoc);
				$.ajax({		
						type: "POST",
						//url: "http://api.silverstreet.com/creditcheck.php?username=ssdhq&password=q01J2GAW",
						url: ROOTURL + "xmlphp.php",
						/*
						//dataType: "jsonp",
						//contentType: "application/xml; charset=ISO-8859-1",
						//async: false,
						//contentType: "text/xml; charset=\"utf-8\"",*/
						complete: function(xmlResponse) {
							alert(xmlResponse.responseText);
							// So you can see what was wrong...
							//console.log("why???");
							//obj = JSON && JSON.parse(xmlResponse.responseText) || $.parseJSON(xmlResponse.responseText);
							
							//console.log(xmlResponse);
							//var xmlDoc = xmlResponse.responseXML; 
							//var id = xmlDoc.getElementsByTagName("balance").nodeValue;
							//alert(id);
							//$(xml).find("balance").each(function(){
							//	alert($(this).text());
							//   });
						  
						}
						/*success: function(xmlResponse){
							alert("inside success block");
							$(xml).find("balance").each(function(){
								alert($(this).text());
							});	
						}
						//alert("out of success");
						/*success: function(xml){
							 $(xml).find("balance").each(function(){
								alert($(this).text());
							   });
							
						},
						error: function(value) {
							alert("error occurred: "+value);//console.log(value);
						}*/
				});
			}
			
		</script>		
	</head>

	<body onload="balanceCheck();"></body>
	
</html>

