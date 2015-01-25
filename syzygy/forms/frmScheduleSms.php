<head>
<?php include("included/checkboxtreeandjpages.php");

checkPrivilegePermission($ScheduleSms);

$action = (isset($_REQUEST['mode']) && !empty($_REQUEST['mode']))?$_REQUEST['mode']: NULL;
$scheduleid = (isset($_REQUEST['scheduleid']) && !empty($_REQUEST['scheduleid']))?$_REQUEST['scheduleid']: NULL;
//echo $campaignid;
?> 
<style type="text/css">
.tabledata{
	border-style:solid;
	border-width:2px;
	vertical-align:middle;
}
</style>  
<script type="text/javascript" src="js/constants.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<div id="loader"><img src="images/loader.gif"></div>

<br /><br />
<form id="sampleform" method="post" action="forms/qryCampaignManagement.php">
<?php
$qry ="select * from smsportal.schedulesms where scheduleid = '$scheduleid'";
$rs = mysql_query($qry,$cn);
$row=mysql_fetch_array($rs);
if(!empty($action)) {
$msg=$row['msg'];
$locktime=$row['locktime'];
}
else{
$msg="";
$locktime="";	
}?>
<div class="cls"></div>
<label for="Message">Message</label>
<label for="smscount" id="SMSCharCount"></label>
<textarea id="txtMsg" cols="45" rows="5" maxlength="640" oninput="charCount();" ><?php echo $msg;?></textarea>

<div class="cls"></div>
<label for="Message">Load from template:</label>
<div id="templates">
		<select id="templateoptions" onchange="loadTemplates();">
		<option value="">Select a template</option>

		<?php 
		$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);
		$query = "select * from template where userid = $LoggedInUserID";
		$value = 'text';
		$text = 'text';
		buildDropDownFromMySQLQuery($cn, $query, $value, $text); 
		?>
	</select></div>

<div class="cls"></div>
<div style="height:300px;">
	<table style="height:300px;" width="100%">
		<tr>
			<td class="tabledata" width="43%">
				<div id="tabs">
					<ul>
						<li><a href="#tab1">Manual Input</a></li>
						<li><a href="#tab2">Import from file</a></li>
						<li><a href="#tab3">Contact Group</a></li>
					</ul>
					
					<div id="tab1" style="height:200px;">
						<div class="cls"></div>
						<textarea id="txtManualInputContactList" cols="30" rows="5"></textarea>
					</div>

					<div id="tab2" style="height:200px;">
					<div class="cls"></div>					
					<input type="file" id="fileinput" name="files[]" multiple/>
					<textarea name="txtContactList" id="txtContactList" cols="30" rows="5"></textarea>
					</div>
					
					<div id="tab3" style="height:200px;">
						<!--<div class="cls"></div>-->
						<div class="contactdiv" id="ExistingGroups"> 
							<!--<input type="button" value="see selected boxes" onclick="appendtofinallist();"/>-->
							<ul id="tree1">
								<?php 
								if(!empty($action)) {//edit mode
									
									$qry ="select groupid from smsportal.schedulesmsdetails where scheduleid = '$scheduleid'";
									$rs = mysql_query($qry,$cn);
									$i=0;
									while($row=mysql_fetch_array($rs)){
									 $existingGroup[$i++] = $row[0];//echo $existingGroup[$i-1];									 
									}
									
									$qry ="select * from smsportal.group where userid = '$LoggedInUserID'";
									$rs = mysql_query($qry,$cn);
									//$row=mysql_fetch_array($rs);$rowcount=mysql_affected_rows();
									while($row=mysql_fetch_array($rs))
									{
										$groupname=$row["groupname"];$groupid=$row["groupid"];
										if(in_array($groupid,$existingGroup)){											
											echo "<li><input name='$groupname' type='checkbox' value='$groupid' checked/>$groupname</li>";
										}
										else{
											echo "<li><input name='$groupname' type='checkbox' value='$groupid'/>$groupname</li>";
										}
									}
								}//if(edit)
								else{//new campaign
									$qry ="select * from smsportal.group where userid = '$LoggedInUserID'";//echo "sssssssssssssss";
									$rs = mysql_query($qry,$cn);
									//$row=mysql_fetch_array($rs);$rowcount=mysql_affected_rows();
									while($row=mysql_fetch_array($rs))
									{
										$groupname=$row["groupname"];$groupid=$row["groupid"];
										echo "<li><input name='$groupname' type='checkbox' value='$groupid'/>$groupname</li>";
										
									}
								}
								?>		
							</ul>	
						</div>
					</div>
				</div>	
			</td>
			<td class="tabledata" width="7%">
				<input type="button" class="sbtn" value="Add" onclick="clickonaddbutton();"/>
			</td>
			<td class="tabledata" width="50%">
				<input type="text" name="searchinfinallist" id="searchinfinallist"><br>	
				<input type="button" value="Remove Selected" onclick='removeselectedrows();'/>
				<!--////////////////pagination---------------->
					
					<ul id="searchfromfinallist">
						<?php
						/*if(!empty($action)) {
							$qry ="select destno from smsportal.campaigndetails where campaignid = '$campaignid' and destno is not null";
							$rs = mysql_query($qry,$cn);
							
							while($row=mysql_fetch_array($rs)){
								echo '<ul id="1"><li style="width: 8em;"><input type="checkbox" value="'.$row[0].'"/>'.$row[0].'</li></ul>';
							}
							
						} */?>
					</ul>
					<div class="holder"></div>	
					<!--<input type="button" value="submit" onclick="submitselectedlist();"/>-->
				</div>
				<!--////////////////pagination---------------->
			</td>
		</tr>	
	</table>
</div>

<br></br>
<?php
$qry ="select * from smsportal.schedulesmsschedule where scheduleid = '$scheduleid'";//echo "sssssssssssssss";
$rs = mysql_query($qry,$cn);
//$row=mysql_fetch_array($rs);$rowcount=mysql_affected_rows();
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
<label>Scheduling Mode: </label>
<select id="autosmsschedule" onchange="showSchedulingOptions();">
	<option>Please Select</option>
	<?php if($scheduletype == 'manual')echo '<option value="manual" selected>manual</option>';else echo '<option value="manual">manual</option>';
		  if($scheduletype == 'auto')echo '<option value="auto" selected>auto</option>';else echo '<option value="auto">auto</option>';
	?>
</select>
	
<div id="auto" style="visibility:hidden;">
	<label>Interval: </label>
	<select id="timeinterval" onchange="showIntervalwiseOptions();">
	
	  <option>Please Select</option>
	  <?php  
	  if($occursoption == 'once')echo '<option value="once" selected>once</option>';else echo '<option value="once">once</option>';
	  if($occursoption == 'daily')echo '<option value="daily" selected>daily</option>';else echo '<option value="daily">daily</option>';
	  if($occursoption == 'weekly')echo '<option value="weekly" selected>weekly</option>';else echo '<option value="weekly">weekly</option>';
	  if($occursoption == 'bi-weekly')echo '<option value="bi-weekly" selected>bi-weekly</option>';else echo '<option value="bi-weekly">bi-weekly</option>';
	  if($occursoption == 'monthly')echo '<option value="monthly" selected>monthly</option>';else echo '<option value="monthly">monthly</option>';
	  if($occursoption == 'quarterly')echo '<option value="quarterly" selected>quarterly</option>';else echo '<option value="quarterly">quarterly</option>';
	  if($occursoption == 'half yearly')echo '<option value="half yearly" selected>half yearly</option>';else echo '<option value="half yearly">half yearly</option>';
	  if($occursoption == 'yearly')echo '<option value="yearly" selected>yearly</option>';else echo '<option value="yearly">yearly</option>';
	  ?>
	</select>
	<div class="cls"></div>
	<label for="scheduling">End date: </label>
	<input type="text" class="Date" id="enddate" name="enddate" value="<?php echo $enddate;?>"/>

</div>

<div class="cls"></div>
<input type="button" value="Save" class="sbtn" onclick="submitOP();"/>
<input type="button" value="Execute Schedule" class="sbtn" onclick=""/>
</form>

<script type="text/javascript">
var finalListnames = {};
var finalListemails = {};
var finalListnos = {};
var finalListids = {};
var finalListid = 0;
var nos = [], names=[],emails=[], x = 0;

$( "#searchinfinallist" ).keyup(function( event ) {
	//alert("key down");
	searchfromfinallist();
	jpage("searchfromfinallist");

}); 
function searchfromfinallist(){
$("#searchfromfinallist").children('ul').remove();
var searchinfinallist = $('#searchinfinallist').val();
for (var i in finalListnos) {
	if(finalListnos[i] && i.lastIndexOf(searchinfinallist, 0) === 0){
		$( "#searchfromfinallist" ).append( '<ul id="'+finalListids[i]+'" class="'+finalListids[i]+'"><li><input type="checkbox" value="'+i+'"/>'+i+'</li></ul>' );

	}
}
}
$(function() {
$("#loader").fadeIn('slow');

$.ajax({
            type: "POST",
            url: "<?php echo $ROOTURL ?>" + "forms/getphonenumberbyschedulesms.php",
            data: {scheduleid:"<?php echo $scheduleid;?>",userid:"<?php echo $LoggedInUserID;?>"},
            success: function(data){
				$("#loader").fadeOut('slow');

				//alert(data);
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
				$( "#error" ).dialog( "open" );
				
			}
    });	
	
});
function submitOP(){
	if($('#txtMsg').val()==''){alert("Please input message");return false;}

	if($('#txtScheduleDate').val()==''){alert("Please enter start date");return false;}
	else{
		if($('#basicExample').val() == ''){
			alert("Please enter start time");return false;
		}
	}
	if($('#autosmsschedule').val()==''){
		alert("Please enter schedule mode");return false;
	}
	
	else if($('#autosmsschedule').val()=='auto'){
		if($('#timeinterval').val()==''){alert("Please enter timeinterval");return false;}
	}
	
	
	var checkedCheckboxes = $('#tree1 input[type="checkbox"]:checked');
	if(finalListid == 0 && checkedCheckboxes.length == 0){alert("Please enter numbers");return false;}
	var groups = [];
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(checkedCheckboxes[i].value){
		groups.push(checkedCheckboxes[i].value);
		}
	}
	var jsonGroups = JSON.stringify(groups);
	
	var checkedCheckboxes = $('#searchfromfinallist input[type="checkbox"]:checked');
	
	var jsonDestnos = JSON.stringify(finalListnos);
	$("#loader").fadeIn('slow');
	$.ajax({
            type: "POST",
            url: "<?php echo $ROOTURL ?>" + "forms/ajaxScedulesms.php",
            data: {scheduleid:"<?php echo $scheduleid;?>",userid:"<?php echo $LoggedInUserID;?>",txtScheduleDate:$('#txtScheduleDate').val(),timeinterval: $('#timeinterval').val(),
			scheduletype:$('#autosmsschedule').val(),txtScheduleTime:$('#basicExample').val(),enddate:$('#enddate').val(),
			msg:$('#txtMsg').val(),locktime:$('#txtLockTime').val(),
			destnos:jsonDestnos,groupids:jsonGroups},
            success: function(value){
				$("#loader").fadeOut('slow');
				document.getElementById("update").innerHTML = 'Operation Successful';

				//alert(value);
				$( "#update" ).dialog( "open" );
             /*   if(value=="1")
                {
					$( "#update" ).dialog( "open" );
					
                }
                else
			    {
					document.getElementById("error").innerHTML = 'Error occured';

					$( "#error" ).dialog( "open" );
                   
                }*/
            },
			 error: function(value) {
				$("#loader").fadeOut('slow');
				$( "#error" ).dialog( "open" );
			 }
        });
}

function appendtofinallist(){
	var nosfrommanualandcsv = getnumbersfromstring();
	document.getElementById("txtContactList").innerHTML = '';
	document.getElementById("txtManualInputContactList").value = '';
	for(var i = 0; i < nosfrommanualandcsv.length; i++){
		if(!finalListnos[nosfrommanualandcsv[i]] && nosfrommanualandcsv[i]){
			finalListnos[nosfrommanualandcsv[i]] = 1;
			finalListnames[nosfrommanualandcsv[i]] = names[i];
			finalListemails[nosfrommanualandcsv[i]] = emails[i];
			finalListids[nosfrommanualandcsv[i]] = finalListid;
			//$( "#finalList" ).append( '<ul id="'+finalListid+'" class="'+finalListid+'"><li><input id="checkall1" type="checkbox" value="'+nosfrommanualandcsv[i]+'"/>'+nosfrommanualandcsv[i]+'</li></ul>' );
			finalListid++;	
		}
			
	}
	searchfromfinallist();
	jpage();
}
function clickonaddbutton(){
	appendtofinallist();
}		
function removethisrow(link) { 
	link.parentNode.parentNode.parentNode.removeChild(link.parentNode.parentNode);
	jpage();
}
function submitselectedlist(){
	var index;
	var texts = [],finallistid = document.getElementById('searchfromfinallist'), lis = finallistid.getElementsByTagName("li");
	//alert(lis.length);
	for(var i=0, im=lis.length; im>i; i++)
	  if(!(i%2))texts.push(lis[i].firstChild.nodeValue);

	//alert(texts);
	var jsonString = JSON.stringify(texts);
	alert(jsonString);
	
}
function getnumbersfromstring(){
	nos.length = 0;names.length = 0;emails.length = 0,x = 0;
	var SearchString = document.getElementById("txtManualInputContactList").value;
	if(SearchString){
	var VariableArray = SearchString.split('\n');
	   //return VariableArray;
	
	for(var i = 0; i < VariableArray.length; i++){
		var KeyValuePair = VariableArray[i].split(',');
		for(var j = 0; j < KeyValuePair.length; j++){
			if(isNumeric(KeyValuePair[j])) {nos.push(KeyValuePair[j]);}
			else if(ValidateEmail(KeyValuePair[j])){ emails.push(KeyValuePair[j]);}
			else names.push(KeyValuePair[j]);
		}
		if(!nos[x]) nos.push('');
		if(!names[x]) names.push('');
		if(!emails[x]) emails.push('');
		x++;
	}
	}
	
	var SearchString = document.getElementById("txtContactList").value;
	if(SearchString){
	var VariableArray = SearchString.split('\n');
	for(var i = 0; i < VariableArray.length; i++){
		var KeyValuePair = VariableArray[i].split(',');
		for(var j = 0; j < KeyValuePair.length; j++){
			if(isNumeric(KeyValuePair[j])) {nos.push(KeyValuePair[j]);}
			else if(ValidateEmail(KeyValuePair[j])){ emails.push(KeyValuePair[j]);}
			else names.push(KeyValuePair[j]);
		}
		if(!nos[x]) nos.push('');
		if(!names[x]) names.push('');
		if(!emails[x]) emails.push('');
		x++;
	}
	}
	//alert(names+emails);
	return nos;

}
function removeall(){
	destroyfinallist();
}
function removeselectedrows(){
	var checkedCheckboxes = $('#searchfromfinallist input[type="checkbox"]:checked');
	//alert(checkedCheckboxes.length);
	var groups = [];
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(checkedCheckboxes[i].value){
			var cls = checkedCheckboxes[i].parentNode.parentNode.className;
			cls='.'+cls;
			$(cls).remove();
			var numbertoberemoved = checkedCheckboxes[i].value;
			finalListnos[numbertoberemoved]=undefined;
			finalListnames[numbertoberemoved]=undefined;
			finalListemails[numbertoberemoved]=undefined;
			
		}
	}
	jpage("searchfromfinallist");
}
function destroyfinallist(){
$("#searchfromfinallist").children('ul').remove();
jpage();
finalListids={};
finalListnos={};
finalListnames={};
finalListemails={};
finalListid=0;
}
function ValidateEmail(n)
{
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(n.match(mailformat))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
function test(n){
	if(isNumeric(n)) alert('true');
}
function getnumbersfromcsv(){
	var nos = [];
	var SearchString = document.getElementById("txtContactList").value;
	var VariableArray = SearchString.split('\n');
	for(var i = 0; i < VariableArray.length; i++){
		var KeyValuePair = VariableArray[i].split(',');
		for(var j = 0; j < KeyValuePair.length; j++){
			if(isNumeric(KeyValuePair[j]))nos.push(KeyValuePair[j]);
		}
	}
	return nos;
}
function jpage(){
	$("div.holder").jPages("destroy").jPages({
		containerID: "searchfromfinallist",
		perPage: 5,
		keyBrowse: true,
		scrollBrowse: true,
		callback: function (pages,items) {
			$("#legend1").html("Page " + pages.current + " of " + pages.count);
			$("#legend2").html("Elements "+items.range.start + " - " + items.range.end + " of " + items.count);
		}
	});
}
function initPagination() {
	$("div.holder").jPages({
        containerID: "searchfromfinallist",
        perPage: 5,
        keyBrowse: true,
        scrollBrowse: true,
        animation: "bounceInUp",
        callback: function (pages,items) {
            $("#legend1").html("Page " + pages.current + " of " + pages.count);
            $("#legend2").html("Elements "+items.range.start + " - " + items.range.end + " of " + items.count);
        }
    });
}
$(document).ready(function() {
    $('#tabs').tabs({
        cookie: { expires: 30 }
    });
    $('.jquery').each(function() {
        eval($(this).html());
    });
    $('.button').button();
	
});	
$(function() {
	
	$(".title").click(function()		
	{
		var id = this.id;
		var checked_status = this.checked;
		$("."+id).each(function()
		{
			this.checked = checked_status;
		});
		
		//$('.myCheckbox').prop('checked', true)
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
function loadTemplates(){
var sel = document.getElementById("templateoptions").selectedIndex;
	document.getElementById("txtMsg").value+=document.getElementById("templateoptions").options[sel].text;}

function operatorOptions(){
	var str;
	if(document.getElementById("localOperator").checked==true){
		str = "<select><option value='teletalk'>Teletalk</option><option value='robi'>Robi</option></select>";
		document.getElementById("Operators").innerHTML = str;
	}
	else if (document.getElementById("internationalOperator").checked==true){
		str = "<select>" + "<option value='bt'>BT</option>" + "<option value='orange'>Orange</option>" +
				"<option value='maxis'>Maxis</option>" + "</select>";
		document.getElementById("Operators").innerHTML = str;
	}
	else
		document.getElementById("Operators").style.visibility = 'hidden';
}

function showSchedulingOptions(){
	if(document.getElementById("autosmsschedule").value == 'auto')     
		document.getElementById("auto").style.visibility = 'visible';  
	else 
		document.getElementById("auto").style.visibility = 'hidden';   
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

function readSingleFile(evt){
	var f = evt.target.files; 
	var lastindex = f.length - 1;
	var f = evt.target.files[lastindex];
    if (f) {
		var r = new FileReader();
        r.onload = function(e){         
			document.getElementById("txtContactList").innerHTML = e.target.result;  
		}
		r.readAsText(f);
    }
	else{ 
		alert("Failed to load file");
    }
}
document.getElementById('fileinput').addEventListener('change', readSingleFile, false);		
var texts = [];

$(document).ready(function() {
	$('#tabs').tabs({
		cookie: { expires: 30 }
	});
	$('.jquery').each(function() {
		eval($(this).html());
	});
	$('.button').button();
	/*$('#tree1').checkboxTree();
	$('#tree1 li input:checkbox').change(
		function() {
			//alert('HI');
			//texts.push($(this).next('label').text());
				  }
	);*/
	initPagination();
	showSchedulingOptions();
});
</script>
