<?php
include "includes/inc.php";
$inv_id=$_GET['id'];
$data=get_order_supply_data($inv_id,1);
if($data[id]==null){
     header("refresh:0;url=index.php");
    die();}
########################
if (isset($_GET['cat_show'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET cat_items_show=" . $_GET['cat_show'] . " where id=" . $get_db_id . "");
    header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");
}
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
                xmlhttp.open("GET", "clients_search.php?q=" + str, true);
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
                str=str+'&offers=order_supply';

                xmlhttp.open("GET", "items_search.php?id=<?php echo $_GET['id']; ?>&q=" + str, true);
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
                    if (isset($_GET['order_supply_cat'])) {
                        mysqli_query($con, "UPDATE " . $prefix . "_config SET order_supply_cat_items_show=" . $_GET['order_supply_cat'] . " where id=" . $get_db_id . "");
                        header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");
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
                if ($user_edit_order_supply !== "1" and $user_IsAdmin != 1) {
                    echo"<div style='margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;'>'.$not_have_permission_lang.'</div>";
                } else {
                    ?>
                    <div class="noprint">
                        <div style="width:60%;border:1px solid #CCC; border-radius:5px; float:right; ">
                            <div>
                               <div id="livesearchcl" style="z-index:1000000000; width:45%;  text-align:right; margin-top:30px;  float:right; position:fixed; border:0px; "></div>
                                <div style="width:100%; padding-top:0px; text-align:center; margin:0 auto;border:0px dashed #CCC; border-radius:5px; height:290px; overflow:auto;">
                                    <?php
                                    if (($_POST['submit']) == $Save_lang and $_POST['submit'] != null) {
                                        ###################################

                                        $result_upt = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply where inv_id='$inv_id' order by id DESC");
                                      
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
                                        
//
                                            ######################
                                            $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply where inv_id='$inv_id' order by id DESC");
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

                                                   $updateSqlStatement="UPDATE " . $prefix . "_order_supply SET staff='" . $staff . "',Quantity='" . $quantity . "',
Price='" . $Price . "',Discount='" . $Discount . "',Total='" . $Total . "',date='" . $DueDate . "',type='1',order_supply_type='" . $order_supply_type . "',BuyPrice=(select price from items where id='" . $item . "') where user_id='$user_id' and id='" . $row_up['id'] . "'";
                                             if (mysqli_query($con, $updateSqlStatement)) {
                                                 $upSql = "UPDATE " . $prefix . "_order_supply_inv SET updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id.  "'  where inv_id='" . $inv_id . "' and type='1'" ;
                                                 mysqli_query($con, $upSql);
#############التأثير على المخزون###########
###########################################
        header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");
                                                }
                                            }
                                            ######################
####
                                    }




























                                    if ($_GET['del'] !== null) {

                                        if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply where id=" . $_GET['del'] . "")) {
                                            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Item_deleted_lang.'
							</div>';
                                            header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");
                                        }
                                    }
                                    if (isset($_POST['submit'])) {
                                        if (current_order_supply_items_data($inv_id) ==0 ) {
                                            //print $paid;
                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_type_at_least_item.'
							</div>';

//                                            header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");

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


                                        $submit_data=($_POST);
 $date_edita=str_replace("/", "-", $_POST['date']);
$date_edit= Trim(date('Y-m-d', strtotime($date_edita)));
#####################################################


                                          $upSql = "UPDATE " . $prefix . "_order_supply_inv SET date='" . $date_edit . "',updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id. "',notes='" . $_POST['notes'] . "',discount='" . $_POST['alldiscount']. "',shipping='" . $_POST['shipping']. "',address='" . $_POST['address']. "',branch_id='" . $_POST['branch_id']. "',region_id='" . $_POST['region_id']. "',alpha='" . $_POST['alpha']. "',mobile1='" . $_POST['mobile1']. "',mobile2='" . $_POST['mobile2']   ."',client='" . $_POST['client']   . "'  where inv_id='" . $inv_id . "' and type='1'" ;
    mysqli_query($con, $upSql);
//mysqli_errno($con);
#####################################################
                                        $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply where inv_id='$inv_id' order by id DESC");
                                        while ($row_up = mysqli_fetch_array($result_up)) {
                                            //echo $row_up['id'];
                                            $item = $_POST[item][$row_up['id']];
                                           $quantity = $_POST[quantity][$row_up['id']]; 
                                            $Price = $_POST[price][$row_up['id']];
                                            $staff = $_POST[staff];
                                            $Discount = $_POST[discount][$row_up['id']];                                          
                                            $BuyPrice = $_POST[BuyPrice][$row_up['id']];
                                            $order_supply_type = $_POST[order_supply_type][$row_up['id']];
                                            $size = $_POST[size][$row_up['id']];
                                            $color = $_POST[color][$row_up['id']];
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
                                          //  echo $quantity;
                                         //   echo"<br />";
                                            if ($quantity == 0 or $quantity == ""  or $quantity == null) {
                                                $error_reports = 1;
                                            } else {
                                               $update1="UPDATE " . $prefix . "_order_supply SET  Quantity='" . $quantity . "',Price='" . $Price . "',Discount='" . $Discount . "',
Total='" . $Total . "',type='1',BuyPrice='" . $BuyPrice . "',order_supply_type='" . $order_supply_type . "',size='" . $size . "',color='" . $color . "',user_id='$user_id',staff='$staff'  where id='" . $row_up['id'] . "'";
                                                mysqli_query($con, $update1);
                                                $upSql = "UPDATE " . $prefix . "_order_supply_inv SET updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id.  "'  where inv_id='" . $inv_id . "' and type='1'" ;
                                                mysqli_query($con, $upSql);
                                            }
                                            //echo"<br />";
                                        }
                                        header("refresh:0;url=order_supply_edit.php?id=".$_GET['id']."");
                                    }
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
                                        if (mysqli_query($con, "UPDATE ".$prefix."_order_supply SET SupplierID=".$SupplierID." where inv_id='$inv_id'")) {
                                            header("refresh:1;url=order_supply_edit.php?id=".$_GET['id']."");
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
                                                        $sql = "INSERT INTO " . $prefix . "_order_supply (item_status,item, Price, Quantity, Discount, Total, BuyPrice, date, type, subqty, order_supply_type, size ,color, user_id)
							VALUES ('" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','" . $item_price_new . "','" . $DueDate . "','1','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $get_barcode_size . "','" . $get_barcode_color . "','".$user_id."')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
                                                          header("refresh:1;url=order_supply_edit.php?id=".$_GET['id']."");
                                                    } else {
                                                        $upSql = "UPDATE " . $prefix . "_order_supply_inv SET updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id.  "'  where inv_id='" . $inv_id . "' and type='1'" ;
                                                        mysqli_query($con, $upSql);
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                          header("refresh:1;url=order_supply_edit.php?id=".$_GET['id']."");
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

                                    if ($_GET['q'] == "d") {
                                        if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply where user_id='$user_id'")) {
                                               header("refresh:1;url=order_supply_edit.php?id=".$_GET['id']."");
                                        }
                                    } else {
                                        if ($_GET['q'] == null) {
                                            //	header( "refresh:0;url=order_supply.php" );
                                        } else {
                                            if( $_GET['item_type']!=$prefix.'_offers_inv') {

//                                                if (GetQuantity($_GET['q'], 1) <= 0) {
//                                                    echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
//							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
//							' . $no_stock_lang . '
//							</div>';
//                                                } else {
                                                    $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $_GET['q'] . "'");
                                                    if (@mysqli_num_rows($result_new) >= 1) {

                                                        while ($row_new = mysqli_fetch_array($result_new)) {
                                                            $item_name_new = $row_new['item'];
                                                            $item_id_new = $row_new['id'];

                                                            $item_Discount_new = $row_new['Discount'];
                                                            $item_price_new = $row_new['price'];
                                                            $item_subqty = $row_new['subqty'];
                                                            if ($get_db_order_supply_type == "1") {
                                                                $item_Retail_price_new = $row_new['Retail_price'];
                                                            } else {
                                                                $item_Retail_price_new = $row_new['subprice'];
                                                            }
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
                                                            $sql = "INSERT INTO " . $prefix . "_order_supply (item_status,item, Price, Quantity, Discount, Total, type, date, BuyPrice, subqty, order_supply_type, size, color, user_id, inv_id)
							VALUES ('" . $item_status . "','". $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','1','" . $DueDate . "','" . $item_price_new . "','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $size . "','" . $color . "','" . $user_id . "','" . $inv_id . "')";
                                                        }
                                                        if (!mysqli_query($con, $sql)) {
                                                            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $not_saved_try_lang . '
							</div>';
                                                            header("refresh:1;url=order_supply_edit.php?id=" . $_GET['id'] . "");
                                                        } else {

                                                            $upSql = "UPDATE " . $prefix . "_order_supply_inv SET updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id . "'  where inv_id='" . $inv_id . "' and type='1'" ;
                                                            mysqli_query($con, $upSql);
                                                            echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $Added_Item_lang . '
							</div>';
                                                            header("refresh:1;url=order_supply_edit.php?id=" . $_GET['id'] . "");
                                                        }
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $item_not_found_lang . '
							</div>';
                                                    }
//                                                }
                                            }
                                            else{
//
                                                    $result_new = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers_inv where id='" . $_GET['q'] . "'");
                                                    if (@mysqli_num_rows($result_new) >= 1) {

                                                        while ($row_new = mysqli_fetch_array($result_new)) {
                                                            $item_name_new = $row_new['name'];
                                                            $item_id_new = $row_new['id'];

                                                            $item_Discount_new = $row_new['Discount'];
                                                            $item_price_new = $row_new['Total'];
                                                            $item_Retail_price_new = $row_new['Total'];

                                                            if ($_GET['item_type']== $prefix . "_offers_inv"){
                                                            $item_status = 'offers';
                                                        }else{
                                                            $item_status = 'items';
                                                        }

                                                            $sql = "INSERT INTO " . $prefix . "_order_supply (item_status,item, Price, Quantity, Discount, Total, type, date, BuyPrice, subqty, order_supply_type, size, color, user_id, inv_id)
							VALUES ('" . $item_status . "','" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','1','" . $DueDate . "','" . $item_price_new . "','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $size . "','" . $color . "','" . $user_id . "','" . $inv_id . "')";
                                                        }
                                                        if (!mysqli_query($con, $sql)) {
                                                            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $not_saved_try_lang . '
							</div>';
                                                            header("refresh:1;url=order_supply_edit.php?id=" . $_GET['id'] . "");
                                                        } else {

                                                            $upSql = "UPDATE " . $prefix . "_order_supply_inv SET updated_at='" . date('Y/m/d H:i:s'). "',edit_user='" . $user_id . "'  where inv_id='" . $inv_id . "' and type='1'" ;
                                                            mysqli_query($con, $upSql);
                                                            echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $Added_Item_lang . '
							</div>';
                                                            header("refresh:1;url=order_supply_edit.php?id=" . $_GET['id'] . "");
                                                        }
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $item_not_found_lang . '
							</div>';
                                                    }
//                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <form method="post">
                                        <?php
//                                        var_dump($data);
//                                        die();

                                     /*   $result_SupplierID = mysqli_query($con, "SELECT SupplierID FROM " . $prefix . "_order_supply where user_id='$user_id' limit 0,1");
                                        if (@mysqli_num_rows($result_SupplierID) > 0) {
                                            while ($row_SupplierID = mysqli_fetch_array($result_SupplierID)) {
                                                $result_search_client = mysqli_query($con, "SELECT id,name FROM " . $prefix . "_clients WHERE id=" . $row_SupplierID['SupplierID'] . "");
                                                if (@mysqli_num_rows($result_search_client) > 0) {
                                                    while ($row_search_client = mysqli_fetch_array($result_search_client)) {
                                                      echo" <span dir=\"rtl\"  style=\"color:#7D060F;\" dir=\"rtl\">$The_client_lang :".$row_search_client['name']."</span>";

                                                        echo'<input type="hidden" name="SupplierID" value="' . $row_search_client['id'] . '" />';
                                                    }
                                                }
                                            }
                                        }*/
                                        ?>

                                        <div class="row" dir="rtl">
                                            <div class="col-12" >

                                                <label><?php echo $The_client_lang;?></label>
                                                <input type="text" placeholder=" <?php echo"$The_client_lang"; ?>" name="client" value="<?php echo"" . $data['client'] . ""; ?>"  />
                                                <br/>
                                                <br/>
                                                <br/>
                                            </div>
                                        </div>
                                        <div class="row" dir="rtl">

                                            <select name="branch_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                                                <option value=""> <?php echo"$the_branch_name_lang"; ?></option>
                                                <?php
                                                $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_branch order by id ASC");
                                                $num_item = mysqli_num_rows($ProductsName);
                                                if ($num_item > 0) {
                                                    while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                        if ($row_item['id'] == $data['branch_id']) {
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
                                                        if ($row_item['id'] == $data['region_id']) {
                                                            echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                        } else {
                                                            echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <input type="text" placeholder=" <?php echo"$Address1_lang"; ?>" name="address" value="<?php echo"" . $data['address'] . ""; ?>"  />

                                            <input type="text"
                                                   pattern="[0-9]{11}"
                                                   title="<?php echo $mobile_error ; ?>"
                                                   name="mobile1" placeholder="<?php echo"$Mobile1_lang"; ?>" value="<?php echo"" . $data['mobile1'] . ""; ?>"  />

                                            <input type="text"
                                                   pattern="[0-9]{11}"
                                                   title="<?php echo $mobile_error ; ?>"
                                                   name="mobile2" placeholder="<?php echo"$Mobile2_lang"; ?>" value="<?php echo"" . $data['mobile2'] . ""; ?>"  />
                                                   
                                                    <select name="alpha" size="1" class="js-example-placeholder-single w25 js-states form-control">
                                              <option value="" <?php if($data['alpha']==""){echo 'selected="selected"';} ?>>code</option>
                                            <option value="A" <?php if($data['alpha']=="A"){echo 'selected="selected"';} ?>>A</option>
                                            <option value="B" <?php if($data['alpha']=="B"){echo 'selected="selected"';} ?>>B</option>
                                            <option value="C" <?php if($data['alpha']=="C"){echo 'selected="selected"';} ?>>C</option>
                                            <option value="D" <?php if($data['alpha']=="D"){echo 'selected="selected"';} ?>>D</option>
                                            <option value="E"  <?php if($data['alpha']=="E"){echo 'selected="selected"';} ?>>E</option>
                                            <option value="F"  <?php if($data['alpha']=="F"){echo 'selected="selected"';} ?>>F</option>
                                            <option value="G"  <?php if($data['alpha']=="G"){echo 'selected="selected"';} ?>>G</option>
                                            <option value="H"  <?php if($data['alpha']=="H"){echo 'selected="selected"';} ?>>H</option>
                                            <option value="I"  <?php if($data['alpha']=="I"){echo 'selected="selected"';} ?>>I</option>
                                            <option value="J"  <?php if($data['alpha']=="J"){echo 'selected="selected"';} ?>>J</option>
                                            <option value="K"  <?php if($data['alpha']=="K"){echo 'selected="selected"';} ?>>K</option>
                                            <option value="L"  <?php if($data['alpha']=="L"){echo 'selected="selected"';} ?>>L</option>
                                            <option value="M"  <?php if($data['alpha']=="M"){echo 'selected="selected"';} ?>>M</option>
                                            <option value="N"  <?php if($data['alpha']=="N"){echo 'selected="selected"';} ?>>N</option>
                                            <option value="O"  <?php if($data['alpha']=="O"){echo 'selected="selected"';} ?>>O</option>
                                            <option value="P"  <?php if($data['alpha']=="P"){echo 'selected="selected"';} ?>>P</option>
                                            <option value="Q"  <?php if($data['alpha']=="Q"){echo 'selected="selected"';} ?>>Q</option>
                                            <option value="R"  <?php if($data['alpha']=="R"){echo 'selected="selected"';} ?>>R</option>
                                            <option value="S"  <?php if($data['alpha']=="S"){echo 'selected="selected"';} ?>>S</option>
                                            <option value="T" <?php if($data['alpha']=="T"){echo 'selected="selected"';} ?>>T</option>
                                            <option value="U" <?php if($data['alpha']=="U"){echo 'selected="selected"';} ?>>U</option>
                                            <option value="V" <?php if($data['alpha']=="V"){echo 'selected="selected"';} ?>>V</option>
                                            <option value="W" <?php if($data['alpha']=="W"){echo 'selected="selected"';} ?>>W</option>
                                            <option value="X" <?php if($data['alpha']=="X"){echo 'selected="selected"';} ?>>X</option>
                                            <option value="Y" <?php if($data['alpha']=="Y"){echo 'selected="selected"';} ?>>Y</option>
                                            <option value="Z" <?php if($data['alpha']=="Z"){echo 'selected="selected"';} ?>>Z</option>
                                            </select>
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
                                            <tbody>
                                                <?php
                                                $tbl_name = "" . $prefix . "order_supply";
                                                //your table name
                                                // How many adjacent pages should be shown on each side?
                                                $adjacents = 3;

                                                /*
                                                  First get total number of rows in data table.
                                                  If you have a WHERE clause in your query, make sure you mirror it here.
                                                 */
                                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_order_supply where inv_id='$inv_id' order by id DESC";
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
                                                 $sql = "SELECT * FROM " . $prefix . "_order_supply where inv_id='$inv_id' order by id DESC";

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


                                                    }
                                                    else{

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
###############################################################################
                                                    if(is_float($i/2)){
                                                        $gr="gr";
                                                    }else{
                                                        $gr="gr2";
                                                    }
                                                     echo'<input type="hidden" name="id[]" value="' . $row['id'] . '" />';
                                                    echo'<input type="hidden" name="BuyPrice[' . $row['id'] . ']" value="' . $item_BuyPrice . '" /><tr class="'.$gr.'">
							<td>' . $i . '</td>
							<td><input type="hidden" name="item[' . $row['id'] . ']" value="' . $item_id . '" />' . $item_name . '</td>';
                                                    if ($Retail_allow == "1") {
                                                        echo'<td>';
                                                        echo'<select  class="'.$gr.'"  name="order_supply_type[' . $row['id'] . ']" style="width:10%; height:20px; text-align:center;border:0px;>';
                                                        ?>
                                                    <option value="0" <?php if ($row['order_supply_type'][$row['id']] == "0") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Select_Type_lang"; ?></option>
                                                    <option value="1" <?php if ($row['order_supply_type'][$row['id']] == "1") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Wholesaling_lang"; ?></option>
                                                    <option value="2" <?php if ($row['order_supply_type'][$row['id']] == "2") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Retail_lang"; ?></option>
                                                    <?php
                                                    echo'</select></td>';
                                                }
                                                echo'<td><input  class="'.$gr.'" type="text" name="quantity[' . $row['id'] . ']"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
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
                                                                               echo'<td><select  class="'.$gr.'" name="color['.$row['id'].']" style="height:25px; text-align:center;border:0px;">';
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
                                                echo'<td><input  class="'.$gr.'" type="text"  name="price[' . $row['id'] . ']" id="price' . $i . '" value="' . $row['Price'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td hidden><input  class="'.$gr.'" type="text"  name="discount[' . $row['id'] . ']" id="discount' . $i . '" value="' . $row['Discount'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input class="'.$gr.'" type="text"  name="subtotal[' . $row['id'] . ']" id="subtotal' . $i . '" value="' . $row['Total'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td valign="middle"><a href="order_supply_edit.php?id=' . $_GET['id'] . '&del=' . $row['id'] . '"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';
                                                $i++;
                                            }
                                            ?>
                                            </tbody>
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
    }

     echo'<tr>';
    if (isset($_POST['alldiscount'])){
        if($Discount_type==2){
            $print_total_disc=$sumTotal*$_POST['alldiscount']/100;
        }
        else if($Discount_type==1){
            $print_total_disc=$_POST['alldiscount'];
        }else{}
    }else{
        $print_total_disc = $data['discount'];
    }
                                 echo'<td colspan="4">م.النقل</td>';
                            echo'<td><font style="color:#060; font-weight:bold;">' . $data[shipping] . '</font></td>
                            <td></td>
                            </tr>';
                              echo'<tr><td  colspan="4">الاجمالى بعد م.النقل</td>
                            <td><font style="color:#060; font-weight:bold;">'.(($sumTotal-$print_total_disc)+$data[shipping]).'</font></td><td></td>
                            </tr>';
//                              echo'<tr><td  colspan="5">الاجمالى بعد م.النقل</td>
//                            <td><font style="color:#060; font-weight:bold;">'.((($sumTotal-$print_total_disc)*$db_tax/100)+($sumTotal-$print_total_disc)+$data[shipping]).'</font></td><td></td>
//                            </tr>';
//
                              #############################################
     mysqli_query($con, "UPDATE " . $prefix . "_order_supply_inv SET Total='" . $sumTotal . "',tax='" . (($sumTotal-$print_total_disc)*$db_tax/100) . "'  where inv_id='" . $inv_id . "' and type='1'");

                              ##############################################
    ?>
                                        </table>

                                        <input type="submit" name="submit" value="submit" hidden="hidden" id="inv_sub" />

                                </div>
                                <table width="100%" dir="rtl">
                                    <tr>
                           

                                        <td style="font-size:16px;" class="text-center">التــاريخ</td>
                                        <td><input type="text" name="date" id="date" value="<?php echo date("d/m/Y",strtotime($data[date])); ?>"  style="text-align:center; background-color:#CCC; width:80px; height:20px;"/>
                                            <script type="text/javascript">
                                                $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                            </script>
                                        </td>
                                        <td style="font-size:16px;" class="text-left"><?php echo"م.النقل"; ?></td>
                                        <td style="font-size:16px;"><input    style="text-align:center; background-color:#CCC; width:80px; height:20px;" type="text" name="shipping" value="<?php echo"" . $data['shipping'] . ""; ?>" /></td>
                                        <td class="text-left" style="font-size:16px;"><?php echo"$Discount_lang"; ?></td>
                                        <td><input  type="text" name="alldiscount" value="<?php echo"" . $data['discount'] . ""; ?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>

                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;" class="text-left"><?php echo $notes_lang; ?></td>
                                        <!--                                            --><?php //echo"$Discount_lang"; ?>
                                        </td>
                                        <td style="font-size:16px;">
                                            <textarea class="form-control" style="text-align: center" name="notes" ><?php echo $data['notes'];?></textarea>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6" align="center"><span style=" text-align:center; margin-right:50px;">
                                                <input type="submit" name="submit" value="<?php echo $save_lang ; ?>"  style="width:120px; height:40px;" />
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
                                        document.getElementById("barcode").focus();
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
                                         autofocus onfocus="this.select()" name="barcode" id="barcode"   style="background-color:#CCC; text-align: center;"
                       onblur="this.value=!this.value?'<?php echo"$barcode_lang"; ?>':this.value;"/>
                                    <?php } ?>
                                        <a href="#" onclick="javascript:void window.open('additems.php', '1390937502641', 'width=400,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                return false;">
                                            <i class="fa fa-plus-square"  title="<?php echo"$Add_New_item"; ?>"></i>
                                        </a>
                                        <span style="padding-right:20px;"></span><input type="text" value="<?php echo"$item_Name_lang"; ?>"  style="background-color:#CCC; z-index:100000000000;"  onkeyup="showResultsOfItems(this.value)" autocomplete="off"    onclick="this.value = '';" onfocus="this.select()"  onblur="this.value = !this.value ? '<?php echo"$item_Name_lang"; ?>' : this.value;"/>
                                        <div id="livesearch" style="z-index:1000000000; width:45%;  text-align:right; margin-top:0px;  float:right; position:fixed; border:0px; "></div>
                                        <input type="submit" hidden="hidden"/>
                                    <?php
                                    if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                        
                                    } else {
                                      echo'<a href="?id='.$_GET['id'].'&cat_show=0"><i class="fa fa-list" title="'.$All_groups_lang.'"></i></a>';
                                    }
                                    ?>
                                    </div></form>
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
<a href=\"?id=" . $_GET['id'] . "&cat_show=" . $row_cat['id'] . "\" class='a_cat_underlines'><img src=\"uploads/" . $row_cat['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"30\" /></a></div>

							</div>";
  
                                                    } else {
                                                       echo "<div   class=\"" . $class . " jqx-rc-all\" style='background-color:" . $row_cat['background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
							<div class=\"draggable-demo-product-header-label\"> <a href=\"?id=" . $_GET['id'] . "&cat_show=" . $row_cat['id'] . "\">" . $row_cat['product_name'] . "</a></div></div>

							</div>";
 
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                <div id="items">
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
							<div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\">" . $row['item'] . "</a></div></div>

							</div>";
                                            /* 	echo"<div class=\"draggable-demo-product jqx-rc-all\"  style='background-color:".$row['Background']."; height:50px;'>
                                              <div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
                                              <div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a href=\"?q=".$row['id']."\">".$row['item']."</a></div></div>

                                              </div>"; */
                                            ###################
                                        } else {
                                            echo "<div class=\"draggable-demo-product jqx-rc-all\" title='$qty_it'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\">
							<div class=\"draggable-demo-product-header-label\"><a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\">" . $row['item'] . "</a></div></div>

							<a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\"><img src=\"uploads/" . $row['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"100\" /></a>
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
                    $('#response').html( data );
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
          $('.gr,.gr2').change( function() {
              $('#inv_sub').click();
          });

        </script>
</html>
<?php //include 'includes/footer.php'; ?>