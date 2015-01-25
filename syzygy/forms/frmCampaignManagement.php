<head>
<?php 
include("included/checkboxtreeandjpages.php"); 
//include_once "../config.php";
checkPrivilegePermission($CampaignManagement);
$action = (isset($_REQUEST['mode']) && !empty($_REQUEST['mode']))?$_REQUEST['mode']: NULL;
$campaignid = (isset($_REQUEST['campaignid']) && !empty($_REQUEST['campaignid']))?$_REQUEST['campaignid']: NULL;
?>  
<script type="text/javascript" src="js/constants.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<div class="cls"></div>	
<div class="smsbox">
	<form id="sampleform" method="post" action="forms/qryCampaignManagement.php">
	<?php
	$qry ="select * from smsportal.campaign where campaignid = '$campaignid'";
	$rs = mysql_query($qry,$cn);
	$row=mysql_fetch_array($rs);
	if(!empty($action)) {
		$msg=$row['msg'];
		$status=$row['isactive'];
		$locktime=$row['locktime'];
	}
	else{
		$msg="";
		$locktime="";	
	}
	?>

	<div class="cls"></div>
	<label for="Message">Message</label>
	<label for="smscount" id="SMSCharCount"></label>
	<textarea id="txtMsg" cols="45" rows="5" maxlength="640" oninput="charCount();" ><?php echo $msg;?></textarea>

	<div class="cls"></div>
	<label for="Message">Load from template:</label>
	<div id="templates">
		<select id="templateoptions" style="width:300px;" onchange="loadTemplates();">
			<option value="" >Select a template</option>
			<?php 
			$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
			$query = "select * from template where userid = $LoggedInUserID";
			$value = 'text';
			$text = 'text';
			buildDropDownFromMySQLQuery($cn, $query, $value, $text); 
			?>
		</select>
	</div>

	<div class="cls"></div>
	<?php
	include "contactimport.php";
	?>
	<?php
	$qry ="select * from smsportal.campaignschedule where campaignid = '$campaignid'";//echo "sssssssssssssss";
	$rs = mysql_query($qry,$cn);
	$row=mysql_fetch_array($rs);
	if(!empty($action)) {
		$scheduledate=$row['scheduledate'];
		$scheduletime=$row['scheduletime'];
		$scheduletype=$row['scheduletype'];
		$occursoption=$row['occursoption'];
		$enddate=$row['enddate'];
	}
	else{
		$scheduledate="";
		$scheduletime="";
		$scheduletype="";
		$occursoption="";
		$enddate="";
	}
	?>

	<div class="cls"></div>
	<label for="scheduling">Start date/time: </label>
	<input type="text" class="Date" id="txtScheduleDate" name="txtScheduleDate" value="<?php echo $scheduledate;?>"/>
	<input id="basicExample" type="text" class="time" size="5" value="<?php echo $scheduletime;?>"/>

	<div class="cls"></div>
	<label>Lock time (in min): </label>
	<input type="text" id="txtLockTime" value="<?php echo $locktime;?>"/>

	<div class="cls"></div>
	<label>Barring period:</label>
	<input type="text" id="txtBarringTime" />

	<div class="cls"></div>
	<label>Status: </label>
	<select id="status" name="status">
		<?php 
		if($status == '1') echo '<option value="1" selected>Active</option>';else echo '<option value="1">Active</option>';
		if($status == '0') echo '<option value="0" selected>Inactive</option>';else echo '<option value="0">Inactive</option>';
		?>

	</select>

	<div class="cls"></div>
	<label>Scheduling Mode: </label>
	<select id="autosmsschedule" onchange="showSchedulingOptions();">
		<option value="">Please Select</option>
		<?php 
		if($scheduletype == 'manual') echo '<option value="manual" selected>manual</option>';else echo '<option value="manual">manual</option>';
		if($scheduletype == 'auto') echo '<option value="auto" selected>auto</option>';else echo '<option value="auto">auto</option>';
		?>
	</select>
	
	<div id="auto" style="visibility:hidden;">
		<label>Interval: </label>
		<select id="timeinterval" onchange="showIntervalwiseOptions();">
	     		<option value="">Please Select</option>
	  		<?php
	  		if($occursoption == '1')echo '<option value="1" selected>once</option>';else echo '<option value="1">once</option>';
	  		if($occursoption == '2')echo '<option value="2" selected>daily</option>';else echo '<option value="2">daily</option>';
	  		if($occursoption == '3')echo '<option value="3" selected>weekly</option>';else echo '<option value="3">weekly</option>';
	  		if($occursoption == '4')echo '<option value="4" selected>bi-weekly</option>';else echo '<option value="4">bi-weekly</option>';
	  		if($occursoption == '5')echo '<option value="5" selected>monthly</option>';else echo '<option value="5">monthly</option>';
	  		if($occursoption == '6')echo '<option value="6" selected>quarterly</option>';else echo '<option value="6">quarterly</option>';
	  		if($occursoption == '7')echo '<option value="7" selected>half yearly</option>';else echo '<option value="7">half yearly</option>';
	  		if($occursoption == '8')echo '<option value="8" selected>yearly</option>';else echo '<option value="8">yearly</option>';
	  		?>
		</select>
		
		<div class="cls"></div>
		<label for="scheduling">End date: </label>
		<input type="text" class="Date" id="enddate" name="enddate" value="<?php echo $enddate;?>"/>

	</div>

	<div class="cls"></div>
	<input type="button" value="Save" class="sbtn" onclick="submitOP();"/>
	<input type="button" value="Execute Campaign" class="sbtn" onclick=""/>
</form>
</div>

<script type="text/javascript">

$(function() {
	$("#loader").fadeIn('slow');
	$.ajax({
		type: "POST",
              url: "<?php echo $ROOTURL ?>" + "forms/getphonenumberbycampaign.php",
              data: {campaignid:"<?php echo $campaignid;?>",userid:"<?php echo $LoggedInUserID;?>"},
              success: function(data){
			$("#loader").fadeOut('slow');
			var VariableArray = data.split('&');
			for(var i = 0; i < VariableArray.length-1; i++){
				var KeyValuePair = VariableArray[i].split(',');
				finalListids[KeyValuePair[0]] = finalListid;
				finalListnos[KeyValuePair[0]] = 1;
				finalListid++;							
			}
			searchfromfinallist();
			jpage("searchfromfinallist");
		},
		error: function(data) {
			$("#loader").fadeOut('slow');
			$("#error").dialog("open");	
		}
	});	
});

function submitOP(){
	var locktime = '<?php echo $locktime?>';
	var scheduletime = '<?php echo $scheduletime;?>';
	var scheduledate = '<?php echo $scheduledate;?>';
	var groups = [];

	if('<?php echo $action;?>' == 'edit'){
		var scheduleDateObj =  getDateObjfromString(makedatetime(scheduledate,scheduletime));
		var currentDateObj = new Date();
		alert(scheduleDateObj - currentDateObj);
		alert(scheduleDateObj);alert(currentDateObj );

		if(scheduleDateObj - currentDateObj < 0){
			//do nothing
		}
		else if(scheduleDateObj - currentDateObj < locktime*60*1000){alert("Time Out"); return false;}			
	}

	if($('#txtMsg').val()==''){alert("Please input message"); return false;}
	if($('#txtScheduleDate').val()==''){alert("Please enter start date"); return false;}
	else{
		if($('#basicExample').val() == ''){alert("Please enter start time"); return false;}
	}
	if($('#autosmsschedule').val()==''){alert("Please enter schedule mode"); return false;}
	else if($('#autosmsschedule').val()=='auto'){
		if($('#timeinterval').val()==''){alert("Please enter timeinterval");return false;}
	}
		
	var checkedCheckboxes = $('#tree1 input[type="checkbox"]:checked');
	if(finalListid == 0 && checkedCheckboxes.length == 0){alert("Please enter numbers");return false;}

	for(var i=0, im=checkedCheckboxes.length; im>i; i++)
		if(checkedCheckboxes[i].value)
			groups.push(checkedCheckboxes[i].value);		

	var jsonGroups = JSON.stringify(groups);
	var checkedCheckboxes = $('#searchfromfinallist input[type="checkbox"]:checked');
	var jsonDestnos = JSON.stringify(finalListnos);
	$("#loader").fadeIn('slow');

	$.ajax({
		type: "POST",
              url: "<?php echo $ROOTURL ?>" + "forms/ajaxCampaignManagement.php",
              data: {campaignid:"<?php echo $campaignid;?>",userid:"<?php echo $LoggedInUserID;?>",txtScheduleDate:$('#txtScheduleDate').val(),timeinterval: $('#timeinterval').val(),
			scheduletype:$('#autosmsschedule').val(),txtScheduleTime:$('#basicExample').val(),enddate:$('#enddate').val(),
			msg:$('#txtMsg').val(),locktime:$('#txtLockTime').val(),
			destnos:jsonDestnos,groupids:jsonGroups,status:$('#status').val()},
	       async:false,
              success: function(value){
			$("#loader").fadeOut('slow');
			alert('Operation Successful');
              },
		error: function(value) {
			$("#loader").fadeOut('slow');
			alert('Error occured');
		}
        });
	 location.reload(true);
}

	
$(function() {
	$(".title").click(function(){
		var id = this.id;
		var checked_status = this.checked;
		$("."+id).each(function(){
			this.checked = checked_status;
		});
	});
	
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			txtMsg: { required:true }
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});		
});

function showSchedulingOptions(){
	if(document.getElementById("autosmsschedule").value == 'auto') document.getElementById("auto").style.visibility = 'visible';  
	else document.getElementById("auto").style.visibility = 'hidden';   
}

function showIntervalwiseOptions(){
	if(document.getElementById("timeinterval").value == 'weekly'){
		document.getElementById("weeklycheckboxes").style.visibility = 'visible';
		document.getElementById("monthlycheckboxes").style.visibility = 'hidden';
	}
	else if(document.getElementById("timeinterval").value == 'monthly'){
		document.getElementById("monthlycheckboxes").style.visibility = 'visible';
		document.getElementById("weeklycheckboxes").style.visibility = 'hidden';
	}
	else{
		document.getElementById("monthlycheckboxes").style.visibility = 'hidden';
		document.getElementById("weeklycheckboxes").style.visibility = 'hidden';
	}
}
		
function getDateTime(type) {
	var now     = new Date(); 
       var year    = now.getFullYear();
       var month   = now.getMonth()+1; 
       var day     = now.getDate();
       var hour    = now.getHours();
       var minute  = now.getMinutes();
       var second  = now.getSeconds(); 

       if(month.toString().length == 1) var month = '0'+month;
       if(day.toString().length == 1) var day = '0'+day;  
       if(hour.toString().length == 1) var hour = '0'+hour;
       if(minute.toString().length == 1) var minute = '0'+minute;
       if(second.toString().length == 1) var second = '0'+second;
       
       var dateTime = year+'-'+month+'-'+day+' '+hour+':'+minute+':'+second;   
       var date = year+'-'+month+'-'+day;   
       var time = hour+':'+minute+':'+second;

       if(type == 1)return dateTime;
       else if(type == 2) return date;
       else return time;
}

function makedatetime(date,time){
	return date+' '+time;
}

function diffDate(start,end){
	var laterdate = new Date('2014-01-29 15:54:30');     // 1st January 2000
	var earlierdate = new Date('2014-01-29 15:54:20');  // 13th March 1998 
	timeDifference(laterdate,earlierdate);

	var start_date = new Date(start);
	var end_date = new Date(end);
	var diff =  Math.floor(( Date.parse(end_date) - Date.parse(start_date) ) / 86400000);
	return diff;
}

function timeDifference(laterdate,earlierdate) {
	var difference = laterdate.getTime() - earlierdate.getTime();
       var daysDifference = Math.floor(difference/1000/60/60/24);
       
	difference -= daysDifference*1000*60*60*24;
       var hoursDifference = Math.floor(difference/1000/60/60);
       
	difference -= hoursDifference*1000*60*60;
       var minutesDifference = Math.floor(difference/1000/60);
    
	difference -= minutesDifference*1000*60;
       var secondsDifference = Math.floor(difference/1000);
 
 	alert('difference = ' + daysDifference + ' day/s ' + hoursDifference + ' hour/s ' + minutesDifference + ' minute/s ' + secondsDifference + ' second/s ');
}

function getDateObjfromString(datetime){
	var dt   = parseInt(datetime.substring(8,10));
	var mon  = parseInt(datetime.substring(5,7));
	var yr   = parseInt(datetime.substring(0,4));
	var hr   = parseInt(datetime.substring(11,13));
	var min   = parseInt(datetime.substring(14,16));
	var sec   = parseInt(datetime.substring(17,19));
	var date = new Date(yr, mon-1, dt, hr, min, sec);
	return date;
}
</script>
