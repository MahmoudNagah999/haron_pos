
<?php
include "../includes/inc.php";

//echo "<pre>";
//$parts = parse_url($_SERVER['REQUEST_URI']);
//parse_str($parts['query'], $query);
//var_dump($query);
//var_dump($_POST);
//var_dump($_GET);
//
//exit();
$DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));

$data = [] ;
if (isset($_GET['cat_show'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET cat_items_show=" . $_GET['cat_show'] . " where id=" . $get_db_id . "");
//    header("refresh:0;url=order_supply.php");
}
if (isset($_POST['ch_status']) and $_POST['ch_status']=='chngeQ') {

    mysqli_autocommit($con,FALSE);
    $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC");
    while ($row_up = mysqli_fetch_array($result_up)) {

        $row_up['id'];
        $item = $_POST[item . $row_up['id']];
        $quantity = $_POST[quantity . $row_up['id']];

        $Price = $_POST[price . $row_up['id']];
        $staff = $_POST[staff . $row_up['id']];
        $Discount = $_POST[discount . $row_up['id']];

        $BuyPrice = $_POST[BuyPrice . $row_up['id']];
        $order_supply_type = $_POST[order_supply_type . $row_up['id']];
        $size = $_POST[size . $row_up['id']];
        $color = $_POST[color . $row_up['id']];
        if ($Discount_type == 1) {
            $DiscountValue = $Discount;
        }
        else if ($Discount_type == 2) {
            if ($Discount == 0) {
                $DiscountValue = $Discount;
            } else {
                $DiscountValue = ($quantity * $Price) * ($Discount / 100);
            }
        }
        else {
            $DiscountValue = $Discount;
        }
        $Total = ($quantity * $Price) - $DiscountValue;

        if ($quantity != 0 or $quantity != "") {
            $staff = $staff ?? 0;
            $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];
            $update1Sql = "UPDATE " . $prefix . "_order_supply_temporary SET  centers_id='" . $centers_id_post . "' ,region_id='" . $_POST['region_id'] . "',address='" . $_POST['address'] . "', mobile1='" . $_POST['mobile1'] . "',mobile2='" . $_POST['mobile2'] . "',Quantity='" . $quantity . "',Price='" . $Price . "',Discount='" . $Discount . "',
Total='" . $Total . "',type='1',BuyPrice='" . $BuyPrice . "',order_supply_type='" . $order_supply_type . "',size='" . $size . "',color='" . $color . "',user_id='$user_id',staff= $staff  where id='" . $row_up['id'] . "'";

            mysqli_query($con , $update1Sql);
        }
        else {
            $error_reports = 1;
            $mysqli_errno++;
        }
        //echo"<br />";
    }
    if($mysqli_errno>0){ mysqli_rollback($con); }
    mysqli_commit($con);
}

if ($_GET['del'] !== null) {
    if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' and id=" . $_GET['del'] . "")) {
       $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Item_deleted_lang.'
							</div>';
//        header("refresh:0;url=order_supply.php");
    }
}
if ($_GET['q'] == "d") {
    if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply_temporary where user_id='$user_id'")) {
//        header("refresh:0;url=order_supply.php");
    }
}
else {
    if ($_GET['q'] == null) {
        //	header( "refresh:0;url=order_supply.php" );
    } else {
//                                            var_dump($_GET['item_status']);
        if( $_GET['item_status']!='offers'){
        /*
            if(GetQuantity($_GET['q'],1)<=0 ) {
               $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							' . $no_stock_lang . '
							</div>';

            }
            */
        //    else{
                $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $_GET['q'] . "'");
                if (@mysqli_num_rows($result_new) >= 1) {

                    while ($row_new = mysqli_fetch_array($result_new)) {
                        $item_name_new = $row_new['item'];
                        $item_id_new = $row_new['id'];

                        $item_Discount_new = $row_new['Discount'];
                        $item_price_new = $row_new['price'];

                        //  die($item_price_new);
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
                        $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];

                        $sql = "INSERT INTO " . $prefix . "_order_supply_temporary (item_status
                        ,address,mobile1,mobile2,region_id,centers_id,item, Price, Quantity, Discount, Total, type, date, BuyPrice, subqty, order_supply_type, size, color, user_id) VALUES ('" . $_GET['item_status'] . "','" . $_POST['address'] . "','" . $_POST['mobile1'] . "','" . $_POST['mobile2'] . "','". $_POST['region_id'] . "','". $centers_id_post . "','" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','1','" . $DueDate . "','" . $item_price_new . "','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $size . "','" . $color . "','".$user_id."')";
                    }
//                    var_dump($sql);
//                    exit();
                    if (!mysqli_query($con, $sql)) {
                       $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
//                        header("refresh:1;url=order_supply.php");
                    } else {
                       $data['status']= '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
//                        header("refresh:1;url=order_supply.php");
                    }
                } else {
                   $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
                }
          //  }
        }
        else{
            $ssql ="SELECT * FROM " . $prefix . "_offers_inv where id='" . $_GET['q'] . "'";
            $result_new = mysqli_query($con, $ssql);
            if (@mysqli_num_rows($result_new) >= 1) {

                while ($row_new = mysqli_fetch_array($result_new)) {
                    $item_name_new = $row_new['name'];
                    $item_id_new = $row_new['id'];

                    $item_Discount_new = $row_new['Discount'];
                     $item_price_new = $row_new['Total'];
                    $item_Retail_price_new = $row_new['Total'];
                    $centers_id_post = $_POST['centers_id'] == '' ? 0 : $_POST['centers_id'];

                      $sql = "INSERT INTO " . $prefix . "_order_supply_temporary (item_status,address,mobile1,mobile2,region_id,centers_id,item, Price, Quantity, Discount, Total, type, date, BuyPrice, subqty, order_supply_type, size, color, user_id) VALUES ('" . $_GET['item_status'] . "','" .$_POST['address'] . "','" . $_POST['mobile1'] . "','" . $_POST['mobile2'] . "','". $_POST['region_id'] . "','". $centers_id_post . "','" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_price_new . "','1','" . $DueDate . "','" . $item_price_new . "','" . $item_subqty . "','" . $get_db_order_supply_type . "','" . $size . "','" . $color . "','".$user_id."')";
                }
//                var_dump($sql);
//                exit();
                if (!mysqli_query($con, $sql)) {
                   $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
//                    header("refresh:1;url=order_supply.php");
                } else {
                   $data['status']= '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
//                    header("refresh:1;url=order_supply.php");
                }
            } else {
               $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
            }
//                                        }
        }
    }
}


$data['table']='';
$sql = "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC";
$result = @mysqli_query($con, $sql);
$tbl_name = "" . $prefix . "order_supply_temporary";
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
    $data['table'].= '<input type="hidden" name="BuyPrice' . $row['id'] . '" value="' . $item_BuyPrice . '" /><tr class="'.$gr.'">
							<td>' . $i . '</td>
							<td><input type="hidden" name="item' . $row['id'] . '" value="' . $item_id . '" />' . $item_name . '</td>';
    if ($Retail_allow == "1") {
        $data['table'].= '<td>';
        $data['table'].= '<select  class="'.$gr.'"  name="order_supply_type' . $row['id'] . '" style="width:10%; height:20px; text-align:center;border:0px;>';
        ?>
        <option value="0" <?php if ($row['order_supply_type'] == "0") {
            $data['table'].= ' selected="selected"';
        } ?>><?php echo"$Select_Type_lang"; ?></option>
        <option value="1" <?php if ($row['order_supply_type'] == "1") {
            $data['table'].= ' selected="selected"';
        } ?>><?php echo"$Wholesaling_lang"; ?></option>
        <option value="2" <?php if ($row['order_supply_type'] == "2") {
            $data['table'].= ' selected="selected"';
        } ?>><?php echo"$Retail_lang"; ?></option>
        <?php
        $data['table'].= '</select></td>';
    }
    $data['table'].= '<td><input  class="'.$gr.'" type="text" name="quantity' . $row['id'] . '"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
    if($use_sizes==1){

        $data['table'].= '<td><select  class="'.$gr.'" name="size'.$row['id'].'" style="height:25px; width:10px; text-align:center;border:0px;">';
        $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (".rtrim(get_sizes_of_item($item_id), ",").") limit 15");
        $num_sizes = @mysqli_num_rows($result_sizes);
        if ($num_sizes > 0) {
            while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                if ($row['size'] == $row_sizes['id']) {
                     $data['table'].= '<option value="' . $row_sizes['id'] . '" selected >' . $row_sizes['size'] . '</option >';
                } else {
                     $data['table'].= '<option value="' . $row_sizes['id'] . '">' . $row_sizes['size'] . '</option >';
                }
            }
        }

        $data['table'].= '</select></td>';
    }
    if($use_colors==1){
        $data['table'].= '<td><select  class="'.$gr.'" name="color'.$row['id'].'" style="height:25px; text-align:center;border:0px;">';
        $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (".rtrim(get_clolors_of_item($item_id), ",").")  ");
        $num_colors = @mysqli_num_rows($result_colors);
        if ($num_colors > 0) {
            while ($row_colors = mysqli_fetch_array($result_colors)) {
                if ($row['color'] == $row_colors['id']) {
                     $data['table'].= '<option value="' . $row_colors['id'] . '" selected >' . $row_colors['color'] . '</option >';
                } else {
                     $data['table'].= '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
                }
            }
        }
        $data['table'].= '</select></td>';
    }
    $data['table'].= '<td><input  class="'.$gr.'" type="text"  name="price' . $row['id'] . '" id="price' . $i . '" value="' . $row['Price'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td hidden><input  class="'.$gr.'" type="text"  name="discount' . $row['id'] . '" id="discount' . $i . '" value="' . $row['Discount'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input class="'.$gr.'" type="text"  name="subtotal' . $row['id'] . '" id="subtotal' . $i . '" value="' . $row['Total'] . '"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td valign="middle"><a class="addProd" par="del" attr="'.$row['id'].'"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';




    $i++;
}

if ($sumTotal == null) {

} else {
     $data['table'].= '<tr>';

    if ($use_sizes == 1) {
        if ($use_colors == 1) {
             $data['table'].= '<td colspan="6">' . $the_total_lang . '</td>';
        } else {
             $data['table'].= '<td colspan="5">' . $the_total_lang . '</td>';
        }

    } else {
        if ($use_colors == 1) {
             $data['table'].= '<td colspan="5">' . $the_total_lang . '</td>';
        } else {
             $data['table'].= '<td colspan="4">' . $the_total_lang . '</td>';
        }
    }
     $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . ($sumTotal) . '</font></td>
                            <td></td>
                            </tr>';
    if ($Discount_type == 2) {
        $Discount_val = $sumTotal * $_POST['alldiscount'] / 100;
        $val_lable = "(" . $_POST['alldiscount'] . "%)";
    } else {
        $Discount_val = $_POST['alldiscount'];
    }
     $data['table'].= '<tr>';
     $data['table'].= '<td colspan="4">الخصم ' . $val_lable . '</td>';
     $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . $Discount_val . '</font></td>
                            <td></td>
                            </tr>';
     $data['table'].= '<tr>';


    if ($use_sizes == 1) {
        if ($use_colors == 1) {
             $data['table'].= '<td colspan="6">' . $the_total_after_lang . '</td>';
        } else {
             $data['table'].= '<td colspan="5">' . $the_total_after_lang . '</td>';
        }

    } else {
        if ($use_colors == 1) {
             $data['table'].= '<td colspan="5">' . $the_total_after_lang . '</td>';
        } else {
             $data['table'].= '<td colspan="4">' . $the_total_after_lang . '</td>';
        }
    }

    if ($Discount_type == 2) {
        $print_total_disc = $sumTotal * $_POST['alldiscount'] / 100;
    } else if ($Discount_type == 1) {
        $print_total_disc = $_POST['alldiscount'];
    } else {
    }
//    var_dump($_POST['alldiscount']);
     $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . ($sumTotal - $print_total_disc) . '</font></td>
                            <td></td>
                            </tr>';
}

          if($_POST['shipping']>0){
          $data['table'].="<tr>";
     $data['table'].='<td  colspan="4">م.النقل</td>
                            <td><font style="color:#060; font-weight:bold;">'.$_POST['shipping'].'</font></td><td></td>
                            </tr>';
        $data['table'].='<tr><td  colspan="4">الاجمالى بعد م.النقل</td>
                            <td><font style="color:#060; font-weight:bold;">'.(($sumTotal-$print_total_disc)+$_POST['shipping']).'</font></td><td></td>
                            </tr>';
    }

echo json_encode($data);


?>

