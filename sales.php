<?php
include "includes/inc.php";
########################

$shipping = 0 ;

if (isset($_GET['order_id'])) {
    $order_data = get_order_supply_inv_data_by_id($_GET['order_id']);

    if (count($order_data) > 0 ){
        $order_supply_num = $order_data[0]['inv_id'];


        if (isset($_GET['order_status'])) {
            if (mysqli_query($con, "DELETE FROM " . $prefix . "_sales_temporary where user_id=" . $_GET['order_user_id'])) {
                header("refresh:0;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
            }
            $result = @mysqli_query($con, "SELECT " . $prefix . "_order_supply.* ," . $prefix . "_order_supply_inv.shipping FROM " . $prefix . "_order_supply JOIN  " . $prefix . "_order_supply_inv on 
            " . $prefix . "_order_supply.inv_id = " . $prefix . "_order_supply_inv.inv_id where  " . $prefix . "_order_supply.inv_id='$order_supply_num'  ");
            $num = @mysqli_num_rows($result);
            if ($num > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    $sql = "INSERT INTO " . $prefix . "_sales_temporary (item_status,item, Price, Quantity, Discount, Total, BuyPrice, date, type, subqty, sales_type, size ,color, user_id)
							VALUES ('" . $row['item_status'] . "','" . $row['item'] . "','" . $row['Price'] . "','" . $row['Quantity'] . "','" . $row['Discount'] . "','" . $row['Total'] . "','" . $row['BuyPrice'] . "','" . $row['date'] . "','" . $row['type'] . "','" . $row['subqty'] . "','" . $row['sales_type'] . "','" . $row['size'] . "','" . $row['color'] . "','" . $row['user_id'] . "')";
                    mysqli_query($con, $sql);
                }
            }
        }
    }


}else{
    $_GET['order_id']=0;
    $_GET['order_user_id']=0;
    $order_supply_num = '' ;
}
##########################
if (isset($_GET['sales_type'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET sales_type=" . $_GET['sales_type'] . " where id=" . $get_db_id . "");
    header("refresh:0;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
}
##########################
if (isset($_GET['unsuspend'])) {
     mysqli_autocommit($con,FALSE);
    if (mysqli_query($con, "INSERT INTO " . $prefix . "_sales_temporary(item, Price, Quantity, Discount, Total, SupplierID, BuyPrice, date, type, sales_type, subqty, size, color, user_id)
SELECT item,Price,Quantity,Discount,Total,SupplierID,BuyPrice,date,type,sales_type,subqty,size,color,user_id from " . $prefix . "_sales_suspended")) {
        if (mysqli_query($con, "DELETE FROM " . $prefix . "_sales_suspended where user_id='$user_id'")) {

            $report_suspend = '0';
        }else{
            $error +=1;
            $mysqli_errno++;
        }
    }
    if($error>0){
        mysqli_rollback($con); 
    }
       mysqli_commit($con);
}
####################################
mysqli_query($con, "UPDATE ".$prefix."_sales_temporary SET type='1' where user_id='$user_id' and type='2'");
mysqli_query($con, "UPDATE ".$prefix."_sales_temporary SET Quantity=Quantity*-1 where user_id='$user_id' and Quantity<=0");
mysqli_query($con, "UPDATE ".$prefix."_sales_temporary SET Total=Total*-1 where user_id='$user_id' and Total<=0");
if (isset($_POST['date'])) {
    $_POST['date'] = str_replace("/", "-", $_POST['date']);
    $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));
    ##################
    if (mysqli_query($con, "UPDATE " . $prefix . "_sales_temporary SET  date='$DueDate' where user_id=$user_id")) { 
    }
}
    if($_POST['inv_tax']=='1'){
    }else if($_POST['inv_tax']==null){
        $db_tax=0; 
    }else if($_POST['inv_tax']=="0"){$db_tax=0;}else{}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <script>
            function popupCenter(pageURL, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               <script type="text/javascript" src="js/shortcut_.js"></script>

        <script>
            function showResults(str) {
                if (str.length == 0) {
                    document.getElementById("livesearchcl").innerHTML = "";
                    document.getElementById("livesearchcl").style.border = "0px";
                    return;
                }
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("livesearchcl").innerHTML = xmlhttp.responseText;
                        document.getElementById("livesearchcl").style.border = "0px solid #A5ACB2";
                    }
                }
                    str = str + '&order_id='+<?php echo $_GET['order_id'] ; ?> +'&order_user_id='+<?php echo $_GET['order_user_id'] ; ?>;

                xmlhttp.open("GET", "ajax/clients_search_ajax.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
        <script>
            function showResultsOfItems(str) {
                if (str.length == 0) {
                    document.getElementById("livesearch").innerHTML = "";
                    document.getElementById("livesearch").style.border = "0px";
                    return;
                }
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                        document.getElementById("livesearch").style.border = "0px solid #A5ACB2";
                    }
                }
                str = str + '&order_id='+<?php echo $_GET['order_id'] ; ?> +'&order_user_id='+<?php echo $_GET['order_user_id'] ; ?>;

                xmlhttp.open("GET", "items_search_offers.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
                <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
    
        <script type="text/javascript">

            $(function () {
                // Set up the number formatting.

                $('#number_container').slideDown('fast');

                $('#price').on('change', function () {
                    console.log('Change event.');
                    var val = $('#price').val();
                    $('#the_number').text(val !== '' ? val : '(empty)');
                });

                $('#price').change(function () {
                    console.log('Second change event...');
                });

                $('#price').number(true, 0, ',', '');


                // Get the value of the number for the demo.
                $('#get_number').on('click', function () {

                    var val = $('#price').val();

                    $('#the_number').text(val !== '' ? val : '(empty)');
                });
            });
        </script>
        <?php include"includes/css.php"; ?>
<?php include"includes/js.php"; ?>
    </head>

    <body class="cmenu1 example-target">
      
            <div>
                <div>
                    <?php
                    if (isset($_GET['sales_cat'])) {
                        mysqli_query($con, "UPDATE " . $prefix . "_config SET sales_cat_items_show=" . $_GET['sales_cat'] . " where id=" . $get_db_id . "");
                        header("refresh:0;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
                    }
                    ?>
                    <?php
                    if ($get_db_isLogo == 1) {
                        if ($get_db_Logo == "") {
                            echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
                        } else {
                            echo '<img src="uploads/' . $get_db_Logo . '" style="float:left; border:0px;"/>';
                        }
                    } else {
                        //echo"<div class='logodiv'>$get_db_CompanyName</div>";
                    }
                    ?>
                </div>
                <?php
                include"includes/buttons.php";
                ?>
            </div>
    
        <div id='main'  class="noprint">
            <article style="margin-bottom:70px;">
                <?php
                if ($user_sale !== "1" and $user_IsAdmin != 1) {
                    echo"<div style='margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;'>'.$not_have_permission_lang.'</div>";
                }
                else {
                    ?>
                    <div class="noprint">
                        <div style="width:60%;border:1px solid #CCC; border-radius:5px; float:right; ">
                            <div>
                                <img src="images/Client.png" style="width:5%; border:0px; float:right; vertical-align:middle;" />
                                <input type="text" name="code" value="" id="searchcl" onkeyup="showResults(this.value)"  autocomplete="off" style="float:right; text-align:center; padding-left:0px; margin-left:0px;  height:25px; width:40%; background-color:#CCC;"/>
<!--                               <div class="row">-->



<!--                               </div>-->
                                <div id="livesearchcl" style="z-index:1000000000; width:45%;  text-align:right; margin-top:30px;  float:right; position:fixed; border:0px; "></div>
                                <div style="width:100%; padding-top:10px; text-align:center; margin:0 auto;border:0px solid #CCC; border-radius:5px;"">
                                    <?php
                                    if (isset($_GET['suspend'])) {
                                         mysqli_autocommit($con,FALSE);
                                        if (mysqli_query($con, "INSERT INTO " . $prefix . "_sales_suspended(item, Price, Quantity, Discount, Total, SupplierID, BuyPrice, date, type, sales_type, subqty, size, color, user_id )
SELECT item,Price,Quantity,Discount,Total,SupplierID,BuyPrice,date,type,sales_type,subqty,size,color,user_id from " . $prefix . "_sales_temporary")) {
                                            if (mysqli_query($con, "DELETE FROM " . $prefix . "_sales_temporary where user_id='$user_id'")) {

                                                $report_suspend = '1';
                                            }else{
                                                $report_suspend = '0';
                                            }
                                        }
                                            if($report_suspend=='0'){ mysqli_rollback($con); }
                                            mysqli_commit($con);
                                    }
                                    ?>

                                    <?php
                                    $result_sales_suspended = mysqli_query($con, "SELECT id FROM " . $prefix . "_sales_suspended where user_id='$user_id'");
                                    if (@mysqli_num_rows($result_sales_suspended) >= 1) {
                                        echo'<a href="sales.php?unsuspend=1"><img src="images/unsuspend.png" style="width:30px; height:30px; border:0px; float:left;"  title="'.$unsuspend_lang.'" /></a>';
                                    } else {
//                                        echo'<a href="sales.php?suspend=1"><img src="images/suspend.png" style="width:30px; height:30px; border:0px; float:left;"  title="'.$suspense_lang.'" /></a>';
                                    }
                                    ?>
                                    <a class="addProd" par="q" attr="d"><img src="images/c.png" style="width:30px; height:30px; float:left; border:0px;"  title="<?php echo"$Cancel_lang"; ?>"/></a>
                                    <a href="sales_returns.php"><img src="images/Returns-128.png" style="width:30px; height:30px; float:left; border:0px;" title="<?php echo"$Returns_lang"; ?>" /></a>
                                    <?php
                                    if ($Retail_allow == "1") {
                                        if ($get_db_sales_type == "1") {
                                            echo' <a href="sales.php?sales_type=2"><img src="images/Shopping_retail-04-128.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Retail_lang.'"   /></a>';
                                        } else if ($get_db_sales_type == "2") {
                                            echo'<a href="sales.php?sales_type=1"><img src="images/g.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Wholesaling_lang.'" /></a>';
                                        } else {
                                            echo'<a href="sales.php?sales_type=1"><img src="images/g.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Wholesaling_lang.'" /></a>';
                                        }
                                    }
                                    ?>





                                    <?php
                                    if ($_GET['print_inv'] !== null) {
                                        ##############
                                        $result_Get_supplier = mysqli_query($con, "SELECT  supplier  FROM ".$prefix."_sales_inv where  inv_id=".$_GET['print_inv']."");
                                        while ($row_Get_supplier = @mysqli_fetch_array($result_Get_supplier)) {
                                            $GsupplierID = $row_Get_supplier['supplier'];
                                        }
                                        ##############
                                        ?>
                                        <a href="#" onclick="javascript:void window.open('pdf/export/sales_inv.php?id=<?php echo"" . $_GET['print_inv'] . ""; ?>&type=sale', '13909375026416', 'width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                return false;"><img src="images/print_icon.gif" style="width:30px; height:30px; float:left; border:0px;" title="<?php echo"$Print_previous_bill_lang"; ?>" /></a>
                                        <?php if ($GsupplierID == null) {
                                            
                                        } else { ?>
                                            <a href="#" onclick="javascript:void window.open('statement_of_account_client.php?id=<?php echo"" . $GsupplierID . ""; ?>&from=<?php echo"" . date("Y-m-01") . ""; ?>&to=<?php echo"" . date("Y-m-d") . ""; ?>', '1390937502641', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                    return false;"><img src="images/arrears_list.gif" style="float:left; border:0px; margin-top:10px;" title="<?php echo"$client_statement_lang"; ?>" /></a>
        <?php } ?>
                                    <?php } ?>

                                   <?php echo"$Bill_of_sale_lang"; ?></div>
                                <div style="width:100%; padding-top:0px; text-align:center; margin:0 auto;border:0px dashed #CCC; border-radius:5px; height:290px; overflow:auto;">
                                    <?php
                                    if ($report_suspend == "1") {
                                        echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$suspended_bill_lang.'
							</div>';
                                        header("refresh:1;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
                                    }
                                    if (($_POST['submit']) == $Save_lang and $_POST['submit'] != null) {




                                        ###################################
                                            mysqli_autocommit($con,FALSE);
                                        $result_upt = mysqli_query($con, "SELECT * FROM " . $prefix . "_sales_temporary where user_id='$user_id' order by id DESC");
                                        while ($row_upt = mysqli_fetch_array($result_upt)) {
                                            $quantityt = $_POST[quantity . $row_upt['id']];
                                            $Pricet = $_POST[price . $row_upt['id']];
                                            $stafft = $_POST[staff . $row_upt['id']];
                                            $Discountt = $_POST[discount . $row_upt['id']];
                                            $sales_type = $_POST[sales_type . $row_upt['id']];
                                            $size = $_POST[size . $row_upt['id']];
                                            $color = $_POST[color . $row_upt['id']];
                                            if ($Discount_type == 1) {
                                                $DiscountValuet = $Discountt;
                                            } else if ($Discount_type == 2) {
                                 $DiscountValuet = ($quantityt * $Pricet) * ($Discountt / 100);

                                            } else {
                                                $DiscountValuet = $Discountt;
                                            }
                                            $Totalt = ($quantityt * $Pricet) - $DiscountValuet;
                                            $inv_Totalt+=($quantityt * $Pricet) - $DiscountValuet;
                                        }
                                        ###############################################
                                        $pay = $_POST['pay'];

                                        $_POST['date'] = str_replace("/", "-", $_POST['date']);
                                        $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));
                                        $paid = trim($_POST['paid']);
										if($Discount_type==2){
											$alldiscount=trim($inv_Totalt*$_POST['alldiscount']/100);
											}else{
											$alldiscount=trim($_POST['alldiscount']);	
												}
                                       
                                        $CheckNumber = '';
                                        ##########مدفوعات العملاء############	
									//	echo ($inv_Totalt);
                                        if($db_tax>0){
                                         $total_inv_after_alldiscount_and_tax=($inv_Totalt - $alldiscount)+(($inv_Totalt - $alldiscount)*$db_tax/100);
                                        }else{
                                          $total_inv_after_alldiscount_and_tax=($inv_Totalt - $alldiscount);
                                        }
                                       $total_inv_after_alldiscount_and_tax_ship=$total_inv_after_alldiscount_and_tax+$_POST['shipping'];

//                                       if ($_POST['SupplierID'] == "" and round($paid,2) != round($total_inv_after_alldiscount_and_tax_ship,2)) {
                                       if ($_POST['SupplierID'] == "" ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_customer.'
							</div>';
                                        } else  if ($_POST['safe_id'] == ""  and  $paid > 0) {
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_safe.'
							</div>';
                                        } else  if ($_POST['branch_id'] == "" ) {
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_branch.'
							</div>';
                                        }else  if ($_POST['store_id'] == "" ) {
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_store.'
							</div>';
                                        } else {


                                           ############################
                                           mysqli_query($con, "UPDATE " . $prefix . "_config SET  LastsaleInvoiceNo= LastsaleInvoiceNo + 1 where id=" . $get_db_id . "");
                                           $result_LastInvoiceNo = mysqli_query($con, "SELECT LastsaleInvoiceNo FROM " . $prefix . "_config where id='1'");
                                           while ($row_LastInvoiceNo = mysqli_fetch_array($result_LastInvoiceNo)) {
                                               $get_LastInvoiceNo = $row_LastInvoiceNo['LastsaleInvoiceNo'];
                                           }
                                            if ($paid < 0 or $paid == null or $paid == "") {
                                            }
                                            else {
                                                if($_POST['inv_tax'] == '1'){
                                                    $taxValue=(($db_tax/(100+$db_tax))*(($inv_Totalt - $alldiscount)));
                                                }else{
                                                    $taxValue = 0 ;
                                                }
                                                        if($_POST['paid']>0){

                                                  $sqlpayments_suppliers = "INSERT INTO " . $prefix . "_sales_inv (branch_id,order_suppy_num ,supplier, Total, date, PaymentMethod, DueDate, notes, type, discount, staff,safe_id,store_id, doc, tax, user_id)
VALUES ('" . $_POST['branch_id'] . "','" .  $get_LastInvoiceNo . "','" . $_POST['SupplierID'] . "','" . ($paid * -1) . "','" . $DueDate . "','" . $pay . "','','" . $_POST['notes']  . "','3','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','" . $_POST['safe_id']. "','" . $_POST['store_id']. "','" . $_POST['doc'] . "','" . $taxValue . "','" . $user_id . "')";

                                                if (!mysqli_query($con, $sqlpayments_suppliers)) {
                                                    echo"$Error_lang .....";
                                                    $mysqli_errno++;
                                                } else {
                                                    if ($_GET['order_id'] > 0){
                                                        $update_temp_sql="UPDATE " . $prefix . "_order_supply_inv SET confirm_status=1 where  id IN (" . $_GET['order_id'] . ")";
                                                        mysqli_query($con, $update_temp_sql);
                                                    }

//                                                    $pp = 1;
//                                                    if ($alldiscount <= 0) {
//
//                                                    } else {
//                                                        if ($_POST['inv_tax'] == '1') {
//                                                            $taxValue = (($db_tax / (100 + $db_tax)) * (($inv_Totalt - $alldiscount)));
//                                                        } else {
//                                                            $taxValue = 0;
//                                                        }
//                                                        if($_POST['alldiscount']>0){
//                                                         $sqlpayments = "INSERT INTO " . $prefix . "_sales_inv (branch_id,order_suppy_num ,supplier, Total, date, PaymentMethod, DueDate, notes, type, discount, staff,safe_id,store_id, doc, tax, user_id)
//VALUES ('" . $_POST['branch_id'] . "','" . $get_LastInvoiceNo . "','" . $_POST['SupplierID'] . "','" . (($alldiscount) * -1) . "','" . $DueDate . "','" . $pay . "','','" . $_POST['notes'] . "','3','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','" . $_POST['safe_id'] . "','" . $_POST['store_id'] . "','" . $_POST['doc'] . "','" . $taxValue . "','" . $user_id . "')";
//
//                                                        if (!mysqli_query($con, $sqlpayments)) {
//                                                            echo "$Error_lang ..";
//                                                            $mysqli_errno++;
//                                                        } else {
//                                                            if ($_GET['order_id'] > 0) {
//                                                                $update_temp_sql = "UPDATE " . $prefix . "_order_supply_inv SET confirm_status=1 where  id IN (" . $_GET['order_id'] . ")";
//                                                                mysqli_query($con, $update_temp_sql);
//                                                            }
//                                                            $pp = 1;
//                                                        }
//                                                    }
//                                                    }
                                                }
                                                }
                                            }
                                           $pp = 1;
                                           if ($alldiscount <= 0) {

                                           } else {
                                               if ($_POST['inv_tax'] == '1') {
                                                   $taxValue = (($db_tax / (100 + $db_tax)) * (($inv_Totalt - $alldiscount)));
                                               } else {
                                                   $taxValue = 0;
                                               }
                                               if($_POST['alldiscount']>0){
                                                   $sqlpayments = "INSERT INTO " . $prefix . "_sales_inv (branch_id,order_suppy_num ,supplier, Total, date, PaymentMethod, DueDate, notes, type, discount, staff,safe_id,store_id, doc, tax, user_id)
VALUES ('" . $_POST['branch_id'] . "','" . $get_LastInvoiceNo . "','" . $_POST['SupplierID'] . "','" . (($alldiscount) * -1) . "','" . $DueDate . "','" . $pay . "','','" . $_POST['notes'] . "','3','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','" . $_POST['safe_id'] . "','" . $_POST['store_id'] . "','" . $_POST['doc'] . "','" . $taxValue . "','" . $user_id . "')";

                                                   if (!mysqli_query($con, $sqlpayments)) {
                                                       echo "$Error_lang ..";
                                                       $mysqli_errno++;
                                                   } else {
                                                       if ($_GET['order_id'] > 0) {
                                                           $update_temp_sql = "UPDATE " . $prefix . "_order_supply_inv SET confirm_status=1 where  id IN (" . $_GET['order_id'] . ")";
                                                           mysqli_query($con, $update_temp_sql);
                                                       }
                                                       $pp = 1;
                                                   }
                                               }
                                           }

######################
######################
                                            if ($pp == 1 and $paid>0) {
                                                $sqlt = "INSERT INTO " . $prefix . "_treasury (user_id,safe_id,type, Amount, date, notes, inv_id, inv_type, client_supp_name)
VALUES ('".$user_id."','".$_POST['safe_id']."','4','" . $paid . "','" . $DueDate . "','تحصيلات نقدية','" . $get_LastInvoiceNo . "','1','" . $_POST['SupplierID'] . "')";

                                                if (!mysqli_query($con, $sqlt)) {
                                                    // die($paid);
                                                    $mysqli_errno++;
                                                }
                                            }
######################
                                            ######################
                                            $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_sales_temporary where user_id='$user_id' order by id DESC");
                                            while ($row_up = mysqli_fetch_array($result_up)) {
                                                $item = round($_POST[item . $row_up['id']]);
                                                $quantity = $_POST[quantity . $row_up['id']];
                                                $Price = $_POST[price . $row_up['id']];
                                                $staff = $_POST[staff . $row_up['id']];
                                                $Discount = $_POST[discount . $row_up['id']];
                                                $sales_type = $_POST[sales_type . $row_up['id']];
                                                if ($Retail_allow == 1) {
                                                    
                                                } else {
                                                    $sales_type = "1";
                                                }
                                                if ($Discount_type == 1) {
                                                    $DiscountValue = $Discount;
                                                } else if ($Discount_type == 2) {
                                                    if ($Discount == 0) {
                                                        $DiscountValue = $Discount;
                                                    } else {
                                                        $DiscountValue = ($quantity * $Price) * ($Discount / 100);
                                                    }
                                                } else {
                                                    $DiscountValue = $Discount;
                                                }
                                                $Total = ($quantity * $Price) - $DiscountValue;
                                                $inv_Total+=($quantity * $Price) - $DiscountValue;

if (mysqli_query($con, "UPDATE " . $prefix . "_sales_temporary SET inv_id='" . $get_LastInvoiceNo . "',staff='" . $staff . "',Quantity='" . $quantity . "',
Price='" . $Price . "',Discount='" . $Discount . "',Total='" . $Total . "',date='" . $DueDate . "',type='1',sales_type='" . $sales_type . "',BuyPrice=(select price from items where id='" . $item . "') where user_id='$user_id' and id='" . $row_up['id'] . "'")) {
#############التأثير على المخزون###########
//if(mysqli_query($con, "UPDATE items SET Quantity=Quantity-$quantity where  id='".$row_up['item']."'")){}
###########################################	
                                                }
                                                //echo"echo mysqli_errno($con);<br />";
                                            }
                                            ######################
                                           if($_POST['inv_tax'] == '1'){
                                               $taxValue=(($db_tax/(100+$db_tax))*(($inv_Totalt - $alldiscount)));

                                           }else{
                                               $taxValue = 0 ;

                                           }
                                             $insert1= "INSERT INTO " . $prefix . "_sales_inv(branch_id,order_suppy_num , inv_id, date, Total, supplier, PaymentMethod, DueDate, CheckNumber, notes, type, paid, discount, staff,safe_id,store_id, doc, tax, shipping, user_id)
VALUES ('" . $_POST['branch_id'] . "','". $order_supply_num . "','" . $get_LastInvoiceNo . "','" . $DueDate . "','" . $inv_Total . "','" . $_POST['SupplierID'] . "','" . $pay . "','','" . $CheckNumber . "','" . $_POST['notes'] . "','1','" . $paid . "','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','". $_POST['safe_id'] . "','" . $_POST['store_id'] . "','" . $_POST['doc'] . "','" .$taxValue. "','" . $_POST['shipping'] . "','" . $user_id . "')";
                                         if (mysqli_query($con,$insert1)) {
                                                $Report_Create_Invoice = 1;
##############
                                                if (mysqli_query($con, "INSERT INTO " . $prefix . "_sales(item_status,Quantity, Discount, Total, SupplierID, BuyPrice, date, type, sales_type, subqty, inv_id, item, Price, size, color, user_id, staff)
SELECT item_status,(CASE when sales_type=2 then  Quantity/subqty else Quantity END) ,Discount,Total,SupplierID,BuyPrice,date,type,sales_type,subqty,inv_id,item,Price,size,color,user_id,staff from " . $prefix . "_sales_temporary where user_id='$user_id' and inv_id !=''")) {
                                                    $Report_Record_purchases = 1;
                                                    if ($_GET['order_id'] > 0){
                                                        $update_temp_sql="UPDATE " . $prefix . "_order_supply_inv SET confirm_status=1 where  id IN (" . $_GET['order_id'] . ")";
                                                        mysqli_query($con, $update_temp_sql);
                                                    }
                                                } else {
                                                    $Report_Record_purchases = 0;
                                                      $mysqli_errno++;
                                                }
                                                ###############
                                            } else {
                                                $Report_Create_Invoice = 0;
                                            }
################
                                            ################################
                                            if (mysqli_query($con, "DELETE FROM " . $prefix . "_sales_temporary where user_id='$user_id'")) {
                                                header("refresh:1;url=sales.php?print_inv=" . $get_LastInvoiceNo . "");
                                            }else{
                                                $mysqli_errno++;
                                            }
                                            ######################
                                        }
                                         if($mysqli_errno>0){ mysqli_rollback($con); }
                                            mysqli_commit($con);
                                    }

                                    ###########################################
                                    if ($error_reports == "1") {
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$quantity_not_zero_lang.'
							</div>';
                                    }
                                    ?>
                                    <?php
                                    if (isset($_GET['SupplierID']) and $_GET['SupplierID'] !== null) {
                                        $SupplierID = $_GET['SupplierID'];
                                        if (mysqli_query($con, "UPDATE ".$prefix."_sales_temporary SET SupplierID=".$SupplierID." where user_id='$user_id'")) {
                                            header("refresh:1;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
                                        } else {
                                            echo"$Please_try_again_lang";
                                        }
                                    }
                                    if (isset($_GET['barcode']) and $_GET['barcode'] !== null and $_GET['barcode'] !== "'.$barcode_lang.'") {
                                        $get_barcode= explode("-", $_GET['barcode']);
                                        $get_barcode_code=$get_barcode[0];
                                        $get_barcode_size=$get_barcode[1];
                                        $get_barcode_color=$get_barcode[2];
                                        $result_barcode = mysqli_query($con, "SELECT id FROM items where Barcode='" . $get_barcode_code . "'");
                                        if (@mysqli_num_rows($result_barcode) >= 1) {
                                            while ($row_barcode = mysqli_fetch_array($result_barcode)) {
                                                $db_item_id = $row_barcode['id'];
                                            }
                                        }
//$db_item_id;
###################
######################
####################
                                        if ($_GET['barcode'] == null) {
                                            //	header( "refresh:0;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']' );
                                        } else {
                 
                                                $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $db_item_id . "'");
                                                if (@mysqli_num_rows($result_new) >= 1) {

                                                    while ($row_new = mysqli_fetch_array($result_new)) {
                                                        $item_name_new = $row_new['item'];
                                                        $item_id_new = $row_new['id'];
                                                        if ($get_db_sales_type == "1") {
                                                            $item_Retail_price_new = $row_new['Retail_price'];
                                                        } else {
                                                            $item_Retail_price_new = $row_new['subprice'];
                                                        }
                                                        $item_Discount_new = $row_new['Discount'];
                                                        $item_price_new = $row_new['price'];
                                                        $item_subqty = $row_new['subqty'];
                                                        if ($Discount_type == 1) {
                                                            $item_total_new = $item_Retail_price_new - $row_new['Discount'];
                                                        } else if ($Discount_type == 2) {
                                                            $item_total_new = $item_Retail_price_new - (($item_Retail_price_new) * ($row_new['Discount'] / 100));
                                                        } else {
                                                            $item_total_new = $item_Retail_price_new;
                                                        }
                                                        $sql = "INSERT INTO " . $prefix . "_sales_temporary (item, Price, Quantity, Discount, Total, BuyPrice, date, type, subqty, sales_type, size ,color, user_id)
							VALUES ('" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','" . $item_price_new . "','" . $DueDate . "','1','" . $item_subqty . "','" . $get_db_sales_type . "','" . $get_barcode_size . "','" . $get_barcode_color . "','".$user_id."')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
                                                        header("refresh:1;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                        header("refresh:1;url=sales.php".'?order_id='.$_GET['order_id'].'&order_user_id='.$_GET['order_user_id']);
                                                    }
                                                } else {
                                                echo'<div class="alert alert-warning text-center">
							'.$item_not_found_lang.'
							 </div>';
                                                }
                                     
                                        }

#####################
#####################				
#####################
                                    }


                                    ?>
                                    <form method="post" id="inv_form">
                                        <input type="hidden" name="order_id" value="<?php echo $_GET['order_id'] ; ?>">
                                        <input type="hidden" name="order_user_id" value="<?php echo $_GET['order_user_id'] ; ?>">
                                        <?php
//                                        $result_SupplierID = mysqli_query($con, "SELECT SupplierID FROM " . $prefix . "_sales_temporary where user_id='$user_id' limit 0,1");
//                                        if (@mysqli_num_rows($result_SupplierID) > 0) {
//                                            while ($row_SupplierID = mysqli_fetch_array($result_SupplierID)) {
//                                                $result_search_client = mysqli_query($con, "SELECT id,name FROM " . $prefix . "_clients WHERE id=" . $row_SupplierID['SupplierID'] . "");
//                                                if (@mysqli_num_rows($result_search_client) > 0) {
//                                                    while ($row_search_client = mysqli_fetch_array($result_search_client)) {
//                                                      echo" <span dir=\"rtl\"  style=\"color:#7D060F;\" dir=\"rtl\">$The_client_lang :".$row_search_client['name']."</span>";
//
//                                                        echo'<input type="hidden" name="SupplierID" value="' . $row_search_client['id'] . '" />';
//                                                    }
//                                                }
//                                            }
//                                        }
                                        ?>
                                        <div style="font-size:16px;"><span dir="rtl"><?php echo $The_client_lang ; ?>: <br /></span>
                                            <span style="color:#7D060F;" dir="rtl"><div id="ajaxResSupp">
                                            <?php echo get_client_data( $_POST['SupplierID'] )[name]; ?>
                                </div></span></div>
                                        <input type="hidden" name="SupplierID" id="SupplierID" value="" />

                                        <div id="ajaxResSupp">
                                        </div>
                                        <table  border="1" style="font-size:16px; width:100%;  direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;">

                                            <thead style="background-color:#0076EA; color:#fff;">
                                            <th width="5%" class="text-center"><?php echo"$Serial_lang"; ?></th>
                                            <th width="35%" class="text-center"><?php echo"$the_Item_lang"; ?></th>
                                                <?php
                                                if ($Retail_allow == "1") {
                                                    echo"<th class='text-center'>$the_Type_lang</th>";
                                                }
                                                ?>  
                                            <th class="text-center"><?php echo"$the_Quantity_lang"; ?></th>
                                           <?php if($use_sizes==1){echo'<th class="text-center">'.$the_Size_lang.'</th>';} ?>
                                                       <?php if($use_sizes==1){echo'<th class="text-center">'.$the_Color_lang.'</th>';} ?>
                                            <th class="text-center"><?php echo"$the_Price_lang"; ?></th>
                                            <th class="text-center"><?php echo"$the_Discount_lang"; ?></th>
                                            <th class="text-center"><?php echo"$the_total_lang"; ?></th>
                                            <th class="text-center"><?php echo"$Delete_lang"; ?></th>
                                            </thead>
                                            <tbody id="tablee">
                                                <?php
                                                $tbl_name = "" . $prefix . "sales_temporary";
                                                //your table name
                                                // How many adjacent pages should be shown on each side?
                                                $adjacents = 3;

                                                /*
                                                  First get total number of rows in data table.
                                                  If you have a WHERE clause in your query, make sure you mirror it here.
                                                 */
                                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_sales_temporary where user_id='$user_id' order by id DESC";
                                                $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                                                $total_pages = $total_pages[num];

                                                /* Setup vars for query. */
                                                $targetpage = "limit=" . $_GET['limit'] . "";
                                                //your file name  (the name of this file)
                                                //how many items to show per page
                                                if (!empty($_GET['limit'])) {
                                                    $_SESSION[limit] = $_GET['limit'];
                                                } else {
                                                    
                                                }
                                                if (!empty($_SESSION[limit])) {
                                                    $limit = $_SESSION[limit];
                                                    if ($limit > 100) {
                                                        $limit = 20;
                                                    }
                                                } else {
                                                    $limit = 100;
                                                }
                                                $page = $_GET['page'];
                                                if ($page)
                                                    $start = ($page - 1) * $limit;
                                                //first item to display on this page
                                                else
                                                    $start = 0;
                                                //if no page var is given, set start to 0

                                                /* Get data. */
                                                 $sql = "SELECT * FROM " . $prefix . "_sales_temporary where user_id='$user_id' order by id DESC";

                                                $result = @mysqli_query($con, $sql);
                                                /* Setup page vars for display. */
                                                if ($page == 0)
                                                    $page = 1;
                                                //if no page var is given, default to 1.
                                                $prev = $page - 1;
                                                //previous page is page - 1
                                                $next = $page + 1;
                                                //next page is page + 1
                                                $lastpage = ceil($total_pages / $limit);
                                                //lastpage is = total pages / items per page, rounded up.
                                                $lpm1 = $lastpage - 1;
                                                //last page minus 1

                                                /*
                                                  Now we apply our rules and draw the pagination object.
                                                  We're actually saving the code to a variable in case we want to draw it more than once.
                                                 */
                                                $pagination = "";
                                                if ($lastpage > 1) {
                                                    $pagination .= "<div class=\"pagination\">";
                                                    //previous button
                                                    if ($page > 1)
                                                        $pagination .= "<a href=\"$targetpage&page=$prev\">>></a>";
                                                    else
                                                        $pagination .= "<span class=\"disabled\">>></span>";

                                                    //pages
                                                    if ($lastpage < 7 + ($adjacents * 2)) {//not enough pages to bother breaking it up
                                                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                                                            if ($counter == $page)
                                                                $pagination .= "<span class=\"current\">$counter</span>";
                                                            else
                                                                $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                        }
                                                    } elseif ($lastpage > 5 + ($adjacents * 2)) {//enough pages to hide some
                                                        //close to beginning; only hide later pages
                                                        if ($page < 1 + ($adjacents * 2)) {
                                                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                                if ($counter == $page)
                                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                                else
                                                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                            }
                                                            $pagination .= "...";
                                                            $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                            $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                                        }
                                                        //in middle; hide some front and some back
                                                        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                                            $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                                                            $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                                                            $pagination .= "...";
                                                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                                if ($counter == $page)
                                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                                else
                                                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                            }
                                                            $pagination .= "...";

                                                            $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                            $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                                        }
                                                        //close to end; only hide early pages
                                                        else {
                                                            $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                                                            $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                                                            $pagination .= "...";
                                                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                                                if ($counter == $page)
                                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                                else
                                                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                            }
                                                        }
                                                    }

                                                    //next button
                                                    if ($page < $counter - 1)
                                                        $pagination .= "<a href=\"$targetpage&page=$next\"><<</a>";
                                                    else
                                                        $pagination .= "<span class=\"disabled\"><<</span>";
                                                    $pagination .= "</div>\n";
                                                }
                                                ###############
                                                $i = 1;
                                                while ($row = @mysqli_fetch_array($result)) {
//                                                    var_dump($row['id']);
//                                                    var_dump('---------------------');
                                                    ###########
//                                                    var_dump($row['id']);
                                                    if($row['item_status']=='offers'){
//                                                        var_dump('Offers');
                                                        $result_it = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers_inv where id=" . $row['item'] . "");
                                                        if (@mysqli_num_rows($result_it) > 0) {
                                                            while ($row_it = mysqli_fetch_array($result_it)) {
//                                                              var_dump($row_it);
                                                                $item_name = $row_it['name'];
                                                                $item_id = $row_it['id'];
                                                                $item_price = $row_it['Retail_price'];
                                                                $item_Discount = $row_it['Discount'];
                                                                $item_BuyPrice = $row_it['price'];
                                                            }
                                                        }
                                                    }else{
//                                                        var_dump('Items');


                                                        $result_it = mysqli_query($con, "SELECT * FROM items where id=" . $row['item'] . "");
                                                        if (@mysqli_num_rows($result_it) > 0) {
                                                            while ($row_it = mysqli_fetch_array($result_it)) {
                                                                $item_name = $row_it['item'];
                                                                $item_id = $row_it['id'];
                                                                $item_price = $row_it['Retail_price'];
                                                                $item_Discount = $row_it['Discount'];
                                                                $item_BuyPrice = $row_it['price'];
                                                            }
                                                        }
                                                    }

                                                    if ($item_Discount == null) {
                                                        $item_Discount = 0;
                                                    }
                                                    /* 								if ($row['Quantity'] < 1) {
                                                      $row['Quantity'] = 1;
                                                      } */

                                                    if ($item_Discount == null) {
                                                        $item_Discount = 0;
                                                    }
                                                    $sumTotal+= $row['Total'];
                                                    ###########
                                                    #############تحديث سعر البيع#####
                                                    if ($Update_SellBuyPrice == 1) {
                                                        if ($row['sales_type'] == "1") {
                                                            mysqli_query($con, "UPDATE items SET Retail_price='" . $row['Price'] . "' where id='" . $row['item'] . "'");
                                                        } else {
                                                            mysqli_query($con, "UPDATE items SET subprice='" . $row['Price'] . "' where id='" . $row['item'] . "'");
                                                        }
                                                    }
###############################################################################
                                                    if(is_float($i/2)){
                                                        $gr="gr";
                                                    }else{
                                                        $gr="gr2";
                                                    }
                                                    echo'<input type="hidden" name="BuyPrice' . $row['id'] . '" value="' . $item_BuyPrice . '" /><tr class="'.$gr.'">
							<td>' . $i . '</td>
							<td><input type="hidden" name="item' . $row['id'] . '" value="' . $item_id . '" />' . $item_name . '</td>';
                                                    if ($Retail_allow == "1") {
                                                        echo'<td>';
                                                        echo'<select  class="'.$gr.'"  name="sales_type' . $row['id'] . '" style="width:10%; height:20px; text-align:center;border:0px;>';
                                                        ?>
                                                    <option value="0" <?php if ($row['sales_type'] == "0") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Select_Type_lang"; ?></option>
                                                    <option value="1" <?php if ($row['sales_type'] == "1") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Wholesaling_lang"; ?></option>
                                                    <option value="2" <?php if ($row['sales_type'] == "2") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Retail_lang"; ?></option>
                                                    <?php
                                                    echo'</select></td>';
                                                }
                                                echo'<td><input  class="'.$gr.'" type="text" name="quantity' . $row['id'] . '"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
                                                if($use_sizes==1){
                                                echo'<td><select  class="'.$gr.'" name="size'.$row['id'].'" style="height:25px; width:10px; text-align:center;border:0px;">';
                                                                          $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (".rtrim(get_sizes_of_item($item_id), ",").") limit 15");
                                                                        $num_sizes = @mysqli_num_rows($result_sizes);
                                                                        if ($num_sizes > 0) {
                                                                            while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                    if ($row['size'] == $row_sizes['id']) {
                        echo '<option value="' . $row_sizes['id'] . '" selected >' . $row_sizes['size'] . '</option >';
                    } else {
                        echo '<option value="' . $row_sizes['id'] . '">' . $row_sizes['size'] . '</option >';
                    }
                                                                            }
                                                                        }
                                                
                                              echo'</select></td>';
                                                }
                                                 if($use_colors==1){
                                                                               echo'<td><select  class="'.$gr.'" name="color'.$row['id'].'" style="height:25px; text-align:center;border:0px;">';
                                  $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (".rtrim(get_clolors_of_item($item_id), ",").")  ");
            $num_colors = @mysqli_num_rows($result_colors);
            if ($num_colors > 0) {
                while ($row_colors = mysqli_fetch_array($result_colors)) {
                    if ($row['color'] == $row_colors['id']) {
                        echo '<option value="' . $row_colors['id'] . '" selected >' . $row_colors['color'] . '</option >';
                    } else {
                        echo '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
                    }
                }
            }
                                               echo'</select></td>';
                                                 }
                                                echo'<td><input tabindex = "'.$i.'" class="'.$gr.'" type="text"  name="price' . $row['id'] . '" id="price' . $i . '" value="' . $row['Price'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input  class="'.$gr.'" type="text"  name="discount' . $row['id'] . '" id="discount' . $i . '" value="' . $row['Discount'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input class="'.$gr.'" type="text"  name="subtotal' . $row['id'] . '" id="subtotal' . $i . '" value="' . $row['Total'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td valign="middle"><a class="addProd" par="del" attr="'.$row['id'].'"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';
                                                $i++;
                                            }
                                            ?>
                                                <?php
                                                if ($sumTotal == null) {

                                                } else {
                                                    echo'<tr>';

                                                    if($use_sizes==1){
                                                        if ($use_colors == 1) {echo'<td colspan="7">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="6">'.$the_total_lang.'</td>'; }

                                                    }else{
                                                        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_lang.'</td>'; }
                                                    }
                                                    echo'<td><font style="color:#060; font-weight:bold;">' . ($sumTotal) . '</font></td>
                            <td></td>
                            </tr>';
                                                    if($Discount_type==2){ $Discount_val=$sumTotal*$_POST['alldiscount']/100; $val_lable="(".$_POST['alldiscount']."%)";}else{$Discount_val=$_POST['alldiscount'];}
                                                    echo'<tr>';
                                                    echo'<td colspan="5">الخصم '.$val_lable.'</td>';
                                                    echo'<td><font style="color:#060; font-weight:bold;">' . $Discount_val . '</font></td>
                            <td></td>
                            </tr>';
                                                    echo'<tr>';


                                                    if($use_sizes==1){
                                                        if ($use_colors == 1) {echo'<td colspan="7">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="6">'.$the_total_after_lang.'</td>'; }

                                                    }else{
                                                        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_after_lang.'</td>'; }
                                                    }


                                                    if ( $order_data[0]){
                                                        $print_total_disc =  $order_data[0]['discount'];
                                                    }else{
                                                        if($Discount_type==2){
                                                            $print_total_disc=$sumTotal*$_POST['alldiscount']/100;
                                                        }
                                                        else if($Discount_type==1){
                                                            $print_total_disc=$_POST['alldiscount'];
                                                        }else{}
                                                    }

                                                    echo'<td><font style="color:#060; font-weight:bold;">'.($sumTotal-$print_total_disc).'</font></td>
                            <td></td>
                            </tr>';
                                                }
                                                if($db_tax>0){
                                                    echo"<tr>";
                                                    echo'<td  colspan="5">'.$tax_lang.'</td>
                            <td><font style="color:#060; font-weight:bold;">'.(($sumTotal-$print_total_disc)*$db_tax/100).'</font></td><td></td>
                            </tr>';
                                                    echo'<tr><td  colspan="5">'.$Total_after_TAX_lang.'</td>
                            <td><font style="color:#060; font-weight:bold;">'.((($sumTotal-$print_total_disc)*$db_tax/100)+($sumTotal-$print_total_disc)).'</font></td><td></td>
                            </tr>';
                                                }
                                                if($shipping>0){
                                                    echo"<tr>";
                                                    echo'<td  colspan="5">م.النقل</td>
                            <td><font style="color:#060; font-weight:bold;">'.$_POST['shipping'].'</font></td><td></td>
                            </tr>';
                                                    echo'<tr><td  colspan="5">الاجمالى بعد م.النقل</td>
                            <td><font style="color:#060; font-weight:bold;">'.((($sumTotal-$print_total_disc)*$db_tax/100)+($sumTotal-$print_total_disc)+$_POST['shipping']).'</font></td><td></td>
                            </tr>';
                                                }
                                                ?>
                                            </tbody>

                                        </table>

                                        <input type="submit" name="submit" value="submit" hidden="hidden" id="inv_sub" />

                                </div>
                                <table width="100%" dir="rtl">
                                    <tr>
                                       
                                     
                                        <td style="font-size:16px;"><?php echo"$amount_paid_lang"; ?></td>
                                        <td style="font-size:16px;"><input type="text" name="paid" value="<?php  echo $_POST['paid']; ?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>
                                        <td style="font-size:16px;" class="text-left"><?php echo"التاريخ"; ?></td>
                                        <td><input type="text" name="date" id="date" value="<?php if ($_POST['date'] == "") {
                                                echo date("d/m/Y");
                                            } else {
                                                echo"" . $_POST['date'] . "";
                                            } ?>"  style="text-align:center; background-color:#CCC; width:80px; height:20px;"/>
                                            <script type="text/javascript">
                                                $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                            </script>
                                        </td>
                           
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="font-size:16px;"><?php echo"$Discount_lang"; ?></td>
                                        <td><input type="text" name="alldiscount" value="<?php if (!$_POST['alldiscount'] ){ echo"" . $order_data[0]['discount'] . "";}else if ($_POST['alldiscount']){
                                                echo"" . $_POST['alldiscount'] . "";
                                            }?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>
                                      
                                   </tr>

                                    <tr>
                                        <td style="font-size:16px;"  class="text-left"><?php echo $Store_name; ?></td>
                                        <td >

                                            <select name="store_id" size="1" class="js-example-placeholder-single  js-states form-control">
                                                <option value=""> <?php echo"$Store_name"; ?></option>
                                                <?php
                                                $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_store order by id ASC");
                                                $num_item = mysqli_num_rows($ProductsName);
                                                if ($num_item > 0) {
                                                    while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                        if ($row_item['id'] == $_POST['store_id']) {
                                                            echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                        } else {
                                                            echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>


                                        </td>
   <td style="font-size:16px;"  class="text-left"><?php echo $treasury_name_lang; ?></td>
                                        <td >

                                            <select name="safe_id" size="1" class="js-example-placeholder-single  js-states form-control">
                                                <option value=""> <?php echo"$treasury_name_lang"; ?></option>
                                                <?php
                                                $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id ASC");
                                                $num_item = mysqli_num_rows($ProductsName);
                                                if ($num_item > 0) {
                                                    while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                        if ($row_item['id'] == $_POST['safe_id']) {
                                                            echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                        } else {
                                                            echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>


                                        </td>
                                        <td style="font-size:16px;"  class="text-left"><?php echo $the_branch_name_lang; ?></td>
                                        <td >
                                            <?php if (!$_POST['branch_id'] ){ $selected_branch = $order_data[0]['branch_id'] ;}else if ($_POST['branch_id']){

                                                $selected_branch = $_POST['branch_id'] ;
                                            }?>

                                            <select name="branch_id" size="1" class="js-example-placeholder-single  js-states form-control">
                                                <option value=""> <?php echo"$the_branch_name_lang"; ?></option>
                                                <?php
                                                $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_branch order by id ASC");
                                                $num_item = mysqli_num_rows($ProductsName);
                                                if ($num_item > 0) {
                                                    while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                        if ($row_item['id'] == $selected_branch) {
                                                            echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                        } else {
                                                            echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>


                                        </td>

                                    </tr>
                                    <tr >
                                        <td  style="font-size:16px;" class="text-left"><?php echo $notes_lang; ?></td>
                                        <!--                                            --><?php //echo"$Discount_lang"; ?>
                                        </td>
                                        <td style="font-size:16px;" colspan="3">
                                            <textarea class="form-control" style="text-align: center" name="notes" ><?php echo $_POST['notes'];?></textarea>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6" align="center"><span style=" text-align:center; margin-right:50px;">
<!--                                                <input type="submit" name="submit" value="--><?php // if($db_tax>0){echo ((($sumTotal-$_POST['alldiscount'])*$db_tax/100)+($sumTotal-$_POST['alldiscount'])+$_POST['shipping']);}else{echo ($sumTotal - $print_total_disc+$_POST['shipping']);}; ?><!--"  style="width:120px; height:40px;" />-->
                                                <input type="submit" name="submit" value="<?php echo $Save_lang  ?>"  style="width:120px; height:40px;" />
                                            </span></td>
                                    </tr>
                                </table>
                                <div style="text-align:right; float:right;">
                                    <div style="float:right; width:200px; margin-right:150px; vertical-align:middle;">




                                    </div>
                                    <div style="float:right; text-align:center; margin-right:50px;">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="inv" value="sales" />
                            </form>

                        </div>
                        <div style="width:100%;border:1px solid #CCC; border-radius:5px;">
                            <div style="height:500px; overflow:auto;">
                                <script>
                                    window.onload = function () {
                                        <?php
                                        if($run_barcode==0){
                                            echo'document.getElementById("barcode").focus();';
                                        }else{
                                            echo'document.getElementById("search_box").focus();';
                                             }
                                        ?>
                                        
                                   
                                    };

                                </script>
                                <form method="get" class="noprint" style="padding-bottom:20px;">
                                    <div class="text-center">
                                    <?php if ($run_barcode == 0) {
                                        
                                    } else { ?>
                                        <input type="text" value="<?php
                                        if ($_GET['barcode'] == null) {
                                            
                                        } else {
                                            echo "" . $_GET['barcode'] . "";
                                        }
                                        ?>"
                                      <?php if($run_barcode==0){}else{echo'autofocus onfocus="this.select()"';} ?>    name="barcode" id="barcode"   style="background-color:#CCC; text-align: center;"
                       onblur="this.value=!this.value?'<?php echo"$barcode_lang"; ?>':this.value;"/>
                                    <?php } ?>
                                        <a href="#" onclick="javascript:void window.open('additems.php', '1390937502641', 'width=400,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                return false;">
                                            <i class="fa fa-plus-square"  title="<?php echo"$Add_New_item"; ?>"></i>
                                        </a>
                                        <span style="padding-right:20px;"></span><input type="text" <?php if($run_barcode==0){echo"autofocus";} ?> name="search_box" id="search_box" value="<?php echo"$item_Name_lang"; ?>"  style="background-color:#CCC; z-index:100000000000;"  onkeyup="showResultsOfItems(this.value)" autocomplete="off"    onclick="this.value = '';" onfocus="this.select()"  onblur="this.value = !this.value ? '<?php echo"$item_Name_lang"; ?>' : this.value;"/>
                                        <div id="livesearch" style="z-index:1000000000; width:45%;  text-align:right; margin-top:0px;  float:right; position:fixed; border:0px; "></div>
                                        <input type="submit" hidden="hidden"/>
                                    <?php
                                    if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                        
                                    } else {
                                      echo'
<span id="allCategories" >
<a class="addProd" par="cat_show" attr="0" ><i class="fa fa-list" title="'.$All_groups_lang.'"></i></a>
</span>';
                                    }
                                    ?>
                                    </div></form>

                                <div id="items">
                                    <?php
                                    if ($showGroups == 0) {

                                    } else {
                                        ?>
                                        <?php if ($db_cat_items_show > 0) {

                                        } else { ?>
                                            <div style="width:100%; margin:0 auto; text-align:center; float:right; text-align:center;">

                                                <?php
                                                $result_cat = mysqli_query($con, "SELECT * FROM products where rank!='0' and rank!='' and id>0  order by rank ASC");
                                                if (@mysqli_num_rows($result_cat) >= 1) {
                                                    while ($row_cat = mysqli_fetch_array($result_cat)) {
                                                        if ($row_cat['id'] == $db_cat_items_show) {
                                                            $class = "draggable-demo-product3";
                                                        } else {
                                                            $class = "draggable-demo-product2";
                                                        }
                                                        if ($row_cat['useimage'] == 1) {
                                                            echo "<div class=\"" . $class . " jqx-rc-all\" style='background-color:" . $row_cat['background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
<a  class='addProd' par='cat_show' attr='".$row_cat['id']."' class='a_cat_underlines'><img src=\"uploads/" . $row_cat['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"30\" /></a></div>

							</div>";

                                                        } else {
                                                            echo "<div   class=\"" . $class . " jqx-rc-all\" style='background-color:" . $row_cat['background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
							<div class=\"draggable-demo-product-header-label\"> <a  class='addProd' par='cat_show' attr='".$row_cat['id']."'>" . $row_cat['product_name'] . "</a></div></div>

							</div>";

                                                        }
                                                    }
                                                }
                                                ?>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php
                                    ###########################################
                                    $tbl_name = "items";
                                    //your table name
                                    // How many adjacent pages should be shown on each side?
                                    $adjacents = 3;

                                    /*
                                      First get total number of rows in data table.
                                      If you have a WHERE clause in your query, make sure you mirror it here.
                                     */
                                 //   if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                     //   $query = "SELECT COUNT(*) as num  FROM  items where OrderNo!='0' and OrderNo!=''  order by OrderNo ASC";
                                 //   } else {
                                        $query = "SELECT COUNT(*) as num  FROM  items  where OrderNo!='0' and OrderNo!='' and groupid=" . $db_cat_items_show . " order by OrderNo ASC";
                                  //  }
                                    $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                                    $total_pages = $total_pages[num];

                                    /* Setup vars for query. */
                                    $targetpage = "limit=" . $_GET['limit'] . "";
                                    //your file name  (the name of this file)
                                    //how many items to show per page
                                    if (!empty($_GET['limit'])) {
                                        $_SESSION[limit] = $_GET['limit'];
                                    } else {
                                        
                                    }
                                    if (!empty($_SESSION[limit])) {
                                        $limit = $_SESSION[limit];
                                        if ($limit > 100) {
                                            $limit = 20;
                                        }
                                    } else {
                                        $limit = 100;
                                    }
                                    $page = $_GET['page'];
                                    if ($page)
                                        $start = ($page - 1) * $limit;
                                    //first item to display on this page
                                    else
                                        $start = 0;
                                    //if no page var is given, set start to 0

                                    /* Get data. */
                                 //   if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                  //      $sql = "SELECT * FROM items where OrderNo!='0' and OrderNo!='' order by OrderNo ASC";
                                 //   } else {
                                        $sql = "SELECT * FROM items where OrderNo!='0' and OrderNo!='' and groupid=" . $db_cat_items_show . "  order by OrderNo ASC";
                              //      }
                                    $result = @mysqli_query($con, $sql);
                                    /* Setup page vars for display. */
                                    if ($page == 0)
                                        $page = 1;
                                    //if no page var is given, default to 1.
                                    $prev = $page - 1;
                                    //previous page is page - 1
                                    $next = $page + 1;
                                    //next page is page + 1
                                    $lastpage = ceil($total_pages / $limit);
                                    //lastpage is = total pages / items per page, rounded up.
                                    $lpm1 = $lastpage - 1;
                                    //last page minus 1

                                    /*
                                      Now we apply our rules and draw the pagination object.
                                      We're actually saving the code to a variable in case we want to draw it more than once.
                                     */
                                    $pagination = "";
                                    if ($lastpage > 1) {
                                        $pagination .= "<div class=\"pagination\">";
                                        //previous button
                                        if ($page > 1)
                                            $pagination .= "<a href=\"$targetpage&page=$prev\">>></a>";
                                        else
                                            $pagination .= "<span class=\"disabled\">>></span>";

                                        //pages
                                        if ($lastpage < 7 + ($adjacents * 2)) {//not enough pages to bother breaking it up
                                            for ($counter = 1; $counter <= $lastpage; $counter++) {
                                                if ($counter == $page)
                                                    $pagination .= "<span class=\"current\">$counter</span>";
                                                else
                                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                            }
                                        } elseif ($lastpage > 5 + ($adjacents * 2)) {//enough pages to hide some
                                            //close to beginning; only hide later pages
                                            if ($page < 1 + ($adjacents * 2)) {
                                                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                                    if ($counter == $page)
                                                        $pagination .= "<span class=\"current\">$counter</span>";
                                                    else
                                                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                }
                                                $pagination .= "...";
                                                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                            }
                                            //in middle; hide some front and some back
                                            elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                                                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                                                $pagination .= "...";
                                                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                                    if ($counter == $page)
                                                        $pagination .= "<span class=\"current\">$counter</span>";
                                                    else
                                                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                }
                                                $pagination .= "...";
                                                $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                                $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                            }
                                            //close to end; only hide early pages
                                            else {
                                                $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                                                $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                                                $pagination .= "...";
                                                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                                    if ($counter == $page)
                                                        $pagination .= "<span class=\"current\">$counter</span>";
                                                    else
                                                        $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                                }
                                            }
                                        }

                                        //next button
                                        if ($page < $counter - 1)
                                            $pagination .= "<a href=\"$targetpage&page=$next\"><<</a>";
                                        else
                                            $pagination .= "<span class=\"disabled\"><<</span>";
                                        $pagination .= "</div>\n";
                                    }
                                    ###############
                                    while ($row = @mysqli_fetch_array($result)) {
                                       
                                        if ($row['image'] == null or $row['useimage'] == 0) {
                                            ###################
                                            $qty_it=GetQuantity($row['id'],'1');
                                            echo "<div title= '$qty_it' class=\"draggable-demo-product jqx-rc-all\"  style='background-color:" . $row['Background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
							<div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a class='addProd' par='q' attr='".$row['id']."'>" . $row['item'] . "</a></div></div>

							</div>";
                                            /* 	echo"<div class=\"draggable-demo-product jqx-rc-all\"  style='background-color:".$row['Background']."; height:50px;'>
                                              <div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
                                              <div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a href=\"?q=".$row['id']."\">".$row['item']."</a></div></div>

                                              </div>"; */
                                            ###################
                                        } else {
                                            echo "<div class=\"draggable-demo-product jqx-rc-all\" title='$qty_it'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\">
							<div class=\"draggable-demo-product-header-label\"><a class='addProd' par='q' attr='".$row['id']."'>" . $row['item'] . "</a></div></div>

							<a class='addProd' par='q' attr='".$row['id']."'><img src=\"uploads/" . $row['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"100\" /></a>
							</div>";
                                        }
                                    }
                                    ?>

    <?php
    if ($total_pages == 0 and $db_cat_items_show!=0) {
	                       echo'<div class="alert alert-warning text-right" style="margin-top:100px;">
        '.$no_items_group_lang.'
                            </div>';
    }
    ?>

                                </div>
                            </div>

                        </div>

                    </div>
<?php } ?>
                <?php
                if($use_colors=='0' and $use_sizes=='0'){}else{ 
                 if($user_sale!=="1" and $user_IsAdmin!=1){}else{
echo'<button  type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="multi_items">'.$Insert_a_multi_alng.'</button>';
               }} ?>
            </article>

            <!--    <nav>nav</nav>-->
            <!-- <aside>aside</aside>-->
        </div>
        <div id="toolbar" class="noprint">
            <footer>
<?php include"includes/scroller_container.php"; ?>
            </footer>
        </div>
<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="myModal" class="modal fade"  role="dialog">
  <div class="modal-dialog" style="width:100%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title"><?php echo"$Insert_a_multi_alng"; ?></h4>
      </div>
        <div id="response"></div>
        <div class="modal-body" id="data">
        
      </div>
      <div class="modal-footer">
        <button  onClick="window.location.href=window.location.href" type="button" class="btn btn-default" data-dismiss="modal"><?php echo"$Close_lang"; ?></button>
      </div>
    </div>

  </div>
</div>
    </body>
<script>
   
        $(document).on("change",'.gr,.gr2',function() {
        // $('#inv_sub').click();
        var dataa =$('#inv_form').serialize();
        $.ajax({
            url: 'ajax/sales_add_product_temp.php',
            dataType: 'text',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: dataa+ '&ch_status=chngeQ',
            success: function (data, textStatus, jQxhr) {
                data = JSON.parse(data);
                $('#tablee').html(data['table']);
                // $('#ajaxRes').html(data['status']);
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    });
    $(document).on("click",'.addSupplier', function() {
        var attr_id = $(this).attr('attr-id');
        var attr_name = $(this).attr('attr-name');
        $('#ajaxResSupp').html(attr_name);
        $('#SupplierID').val(attr_id);

    });


    $(document).on("click",'.addProd', function() {
        var par = $(this).attr('par');
        if(par == 'q') {
            $.ajax({
                url: 'ajax/sales_add_product_temp.php',
                dataType: 'text',
                type: 'GET',
                contentType: 'application/x-www-form-urlencoded',
                data: {'q': $(this).attr('attr')},
                success: function (data, textStatus, jQxhr) {
                    data = JSON.parse(data);
                    $('#tablee').html(data['table']);
                    $('#ajaxRes').html(data['status']);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }else
        if(par == 'del'){
            $.ajax({
                url: 'ajax/sales_add_product_temp.php',
                dataType: 'text',
                type: 'GET',
                contentType: 'application/x-www-form-urlencoded',
                data: {'del': $(this).attr('attr')},
                success: function (data, textStatus, jQxhr) {
                    data = JSON.parse(data);
                    $('#tablee').html(data['table']);
                    $('#ajaxRes').html(data['status']);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
        else
        if(par == 'cat_show'){
            $.ajax({
                url: 'ajax/category_items_data.php',
                dataType: 'text',
                type: 'GET',
                contentType: 'application/x-www-form-urlencoded',
                data: {'cat_show': $(this).attr('attr')},
                success: function (data, textStatus, jQxhr) {
                    data = JSON.parse(data);
                    $('#items').html(data['items']);
                    if (parAttr ==0 ){
                        $('#allCategories').html('');
                    }else{
                        $('#allCategories').html('<a class="addProd" par="cat_show" attr="0" ><i class="fa fa-list" title="<?php echo $All_groups_lang ;?>"></i></a>');
                    }
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    });

    $(function() {
        (function($){
        function processForm( e ){
            $.ajax({
                url: 'storein_sales.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#response').html( data );
                          var $container = $("#data");
        $container.load('multi_items_sales.php');
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

            e.preventDefault();
        }

        $('#multi_items').click( processForm );
    })(jQuery);
    });
</script>
      <script type="text/javascript">//<![CDATA[
            window.onload = function() {
                $(document).ready(function() {
                    shortcut.add("Ctrl+i", function() {
                      //  $('span').html("أحسنت. لقد ضغطت على حرفي : Ctrl+i");
                    });
                                 shortcut.add("Ctrl+B", function() {
                      //  $('span').html("أحسنت. لقد ضغطت على حرفي : Ctrl+i");
                    });
                });
            }//]]>
          $(".js-example-placeholder-single").select2({
              placeholder: "اختر",
              allowClear: true
          });
          $(document).on("click",'.addSupplier', function() {
              $('.addSupplier').hide();
          });
        </script>
</html>
<?php //include 'includes/footer.php'; ?>