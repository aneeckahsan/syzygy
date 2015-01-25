<head>
<style type="text/css">

#finalList ul{
  clear:left;
   display:block;
list-style:none;
margin:0;
padding-left: 0;
position:relative;
left:0%;
}
#finalList ul li {
   display:inline;
position:relative;
float:center;
height: 31px;
width: 151px;
list-style:none;
padding: 6px 6px 6px 20px;
margin: 0;
text-align: center;
right:0%;
}*/
/*#finalList ul li a {
text-decoration: none;
display: block;
color: #5aa0b1;
font-weight: bold;
}*/

.holder { margin: 5px 0; }

.holder a {
  font-size: 12px;
  cursor: pointer;
  margin: 0 5px;
  color: #333;
}

.holder a:hover {
  background-color: #222;
  color: #fff;
}

.holder a.jp-previous { margin-right: 15px; }
.holder a.jp-next { margin-left: 15px; }

.holder a.jp-current, a.jp-current:hover { 
  color: #ed4e2a;
  font-weight: bold;
}

.holder a.jp-disabled, a.jp-disabled:hover { color: #bbb; }

.holder a.jp-current, a.jp-current:hover,
.holder a.jp-disabled, a.jp-disabled:hover {
  cursor: default; 
  background: none;
}

.holder span { margin: 0 5px; }

.tabledata{
	border-style:solid;
	border-width:2px;
	vertical-align:middle;
}
</style>
<!-- start checkboxTree configuration -->
    <script type="text/javascript" src="library/jquery-1.4.4.js"></script>
    <script type="text/javascript" src="library/jquery-ui-1.8.12.custom/js/jquery-ui-1.8.12.custom.min.js"></script>
	<script type="text/javascript" src="library/jquery.checkboxtree.js"></script>
    <link rel="stylesheet" type="text/css" href="library/jquery.checkboxtree.css"/>
	<script type="text/javascript" src="library/jquery.cookie.js"></script>
	<link rel="stylesheet" type="text/css"
          href="library/jquery-ui-1.8.12.custom/css/smoothness/jquery-ui-1.8.12.custom.css"/>
	<!-- end checkboxTree configuration -->
	<!--<link href="css/stylePagination.css" media="screen" rel="stylesheet" type="text/css" />-->
	<script type="text/javascript" src="library/jquery.min.js"></script>
	<script type="text/javascript" src="library/jquery.pages.js"></script>

   
    <script type="text/javascript">
        //<!--
		var texts = [];

        $(document).ready(function() {
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
			
        });
		function selectedcheckbox(){
		var checkedCheckboxes = $('#tree1 input[type="checkbox"]:checked');
		alert(checkedCheckboxes.length);
		var texts = [];
		for(var i=0, im=checkedCheckboxes.length; im>i; i++)
		  texts.push(checkedCheckboxes[i].value);

		alert(texts);
		}
</script>
<script>

		 $(document).ready(function() {
			$("div.holder").jPages({
				containerID : "finalList",
				perPage: 5
  			});
		});
		
		function removethisrow(link) { 
			link.parentNode.parentNode.parentNode.removeChild(link.parentNode.parentNode);
			
		}
		function submitselectedlist(){
		var index;
		var texts = [], lis = document.getElementsByTagName("li");
		for(var i=0, im=lis.length; im>i; i++)
		  if(!(i%2))texts.push(lis[i].firstChild.nodeValue);

		alert(texts);
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
</script>
</head>


<form id="sampleform" method="post" action="<?php echo($ACTION);?>">
	<div class="cls"></div>
	<div class="holder"></div>		
		<ul id="finalList">
			<ul id="1">
				<li>Nokia</li>
				<li><a href='javascript:void(0);' onclick="removethisrow(this)">Edit</a></li>
				<li><a href='javascript:void(0);' onclick="removethisrow(this)">Remove</a></li>
			</ul>
			<ul id="1">
				<li>Aarong</li>
				<li><a href='javascript:void(0);' onclick="removethisrow(this)">Edit</a></li>
				<li><a href='javascript:void(0);' onclick="removethisrow(this)">remove</a></li>
			</ul>
		</ul>	
	</div>
</form>
<script type="text/javascript">
$(function() {
	$("#sampleform").validate({
		ignore: ":disabled",
		rules: {
			txtContactGroup: { required:true },
			txtRecipientList: { required:true },
			txtMobileNo: { required:true },
			txtEmail: { required:true , email:true },
			
		},
		errorPlacement: function(error, element) {
			element.next("span.error").html(error);
		}
	});
});	
	
</script>

