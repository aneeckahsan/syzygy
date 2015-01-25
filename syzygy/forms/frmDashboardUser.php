<div class="cls"></div>
<div class="smsbox">
    
<?php 

$cn = connectDB();
 $userid=$_SESSION["LoggedInUserID"];
$qry	="SELECT *,COUNT(contentoutbox.MSISDN) AS 'numberOfSMS'  FROM `user` 
INNER JOIN contentoutbox ON `user`.userid=contentoutbox.userid 
INNER JOIN account ON `user`.accountid=account.accountID 
WHERE `user`.userid ='$userid' ";
        $result	=mysql_query($qry, $cn);
        
        while($row = mysql_fetch_array($result)) {
            $firstname=$row['full_name'];
            $mobileno=$row['mobileno'];
            $email=$row['email'];
            $username=$row['username'];
            $numberOfSMS=$row['numberOfSMS'];
            $balance=$row['balance'];
 
        } // style="background-color: #0D5293; color: #fff; padding: 20px; border-color: #fff; "
?>
    <table border="1">
        <tr><td  width="45%" colspan="2" style="font-size: medium; font-weight: 400; " >Personal Information </td> <td width ="35%" style="font-size: medium; font-weight: 400; ">Account Information </td> <td  width ="20%" style="font-size: medium; font-weight: 400; ">SMS Summary </td></tr>
        <tr ><td width ="14%" style="font-size: small; font-weight: 400; ">Name :</td> <td  style="font-size: small; font-weight: 400; "><?php echo $firstname;?></td><td rowspan="3"  style="font-size: small; font-weight: 400; "><?php if($userid==1){ $qry="SELECT * FROM smsGatewayInfo"; $result	= mysql_query($qry, $cn); 
		while($row = mysql_fetch_array($result)) {
            echo $gatewayName=$row['gatewayName'];
			echo "  -  ";
            echo $balance=$row['balance'];
			echo "  (  ";
            echo $balanceupdatetime=$row['balanceupdatetime'];   
			echo "  )  </br>";
 
        }
				?>
     <a href="<?php echo $root_base ?>/balanceOFgateway.php" style="border: inherit;background-color:  #0D5269; text-decoration-style: none; color: #fff;font-size:  medium; font-weight: 300; border-bottom-color: #000;border-style: double; padding: 4px;">Update Balance</a> 
<?php 
		}else { ?>You have <?php echo $balance;?> BDT. <br> <br> <br> <a href="<?php echo $root_base ?>/index.php?FORM=forms/frmOnlineRecharge.php" style="border: inherit;background-color:  #0D5269; text-decoration-style: none; color: #fff;font-size:  medium; font-weight: 300; border-bottom-color: #000;border-style: double; padding: 4px;">Online Recharge</a> <?php } ?></td><td rowspan="3"  style="font-size: small; font-weight: 400; ">You Have Sent  <?php echo $numberOfSMS;?> SMS.</td></tr>
        <tr><td width ="14%" style="font-size: small; font-weight: 400; ">Mobile No: </td><td  style="font-size: small; font-weight: 400; "> <?php echo $mobileno;?></td></tr>
        <tr><td width ="14%" style="font-size: small; font-weight: 400; ">Email Id: </td><td  style="font-size: small; font-weight: 400; "> <?php echo $email;?></td></tr>

    </table>
</div>
<div id="interval"></div> 
 