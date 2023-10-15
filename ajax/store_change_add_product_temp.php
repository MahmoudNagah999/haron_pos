<?php
include "../includes/inc.php";

$data = [] ;





if ($_GET['del'] !== null) {
    if (mysqli_query($con, "DELETE FROM " . $prefix . "_stores_change_temporary where user_id='$user_id' and id=" . $_GET['del'] . "")) {
        $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Item_deleted_lang.'
							</div>';
//        header("refresh:0;url=stores_change.php");
    }
}
if ($_GET['q'] == "d") {
    if (mysqli_query($con, "DELETE FROM " . $prefix . "_stores_change_temporary where user_id='$user_id'")) {
//        header("refresh:0;url=stores_change.php");
    }
}
else {
    if ($_GET['q'] == null) {
        //	header( "refresh:0;url=stores_change.php" );
    } else {
        if(GetQuantity($_GET['q'],1 , $_GET['store_from_id'])<=0){
           $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
							'.$no_stock_lang.'
							</div>';
        }else{
            $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $_GET['q'] . "'");
            if (@mysqli_num_rows($result_new) >= 1) {

                while ($row_new = mysqli_fetch_array($result_new)) {
                    $item_name_new = $row_new['item'];
                    $item_id_new = $row_new['id'];


                    $sql = "INSERT INTO " . $prefix . "_stores_change_temporary (item, Quantity,  date, user_id)
							VALUES ('"  . $item_id_new  . "','1','" . $DueDate .   "','".$user_id."')";
                }
                if (!mysqli_query($con, $sql)) {
                   $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
                    header("refresh:1;url=stores_change.php");
                } else {
                   $data['status']= '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                    header("refresh:1;url=stores_change.php");
                }
            } else {
               $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
            }
        }
    }
}




if (isset($_POST['ch_status']) and $_POST['ch_status']=='chngeQ') {

                            mysqli_autocommit($con,FALSE);
                            $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_stores_change_temporary where user_id='$user_id' order by id DESC");
                            while ($row_up = mysqli_fetch_array($result_up)) {
                                //echo $row_up['id'];
                                $item = $_POST[item . $row_up['id']];
                                $quantity = $_POST[quantity . $row_up['id']];
                                if(GetQuantity($item,'1')>=$quantity){}else{
                                    $quantity=GetQuantity($item,'1');
                                }

                                $Price = $_POST[price . $row_up['id']];
                                $staff = $_POST[staff . $row_up['id']];
                                $Discount = $_POST[discount . $row_up['id']];

                                $BuyPrice = $_POST[BuyPrice . $row_up['id']];
                                $stores_change_type = $_POST[stores_change_type . $row_up['id']];
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
                                    $productQuanSql = "UPDATE " . $prefix . "_stores_change_temporary SET Quantity='" . $quantity  . "',user_id='$user_id'  where id='" . $row_up['id'] . "'";
                                    mysqli_query($con, $productQuanSql);
                                }
                                else {
                                    //
                                    $error_reports = 1;
                                    $mysqli_errno++;
                                }
                                //echo"<br />";
                            }
                            if($mysqli_errno>0){ mysqli_rollback($con); }
                            mysqli_commit($con);
                        }











$data['table']='';
$sql = "SELECT * FROM " . $prefix . "_stores_change_temporary where user_id='$user_id' order by id DESC";
$result = @mysqli_query($con, $sql);
$tbl_name = "" . $prefix . "stores_change_temporary";
$i = 1;
$total_qty = 0 ;
while ($row = @mysqli_fetch_array($result)) {
    ###########
    $total_qty +=$row['Quantity'];
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
        if ($row['offers_type'] == "1") {
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
    $data['table'] .='<input type="hidden" name="BuyPrice' . $row['id'] . '" value="' . $item_BuyPrice . '" /><tr class="'.$gr.'">
							<td>' . $i . '</td>
							<td><input type="hidden" name="item' . $row['id'] . '" value="' . $item_id . '" />' . $item_name . '</td>';
    if ($Retail_allow == "1") {
        $data['table'] .='<td>';
        $data['table'] .='<select  class="'.$gr.'"  name="offers_type' . $row['id'] . '" style="width:10%; height:20px; text-align:center;border:0px;>';
        ?>
        <option value="0" <?php if ($row['offers_type'] == "0") {
            $data['table'] .=' selected="selected"';
        } ?>><?php echo"$Select_Type_lang"; ?></option>
        <option value="1" <?php if ($row['offers_type'] == "1") {
            $data['table'] .=' selected="selected"';
        } ?>><?php echo"$Wholesaling_lang"; ?></option>
        <option value="2" <?php if ($row['offers_type'] == "2") {
            $data['table'] .=' selected="selected"';
        } ?>><?php echo"$Retail_lang"; ?></option>
        <?php
        $data['table'] .='</select></td>';
    }
    $data['table'] .='<td><input  class="'.$gr.'" type="text" name="quantity' . $row['id'] . '"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
    if($use_sizes==1){
        $data['table'] .='<td><select  class="'.$gr.'" name="size'.$row['id'].'" style="height:25px; width:10px; text-align:center;border:0px;">';
        $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (".rtrim(get_sizes_of_item($item_id), ",").") limit 15");
        $num_sizes = @mysqli_num_rows($result_sizes);
        if ($num_sizes > 0) {
            while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                if ($row['size'] == $row_sizes['id']) {
                   $data['status']= '<option value="' . $row_sizes['id'] . '" selected >' . $row_sizes['size'] . '</option >';
                } else {
                   $data['status']= '<option value="' . $row_sizes['id'] . '">' . $row_sizes['size'] . '</option >';
                }
            }
        }

        $data['table'] .='</select></td>';
    }
    if($use_colors==1){
        $data['table'] .='<td><select  class="'.$gr.'" name="color'.$row['id'].'" style="height:25px; text-align:center;border:0px;">';
        $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (".rtrim(get_clolors_of_item($item_id), ",").")  ");
        $num_colors = @mysqli_num_rows($result_colors);
        if ($num_colors > 0) {
            while ($row_colors = mysqli_fetch_array($result_colors)) {
                if ($row['color'] == $row_colors['id']) {
                   $data['status']= '<option value="' . $row_colors['id'] . '" selected >' . $row_colors['color'] . '</option >';
                } else {
                   $data['status']= '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
                }
            }
        }
        $data['table'] .='</select></td>';
    }
    $data['table'] .='<td valign="middle"><a   par="del" attr="'.$row['id'].'" class="addProd"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';
    $i++;
}
$data['table'] .='
 <tr ><td colspan="2"> <td>'.$total_qty .'</td><td>اجمالى الكميه</td></tr>

 ' ;
?>



<?php
echo json_encode($data);


?>

