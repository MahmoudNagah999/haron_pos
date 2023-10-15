
<?php include "includes/inc.php";
$store_id=$_GET['store_id'];
$search=$_GET['search'];
$orderby=$_GET['orderby'];
$type=$_GET['type'];
if (!$_GET['date_from']){
    $_GET['date_from'] =date("01-01-2019") ;
}
if (!$_GET['date_to']){
    $_GET['date_to'] =date("d/m/Y") ;
}
function last_group_rank(){
    global $con;
    $result_ranks= mysqli_query($con,"SELECT OrderNo FROM items order by OrderNo DESC limit 0,1");
    if(mysqli_num_rows($result_ranks)>0){
        while($row_ranks= mysqli_fetch_array($result_ranks))
        {
            $ranks=$row_ranks['OrderNo'];
        }
        return $ranks+1;
    }else{return 1;}
}
$last_barcode=get_lastbarcode_of_item();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
    <style type="text/css">

        /* printer specific CSS */
        @media print
        {
            #contentnoprint { display:none;}
            #contentnoprint1 { display:none;}
            #contentnoprint2 { display:none;}
            #contentnoprint3 { display:none;}
        }
    </style>
    <?php include"includes/css.php"; ?>
    <?php include"includes/js.php"; ?>
</head>
<body class="cmenu1 example-target">
<div>
    <div>
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
<div id='main'>
    <article style="margin-bottom:70px;">

        <fieldset>
            <legend  align="right"><?php echo"$the_items_lang"; ?>:  <li style="cursor:pointer;" class="glyphicon glyphicon-minus"  onclick="toggle_visibility('myForm');"></li></legend>
            <?php
            if ($user_Items !== "1" and $user_IsAdmin != 1) {
                echo'<div class="alert alert-warning text-right">
                            '.$not_have_permission_lang.'
                            </div>';
            } else {
            ?>
            <?php
            if ($_GET['del'] !== null) {
                if($demo==1){
                    echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                }else{
                    if($user_del_item !==1 and $user_IsAdmin != 1){
                        echo'<div class="alert alert-warning text-right">
                            '.$permission_delete_lang.'
                            </div>';
                    }else{
                        if($demo==1){
                            echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                        }else{
                            $delSql = "DELETE FROM items WHERE id='" . $_GET['del'] . "'  and id Not IN (select item from " . $prefix . "_stores_change )     and id Not IN (select item from " . $prefix . "_offers )   and id Not IN (select item from " . $prefix . "_receivings )  and id Not IN (select item from " . $prefix . "_sales ) and id Not IN (select item from " . $prefix . "_order_supply )";
                            if(mysqli_query($con, $delSql)){


                                if(mysqli_affected_rows($con) > 0 ){
                                    echo'<div class="alert alert-success text-right">
           '.$Deletion_successfully_lang.'
                            </div>';
                                }else{
                                    $error_msg .= " الصنف كود ".$del_id." لا يمكن حذفها لترابطها ببيانات اخرى";

                                }

                                if ($error_msg!= ""){
                                    echo '<div class="alert alert-warning text-right">
                  '.$related_alert .' التفصيل :  '.$error_msg.'
                            </div>';
                                }

                                header("refresh:1;url=items_and_inventory.php");



                            }
                        }  }
                }  }
            ?>
            <?php
            if($_GET['hide']!=null){
                if($demo==1){
                    echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                }else{
                    $sqlitems_hide = "INSERT INTO ".$prefix."_items_hide (item) VALUES ('".$_GET['hide']."')";
                    if (!mysqli_query($con, $sqlitems_hide)) {

                    } else {
                        echo'<div class="alert alert-success text-right">
              '.$Hide_Item_lang.'
</div>';
                    }
                }
            }
            ?>
            <?php
            $checkbox = $_POST['cb']; //from name="checkbox[]"
            if($checkbox==null){}else{
                $countCheck = count($_POST['cb']);
                if($countCheck>0){
                    if($demo==1){
                        echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                    }else{
                        if ($user_del_Items !== "1" and $user_IsAdmin != 1){

                            echo'<div class="alert alert-warning text-right">
                             '.$not_have_permission_lang.'
                            </div>          <br />';
                        }else{
                            for ($i = 0; $i <= $countCheck; $i++) {
                                $del_id = $checkbox[$i];
                                mysqli_query($con, "DELETE FROM items WHERE id='" . $del_id . "'  and id Not IN (select item from " . $prefix . "_stores_change )     and id Not IN (select item from " . $prefix . "_offers )   and id Not IN (select item from " . $prefix . "_receivings )  and id Not IN (select item from " . $prefix . "_sales ) and id Not IN (select item from " . $prefix . "_order_supply )");
                                if ($i == $countCheck - 1) {

                                    if(mysqli_affected_rows($con) > 0 ){
                                        echo'<div class="alert alert-success text-right">
             '.$Deletion_successfully_lang.'
                            </div> 
                            
                            
                                     <br />';
                                    }else{
                                        $error_msg .= " الصنف كود ".$del_id." لا يمكن حذفها لترابطها ببيانات اخرى";

                                    }


                                }
                            }
                            if ($error_msg!= ""){
                                echo '<div class="alert alert-warning text-right">
                  '.$related_alert .' التفصيل :  '.$error_msg.'
                            </div>';
                            }

                            header("refresh:1;url=items_and_inventory.php");
                        }
                    }  }
            }


            if (isset($_POST['add']) or isset($_POST['modification'])) {
                if($demo==1){
                    echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                }else{
                    $groups = Trim(stripslashes($_POST['groups']));
                    $items = Trim(stripslashes($_POST['items']));
                    $_POST['date'] = str_replace("/", "-", $_POST['date']);
                    $date = Trim(date('Y-m-d', strtotime($_POST['date'])));
                    $subqty = Trim(stripslashes($_POST['subqty']));
                    if($subqty==null){$subqty=1;}
                    $Quantity = Trim(stripslashes($_POST['Quantity']));
                    $explQuantity = explode(",", $Quantity);
                    $Quantity=$explQuantity[0];
                    $Quantity_sub_units=$explQuantity[1];
                    $sub_units=$explQuantity[1]/$subqty;
                    $Quantity=$Quantity+$sub_units;
                    //   die();
                    $price = Trim(stripslashes($_POST['price']));
                    $Sale_price = Trim(stripslashes($_POST['Sale_price']));
                    $Barcode = Trim(stripslashes($_POST['Barcode']));
                    $subprice = Trim(stripslashes($_POST['subprice']));
                    $Discount = Trim(stripslashes($_POST['Discount']));
                    $OrderNo = Trim(stripslashes($_POST['OrderNo']));
                    if($OrderNo==""){$OrderNo=last_group_rank()+1;}
                    $useimage = Trim(stripslashes($_POST['useimage']));
                    $FileInput = Trim(stripslashes($_POST['FileInput']));
                    $Background = Trim(stripslashes($_POST['Background']));
                    $subprice = Trim(stripslashes($_POST['subprice']));

                    $size = $_POST['size'];
                    $color = $_POST['color'];
                    ##############
                    for ($x = 0; $x <= count($size); $x++) {
                        $add_size.=$size[$x];
                        if ($x == count($size)) {

                        } else {
                            $add_size.=",";
                        }
                    }
                    for ($x = 0; $x <= count($color); $x++) {
                        $add_color.=$color[$x];
                        if ($x == count($color)) {

                        } else {
                            $add_color.=",";
                        }
                    }
                    #########################
                    if ($Retail_allow == 1) {

                    } else {
                        $subqty = "1";
                    }
                    $companies = Trim(stripslashes($_POST['companies']));
                    $alert_shortcomings = Trim(stripslashes($_POST['alert_shortcomings']));
//                        if ($items == null or $items == "" or $date == null or $date == "" or $price == null or $price == "" or $Sale_price == null or $Sale_price == "") {
                    if ($items == null or $items == "" or $date == null or $date == "" ) {
                        if ($groups == null or $groups == "") {
                            $error_groups = 'background-color:#FC9698';
                        }
                        if ($items == null or $items == "") {
                            $error_items = 'background-color:#FC9698';
                        }
                        if ($date == null or $date == "") {
                            $error_date = 'background-color:#FC9698';
                        }
                        if ($price == null or $price == "") {
                            $error_price = 'background-color:#FC9698';
                        }


                        echo'<div class="alert alert-danger  text-right">
'.$Red_fields_required.'

                            </div>          <br />';
                    } else {
//die('Success! File Uploaded.');
                        include('includes/function.php');
// settings
                        $result = process_image_upload('image');
                        if ($result === false) {
// echo '<br>An error occurred while processing upload';
                            $error = 1;
                        } else {
                            //  echo '<br>Uploaded image saved as ' . $result[0];
                            if (file_exists($result[0])) {
                                unlink($result[0]);
                            }
//echo '<br>Thumbnail image saved as ' . $result[1];
                        }
#########
                        if (isset($_POST['modification'])) {
                            for ($x = 0; $x <= count($models_size); $x++) {
                                $add_size.=$models_size[$x];
                                if($x==count($models_size)){}else{$add_size.=",";}
                            }
                            for ($x = 0; $x <= count($models_color); $x++) {
                                $add_color.=$models_color[$x];
                                if($x==count($models_color)){}else{$add_color.=",";}
                            }
                            if ($error == 1) {
                                $sql = "UPDATE items SET groupid='" . $groups . "',item='" . $items . "',Quantity='" . $Quantity . "',Retail_price='" . $Sale_price . "',price='" . $price . "',Barcode='" . $Barcode . "',Discount='" . $Discount . "',OrderNo='" . $OrderNo . "',useimage='" . $useimage . "',Background='" . $Background . "',subprice='" . $subprice . "',subqty='" . $subqty . "',alert_shortcomings='" . $alert_shortcomings . "',companies='" . $companies . "',sizes='".$add_size."',colors='".$add_color."'  where id=" . $_GET['Edit'] . "";
                            } else {
                                $sql = "UPDATE items SET groupid='" . $groups . "',item='" . $items . "',Quantity='" . $Quantity . "',Retail_price='" . $Sale_price . "',price='" . $price . "',Barcode='" . $Barcode . "',Discount='" . $Discount . "',OrderNo='" . $OrderNo . "',image='" . str_replace("uploads/", "", "" . $result[1] . "") . "',useimage='" . $useimage . "',Background='" . $Background . "',subprice='" . $subprice . "',subqty='" . $subqty . "',alert_shortcomings='" . $alert_shortcomings . "',companies='" . $companies . "',sizes='".$add_size."',colors='".$add_color."'   where id=" . $_GET['Edit'] . "";
                            }
                        } else {
#########
                            $sql = "INSERT INTO items (groupid,  item, date, Quantity, Retail_price, price, Barcode, Supplier, Discount, OrderNo, useimage, image, Background, subprice, subqty, alert_shortcomings, companies, sizes, colors)
VALUES ('" . $groups . "','" . $items . "','" . $date . "','" . $Quantity . "','" . $Sale_price . "','" . $price . "','" . $Barcode . "','" . $Supplier . "','" . $Discount . "','" . $OrderNo . "','" . $useimage . "','" . str_replace("uploads/", "", "" . $result[1] . "") . "','" . $Background . "','" . $subprice . "','" . $subqty . "','" . $alert_shortcomings . "','" . $companies . "','" . $add_size . "','" . $add_color . "')";
                        }
                        if(currently_items()>=$allow_num_items){
                            echo'<div class="alert alert-warning text-right">
                       '.$allow_num_items_lang.'
                            </div>';
                        }else{
                            if (!mysqli_query($con, $sql)) {
                                if (mysqli_errno($con) == 1062) {

                                    echo'<div class="alert alert-danger  text-right">
            '.$Item_already_exists_lang.'
                            </div>';
                                } else {
                                    echo'<div class="alert alert-danger  text-right">
     '.$not_saved_try_lang.'
                            </div>          <br />';
                                }
                            } else {
                                echo'<div class="alert alert-success text-right">
         '.$Data_is_saved_lang.'
</div>          <br />';
                                header("refresh:1;url=items_and_inventory.php?groups=".$_GET['groups']."&search=".$_GET['search']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&s=1&page=".$_GET['page']."");
                            }
                        }
                    }

                    $modelssizevexplode=explode(",", $add_size);
                    $models_color_v_explode=explode(",", $add_color);

                }     }

            ?>
            <?php
            if($user_edit_item !=="1" and $user_IsAdmin != "1"){}else{
                if ($_GET['Edit'] !== null) {
                    $isedit = 1;
                    $result_items = mysqli_query($con, "SELECT * FROM items where id='" . $_GET['Edit'] . "'");
                    if (mysqli_num_rows($result_items) > 0) {
                        while ($row_items = mysqli_fetch_array($result_items)) {

                            $row_items_id = $row_items['groupid'];
                            $row_items_item = $row_items['item'];
                            $row_items_date = $row_items['date'];
                            if($row_items_date==null){}else{$row_items_date = date('d/m/Y', strtotime($row_items_date)); }
                            $row_items_Quantity = $row_items['Quantity'];
                            $NumberBreakdown2=NumberBreakdown($row_items_Quantity, $returnUnsigned = false);
                            $all_qty002=round((abs($NumberBreakdown2[1])*$row_items['subqty']));
                            $row_items_Quantity="$NumberBreakdown2[0],$all_qty002";
                            $row_items_Retail_price = $row_items['Retail_price'];
                            $row_items_price = $row_items['price'];
                            $row_items_Barcode = $row_items['Barcode'];
                            $row_items_Discountr = $row_items['Discount'];
                            $row_items_useimage = $row_items['useimage'];
                            $row_items_image = $row_items['image'];
                            $row_items_Background = $row_items['Background'];
                            $row_items_OrderNo = $row_items['OrderNo'];
                            $row_items_subqty = $row_items['subqty'];
                            $row_items_subprice = $row_items['subprice'];
                            $row_items_alert_shortcomings = $row_items['alert_shortcomings'];
                            $row_items_companies = $row_items['companies'];
                            $models_size_v=$row_items['sizes'];
                            $models_color_v=$row_items['colors'];

                            $modelssizevexplode=explode(",", $models_size_v);
                            $models_color_v_explode=explode(",", $models_color_v);
                        }
                    }
                } else { }
            }
            if($row_items_Background=="" or $row_items_Background==null){$row_items_Background="#ffffff";}
            ?>

            <?php     if($user_edit_item !=="1" and $user_IsAdmin != "1"){
                //  echo $user_edit_item;
                //  die('');
            }else{ ?>
                <form id="myForm" style="disply:block;" method="post"  name="myForm" enctype="multipart/form-data"  autocomplete="off">
                    <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">

                        <tr>
                            <td class="text-right"><lable><?php echo"$the_Item_lang"; ?></lable></td>

                            <td  class="text-right"><input type="text" name="items"  value="<?php if ($items == "") {
                                    echo"" . $row_items_item . "";
                                } else {
                                    echo"" . $_POST['items'] . "";
                                } ?>"  class="form-control"   style="<?php echo"$error_items"; ?>"/></td>

                            <td hidden class="text-right"><lable><?php echo"$the_date_lang"; ?></lable></td>
                            <td class="text-right">
                                <input type="hidden" name="date" value="<?php if ($date == "") {
                                    echo date("d/m/Y");
                                } else {
                                    if($row_items_date=="01/01/1970"){}else{   echo"" . $row_items_date . ""; }
                                } ?>" id="date"  class="form-control"  style="<?php echo"$error_date"; ?>" />
                            </td>
                        </tr>


                        <tr>
                            <td class="text-right"><lable><?php echo"$the_Group"; ?></lable></td>
                            <td class="text-right">


                                <select name="groups" class="form-control" style="width:80%; float: right; <?php echo"$error_groups"; ?>">
                                    <option value=""></option>
                                    <?php
                                    $Groups_list = mysqli_query($con, "SELECT * FROM products where id>0  order by product_name ASC");
                                    $num_Groups_list = mysqli_num_rows($Groups_list);
                                    if ($num_Groups_list > 0) {
                                        while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                                            if ($row_Groups_list['id'] == $row_items_id) {
                                                echo'<option value="' . $row_Groups_list['id'] . '"   selected="selected">' . $row_Groups_list['product_name'] . '</option>';
                                            } else {
                                                echo'<option value="' . $row_Groups_list['id'] . '">' . $row_Groups_list['product_name'] . '</option>';
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                <a href="groups.php" target="$_BLANK"><li class="fa fa-plus-circle fa-2x float-right"></li></a>

                            </td>
                            <!--                            <td class="text-right"><lable>--><?php //echo"$The_company_lang"; ?><!--</lable></td>-->
                            <!--                            <td class="text-right">-->
                            <!---->
                            <!---->
                            <!--                                <select name="companies" class="form-control"  style="width:80%; float: right;">-->
                            <!--                                    <option value=""></option>-->
                            <!--    --><?php
                            //    $companies_list = mysqli_query($con, "SELECT * FROM " . $prefix . "_companies order by id ASC");
                            //    $num_companies_list = mysqli_num_rows($companies_list);
                            //    if ($num_companies_list > 0) {
                            //        while ($row_companies_list = mysqli_fetch_array($companies_list)) {
                            //            if ($row_companies_list['id'] == $row_items_companies) {
                            //                echo'<option value="' . $row_companies_list['id'] . '"   selected="selected">' . $row_companies_list['CompaniesName'] . '</option>';
                            //            } else {
                            //                echo'<option value="' . $row_companies_list['id'] . '">' . $row_companies_list['CompaniesName'] . '</option>';
                            //            }
                            //        }
                            //    }
                            //    ?>
                            <!--                                </select>-->
                            <!-- <a href="companies.php" target="$_BLANK"><li class="fa fa-plus-circle fa-2x float-right"></li></a>-->
                            <!--                            </td>-->

                        </tr>
                        <tr>
                            <td hidden class="text-right"><lable><?php echo"$opening_balance_lang"; ?></lable></td>
                            <td hidden class="text-right"><input  name="Quantity" value="<?php if ($_PST[Quantity] == "") {
                                    echo"" . $row_items_Quantity . "";
                                } else {
                                    echo $_POST['Quantity'];
                                    // echo"" . $Quantity . "";
                                } ?>"  class="form-control"/>

                            </td>
                                                        <td class="text-right"><lable><?php echo"$Purchasing_price_lang"; ?></lable></td>
                                                        <td class="text-right">
                                                            <input type="text" name="price" value="<?php if ($price == "") {
                                    echo"" . $row_items_price . "";
                                } else {
                                    echo"" . $price . "";
                                    } ?>" class="form-control"  style="<?php echo"$error_price"; ?>" />

                                                        </td>
                                                        <td class="text-right"><lable><?php echo"$Selling_price_lang"; ?></lable></td>
                                                        <td class="text-right"><input type="text" name="Sale_price" value="<?php if ($Sale_price == "") {
                                    echo"" . $row_items_Retail_price . "";
                                } else {
                                    echo"" . $Sale_price . "";
                                    } ?>"   class="form-control"  style="<?php echo"$error_Sale_price"; ?>"/>

                                                        </td>

                        </tr>




                        <tr>
                            <?php if ($BARCODE_type == 1){ ?>
                                <td class="text-right"><lable><?php echo"$barcode_lang"; ?></lable></td>
                                <td class="text-right">
                                    <input type="text" name="Barcode" value="<?php if ($Barcode == "") {
                                        if($_GET['Edit']==null){    echo"" . $last_barcode . ""; }else{echo $row_items_Barcode;}
                                    } else {
                                        echo"" . $Barcode . "";
                                    } ?>" class="form-control" />
                                </td>
                            <?php  } ?>
                            <!--                            <td class="text-right"><lable>--><?php //echo"$the_Discount_lang"; ?><!--</lable></td>-->
                            <!--                            <td class="text-right"><input type="text" name="Discount" value="--><?php //if ($Discount == "") {
                            //                                echo"" . $row_items_Discountr . "";
                            //                            } else {
                            //                                echo"" . $Discount . "";
                            //                            } ?><!--" class="form-control"  /></td>-->
                            <td class="text-right"><lable><?php echo"$Ranking_lang"; ?></lable></td>
                            <td class="text-right"><input type="text" name="OrderNo" value="<?php if ($OrderNo == "") {
                                    echo"" . $row_items_OrderNo . "";
                                } else {
                                    echo"" . $OrderNo . "";
                                } ?>" class="form-control" /></td>
                        </tr>


                        <tr>
                            <td class="text-right"><lable><?php echo"$Image_lang"; ?></lable></td>
                            <td class="text-right"><input type="checkbox" name="useimage" value="1"  class="form-control" <?php if ($useimage == "1") {
                                    echo"checked";
                                } else if ($row_items_useimage == 1) {
                                    echo"checked";
                                } else {

                                } ?>/></td>
                            <td class="text-right"></td>
                            <td class="text-right"><span><input name="image" id="image" type="file"  class="form-control" /></span></td>
                            <td class="text-right"><lable><?php echo"$Background_lang"; ?></lable></td>
                            <td class="text-right"><input type="color" name="Background"  id="color5" value="<?php if ($Background == "") {
                                    echo"" . $row_items_Background . "";
                                } else {
                                    echo"#cccccc";
                                } ?>"    class="form-control"/>


                                <?php
                                if (isset($_GET['Edit'])) {
                                    echo"$Current_inventory_Stock_lang";
                                    ######################################
                                    $id = $_GET['Edit'];
                                    $result_getbalance = mysqli_query($con, "SELECT Quantity,subqty FROM items where id='" . $_GET['Edit'] . "'");
                                    if (@mysqli_num_rows($result_getbalance) > 0) {
                                        while ($row_getbalance = mysqli_fetch_array($result_getbalance)) {
                                            $totalgetbalance = $row_getbalance['Quantity'];
                                            $totalgetsubqty = $row_getbalance['subqty'];
                                        }
                                    }
############################
                                    $sqlalast = "SELECT item,id,Quantity,date,SupplierID FROM " . $prefix . "_receivings where item='$id'  UNION ALL SELECT item,id,Quantity*-1,date,SupplierID FROM " . $prefix . "_sales where item='$id'";
                                    //$sqla = "SELECT * 
                                    //FROM sales t1
                                    //LEFT JOIN receivings t2 ON t1.inv_id=t2.inv_id AND t1.item=t2.item AND t1.Quantity=t2.Quantity AND t1.SupplierID=t2.SupplierID AND t1.date=t2.date";	
                                    $resultalast = @mysqli_query($con, $sqlalast);
                                    while ($rowalast = @mysqli_fetch_array($resultalast)) {
                                        $Quantitytotallast+=$rowalast['Quantity'];
                                    }
####################
                                    $Quantitytotala = $totalgetbalance + $Quantitytotallast;


                                    $openQ = get_sum_product_store_data($id, $_GET['store_id'] , $_GET['date_from'] , $_GET['date_to'])[Quantity] ;


                                    $all_qty0 = ($openQ + GetQuantity($id,null , $store_id , $_GET['date_from'] , $_GET['date_to']));
                                    $NumberBreakdown00 = NumberBreakdown($all_qty0, $returnUnsigned = false);


//                                    $NumberBreakdown00 = NumberBreakdown($Quantitytotala, $returnUnsigned = false);
                                    $all_qty00 = (abs($NumberBreakdown00[1]) * $totalgetsubqty);
                                    $whole00 = $NumberBreakdown00[0];
                                    echo'<span style="color:#F00;">' . $whole00 . ',' . round($all_qty00) . ' </span>';
                                }
                                ?>


                            </td>
                        </tr>
                        <td class="text-right"><lable><?php echo"$Minimum_quantity_lang"; ?></lable></td>
                        <td class="text-right"><input type="text" name="alert_shortcomings" value="<?php if ($alert_shortcomings == "") {
                                echo"" . $row_items_alert_shortcomings . "";
                            } else {
                                echo"" . $alert_shortcomings . "";
                            } ?>" class="form-control" /></td>
                        <?php if ($Retail_allow == "1") { ?>
                            <tr>
                                <td class="text-right">
                                    <lable><?php echo"$number_sub_units_lang"; ?></lable>

                                </td>
                                <td class="text-right"><input type="text" name="subqty" value="<?php echo $row_items_subqty; ?>" class="form-control" /></td>
                                <td class="text-right"><lable><?php echo"$Sub_unit_price_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="subprice" value="<?php if ($subprice == "") {
                                        echo"" . $row_items_subprice . "";
                                    } else {
                                        echo"" . $subprice . "";
                                    } ?>" class="form-control"  /></td>

                            </tr>

                        <?php } ?>

                        <tr>

                            <td colspan="<?php echo"$colspanc"; ?>">
                                <?php if($use_colors==1){ ?>

                                    <div class="form-group">

                                        <div class="col-lg-4 float-inp">
                                            <spam style="vertical-align:top;"><?php echo"$Colors_lang"; ?></spam>
                                            <select class="input-small.form-control" name="color[]" multiple="">
                                                <?php
                                                $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3");
                                                $num_colors = @mysqli_num_rows($result_colors);
                                                if ($num_colors > 0) {
                                                    while ($row_colors = mysqli_fetch_array($result_colors)) {
                                                        if(in_array($row_colors['id'], $models_color_v_explode, true)){$sel='selected="selected"';}else{$sel=""; }
                                                        echo '<option value="' . $row_colors['id'] . '"  '.$sel.' >' . $row_colors['color'] . '</option >';

                                                    }
                                                }
                                                ?>





                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            </td>

                            <td colspan="<?php echo"$colspan"; ?>">
                                <?php if($use_sizes==1){ ?>
                                    <div class="form-group">

                                        <div class="col-lg-4 float-inp">
                                            <spam style="vertical-align:top;"><?php echo"$Sizes_lang"; ?></spam>
                                            <select class="input-small.form-control" name="size[]"  multiple="">
                                                <?php
                                                $result_sizes = @mysqli_query($con, "SELECT * FROM sizes");
                                                $num_sizes = @mysqli_num_rows($result_sizes);
                                                if ($num_sizes > 0) {
                                                    while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                                                        if(in_array($row_sizes['id'], $modelssizevexplode, true)){$sel='selected="selected"';}else{$sel=""; }
                                                        echo '<option value="' . $row_sizes['id'] . '" '.$sel.' >' . $row_sizes['size'] . '</option >';

                                                    }
                                                }
                                                ?>





                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <td class="text-right">
                            <?php
                            if ($isedit == 1) {
                                echo'<input type="submit" name="modification" id="modification" value="'.$Modify_lang.'" class="button"  />';
                                echo'<input type="hidden"  name="id" value="' . $row_items_id . '"/>';
                            } else {
                                echo'<input type="submit" name="add" id="add" value="'.$save_lang.'" class="button"  />';
                            }
                            ?>
                            <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href = 'items_and_inventory.php'"  />
                        </td>

                        <td>
                        <th class="text-center"></th>
                        <td class="text-center"></td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>

                        </td>
                    </table>

                </form>
            <?php } ?>

        </fieldset>

<!--        <div>-->
            <form method="get">

                <select name="store_id" size="1" style="height:20px; width:20%;" class="js-example-placeholder-single  js-states form-control">
                    <option value=""> <?php echo"$Store_name"; ?></option>
                    <?php
                    $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_store order by id ASC");
                    $num_item = mysqli_num_rows($ProductsName);
                    if ($num_item > 0) {
                        while ($row_item = mysqli_fetch_array($ProductsName)) {
                            if ($row_item['id'] == $_GET['store_id']) {
                                echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                            } else {
                                echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <select name="Quanstatus" size="1" style="height:20px; width:20%;"  class="js-example-placeholder-single  js-states form-control">
                    <option <?php if ($_GET['Quanstatus']=='1') {echo 'selected="selected"'; } ?> value="1">الكميات فقط </option>
                    <option <?php if ($_GET['Quanstatus']=='2' or !isset($_GET['Quanstatus'])) {echo 'selected="selected"'; } ?> value="2">بدون كميات </option>
                    <option <?php if ($_GET['Quanstatus']=='0' or !isset($_GET['Quanstatus'])) {echo 'selected="selected"'; } ?> value="0">الكل </option>

                </select>
                <select name="search" size="1" style="height:20px; width:20%;"  class="js-example-placeholder-single  js-states form-control">
                    <option value=""><?php echo"$the_Item_lang"; ?></option>
                    <?php
                    $ProductsName = mysqli_query($con, "SELECT * FROM items order by item ASC");
                    $num_item = mysqli_num_rows($ProductsName);
                    if ($num_item > 0) {
                        while ($row_item = mysqli_fetch_array($ProductsName)) {
                            if ($row_item['id'] == $_GET['search']) {
                                echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['item'] . '</option>';
                            } else {
                                echo'<option value="' . $row_item['id'] . '">' . $row_item['item'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>

                <select name="groups" size="1" style="height:20px; width:20%;" class="js-example-placeholder-single  js-states form-control" >
                    <option value=""><?php echo"$the_Group"; ?></option>
                    <?php
                    $Groups_list = mysqli_query($con, "SELECT * FROM products where id>0 order by product_name ASC");
                    $num_Groups_list = mysqli_num_rows($Groups_list);
                    if ($num_Groups_list > 0) {
                        while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                            if ($row_Groups_list['id'] == $row_items_id) {
                                echo'<option value="' . $row_Groups_list['id'] . '"   selected="selected">' . $row_Groups_list['product_name'] . '</option>';
                            } else {
                                echo'<option value="' . $row_Groups_list['id'] . '">' . $row_Groups_list['product_name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <input type="text" name="date_from" style="display:none ;height:20px; width:20%;"  id="from" value="<?php if (isset($_GET['date_from'])) {
                    echo"" . $_GET['date_from'] . "";
                }

                else{
                    echo '';
                } ?>" class=" form-control" />

                <input  type="text" name="date_to" style="height:20px; width:20%;"  id="to" value="<?php if (isset($_GET['date_to'])) {
                    echo"" . $_GET['date_to'] . "";
                }

                else{
                    echo '';
                } ?>" class=" form-control" />
                <script type="text/javascript">
                    $('#to').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                </script>
                <script type="text/javascript">
                    $('#from').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                </script>
                <input type="submit" value="<?php echo"$Search_lang"; ?>" />
                <a href="hide_items_and_inventory.php"><?php echo"$Show_hidden_items_lang"; ?></a>
            </form>
<!--        </div>-->
        <form id="mainform" action="" method="post">
            <table border="1" style="font-size: 16px; width: 100%; direction: rtl; border: 1px; border-collapse: collapse; margin-top: 10px;text-align:center; table-layout: fixed;"    class="container" id="container">
                <thead style="background-color:#CCC;">
                <th style="width:5%;" class="text-center"><input type="checkbox" name="all" value="1" id="all" /></th>

                <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                    echo"sort_t";
                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                    echo"sort_d";
                } else {
                    echo"sort0";
                } ?>"><a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                        echo"DESC";
                    } else if ($_GET['type'] == "DESC") {
                        echo"ASC";
                    } else {
                        echo"DESC";
                    } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
                <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "groupid") {
                    echo"sort_t";
                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "groupid") {
                    echo"sort_d";
                } else {
                    echo"sort0";
                } ?>"><a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=groupid&type=<?php if ($_GET['type'] == "ASC") {
                        echo"DESC";
                    } else if ($_GET['type'] == "DESC") {
                        echo"ASC";
                    } else {
                        echo"DESC";
                    } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_Group"; ?></a></th>
                <th  class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "OrderNo") {
                    echo"sort_t";
                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "OrderNo") {
                    echo"sort_d";
                } else {
                    echo"sort0";
                } ?>"><a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=OrderNo&type=<?php if ($_GET['type'] == "ASC") {
                        echo"DESC";
                    } else if ($_GET['type'] == "DESC") {
                        echo"ASC";
                    } else {
                        echo"DESC";
                    } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Ranking_lang"; ?></a></th>

                <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "item") {
                    echo"sort_t";
                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "item") {
                    echo"sort_d";
                } else {
                    echo"sort0";
                } ?>"><a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=item&type=<?php if ($_GET['type'] == "ASC") {
                        echo"DESC";
                    } else if ($_GET['type'] == "DESC") {
                        echo"ASC";
                    } else {
                        echo"DESC";
                    } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_Item_lang"; ?></a></th>


                <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Quantity") {
                    echo"sort_t";
                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Quantity") {
                    echo"sort_d";
                } else {
                    echo"sort0";
                } ?>"><a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=Quantity&type=<?php if ($_GET['type'] == "ASC") {
                        echo"DESC";
                    } else if ($_GET['type'] == "DESC") {
                        echo"ASC";
                    } else {
                        echo"DESC";
                    } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_Quantity_lang"; ?></a></th>
                <!--                        --><?php //if ($user_IsAdmin == 1) { ?>
                <!--                            <th  class="text-center  --><?php //if ($_GET['type'] == "ASC" and $_GET['orderby'] == "price") {
                //                        echo"sort_t";
                //                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "price") {
                //                        echo"sort_d";
                //                    } else {
                //                        echo"sort0";
                //                    } ?><!--"><a href="?groups=--><?php //echo"" . $_GET['groups'] . ""; ?><!--&search=--><?php //echo"" . $_GET['search'] . ""; ?><!--&limit=--><?php //echo"" . $_GET['limit'] . ""; ?><!--&orderby=price&type=--><?php //if ($_GET['type'] == "ASC") {
                //                        echo"DESC";
                //                    } else if ($_GET['type'] == "DESC") {
                //                        echo"ASC";
                //                    } else {
                //                        echo"DESC";
                //                    } ?><!--&page=--><?php //echo"" . $_GET['page'] . ""; ?><!--" class="a_remove_underlines">--><?php //echo"$Purchasing_price_lang"; ?><!--</a></th>-->
                <!--                        --><?php //} ?>

                <!--                        <th  class="text-center --><?php //if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Retail_price") {
                //                        echo"sort_t";
                //                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Retail_price") {
                //                        echo"sort_d";
                //                    } else {
                //                        echo"sort0";
                //                    } ?><!--"><a href="?groups=--><?php //echo"" . $_GET['groups'] . ""; ?><!--&search=--><?php //echo"" . $_GET['search'] . ""; ?><!--&limit=--><?php //echo"" . $_GET['limit'] . ""; ?><!--&orderby=Retail_price&type=--><?php //if ($_GET['type'] == "ASC") {
                //                        echo"DESC";
                //                    } else if ($_GET['type'] == "DESC") {
                //                        echo"ASC";
                //                    } else {
                //                        echo"DESC";
                //                    } ?><!--&page=--><?php //echo"" . $_GET['page'] . ""; ?><!--" class="a_remove_underlines">--><?php //echo"$Selling_price_lang"; ?><!--</a></th>-->
                <!---->
                <!--                        <th  class="text-center --><?php //if ($_GET['type'] == "ASC" and $_GET['orderby'] == "companies") {
                //                        echo"sort_t";
                //                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "companies") {
                //                        echo"sort_d";
                //                    } else {
                //                        echo"sort0";
                //                    } ?><!--"><a href="?groups=--><?php //echo"" . $_GET['groups'] . ""; ?><!--&search=--><?php //echo"" . $_GET['search'] . ""; ?><!--&limit=--><?php //echo"" . $_GET['limit'] . ""; ?><!--&orderby=companies&type=--><?php //if ($_GET['type'] == "ASC") {
                //                        echo"DESC";
                //                    } else if ($_GET['type'] == "DESC") {
                //                        echo"ASC";
                //                    } else {
                //                        echo"DESC";
                //                    } ?><!--&page=--><?php //echo"" . $_GET['page'] . ""; ?><!--" class="a_remove_underlines">--><?php //echo"$barcode_lang"; ?><!--</a></th>-->
                <!---->
                <!--                        <th  class="text-center --><?php //if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Discount") {
                //                        echo"sort_t";
                //                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Discount") {
                //                        echo"sort_d";
                //                    } else {
                //                        echo"sort0";
                //                    } ?><!--"><a href="?groups=--><?php //echo"" . $_GET['groups'] . ""; ?><!--&search=--><?php //echo"" . $_GET['search'] . ""; ?><!--&limit=--><?php //echo"" . $_GET['limit'] . ""; ?><!--&orderby=Discount&type=--><?php //if ($_GET['type'] == "ASC") {
                //                        echo"DESC";
                //                    } else if ($_GET['type'] == "DESC") {
                //                        echo"ASC";
                //                    } else {
                //                        echo"DESC";
                //                    } ?><!--&page=--><?php //echo"" . $_GET['page'] . ""; ?><!--" class="a_remove_underlines">--><?php //echo"$the_Discount_lang"; ?><!--</a></th>-->
                <!--                        -->
                <th class="text-center "><a href="#" onclick="javascript:void window.open('items_and_inventory_print.php?groups=<?php echo"" . $_GET['groups'] . ""; ?>&search=<?php echo"" . $_GET['search'] . ""; ?>&store_id=<?php echo"" . $_GET['store_id'] . ""; ?>&to=<?php echo"" . date("Y-m-d") . ""; ?>', '139093750264169', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                            return false;"><img width="25" height="25" src="images/print_icon.gif" style="border:0px;"></a>
                </th>
                </thead>
                <?php
                if ($orderby == null) {
                    $orderby = "id";
                }
                if ($type == null) {
                    $type = "DESC";
                }
                ###########################################
                $tbl_name = "items";  //your table name
                // How many adjacent pages should be shown on each side?
                $adjacents = 3;

                /*
                  First get total number of rows in data table.
                  If you have a WHERE clause in your query, make sure you mirror it here.
                 */
                if ($_GET['search'] == "" or $_GET['search'] == null) {
                    if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                        $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") order by $orderby $type";
                    } else {
                        if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                            $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") and  groupid='" . $_GET['groups'] . "' and companies=='" . $_GET['companies'] . "' order by $orderby $type";
                        } else {
                            $query = "SELECT COUNT(*) as num  FROM  items  where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "'  order by $orderby $type";
                        }
                    }
                } else {
                    $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") and  id='$search'  and groupid='" . $_GET['groups'] . "'  order by $orderby $type";
                }
                $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                $total_pages = $total_pages[num];

                /* Setup vars for query. */
                $targetpage = "?companies=" . $_GET['companies'] . "&Quanstatus=" . $_GET['Quanstatus']. "&groups=" . $_GET['groups']. "&store_id=" . $_GET['store_id'] . "&date_to=" . $_GET['date_to']. "&date_from=" . $_GET['date_from']. "&search=" . $_GET['search'] . "&limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "";  //your file name  (the name of this file)
                //how many items to show per page
                if (!empty($_GET['limit'])) {
                    $_SESSION[limit] = $_GET['limit'];
                } else {

                }
                if (!empty($_SESSION[limit])) {
                    $limit = $_SESSION[limit];
                } else {
                    $limit = 300;
                }
                $page = $_GET['page'];
                if ($page)
                    $start = ($page - 1) * $limit;    //first item to display on this page
                else
                    $start = 0;        //if no page var is given, set start to 0

                /* Get data. */
                if ($orderby == "item") {
                    /* 			SELECT
                      A.id AS Id,
                      A.nome AS Nome,
                      JT.id as OB_FIELD
                      FROM main_table A
                      JOIN joined_table JT ON JT.id = A.id_cat

                      ORDER BY OB_FIELD */
                    if ($_GET['search'] == "" or $_GET['search'] == null) {
                        if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") order by $orderby $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' order by $orderby $type LIMIT $start, $limit";
                            }
                        } else {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "' order by $orderby $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and groupid='" . $_GET['groups'] . "' order by $orderby $type LIMIT $start, $limit";
                            }
                        }
                    }
                    else {
                        if ($_GET['groups'] == null) {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  order by $orderby $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'  order by $orderby $type LIMIT $start, $limit";
                            }
                        } else {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'   and groupid='" . $_GET['groups'] . "' order by $orderby $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'   and groupid='" . $_GET['groups'] . "' order by $orderby $type LIMIT $start, $limit";
                            }
                        }
                    }
                }
                else if ($orderby == "groupid") {
                    if ($_GET['search'] == "" or $_GET['search'] == null) {
                        if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                            $sql = "SELECT i.id as id,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  order by g.GroupName  $type LIMIT $start, $limit";
                        } else {
                            if ($_GET['groups'] == null) {
                                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid order by g.GroupName  $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid order by g.GroupName  $type LIMIT $start, $limit";
                                }
                            } else {
                                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                    $sql = "SELECT i.id as id,i.groupid as groupid,i.companies as companies,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid where groupid='" . $_GET['groups'] . "' order by g.GroupName  $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT i.id as id,i.groupid as groupid,i.companies as companies,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid where groupid='" . $_GET['groups'] . "' order by g.GroupName  $type LIMIT $start, $limit";
                                }
                            }
                        }
                    } else {
                        if ($_GET['groups'] == null) {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   order by g.GroupName  $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   order by g.GroupName  $type LIMIT $start, $limit";
                            }
                        } else {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   and groupid='" . $_GET['groups'] . "' order by g.GroupName  $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i  where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   and groupid='" . $_GET['groups'] . "' order by g.GroupName  $type LIMIT $start, $limit";
                            }
                        }
                    }
                }
                else {
                    if ($_GET['search'] == "" or $_GET['search'] == null) {
                        if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") order by $orderby+0 $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and  companies='" . $_GET['companies'] . "' order by $orderby+0 $type LIMIT $start, $limit";
                            }
                        } else {
                            if ($_GET['groups'] == null) {
                                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") order by $orderby+0 $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and  companies='" . $_GET['companies'] . "' order by $orderby+0 $type LIMIT $start, $limit";
                                }
                            } else {
                                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "'  order by $orderby+0 $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and groupid='" . $_GET['groups'] . "'  order by $orderby+0 $type LIMIT $start, $limit";
                                }
                            }
                        }
                    } else {
                        if ($_GET['groups'] == null) {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  order by $orderby+0 $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'  order by $orderby+0 $type LIMIT $start, $limit";
                            }
                        } else {
                            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  and groupid='" . $_GET['groups'] . "' order by $orderby+0 $type LIMIT $start, $limit";
                            } else {
                                $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and  id='$search'  and groupid='" . $_GET['groups'] . "' order by $orderby+0 $type LIMIT $start, $limit";
                            }
                        }
                    }
                }


                $result = @mysqli_query($con, $sql);
                /* Setup page vars for display. */
                if ($page == 0)
                    $page = 1;     //if no page var is given, default to 1.
                $prev = $page - 1;       //previous page is page - 1
                $next = $page + 1;       //next page is page + 1
                $lastpage = ceil($total_pages / $limit);  //lastpage is = total pages / items per page, rounded up.
                $lpm1 = $lastpage - 1;      //last page minus 1

                /*
                  Now we apply our rules and draw the pagination object.
                  We're actually saving the code to a variable in case we want to draw it more than once.
                 */
                $pagination = "";
                if ($lastpage > 1) {
                    $pagination .= "<div class=\"pagination\">";
                    //previous button
                    if ($page > 1)
                        $pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
                    else
                        $pagination.= "<span class=\"disabled\">>></span>";

                    //pages
                    if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page)
                                $pagination.= "<span class=\"current\">$counter</span>";
                            else
                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                        }
                    }
                    elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
                        //close to beginning; only hide later pages
                        if ($page < 1 + ($adjacents * 2)) {
                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                            $pagination.= "...";
                            $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                            $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                        }
                        //in middle; hide some front and some back
                        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                            $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                            $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                            $pagination.= "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                            $pagination.= "...";
                            $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                            $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                        }
                        //close to end; only hide early pages
                        else {
                            $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                            $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                            $pagination.= "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page)
                                    $pagination.= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                        }
                    }

                    //next button
                    if ($page < $counter - 1)
                        $pagination.= "<a href=\"$targetpage&page=$next\"><<</a>";
                    else
                        $pagination.= "<span class=\"disabled\"><<</span>";
                    $pagination.= "</div>\n";
                }
                ###############
                $i = 0;
                $wholeZeroCount = 0 ;
                $wholeZeroCount2 = 0 ;
                while ($row = @mysqli_fetch_array($result)) {

                $item_id = $row['id'];
                #################
                $Groups_list = mysqli_query($con, "SELECT product_name FROM products where id=" . $row['groupid'] . "");
                $num_Groups_list = mysqli_num_rows($Groups_list);
                if ($num_Groups_list > 0) {
                    while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                        $row_Groups = $row_Groups_list['product_name'];
                    }
                }
                $issingle = $i / 2;
                $dot = strstr($issingle, '.');
                if ($dot == "") {
                    $class = "background_color_FFF";
                } else {
                    $class = 'background_color_D5EFF0';
                }
                $openQ = get_sum_product_store_data($row['id'], $_GET['store_id'] , $_GET['date_from'] , $_GET['date_to'])[Quantity] ;


                $all_qty0 = ($openQ + GetQuantity($row['id'],null , $store_id , $_GET['date_from'] , $_GET['date_to']));
                $NumberBreakdown = NumberBreakdown($all_qty0, $returnUnsigned = false);
                $all_qty = (abs($NumberBreakdown[1]) * $row['subqty']);
                $whole = $NumberBreakdown[0];
                if(isset($_GET['Quanstatus']) and $whole == 0 and  $_GET['Quanstatus']=='1'){
                    $wholeZeroCount ++ ;
                }elseif(isset($_GET['Quanstatus']) and $whole > 0 and  $_GET['Quanstatus']=='2'){
                    $wholeZeroCount2 ++ ;
                }else{
                ?>
                <tr class="text-center  <?php echo"" . $class . ""; ?>">
                    <td class="text-center "><input type="checkbox" name="cb[]" value="<?php echo"" . $row['id'] . ""; ?>"></td>
                    <td class="text-center "><?php echo"" . $row['id'] . ""; ?></td>
                    <td class="text-center "><?php echo"" . $row_Groups . ""; ?></td>
                    <td class="text-center "><?php echo"" . $row['OrderNo'] . ""; ?></td>
                    <td class="text-center "><?php echo"<a href='product_store.php?item=$item_id' >" . $row['item'] . "</a>"; ?></td>
                    <td class="text-center ">
                        <?php
                        if($use_colors=='0' and $use_sizes=='0'){?>
                            <?php echo"" . $whole . "";
                            //," . round($all_qty) . "
                            ?>
                        <?php }else{ ?>
                            <a href="item_analysis.php?id=<?php echo"" . $row['id'] . ""; ?>"><?php echo"" . $whole . "," . round($all_qty) . ""; ?></a>
                        <?php } ?>
                    </td>

                    <!--        --><?php //if ($user_IsAdmin == 1) { ?>
                    <!--                                    <td class="text-center ">--><?php //echo"" . $row['price'] . ""; ?><!--</div></td>-->
                    <!--        --><?php //} ?>

                    <!--                                <td class="text-center ">--><?php //echo"" . $row['Retail_price'] . ""; ?><!--</td>-->
                    <!--                                <td class="text-center ">--><?php //echo $row['Barcode'];       ?>
</div></td>
<!--                                <td class="text-center ">--><?php //echo"" . $row['Discount'] . ""; ?><!--</td>-->
<td class="text-center ">

    <a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&del=<?php echo"" . $row['id'] . ""; ?>"><img src="images/erase.png" style="border:0px;"/></a>
    <a href="?groups=<?php echo"" . $_GET['groups'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&Edit=<?php echo"" . $row['id'] . ""; ?>"><img src="images/edit.png"/></a>
    <?php /* ?><img src="images/view.png"/><?php */ ?>
    <a href="#" onclick="javascript:void window.open('items_and_inventory_mov.php?id=<?php echo"" . $row['id'] . ""; ?>&from=<?php echo"" . date("Y-m-01") . ""; ?>&to=<?php echo"" . date("Y-m-d") . ""; ?>', '1390937502641', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
            return false;"><img src="images/arrears_list.gif" style="border:0px;" title="<?php echo"$Statement_Item_lang"; ?>" /></a>
    <?php //if ($inv_barcode == "0") {

    //  } else { ?>
    <a href="#" onclick="javascript:void window.open('inv_barcode_items.php?codetype=code128&size=100&text=<?php echo"" . $row['Barcode'] . ""; ?>&text2=<?php echo"".$row['item'].""; ?>&id=<?php echo"" . $row['id'] . ""; ?>', '1390937502641', 'width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
            return false;"><img src="images/barcode.png" style="border:0px;"/></a>
    <?php // } ?>
    <a  onclick="return confirm('<?php echo"$sure_hide_item_lang"; ?>');" href="?hide=<?php echo"" . $row['id'] . ""; ?>"><img src="images/eye-dark.png" width="16" height="16" /></a>
</td>
</tr>

<?php $i++;
}
}

if ($_GET['Quanstatus']='1'){
    $total_pages = $total_pages - $wholeZeroCount ;
}
if ($_GET['Quanstatus']='2'){
    $total_pages = $total_pages - $wholeZeroCount2 ;
}

?>
<thead style="background-color:#CCC;">

<th colspan="6" class="text-center "><?php echo"$pagination"; ?></th>
<th class="text-center ">

    <a href="#" onClick="confirmSubmit();"><img src="images/erase.png"/></a>

</th>
</thead>
</table>
</form>
<?php } ?>
</article>

<!--    <nav></nav>-->
<!-- <aside></aside>-->
</div>
</body>

</html>
<?php  include 'includes/footer.php'; ?>

<script type="text/javascript">

    $(".js-example-placeholder-single").select2({
        // placeholder: "اختر",
        allowClear: true
    });

    $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
</script>
<script type="text/javascript">
    if(Session["display"]=="block"){
        $('#myForm').css('display', 'block');
    }else{
        $('#myForm').css('display', 'none');
    }
    function toggle_visibility(id) {
        var e = document.getElementById(id);
        if(e.style.display == 'block'){
            e.style.display = 'none';
            Session["display"] ="none";
        }
        else
        {
            e.style.display = 'block';
            Session["display"] ="block";
        }
    }
</script>