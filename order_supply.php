<?php
include "includes/inc.php";
########################
$new='جديد';
$new_status=get__order_supply_status_data_by_name($new);

if ($new_status){

    $new_status= $new_status[id];
}else{
    $sql="INSERT INTO ".$prefix."_order_supply_status (name, notes)
VALUES ('".$new."','".$notes."')";

if (mysqli_query($con,$sql))
{
    $new_status = $con->insert_id;

}
}


##########################
if (isset($_GET['order_supply_type'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET order_supply_type=" . $_GET['order_supply_type'] . " where id=" . $get_db_id . "");
    header("refresh:0;url=order_supply.php");
}
##########################
//if (isset($_GET['unsuspend'])) {
//     mysqli_autocommit($con,FALSE);
//    if (mysqli_query($con, "INSERT INTO " . $prefix . "_order_supply_temporary(item, Price, Quantity, Discount, Total, SupplierID, BuyPrice, date, type, order_supply_type, subqty, size, color, user_id)
//SELECT item,Price,Quantity,Discount,Total,SupplierID,BuyPrice,date,type,order_supply_type,subqty,size,color,user_id from " . $prefix . "_order_supply_suspended")) {
//        if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply_suspended where user_id='$user_id'")) {
//
//            $report_suspend = '0';
//        }else{
//            $error +=1;
//            $mysqli_errno++;
//        }
//    }
//    if($error>0){
//        mysqli_rollback($con);
//    }
//       mysqli_commit($con);
//}
####################################
mysqli_query($con, "UPDATE ".$prefix."_order_supply_temporary SET type='1' where user_id='$user_id' and type='2'");
mysqli_query($con, "UPDATE ".$prefix."_order_supply_temporary SET Quantity=Quantity*-1 where user_id='$user_id' and Quantity<=0");
mysqli_query($con, "UPDATE ".$prefix."_order_supply_temporary SET Total=Total*-1 where user_id='$user_id' and Total<=0");
if (isset($_POST['date'])) {
    $_POST['date'] = str_replace("/", "-", $_POST['date']);
    $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));
    ##################
    if (mysqli_query($con, "UPDATE " . $prefix . "_order_supply_temporary SET  date='$DueDate' where user_id=$user_id")) {
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

<!--        <script>-->
<!--            function showResults(str) {-->
<!--                if (str.length == 0) {-->
<!--                    document.getElementById("livesearchcl").innerHTML = "";-->
<!--                    document.getElementById("livesearchcl").style.border = "0px";-->
<!--                    return;-->
<!--                }-->
<!--                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari-->
<!--                    xmlhttp = new XMLHttpRequest();-->
<!--                } else {// code for IE6, IE5-->
<!--                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");-->
<!--                }-->
<!--                xmlhttp.onreadystatechange = function () {-->
<!--                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {-->
<!--                        document.getElementById("livesearchcl").innerHTML = xmlhttp.responseText;-->
<!--                        document.getElementById("livesearchcl").style.border = "0px solid #A5ACB2";-->
<!--                    }-->
<!--                }-->
<!--                xmlhttp.open("GET", "clients_search.php?q=" + str, true);-->
<!--                xmlhttp.send();-->
<!--            }-->
<!--        </script>-->
        <script>
            function showResultsOfItems(str) {
                // alert('2');
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
                str=str+'&offers=order_supply';
                xmlhttp.open("GET", "items_search_order_supply.php?q=" + str, true);
                xmlhttp.send();
            }
        </script>
                <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
    
        <script type="text/javascript">

            $(function () {
                console.log('Change event11111111111111111111111.');

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


                Get the value of the number for the demo.
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
                    if (isset($_GET['order_supply_cat'])) {
                        mysqli_query($con, "UPDATE " . $prefix . "_config SET order_supply_cat_items_show=" . $_GET['order_supply_cat'] . " where id=" . $get_db_id . "");
                        header("refresh:0;url=order_supply.php");
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
                if ($user_order_supply !== "1" and $user_IsAdmin != 1) {
                    echo"<div style='margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;'>'.$not_have_permission_lang.'</div>";
                } else {
                    ?>
                    <div class="noprint">
                        <div style="width:60%;border:1px solid #CCC; border-radius:5px; float:right; ">
                            <div>
                                <div id="livesearchcl" style="z-index:1000000000; width:45%;  text-align:right; margin-top:30px;  float:right; position:fixed; border:0px; "></div>
                                <div style="width:100%; padding-top:10px; text-align:center; margin:0 auto;border:0px solid #CCC; border-radius:5px;"">


                                <a class="addProd" par="q" attr="d"><img src="images/c.png" style="width:30px; height:30px; float:left; border:0px;"  title="<?php /*echo"$Cancel_lang"; */?>"/></a>


 <?php
                                    if ($Retail_allow == "1") {
                                        if ($get_db_order_supply_type == "1") {
                                            echo' <a href="order_supply.php?order_supply_type=2"><img src="images/Shopping_retail-04-128.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Retail_lang.'"   /></a>';
                                        } else if ($get_db_order_supply_type == "2") {
                                            echo'<a href="order_supply.php?order_supply_type=1"><img src="images/g.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Wholesaling_lang.'" /></a>';
                                        } else {
                                            echo'<a href="order_supply.php?order_supply_type=1"><img src="images/g.png" style="width:30px; height:30px; float:left; border:0px;" title="'.$Wholesaling_lang.'" /></a>';
                                        }
                                    }
                                    ?>





                                    <?php
                                    if ($_GET['print_inv'] !== null) {
                                        ##############
                                        $result_Get_supplier = mysqli_query($con, "SELECT  supplier  FROM ".$prefix."_order_supply_inv where  inv_id=".$_GET['print_inv']."");
                                        while ($row_Get_supplier = @mysqli_fetch_array($result_Get_supplier)) {
                                            $GsupplierID = $row_Get_supplier['supplier'];
                                        }
                                        ##############
                                        ?>
                                        <?php if ($GsupplierID == null) {

                                        } else { ?>
                                            <a href="#" onclick="javascript:void window.open('statement_of_account_client.php?id=<?php echo"" . $GsupplierID . ""; ?>&from=<?php echo"" . date("Y-m-01") . ""; ?>&to=<?php echo"" . date("Y-m-d") . ""; ?>', '1390937502641', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                    return false;"><img src="images/arrears_list.gif" style="float:left; border:0px; margin-top:10px;" title="<?php echo"$client_statement_lang"; ?>" /></a>
        <?php } ?>
                                    <?php } ?>

                                   <?php echo"$Bill_of_order_supply_lang"; ?></div>
                                <div style="width:100%; padding-top:0px; text-align:center; margin:0 auto;border:0px dashed #CCC; border-radius:5px; height:290px; overflow:auto;">
                                    <?php
                                    if ($report_suspend == "1") {
                                        echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$suspended_bill_lang.'
							</div>';
                                        header("refresh:1;url=order_supply.php");
                                    }
                                    if (($_POST['submit']) == $Save_lang and $_POST['submit'] != null) {
                                        ###################################
                                            mysqli_autocommit($con,FALSE);
                                        $result_upt = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC");
                                        while ($row_upt = mysqli_fetch_array($result_upt)) {
                                            //echo $row_up['id'];
                                            $quantityt = $_POST[quantity . $row_upt['id']];
                                            $Pricet = $_POST[price . $row_upt['id']];
                                            $stafft = $_POST[staff . $row_upt['id']];
                                            $Discountt = $_POST[discount . $row_upt['id']];
                                            $order_supply_type = $_POST[order_supply_type . $row_upt['id']];
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
                                        $pay = $_POST['pay'] ?? 0;

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
//                                        if($db_tax>0){
//                                         $total_inv_after_alldiscount_and_tax=($inv_Totalt - $alldiscount)+(($inv_Totalt - $alldiscount)*$db_tax/100);
//                                        }else{
                                          $total_inv_after_alldiscount_and_tax=($inv_Totalt - $alldiscount);
//                                        }
                                       $total_inv_after_alldiscount_and_tax_ship=$total_inv_after_alldiscount_and_tax+$_POST['shipping'];
                                      // echo"<br />";
                                     //  echo $paid;
//                                       if ($_POST['client'] == "" and round($paid,2) != round($total_inv_after_alldiscount_and_tax_ship,2)) {
//                                            //print $paid;
//                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
//							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
//							'.$must_choose_customer.'
//							</div>';
//                                        }
//                                       else
//                                        var_dump(current_order_supply_temp_data($user_id));
//                                        die();
                                    if (current_order_supply_temp_data($user_id) ==0 ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_at_least_item.'
							</div>';
                                        }elseif ($_POST['client'] == "" ) {
                                        //print $paid;
                                        echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_add_customer_name.'
							</div>';
                                    }elseif ($_POST['mobile1'] == "" ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_mobile.'
							</div>';
                                        }elseif ($_POST['branch_id'] == "" ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_branch.'
							</div>';
                                        }elseif ($_POST['region_id'] == "" ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_region.'
							</div>';
                                        } elseif ($_POST['address'] == "" ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_address.'
							</div>';
                                        }
                                       else {
                                            if ($paid < 0 or $paid == null or $paid == "") {

                                            } else {

                                                $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];

                                                $sqlpayments_suppliers = "INSERT INTO " . $prefix . "_order_supply_inv (status,mobile1,mobile2,address,branch_id,region_id,centers_id,alpha,supplier, Total, date, PaymentMethod, DueDate, type, discount, staff, client, tax,shipping,notes, user_id) VALUES ('" .$new_status . "','".$_POST['mobile1'] . "','".$_POST['mobile2']  . "','".$_POST['address']  . "','".$_POST['branch_id'] . "','".$_POST['region_id'] . "','" . $centers_id_post .
                                                    "','". $_POST['alpha'] . "','". $_POST['SupplierID'] . "','" . ($paid * -1) . "','" . $DueDate . "','" . $pay . "','"  . "','3','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','" . $_POST['client'] . "','" . (($db_tax/(100+$db_tax))*(($inv_Totalt - $alldiscount))) . "','" . $_POST['shipping']. "','" . $_POST['notes']. "','" . $user_id . "')";


                                            if (!mysqli_query($con, $sqlpayments_suppliers)) {
                                                    echo"$Error_lang .....";
                                                    $mysqli_errno++;
                                                } else {
                                                    $pp = 1;
                                                    if ($alldiscount <= 0) {

                                                    } else {
                                                        $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];

                                                        $sqlpayments = "INSERT INTO " . $prefix . "_order_supply_inv (status,mobile1,mobile2,address,branch_id,region_id,centers_id,alpha,supplier, Total, date, PaymentMethod, DueDate, type, discount, staff, client, tax,shipping,notes, user_id) VALUES ('" .  $new_status . "','". $_POST['mobile1'] . "','".$_POST['mobile2']  . "','".$_POST['address']  . "','".$_POST['branch_id']. "','".$_POST['region_id'] . "','" . $centers_id_post .
                                                            "','". $_POST['alpha'] . "','" . $_POST['SupplierID'] . "','" . (($alldiscount) * -1) . "','" . $DueDate . "','" . $pay . "','','".$Cash_discount_lang."','3','" . $_POST['alldiscount'] . "','" . $_POST['staff'] . "','" . $_POST['client'] . "','" . (($db_tax/(100+$db_tax))*(($inv_Totalt - $alldiscount))) . "','" . $_POST['shipping']. "','" . $_POST['notes'] ."','" . $user_id . "')";


                                                        if (!mysqli_query($con, $sqlpayments)) {
                                                           echo"$Error_lang ..";
                                                           $mysqli_errno++;
                                                        } else {
                                                            $pp = 1;
                                                        }
                                                    }
                                                }
                                            }
                                            ############################
                                            mysqli_query($con, "UPDATE " . $prefix . "_config SET  Lastorder_supplyInvoiceNo= Lastorder_supplyInvoiceNo + 1 where id=" . $get_db_id . "");
                                            mysqli_query($con, "select Lastorder_supplyInvoiceNo FRom  " . $prefix . "_config  where id=" . $get_db_id . "");
                                            $result_LastInvoiceNo = mysqli_query($con, "SELECT Lastorder_supplyInvoiceNo FROM " . $prefix . "_config where id='1'");
                                            while ($row_LastInvoiceNo = mysqli_fetch_array($result_LastInvoiceNo)) {
                                                $get_LastInvoiceNo = $row_LastInvoiceNo['Lastorder_supplyInvoiceNo'];
                                            }
######################
                                            ######################
                                            $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC");
                                            while ($row_up = mysqli_fetch_array($result_up)) {
                                                //echo $row_up['id'];
                                                $item = round($_POST[item . $row_up['id']]);
                                                $quantity = $_POST[quantity . $row_up['id']];
                                                $Price = $_POST[price . $row_up['id']];
                                                $staff = $_POST[staff . $row_up['id']];
                                                $Discount = $_POST[discount . $row_up['id']];
                                                $order_supply_type = $_POST[order_supply_type . $row_up['id']];
                                                if ($Retail_allow == 1) {

                                                } else {
                                                    $order_supply_type = "1";
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

                                               $update_temp_sql="UPDATE " . $prefix . "_order_supply_temporary SET centers_id='" . $_POST['centers_id'] . "',region_id='" . $_POST['region_id'] . "',alpha='" . $_POST['alpha'] . "',branch_id='" . $_POST['branch_id']. "',address='" . $_POST['address'] . "', mobile1='" . $_POST['mobile1'] . "',mobile2='" . $_POST['mobile2'] . "',inv_id='" . $get_LastInvoiceNo . "',staff='" . $staff . "',Quantity='" . $quantity . "',
Price='" . $Price . "',Discount='" . $Discount . "',Total='" . $Total . "',date='" . $DueDate . "',type='1',order_supply_type='" . $order_supply_type . "',BuyPrice=(select price from items where id='" . $item . "') where user_id='$user_id' and id='" . $row_up['id'] . "'";
if (mysqli_query($con, $update_temp_sql)) {
#############التأثير على المخزون###########
//if(mysqli_query($con, "UPDATE items SET Quantity=Quantity-$quantity where  id='".$row_up['item']."'")){}
###########################################
                                                }
                                                //echo"echo mysqli_errno($con);<br />";
                                            }
                                            ######################
if($db_tax>0){$add_tax_inv=($inv_Total-$_POST['alldiscount'])*$db_tax/100;}else{$add_tax_inv=0;}

                                           $shipping = $_POST['shipping'] == '' ? 0 : $_POST['shipping'];
                                            $staff = $_POST['staff'] == '' ? 0 : $_POST['staff'];

                                           $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];

if (mysqli_query($con, "INSERT INTO " . $prefix . "_order_supply_inv(status,mobile1,mobile2,address,branch_id,region_id,centers_id,alpha,inv_id, date, Total, supplier, PaymentMethod, DueDate, CheckNumber, type, paid, discount, staff, client, tax, shipping, notes,user_id) VALUES ('" . $new_status . "','". $_POST['mobile1'] . "','".$_POST['mobile2']  . "','".$_POST['address']  . "','".$_POST['branch_id']. "','".$_POST['region_id'] . "','" . $centers_id_post .
                                                "','" . $_POST['alpha'] . "','". $get_LastInvoiceNo . "','" . $DueDate . "','" . $inv_Total . "','" . $_POST['SupplierID'] . "','" . $pay . "','". $DueDate ."','" . $CheckNumber  . "','1','" . $paid . "','" . $_POST['alldiscount'] . "','" . $staff . "','" . $_POST['client'] . "','" .$add_tax_inv. "','" . $shipping ."','" . $_POST['notes'] . "','" . $user_id . "')")) {
                                                $Report_Create_Invoice = 1;

                                                if (mysqli_query($con, "INSERT INTO " . $prefix . "_order_supply(item_status,Quantity, Discount, Total, SupplierID, BuyPrice, date, type, order_supply_type, subqty, inv_id, item, Price, size, color, user_id, staff)
SELECT item_status,(CASE when order_supply_type=2 then  Quantity/subqty else Quantity END) ,Discount,Total,SupplierID,BuyPrice,date,type,order_supply_type,subqty,{$get_LastInvoiceNo},item,Price,size,color,user_id,staff from " . $prefix . "_order_supply_temporary where user_id='$user_id' ")) {
                                                    $Report_Record_purchases = 1;
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
                                            if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply_temporary where user_id='$user_id'")) {
                                                header("refresh:1;url=order_supply.php?print_inv=" . $get_LastInvoiceNo . "");
                                            }else{
                                                $mysqli_errno++;
                                            }
                                            //echo $inv_Total;
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
                                    <?php if (isset($_GET['SupplierID']) and $_GET['SupplierID'] !== null) {
                                        $SupplierID = $_GET['SupplierID'];
                                        if (mysqli_query($con, "UPDATE ".$prefix."_order_supply_temporary SET SupplierID=".$SupplierID." where user_id='$user_id'")) {
                                            header("refresh:1;url=order_supply.php");
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
                                            //	header( "refresh:0;url=order_supply.php" );
                                        } else {

                                                $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $db_item_id . "'");
                                                if (@mysqli_num_rows($result_new) >= 1) {

                                                    while ($row_new = mysqli_fetch_array($result_new)) {
                                                        $item_name_new = $row_new['item'];
                                                        $item_id_new = $row_new['id'];
                                                        if ($get_db_order_supply_type == "1") {
                                                            $item_Retail_price_new = $row_new['Retail_price'];
                                                        } else {
                                                            $item_Retail_price_new = $row_new['subprice'];
                                                        }
                                                        $item_Discount_new = $row_new['Discount'];
                                                        $item_price_new = $row_new['price'];
                                                        $item_subqty = $row_new['subqty'];
                                                        $item_centers_id = $row_new['centers_id'];
                                                        if ($Discount_type == 1) {
                                                            $item_total_new = $item_Retail_price_new - $row_new['Discount'];
                                                        } else if ($Discount_type == 2) {
                                                            $item_total_new = $item_Retail_price_new - (($item_Retail_price_new) * ($row_new['Discount'] / 100));
                                                        } else {
                                                            $item_total_new = $item_Retail_price_new;
                                                        }
                                                        if ($_GET['item_type']== $prefix . "_offers_inv"){
                                                            $item_status = 'offers';
                                                        }else{
                                                            $item_status = 'items';
                                                        }

                                                        $sql = "INSERT INTO " . $prefix . "_order_supply_temporary (item_status,item, Price, Quantity, Discount, Total, BuyPrice, date, type, subqty, order_supply_type, size ,color, user_id )
							VALUES ('" .$item_status . "','" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','" . $item_price_new . "','" . $DueDate . "','1','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $get_barcode_size . "','" . $get_barcode_color . "','".$user_id."')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
                                                        header("refresh:1;url=order_supply.php");
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                        header("refresh:1;url=order_supply.php");
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

                                  <?php
                                    $sql = "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC";
                                                $result = @mysqli_query($con, $sql);


                                                ?>

                                        <div class="row" dir="rtl">
                                        <div class="col-12" >

<label><?php echo $The_client_lang;?></label>
                                        <input type="text" placeholder=" <?php echo"$The_client_lang"; ?>" name="client" value="<?php echo"" . $_POST['client'] . ""; ?>"  />
<br/>
<br/>
<br/>
                                        </div>
                                        </div>
                                        <div class="row" dir="rtl">

                                        <select name="branch_id" size="1" class="js-example-placeholder-single2 w25 js-states form-control">


                                            <?php
                                            if($user_branch_id=="0"){ ?>
                                                    <option value=""> <?php echo"$the_branch_name_lang"; ?></option>
                                            <?php }else{
                                                $user_perme="where id IN ($user_branch_id)";
                                            }
                                            $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_branch $user_perme order by id ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_POST['branch_id']) {
                                                        echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <select name="region_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                                            <option value=""> <?php echo"$region_name"; ?></option>
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_region   order by parent_id ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_POST['region_id']) {
                                                        echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                            <select name="centers_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                                                <option value=""> <?php echo"المركز"; ?></option>
                                                <?php
                                                $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_centers   order by parent_id ASC");
                                                $num_item = mysqli_num_rows($ProductsName);
                                                if ($num_item > 0) {
                                                    while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                        if ($row_item['id'] == $_POST['centers_id']) {
                                                            echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                        } else {
                                                            echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>


                                        <input type="text" placeholder=" <?php echo"$Address1_lang"; ?>" name="address" value="<?php echo"" . $_POST['address'] . ""; ?>"  />

                                        <input type="text"
                                               pattern="[0-9]{11}"
                                               title="<?php echo $mobile_error ; ?>"
                                               name="mobile1" placeholder="<?php echo"$Mobile1_lang"; ?>" value="<?php echo"" . $_POST['mobile1'] . ""; ?>"  />

                                        <input type="text"
                                               pattern="[0-9]{11}"
                                               title="<?php echo $mobile_error ; ?>"
                                               name="mobile2" placeholder="<?php echo"$Mobile2_lang"; ?>" value="<?php echo"" . $_POST['mobile2'] . ""; ?>"  />

                                              <select name="alpha" size="1" class="js-example-placeholder-single w25 js-states form-control">
                                              <option value="" <?php if($_POST['alpha']==""){echo 'selected="selected"';} ?>>code</option>
                                            <option value="A" <?php if($_POST['alpha']=="A"){echo 'selected="selected"';} ?>>A</option>
                                            <option value="B" <?php if($_POST['alpha']=="B"){echo 'selected="selected"';} ?>>B</option>
                                            <option value="C" <?php if($_POST['alpha']=="C"){echo 'selected="selected"';} ?>>C</option>
                                            <option value="D" <?php if($_POST['alpha']=="D"){echo 'selected="selected"';} ?>>D</option>
                                            <option value="E"  <?php if($_POST['alpha']=="E"){echo 'selected="selected"';} ?>>E</option>
                                            <option value="F"  <?php if($_POST['alpha']=="F"){echo 'selected="selected"';} ?>>F</option>
                                            <option value="G"  <?php if($_POST['alpha']=="G"){echo 'selected="selected"';} ?>>G</option>
                                            <option value="H"  <?php if($_POST['alpha']=="H"){echo 'selected="selected"';} ?>>H</option>
                                            <option value="I"  <?php if($_POST['alpha']=="I"){echo 'selected="selected"';} ?>>I</option>
                                            <option value="J"  <?php if($_POST['alpha']=="J"){echo 'selected="selected"';} ?>>J</option>
                                            <option value="K"  <?php if($_POST['alpha']=="K"){echo 'selected="selected"';} ?>>K</option>
                                            <option value="L"  <?php if($_POST['alpha']=="L"){echo 'selected="selected"';} ?>>L</option>
                                            <option value="M"  <?php if($_POST['alpha']=="M"){echo 'selected="selected"';} ?>>M</option>
                                            <option value="N"  <?php if($_POST['alpha']=="N"){echo 'selected="selected"';} ?>>N</option>
                                            <option value="O"  <?php if($_POST['alpha']=="O"){echo 'selected="selected"';} ?>>O</option>
                                            <option value="P"  <?php if($_POST['alpha']=="P"){echo 'selected="selected"';} ?>>P</option>
                                            <option value="Q"  <?php if($_POST['alpha']=="Q"){echo 'selected="selected"';} ?>>Q</option>
                                            <option value="R"  <?php if($_POST['alpha']=="R"){echo 'selected="selected"';} ?>>R</option>
                                            <option value="S"  <?php if($_POST['alpha']=="S"){echo 'selected="selected"';} ?>>S</option>
                                            <option value="T" <?php if($_POST['alpha']=="T"){echo 'selected="selected"';} ?>>T</option>
                                            <option value="U" <?php if($_POST['alpha']=="U"){echo 'selected="selected"';} ?>>U</option>
                                            <option value="V" <?php if($_POST['alpha']=="V"){echo 'selected="selected"';} ?>>V</option>
                                            <option value="W" <?php if($_POST['alpha']=="W"){echo 'selected="selected"';} ?>>W</option>
                                            <option value="X" <?php if($_POST['alpha']=="X"){echo 'selected="selected"';} ?>>X</option>
                                            <option value="Y" <?php if($_POST['alpha']=="Y"){echo 'selected="selected"';} ?>>Y</option>
                                            <option value="Z" <?php if($_POST['alpha']=="Z"){echo 'selected="selected"';} ?>>Z</option>
                                            </select>
                                        </div>




                                        <!--                                        --><?php
//                                        $result_SupplierID = mysqli_query($con, "SELECT SupplierID FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' limit 0,1");
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

//                                        ?><!-- -->
                                        <div id="ajaxRes">
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
                                            <th hidden class="text-center"><?php echo"$the_Discount_lang"; ?></th>
                                            <th class="text-center"><?php echo"$the_total_lang"; ?></th>
                                            <th class="text-center"><?php echo"$Delete_lang"; ?></th>
                                            </thead>
                                            <tbody  id="tablee">
                                                <?php
                                                $sql = "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC";
                                                $result = @mysqli_query($con, $sql);
                                                $tbl_name = "" . $prefix . "order_supply_temporary";
                                                //your table name
                                                // How many adjacent pages should be shown on each side?
                                                $adjacents = 3;

                                                /*
                                                  First get total number of rows in data table.
                                                  If you have a WHERE clause in your query, make sure you mirror it here.
                                                 */
                                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC";
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
                                                    ###########

                                                    if ($row['item_status']=='offers'){
                                                        $result_it = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers_inv where id=" . $row['item'] . "");
                                                        if (@mysqli_num_rows($result_it) > 0) {
                                                            while ($row_it = mysqli_fetch_array($result_it)) {
                                                                $item_name = $row_it['name'];
                                                                $item_id = $row_it['id'];
                                                                $item_price = $row_it['Total'];
                                                                $item_Discount = $row_it['Discount'];
                                                                $item_BuyPrice = $row_it['price'];
                                                            }
                                                        }


                                                    }else{
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


                                                    if ($item_Discount == null) {
                                                        $item_Discount = 0;
                                                    }
                                                    $sumTotal+= $row['Total'];
                                                    ###########
                                                    #############تحديث سعر البيع#####
                                                    if ($Update_SellBuyPrice == 1) {
                                                        if ($row['order_supply_type'] == "1") {
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
							<td >
							<input type="hidden" name="item' . $row['id'] . '" value="' . $item_id . '" />' . $item_name . '</td>';
                                                    if ($Retail_allow == "1") {
                                                        echo'<td>';
                                                        echo'<select  class="'.$gr.'"  name="order_supply_type' . $row['id'] . '" style="width:10%; height:20px; text-align:center;border:0px;>';
                                                        ?>
                                                    <option value="0" <?php if ($row['order_supply_type'] == "0") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Select_Type_lang"; ?></option>
                                                    <option value="1" <?php if ($row['order_supply_type'] == "1") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Wholesaling_lang"; ?></option>
                                                    <option value="2" <?php if ($row['order_supply_type'] == "2") {
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
                                                echo'<td><input  tabindex = "'.$i.'" class="'.$gr.'" type="text"  name="price' . $row['id'] . '" id="price' . $i . '" value="' . $row['Price'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input class="'.$gr.'" type="text"  name="subtotal' . $row['id'] . '" id="subtotal' . $i . '" value="' . $row['Total'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td valign="middle"><a class="addProd" par="del" attr="'.$row['id'].'"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';


/*							<td><input  class="'.$gr.'" type="hidden"  name="discount' . $row['id'] . '" id="discount' . $i . '" value="' . $row['Discount'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>*/


                                                $i++;
                                            }
                                            ?>
                                                <?php
                                                if ($sumTotal == null) {

                                                } else {
                                                    echo'<tr>';

                                                    if($use_sizes==1){
                                                        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_lang.'</td>'; }

                                                    }else{
                                                        if ($use_colors == 1) {echo'<td colspan="5">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="4">'.$the_total_lang.'</td>'; }
                                                    }
                                                    echo'<td><font style="color:#060; font-weight:bold;">' . ($sumTotal) . '</font></td>
                            <td></td>
                            </tr>';
                                                    if($Discount_type==2){ $Discount_val=$sumTotal*$_POST['alldiscount']/100; $val_lable="(".$_POST['alldiscount']."%)";}else{$Discount_val=$_POST['alldiscount'];}
                                                    echo'<tr>';
                                                    echo'<td colspan="4">الخصم '.$val_lable.'</td>';
                                                    echo'<td><font style="color:#060; font-weight:bold;">' . $Discount_val . '</font></td>
                            <td></td>
                            </tr>';
                                                    echo'<tr>';


                                                    if($use_sizes==1){
                                                        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_after_lang.'</td>'; }

                                                    }else{
                                                        if ($use_colors == 1) {echo'<td colspan="5">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="4">'.$the_total_after_lang.'</td>'; }
                                                    }
                                                    if($Discount_type==2){
                                                        $print_total_disc=$sumTotal*$_POST['alldiscount']/100;
                                                    }
                                                    else if($Discount_type==1){
                                                        $print_total_disc=$_POST['alldiscount'];
                                                    }else{}
                                                    echo'<td><font style="color:#060; font-weight:bold;">'.($sumTotal-$print_total_disc).'</font></td>
                            <td></td>
                            </tr>';
                                                }
                                                          if($_POST['shipping']>0){
                                                          echo"<tr>";
                                                     echo'<td  colspan="4">م.النقل</td>
                                                                            <td><font style="color:#060; font-weight:bold;">'.$_POST['shipping'].'</font></td><td></td>
                                                                            </tr>';
                                                        echo'<tr><td  colspan="4">الاجمالى بعد م.النقل</td>
                                                                            <td><font style="color:#060; font-weight:bold;">'.$total_inv_after_alldiscount_and_tax_ship.'</font></td><td></td>
                                                                            </tr>';
                                                    }
                                                ?>
                                            </tbody>

                                        </table>

                                        <input type="submit" name="submit" value="submit" hidden="hidden" id="inv_sub" />

                                </div>
                                <table width="100%" dir="rtl">
                                    <tr>

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
                                        <td style="font-size:16px;" class="text-left"><?php echo"م.النقل"; ?></td>
                                        <td style="font-size:16px;"><input class="gr"  style="text-align:center; background-color:#CCC; width:80px; height:20px;" type="text" name="shipping" value="<?php echo"" . $_POST['shipping'] . ""; ?>" /></td>

                                        <td class="text-left" style="font-size:16px;"><?php echo"$Discount_lang"; ?></td>
                                        <td><input class="gr" type="text" name="alldiscount" value="<?php echo"" . $_POST['alldiscount'] . ""; ?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>


                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;" class="text-left"><?php echo $notes_lang; ?></td>
                                        <!--                                            --><?php //echo"$Discount_lang"; ?>
                                        </td>
                                        <td style="font-size:16px;">
                                        <textarea class="form-control" style="text-align: center" name="notes" ><?php echo $_POST['notes'];?></textarea>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="text-left" style="font-size:16px;">

<!--                                       <td style="font-size:16px;"  class="text-left">--><?php //echo"الضرائب"; ?><!--</td>-->
              <td><input style="display:none;" type="checkbox" name="inv_tax" id="inv_tax" value="1" <?php if($_POST['inv_tax']==null or $_POST['inv_tax']=="0"){}else{echo' checked="checked"';} ?> /></td>

<!--                                        <td style="font-size:16px;"  class="text-left">--><?php //echo"$the_Employee"; ?><!--</td>-->
                                        <td><select name="staff" style="display:none;" style="text-align:center;background-color:#CCC; float:right;">
<option value="" <?php if($_POST['staff']=="" or $_POST['staff']==null){echo "selected='selected'";}else{} ?>></option>
<?php
$result_staff = mysqli_query($con,"SELECT * FROM ".$prefix."_staff");
if(mysqli_num_rows($result_staff)>0){
while($row_staff = mysqli_fetch_array($result_staff))
  {
    if($row_staff['id']==$_POST['staff']){$select="selected='selected'";}else{$select=null;}
echo'<option value="'.$row_staff['id'].'" '.$select.'>'.$row_staff['name'].'</option>';
  }
}
?>

                                            </select></td>
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
                            <input type="hidden" name="inv" value="order_supply" />
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
                                        <span style="padding-right:20px;"></span>

                                        <input type="text" <?php if($run_barcode==0){echo"autofocus";} ?> name="search_box" id="search_box" value="<?php echo"$item_Name_lang"; ?>"  style="background-color:#CCC; z-index:100000000000;"  onkeyup="showResultsOfItems(this.value)" autocomplete="off"    onclick="this.value = '';" onfocus="this.select()"  onblur="this.value = !this.value ? '<?php echo"$item_Name_lang"; ?>' : this.value;"/>
                                        <div id="livesearch" style="z-index:1000000000; width:45%;  text-align:right; margin-top:0px;  float:right; position:fixed; border:0px; "></div>
                                        <input type="submit" hidden="hidden"/>
                                    <?php
                                    if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {

                                    } else {
                                      echo'

<span id="allCategories">
<a class="addProd" par="cat_show" attr="0" ><i class="fa fa-list" title="'.$All_groups_lang.'"></i></a></span>';
                                    }
                                    ?>
                                    </div></form>

                                <div id="items">
                                    <?php
                                    if ($showGroups == 0) {

                                    }
                                    else {
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
                                        $query = "SELECT COUNT(*) as num  FROM  items  where OrderNo !='0' and OrderNo!='' and groupid=" . $db_cat_items_show . " order by OrderNo ASC";
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
//                                        $sql = "SELECT * FROM cairo_offers_inv order by id ASC";

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
							<div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a class='addProd' data_item_type='items'  par='q' attr='".$row['id']."'>" . $row['item'] . "</a></div></div>

							</div>";

                                        } else {
                                            echo "<div class=\"draggable-demo-product jqx-rc-all\" title='$qty_it'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\">
							<div class=\"draggable-demo-product-header-label\"><a class='addProd' data_item_type='items'  par='q' attr='".$row['id']."'>" . $row['item'] . "</a></div></div>

							<a class='addProd' data_item_type='items' par='q' attr='".$row['id']."'><img src=\"uploads/" . $row['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"100\" /></a>
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
                 if($user_order_supply!=="1" and $user_IsAdmin!=1){}else{
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
        $(".js-example-placeholder-single").select2({
        placeholder: "اختر المنطقه",
        allowClear: true
    });
        $(".js-example-placeholder-single2").select2({
        placeholder: "اختر الفرع",
        allowClear: true
    });
        $(document).on("change",'.gr,.gr2',function() {
            // $('#inv_sub').click();
            var dataa =$('#inv_form').serialize();
            $.ajax({
                url: 'ajax/order_supply_add_product_temp.php',
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

        $(document).on("click",'.addProd', function() {
            // alert('hereeeee class add prod');
            var par = $(this).attr('par');
            var dataaaa =$('#inv_form').serialize();
            // alert($(this).attr('data_item_type'));
            if(par == 'q') {
                $.ajax({
                    url: 'ajax/order_supply_add_product_temp.php?q='+$(this).attr('attr') + "&item_status="+$(this).attr('data_item_type'),
                    dataType: 'text',
                    type: 'POST',
                    contentType: 'application/x-www-form-urlencoded',
                    data: dataaaa,
                    success: function (data, textStatus, jQxhr) {
                        data = JSON.parse(data);

                        $('#tablee').html(data['table']);
                        $('#ajaxRes').html(data['status']);
                        $('#item_type_val').val($(this).attr('data_item_type'));
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }else
            if(par == 'del'){
                $.ajax({
                    url: 'ajax/order_supply_add_product_temp.php',
                    dataType: 'text',
                    type: 'GET',
                    contentType: 'application/x-www-form-urlencoded',
                    data: {'del': $(this).attr('attr') ,'item_status':$(this).attr('data_item_type')},
                    success: function (data, textStatus, jQxhr) {
                        data = JSON.parse(data);
                        $('#tablee').html(data['table']);
                        $('#ajaxRes').html(data['status']);
                        $('#item_type_val').val($(this).attr('data_item_type'));

                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });

            }else
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
                url: 'storein_order_supply.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){

                    $('#response').html( data['data'] );
                          var $container = $("#data");
        $container.load('multi_items_order_supply.php');
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

      <script type="text/javascript">



          //<![CDATA[
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
        </script>
</html>
<?php //include 'includes/footer.php'; ?>