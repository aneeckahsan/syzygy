<head>
<style type="text/css">

  
     #searchfromfinallist ul li
        {
            list-style-type: none;
            display: inline-block;
            margin: 10px;
           /* background: #0066FF;
            width: 100px;
            height: 100px;*/
        }
.tabledata{
	border-style:solid;
	border-width:2px;
	vertical-align:middle;
}
</style>
<?php include("included/checkboxtreeandjpages.php");?>
</head>


<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
<div class="cls"></div>
<!--
<label for="Contact Group">Contact Group</label>
<div id="createContactGroup">
	<div id="addNew">
		<select id="contactGroup">
			<option value="1" selected="selected">Group 1</option>
			<option value="2">Group 2</option>
			<option value="3">Group 3</option>
		</select>
		<input type="button" value="Add New" onclick="addNew();"/>
	</div>	
</div>
-->
<label for="Contact Group">Contact Group</label>
<input type="text" value="" id="txtNewContactGroupName"/>
<div><input type="button" value="Save" class="sbtn" onclick="submitContactgroup();"/></div>

<div class="cls"></div>
<div>
	<table style="height:530px;" width="100%">
		<tr>
			<td class="tabledata" width="41%">
				<div id="tabs">
					<ul>
						<li><a href="#tab1">Manual Input</a></li>
						<li><a href="#tab2">Import from file</a></li>
						<li><a href="#tab3">Contact Group</a></li>
					</ul>
					
					<div id="tab1" style="height:420px;">
						<div class="cls"></div>
						<textarea id="txtManualInputContactList" cols="30" rows="5"></textarea>
					</div>

					<div id="tab2" style="height:420px;">															
					<input type="file" id="fileinput" name="files[]" multiple/>
					<textarea name="txtContactList" id="txtContactList" cols="30" rows="5"></textarea>
					</div>
					
					
					<div id="tab3" style="height:420px;">
						<table>
						<tr>
							<td><input type="text" name="searchgroupinput" id="searchgroupinput"><br></td>
							<td><input type="text" name="searchphoneinput" id="searchphoneinput">
							
						</tr>
						<tr>
							<td><div id="searchholder" style="height:200px;overflow:auto;">
								<?php
								
								$qry ="select * from smsportal.group where userid = '$LoggedInUserID'";//echo "sssssssssssssss";
								$rs = mysql_query($qry,$cn);
								//$row=mysql_fetch_array($rs);$rowcount=mysql_affected_rows();
								echo "<ul>";
								while($row=mysql_fetch_array($rs))
								{
									$groupname=$row["groupname"];$groupid=$row["groupid"];
									echo "<li>$groupname</li>";
									
									
								}
								echo "</ul>";
								?>	
							</div></td>
							<td>
								<div id="searchholder1" style="overflow:auto;">
									<ul id="getphonenumberbygrouplist"><li id=""><input id="checkall1" type="checkbox" value=""/>Select all</li></ul>
									<ul id="searchfromgetphonenumberbygrouplist"><li id=""><input id="checkall2" type="checkbox" value=""/>Select all</li></ul>
								</div>
							</td>
						</tr>
						</table>
					</div>
				</div>	
			</td>
			<td class="tabledata" width="7%">
				<input type="button" class="sbtn" value="Add" onclick="clickonaddbutton();"/>
			</td>
			<td class="tabledata" width="30%">
			<input type="button" value="Remove All" onclick="removeall();"/>
				<!--////////////////pagination---------------->
						
					<ul id="finalList">
							
					</ul>
					<div class="holder"></div>
				
				<!--////////////////pagination---------------->
			</td>
			<td class="tabledata" width="24%">
				<input type="text" name="searchinfinallist" id="searchinfinallist"><br>	
					<div id="searchholder2" style="height:300px;overflow:auto;">
					<ul id="searchfromfinallist">
						<li id=""><input id="checkall4" type="checkbox" value=""/>Select all</li>
					</ul>
					<!--<div class="searchholder"></div>-->
					</div>
			</td>
		</tr>	
	</table>
	
</div>
<div id="test">
</div>
<br></br>
<div class="cls"></div>
</form>
<script type="text/javascript">
var finalListnames = new Object();
var finalListemails = new Object();
var finalListnos = new Object();
var finalListids = new Object();
var finalListid = 0;
var nos = [], names=[],emails=[];


$('#checkall1').click(function(){
        //$("#getphonenumberbygrouplist").find('> li > input[type=checkbox]').prop('checked', this.find('> li > input[type=checkbox]').checked);
		   $(this).closest('ul').find('> li > input[type=checkbox]').not(':first').prop('checked', this.checked)
});
$('#checkall2').click(function(){
        //$("#searchfromgetphonenumberbygrouplist").find('> li > input[type=checkbox]').prop('checked', this.find('> li > input[type=checkbox]').checked);
		   $(this).closest('ul').find('> li > input[type=checkbox]').not(':first').prop('checked', this.checked)
});
$('#checkall3').click(function(){
        //$("#getphonenumberbygrouplist").find('> li > input[type=checkbox]').prop('checked', this.find('> li > input[type=checkbox]').checked);
		   $(this).closest('ul').find('> li > input[type=checkbox]').not(':first').prop('checked', this.checked)
});
$('#checkall4').click(function(){
        //$("#searchfromfinallist").find('> li > input[type=checkbox]').prop('checked', this.find('> li > input[type=checkbox]').checked);
		   //$(this).closest('ul').find('> li > input[type=checkbox]').not(':first').prop('checked', this.checked)
});
$( "#searchphoneinput" ).keyup(function( event ) {
	//alert("key down");
	$("#searchfromgetphonenumberbygrouplist").show();
	var input = $(this).val().toLowerCase(); 
	searchfromgetphonenumberbygrouplist(input);
});
$( "#searchinfinallist" ).keyup(function( event ) {
	//alert("key down");
	searchfromfinallist();
});
$('#searchgroupinput').keypress(function(event){
 
	var keycode = (event.keyCode ? event.keyCode : event.which);
	if(keycode == '13'){
		var input = $(this).val().toLowerCase(); 
		//alert(input);
		getphonenumberbygroup(input);	
	}
 
});

function searchfromgetphonenumberbygrouplist(input){
	
	$("#getphonenumberbygrouplist").hide();
	$("#searchfromgetphonenumberbygrouplist").children('li').not(':first').remove();

	$('#getphonenumberbygrouplist li').map(function(i,n) {
		if($(n).attr('id').lastIndexOf(input, 0) === 0){
			$( "#searchfromgetphonenumberbygrouplist" ).append( '<li id="'+$(n).attr('id')+'"><input name="" type="checkbox" value="'+$(n).attr('id')+'"/>'+$(n).attr('id')+'</li>' );
		}
	});
	
}
function addNew(){
	var parent = document.getElementById("addNew");
	var numberofchildren = parent.childNodes.length;
	//alert(numberofchildren);
	if(numberofchildren <=5){
	var clear = document.createElement('div');
	clear.setAttribute('class','cls');
	
	var label = document.createElement('label');
	label.innerHTML = "New Group Name:";
	
	var input = document.createElement('input');
	input.setAttribute('type','text');	
	input.setAttribute('id','txtNewContactGroupName');
	
	parent.appendChild(clear);
	parent.appendChild(label);
	parent.appendChild(input);
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

$(document).ready(function() {
	$("#getphonenumberbygrouplist").hide();
	$("#searchfromgetphonenumberbygrouplist").hide();

	$('#tabs').tabs({
		cookie: { expires: 30 }
	});
	$('.jquery').each(function() {
		eval($(this).html());
	});
	$('.button').button();
	$('#tree1').checkboxTree();
	$('#tree1 li input:checkbox').change(
		function() {
			//alert('HI');
			//texts.push($(this).next('label').text());
				  }
	);
	$('#tabs').tabs({
        cookie: { expires: 30 }
    });
    $('.jquery').each(function() {
        eval($(this).html());
    });
    $('.button').button();
	initPagination("finalList");
	//initPaginationforsearch("searchfromfinallist");
});

function appendtofinallist(){

	//var nosfrommanualinput = getnumbersfromstring();
	//var nosfrommanualandcsv = nosfrommanualinput.concat(getnumbersfromcsv());
	var nosfrommanualandcsv = getnumbersfromstring();
	//alert(names.length);alert(emails.length);
	document.getElementById("txtContactList").innerHTML = '';
	document.getElementById("txtManualInputContactList").value = '';

	var checkedCheckboxes = $('#getphonenumberbygrouplist input[type="checkbox"]:checked');
	//alert(checkedCheckboxes.length);
	var groups = [];
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(!finalListnos[checkedCheckboxes[i].value] && checkedCheckboxes[i].value){
			finalListids[checkedCheckboxes[i].value] = finalListid;
			finalListnos[checkedCheckboxes[i].value] = 1;
			finalListnames[checkedCheckboxes[i].value] = 1;
			finalListemails[checkedCheckboxes[i].value] = 1;

			$( "#finalList" ).append( '<ul id="'+finalListid+'"><li style="width: 8em;">'+checkedCheckboxes[i].value+'</li><li><a href="javascript:void(0);" onclick="removethisrow(this)">remove</a></li></ul>' );
			finalListid++;
		}
	}
	var checkedCheckboxes = $('#searchfromgetphonenumberbygrouplist input[type="checkbox"]:checked');
	for(var i=0, im=checkedCheckboxes.length; im>i; i++){
		if(!finalListnos[checkedCheckboxes[i].value] && checkedCheckboxes[i].value){
			finalListids[checkedCheckboxes[i].value] = finalListid;
			finalListnos[checkedCheckboxes[i].value] = 1;
			finalListnames[checkedCheckboxes[i].value] = 1;
			finalListemails[checkedCheckboxes[i].value] = 1;

			$( "#finalList" ).append( '<ul id="'+finalListid+'"><li style="width: 8em;">'+checkedCheckboxes[i].value+'</li><li><a href="javascript:void(0);" onclick="removethisrow(this)">remove</a></li></ul>' );
			finalListid++;
		}
	}
	for(var i = 0; i < nosfrommanualandcsv.length; i++){
		if(!finalListnos[nosfrommanualandcsv[i]] && nosfrommanualandcsv[i]){
			finalListnos[nosfrommanualandcsv[i]] = 1;
			finalListnames[nosfrommanualandcsv[i]] = names[i];
			finalListemails[nosfrommanualandcsv[i]] = emails[i];
			finalListids[nosfrommanualandcsv[i]] = finalListid;
			$( "#finalList" ).append( '<ul id="'+finalListid+'"><li style="width: 8em;">'+nosfrommanualandcsv[i]+'</li><li><a href="javascript:void(0);" onclick="removethisrow(this)">remove</a></li></ul>' );
			finalListid++;	
		}
			
	}//alert(names);alert(finalListnames);
	jpage("finalList");
}
function clickonaddbutton(){
	appendtofinallist();
}
function searchfromfinallist(){
$("#searchfromfinallist").children('ul').remove();
var searchinfinallist = $('#searchinfinallist').val();
for (var i in finalListnos) {
	if(finalListnos[i] && i.lastIndexOf(searchinfinallist, 0) === 0){
		$( "#searchfromfinallist" ).append( '<ul id="'+finalListids[i]+'"><li style="width: 8em;">'+i+'</li><li><a href="javascript:void(0);" onclick="removethisrow(this)">remove</a></li></ul>' );

	}

}
//jpageforsearch("searchfromfinallist");
}
function jpage(sourceid){
	$("div.holder").jPages("destroy").jPages({
		containerID: sourceid,
		perPage: 5,
		keyBrowse: true,
		scrollBrowse: true,
		callback: function (pages,items) {
			$("#legend1").html("Page " + pages.current + " of " + pages.count);
			$("#legend2").html("Elements "+items.range.start + " - " + items.range.end + " of " + items.count);
		}
	});
}

function initPagination(sourceid) {
	$("div.holder").jPages({
        containerID: sourceid,
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

function removeall(){
	$("#finalList").children('ul').remove();
	jpage("finalList");
}
		
function removethisrow(link) { alert(link.parentNode.parentNode.id);
//link.parentNode.parentNode.parentNode.removeChild(link.parentNode.parentNode);
	var numbertoberemoved = link.parentNode.parentNode.firstChild.firstChild.nodeValue;
	var elem = document.getElementById(link.parentNode.parentNode.id);
	elem.remove();
	finalListnos[numbertoberemoved]=undefined;
	finalListnames[numbertoberemoved]=undefined;
	finalListemails[numbertoberemoved]=undefined;
	jpage("finalList");
}
function submitselectedlist(){
	var index;
	var texts = [],finallistid = document.getElementById('finalList'), lis = finallistid.getElementsByTagName("li");
	//alert(lis.length);
	for(var i=0, im=lis.length; im>i; i++)
	  if(!(i%2))texts.push(lis[i].firstChild.nodeValue);

	//alert(texts);
	var jsonString = JSON.stringify(texts);
	//alert(jsonString);
	
}
function getnumbersfromstring(){
	nos.length = 0;names.length = 0;emails.length = 0;
	var SearchString = document.getElementById("txtManualInputContactList").value;
	if(SearchString){
	var VariableArray = SearchString.split('\n');
	   //return VariableArray;
	var x=0;
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


function isNumeric(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}
function test(n){
	if(isNumeric(n)) alert('true');
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
function getphonenumberbygroup(input){
	$("#getphonenumberbygrouplist").children('li').not(':first').remove();
	$("#searchfromgetphonenumberbygrouplist").children('li').not(':first').remove();
	$("#getphonenumberbygrouplist").show();
	$("#searchfromgetphonenumberbygrouplist").hide();

	$.ajax({
            type: "POST",
            url: "<?php echo $ROOTURL ?>" + "forms/getphonenumberbygroup.php",
            data: {groupname:input,userid:"<?php echo $LoggedInUserID;?>"},
            success: function(data){
				alert(data);
				obj = JSON && JSON.parse(data) || $.parseJSON(data);
				//obj = data;
				
				$.each(obj, function(key, val) {
					$( "#getphonenumberbygrouplist" ).append( '<li id="'+val+'"><input name="" type="checkbox" value="'+val+'"/>'+val+'</li>' );

				});
				/*
				var mobileno = data.split(',');
				for(var j = 0; j < mobileno.length && mobileno[j]; j++){
					$( "#getphonenumberbygrouplist" ).append( '<li id="'+mobileno[j]+'"><input name="" type="checkbox" value="'+mobileno[j]+'"/>'+mobileno[j]+'</li>' );
				}  
				*/
            },
			 error: function(data) {
				$( "#error" ).dialog( "open" );
			 }
    });
}
function submitContactgroup(){
	
	$.ajax({
            type: "POST",
            url: "<?php echo $ROOTURL ?>" + "forms/ajaxContactGroup.php",
            data: {GroupName:$('#txtNewContactGroupName').val(),nos:finalListnos,names:finalListnames,emails:finalListemails,userid:"<?php echo $LoggedInUserID;?>"},
            success: function(value){
				alert(value);
				$( "#update" ).dialog( "open" );
                /*if(value=="1")
                {
					$( "#update" ).dialog( "open" );
					
                }
                else
			    {
					$( "#error" ).dialog( "open" );
                   
                }*/
            },
			 error: function(value) {
				$( "#error" ).dialog( "open" );
			 }
    });
}
/*
function jpageforsearch(sourceid){
	$("div.searchholder").jPages("destroy").jPages({
		containerID: sourceid,
		perPage: 5,
		keyBrowse: true,
		scrollBrowse: true,
		callback: function (pages,items) {
			$("#legend1").html("Page " + pages.current + " of " + pages.count);
			$("#legend2").html("Elements "+items.range.start + " - " + items.range.end + " of " + items.count);
		}
	});
}
function initPaginationforsearch(sourceid) {
	$("div.searchholder").jPages({
        containerID: sourceid,
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
function getnumbersfromcsv(){
	nos.length = 0;names.length = 0;emails.length = 0;
	var SearchString = document.getElementById("txtContactList").value;
	var VariableArray = SearchString.split('\n');
	for(var i = 0; i < VariableArray.length; i++){
		var KeyValuePair = VariableArray[i].split(',');
		for(var j = 0; j < KeyValuePair.length; j++){
			if(isNumeric(KeyValuePair[j])) {nos.push(KeyValuePair[j]);}
			else if(ValidateEmail(KeyValuePair[j])){ emails.push(KeyValuePair[j]);}
			else names.push(KeyValuePair[j]);
		}
		if(!nos[i]) nos.push('');
		if(!names[i]) names.push('');
		if(!emails[i]) emails.push('');
	}
	return nos;
}*/
</script>

