<?php
/*
1st code in ssd tech. 
By
Mazhar.
date:mone nai

*/
checkPrivilegePermission($Report);

$txtstartdate = (isset($_POST['txtstartdate']) && !empty($_POST['txtstartdate'])) ? $_POST['txtstartdate'] : NULL;
$txtenddate = (isset($_POST['txtenddate']) && !empty($_POST['txtenddate'])) ? $_POST['txtenddate'] : NULL;
$type = (isset($_POST['type']) && !empty($_POST['type'])) ? $_POST['type'] : NULL;
$destinationNo = (isset($_POST['destinationNo']) && !empty($_POST['destinationNo'])) ? $_POST['destinationNo'] : NULL;
$mask = (isset($_POST['mask']) && !empty($_POST['mask'])) ? $_POST['mask'] : NULL;
$message = (isset($_POST['message']) && !empty($_POST['message'])) ? $_POST['message'] : NULL;

?>
<div class="cls"></div>
<div class="form">
    <form id="sampleform" action="index.php?FORM=forms/frmviewhistory.php" method="post">
        <div>
            <table>
                <tr>
                    <td>
                        <label for="" style="float: inherit;">Start date: </label></td>
                    <td>
                        <input type="text" class="Date" id="txtstartdate" name="txtstartdate" value=""
                               placeholder="Start date"/>
                    </td>
                    <td>
                        <label for="" style="float: inherit;">End date: </label></td>
                    <td>
                        <input type="text" class="Date" id="txtenddate" name="txtenddate" value=""
                               placeholder="End date"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="" style="float: inherit;">Distination No </label></td>
                    <td>
                        <input type="text" class="" id="destinationNo" name="destinationNo" placeholder="Distination No"
                               value=""/>
                    </td>
                    <td>
                        <label for="" style="float: inherit;">Mask </label></td>
                    <td>
                        <input type="text" class="" id="mask" name="mask" placeholder="Mask" value=""/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="" style="float: inherit;">Message </label></td>
                    <td>
                        <input type="text" class="" id="message" name="message" placeholder="Message" value=""/>
                    </td>
                    <td>
                        <input type="submit"></td>
                </tr>
            </table>
        </div>
    </form>
</div></br>
<div class="form">
    <div class="cls"></div>
    <div id="viewsmppaccount">
        <?php
        try {
            $cn = connectDB();
            if (!$cn) {
                throw new Exception(" Database connection problem .  Line number : " . __LINE__ . "  File name : " . __FILE__);
            }
        } catch (Exception $e) {
            errorHandling($e->getMessage());
        }
        //$cn = mysql_connect($MYSERVER, $MYUID, $MYPASSWORD);
        //mysql_select_db($MYDB);
        $userid = $_SESSION["LoggedInUserID"];
        $query = "select MSISDN, SMSText, SMSMask, DeliveryTime, `Status`, userid from contentoutbox
				where  userid =$userid ";
        if ($txtstartdate != NULL)
            $query = $query . " and DeliveryTime >='$txtstartdate' ";

        if ($txtenddate != NULL)
            $query = $query . " and DeliveryTime <='$txtenddate' ";

        if ($destinationNo != NULL)
            $query = $query . " and  MSISDN like '%$destinationNo%' ";
        if ($mask != NULL)
            $query = $query . " and  SMSMask like '%$mask%' ";
        if ($message != NULL)
            $query = $query . " and  SMSText like '%$message%' ";

        try {
            $rs = mysql_query($query, $cn);
            if (!$rs) {
                throw new Exception(" Query execution problem . Query is *$query*  Line number : " . __LINE__ . "  File name : " . __FILE__);
            }
        } catch (Exception $e) {
            errorHandling($e->getMessage());
        }


        ?>
        <div class="showlistwithpagination">
            <ul style="margin-bottom: 2px;  width:98%">
                <li><h1>SMS</h1></li>
                <li><h1>Mask</h1></li>
                <li><h1>Destination</h1></li>
                <li><h1>Date</h1></li>
                <li><h1>Status</h1></li>

            </ul>
            <div class="cls"></div>
            <ul id="finalList">
                <?php
                while ($dt = mysql_fetch_array($rs)) {

                    if (strlen($dt['SMSText']) > 20) $msg = substr($dt['SMSText'], 0, 20) . "...";
                    else $msg = $dt['SMSText'];
                    ?>
                    <ul>

                        <li Title="<?php echo $dt['SMSText']; ?>" id="tableText"><p> <?php echo $msg; ?> </p></li>
                        <li id="tableText"><p><?php echo $dt['SMSMask']; ?></p></li>
                        <li id="tableText"><p><?php echo $dt['MSISDN']; ?></p></li>
                        <li id="tableText"><p><?php echo $dt['DeliveryTime']; ?></p></li>
                        <li id="tableText"><p><?php echo $dt['Status']; ?></p></li>

                    </ul>
                <?php } ?>
            </ul>
            <div class="holder"></div>
        </div>
    </div>
</div>
<!--<input type="button" class="sbtn" value="Add" onclick="clickonaddbutton();"/>-->

<script>


    $(document).ready(function () {


        $("div.holder").jPages({
            containerID: "finalList",
            perPage: 5,
            keyBrowse: true,
            scrollBrowse: true,
            animation: "bounceInUp"

        });

        $("#txtenddate").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "yy-mm-dd",

            onSelect: function (selected) {

                $("#txtstartdate").datepicker("option", "maxDate", selected);

            }
        });

        $("#txtenddate").keyup(function () {

            if (!this.value) {
                $("#txtstartdate").datepicker("option", "maxDate", null);
            }

        });

        $("#txtstartdate").keyup(function () {

            if (!this.value) {
                $("#txtenddate").datepicker("option", "minDate", null);
            }

        });

        $("#txtstartdate").datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            dateFormat: "yy-mm-dd",

            onSelect: function (selected) {

                $("#txtenddate").datepicker("option", "minDate", selected);
            }
        });
    });


</script>