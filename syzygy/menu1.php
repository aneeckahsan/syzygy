<ul>
<!--li><a href="index.php" class="selected">Dashboard</a></li-->
<?php
$cn = mysql_connect($MYSERVER,$MYUID,$MYPASSWORD);

// Get all privilege details
$qry = "select * from privilege";
$rs=Sql_exec($cn, $qry);
$i = 0;
while($row = Sql_fetch_array($rs)){
	$arrAllPrivileges[$i][0]= $row["id"];
	$arrAllPrivileges[$i++][1]= $row["menuid"];
}

// Form the permitted menu labels string for the user
$PermittedMenuLabels = ",";
for($i=0; $i<count($arrAllPrivileges); $i++){
	$tmp = ",".$arrAllPrivileges[$i][0].",";
	if(strstr($_SESSION["PrivilegeIDs"], $tmp)){
		$PermittedMenuLabels .= $arrAllPrivileges[$i][1].",";
	}
}

$qry="select MenuID, Parent, MenuLabel, URL, RootWidth, LabelWidth from menudef Where Parent = 'Root' order by DisplayOrder";
$rs=Sql_exec($cn, $qry);
while ($row=Sql_fetch_array($rs)){
	$MenuID = $row["MenuID"];
	$MenuLabel=$row["MenuLabel"];
	echo "<li><a href='#'>$MenuLabel</a>";
	
	$qry2="select MenuID, Parent, MenuLabel, URL, RootWidth, LabelWidth from menudef Where Parent = '$MenuID' And Parent != 'Root' order by DisplayOrder";
	$rs2=Sql_exec($cn, $qry2);
	$n2=Sql_Num_Rows($rs2);
	if ($n2 != 0){
		echo "<ul>";
		while ($row2=Sql_fetch_array($rs2)){
			$URL2 = $row2["URL"];
			$MenuLabel2 = $row2["MenuLabel"];
			
			// If the current menu label is contained in the user's permitted menu label string then show the menu item
			$temp = ",".$row2["MenuID"].",";
			if(strstr($PermittedMenuLabels, $temp)){		
				echo "<li>";
				echo "<a href='$URL2'>$MenuLabel2</a>";
				echo "</li>";
			}				
		}
		echo "</ul>";
	}
	echo "</li>";
}
?>
</ul>