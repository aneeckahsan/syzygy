<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Form Sample</title>
<link rel="stylesheet" href="../css/style2.css">
<!--<script type="text/javascript" src="/script/jquery.watermarkinput.js"></script>-->
<link href="../css/style2.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link href="../css/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="../css/admin.css" rel="stylesheet" type="text/css" media="all,handheld" />
<link rel="stylesheet" media="screen" type="text/css" href="../css/datepicker.css" />

<link rel="stylesheet" href="development-bundle/themes/cupertino/jquery.ui.all.css">
<script src="../js/jquery-1.8.0.js"></script>
<script type="text/javascript" src="../js/jquery-ui-sliderAccess.js"></script>
<script src="../development-bundle/ui/jquery.ui.core.js"></script>
<!-- datepicker -->
<link rel="stylesheet" href="development-bundle/demos/demos.css">
<script src="../development-bundle/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../js/datetimepicker.js"></script>
<script type="text/javascript" src="../js/datepicker.js"></script>
<script type="text/javascript" src="../js/jquery-ui-timepicker-addon.js"></script>
<!-- end datepicker -->
<script type="text/javascript" src="../js/ajax-validation.js"></script>
<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
</head>
<body>

<!--<form id="sampleform" action="example.php"> 
   <label for="name">test: <em>*</em></label>    
				<input id="test" name="test" class="text" type="text" maxlength="250" />
				<span class="error"></span>
	<fieldset>    
		<legend><span>Contact Details</span></legend>        
		<ol>
			<li>    
				<label for="name">Name: <em>*</em></label>    
				<input id="name" name="name" class="text" type="text" maxlength="250" />
				<span class="error"></span>			</li>    
			<li>    
				<label for="email">Email: <em>*</em></label>    
				<input id="email" name="email" class="text" type="text" maxlength="250" />
				<span class="error"></span>			</li>
			<li>    
				<label for="about">About me:</label>    
				<textarea id="about" name="about"></textarea>
				<span class="error"></span>			</li>
			<li>
				<label>Gender:</label>
				<fieldset>        
					<ol>        
						<li>        
							<input id="gender1" name="gender" class="radio" type="radio" value="1" checked="checked"/>        
							<label for="gender1">Male</label>        
						</li>        
						<li>        
							<input id="gender2" name="gender" class="radio" type="radio" value="1" />        
							<label for="gender2">Female</label>
						</li> 
					</ol>
				</fieldset> 
			</li>			
			<li>
				<label>Interest:</label>
				<fieldset>        
					<ol>        
						<li>        
							<input id="interest1" name="interest[]" class="checkbox" type="checkbox" value="1" />        
							<label for="interest1">Food</label>						
						</li>        
						<li>        
							<input id="interest2" name="interest[]" class="checkbox" type="checkbox" value="1" />        
							<label for="interest2">Sports</label>        
						</li>        
						<li>        
							<input id="interest3" name="interest[]" class="checkbox" type="checkbox" value="1" />        
							<label for="interest3">Fashion</label>        
						</li>        
						<li>        
							<input id="interest4" name="interest[]" class="checkbox" type="checkbox" value="1" />        
							<label for="interest4">Art</label>							
						</li>        
					</ol>        
				</fieldset> 
			</li>
		</ol>		
	</fieldset>    
	<fieldset class="alt">    
		<legend><span>Delivery Address</span></legend>
		<ol>
			<li>    
				<label for="address1">Address 1:</label>    
				<input id="address1" name="address1" class="text" type="text" maxlength="250" /> 
				<span class="error"></span>			</li>    
			<li>    
				<label for="address2">Address 2:</label>    
				<input id="address2" name="address2" class="text" type="text" maxlength="250" />    
			</li>    
			<li>    
				<label for="suburb">City:</label>    
				<input id="suburb" name="city" class="text" type="text" maxlength="250" />
				<span class="error"></span>			</li>    
			<li>    
				<label for="postcode">Postcode:</label>    
				<input id="postcode" name="postcode" class="text" type="text" maxlength="10" />
				<span class="error"></span>			</li>    
			<li>    
				<label for="country">Country:</label>
				<select id="country" name="country">
					<option value="Malaysia">Malaysia</option>
					<option value="Singapore">Singapore</option>
					<option value="Thailand">Thailand</option>
					<option value="Indonesia">Indonesia</option>
					<option value="Philippines">Philippines</option>
				</select>  
			</li>
		</ol>
	</fieldset>    
	   
		<input class="submit" type="submit" value="Submit" />    
	
</form>  

<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			test: { required:true },
			name: { required:true },
			email: { required:true, email:true },
			about: { required:true },
			address1: { required:true },
			postcode: { required:true, minlength:4, maxlength:8, number:true },
			city: { required:true }
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
});
</script>-->
<form id="sampleform" action="example.php"> 
   <label for="name">test: <em>*</em></label>    
	<input id="test" name="test" class="text" type="text" maxlength="250" />
	<span class="error"></span>
	<br />
	<input class="submit" type="submit" value="Submit" />    
</form>
<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			test: { required:true }
			
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
});
</script>

</body>
</html>

 