<?php
include "../includes/inc.php";
$data = [] ;


if(isset($_GET['cat_show'])){
    mysqli_query($con, "UPDATE ".$prefix."_config SET cat_items_show=".$_GET['cat_show']." where id=".$get_db_id."");
//    header("refresh:0;url=receivings.php");
}
if (isset($_POST['ch_status']) and $_POST['ch_status']=='chngeQ') {
    //       die("333333333333333333");
    $result_up = mysqli_query($con, "SELECT * FROM ".$prefix."_receivings_temporary where user_id='$user_id' order by id DESC");
    while ($row_up = mysqli_fetch_array($result_up)) {
        //echo $row_up['id'];
        $quantity=round($_POST[quantity.$row_up['id']]);
        $Price=$_POST[price.$row_up['id']];
        $Discount=round($_POST[discount.$row_up['id']]);
        $item=round($_POST[item.$row_up['id']]);
        $unit=round($_POST[unit.$row_up['id']]);
        $BuyPrice=$_POST[BuyPrice.$row_up['id']];
        $size=$_POST[size.$row_up['id']];
        $color=$_POST[color.$row_up['id']];
        if ($Discount_type==1) {
            $DiscountValue=$Discount;
        } else if ($Discount_type==2) {
            if($Discount==0){$DiscountValue=$Discount;}else{
                $DiscountValue=($quantity * $Price) * ($Discount/100);
            }
        } else {
            $DiscountValue=$Discount;
        }
        $Total= ($quantity*$Price)-$DiscountValue;

        if($quantity>0){
            mysqli_query($con, "UPDATE ".$prefix."_receivings_temporary SET  Quantity='".$quantity."',unit='".$unit."',Price='".$BuyPrice."',Discount='".$Discount."',Total='".$Total."',type='1',BuyPrice='".$Price."',color='".$color."',size='".$size."',user_id='$user_id' where  id='".$row_up['id']."'");
        }else{
            $error_reports=1;
        }
    }
}

if($_GET['del']!==null){
    if(mysqli_query($con,"DELETE FROM ".$prefix."_receivings_temporary where user_id='$user_id' and id=".$_GET['del']."")){
        $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Item_deleted_lang.'
							</div>';
//        header("refresh:0;url=receivings.php");
    }
}
if ($_GET['q']=="d") {
    if (mysqli_query($con, "DELETE FROM ".$prefix."_receivings_temporary where user_id='$user_id'")) {
//        header("refresh:0;url=receivings.php");
    }
} else {
    if ($_GET['q']==null) {
        //	header( "refresh:0;url=receivings.php" );
    }
    else {
        $result_new = mysqli_query($con, "SELECT * FROM items where id='".$_GET['q']."'");
        if (@mysqli_num_rows($result_new)>=1) {

            while ($row_new = mysqli_fetch_array($result_new)) {
                $item_name_new = $row_new['item'];
                $item_id_new = $row_new['id'];
                $item_subqty_new = $row_new['subqty'];
                $item_Retail_price_new = $row_new['Retail_price'];
                $item_Discount_new = $row_new['Discount'];
                $item_price_new = $row_new['price'];

                if ($Discount_type == 1) {
                    $item_total_new = $row_new['price'] - $row_new['Discount'];
                } else if ($Discount_type == 2) {
                    $item_total_new = $row_new['price'] - (($row_new['price']) * ($row_new['Discount'] / 100));
                } else {$item_total_new = $row_new['price'];
                }
                $sql = "INSERT INTO ".$prefix."_receivings_temporary (item, Price, Quantity, unit, Discount, Total, type, date, BuyPrice, subqty, size ,color, user_id)
VALUES ('".$item_id_new."','".$item_Retail_price_new."','1','1','".$row_new['Discount']."','".$item_total_new."','1','".$DueDate."','".$item_price_new."','".$item_subqty_new."','" . $get_barcode_size . "','" . $get_barcode_color . "','".$user_id."')";

            }
            if (!mysqli_query($con, $sql)) {
                $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
//                header("refresh:5;url=receivings.php");
            } else {
                $data['status']= '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
//                header("refresh:1;url=receivings.php");
            }
        } else {
            $data['status']= '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
        }


    }
}


$data['table']='';
 $sql = "SELECT * FROM ".$prefix."_receivings_temporary where user_id='$user_id' order by id DESC";
$result_upt = mysqli_query($con, $sql);
$result = @mysqli_query($con, $sql);
$tbl_name = "" . $prefix . "receivings_temporary";
$i = 1;
while ($row = @mysqli_fetch_array($result)) {
    ###########
    $result_it = mysqli_query($con, "SELECT * FROM items where id=".$row['item']."");
    if (@mysqli_num_rows($result_it) > 0) {
        while ($row_it=mysqli_fetch_array($result_it)) {
            $item_name=$row_it['item'];
            $item_id=$row_it['id'];
            $item_price=$row_it['Retail_price'];
            $item_Discount = $row_it['Discount'];
            $item_BuyPrice= $row_it['price'];
            $item_subqty=$row_it['subqty'];
        }
    }
    if ($item_Discount == null) {
        $item_Discount = 0;
    }
    /*								if ($row['Quantity'] < 1) {
                                        $row['Quantity'] = 1;
                                    }*/

    if ($item_Discount == null) {
        $item_Discount = 0;
    }
    $sumTotal+= $row['Total'];
    ###########
    #############تحديث سعر الشراء#####
    if($Update_SellBuyPrice==1){
        mysqli_query($con, "UPDATE items SET Price='".$row['BuyPrice']."' where id='".$row['item']."'");
    }
###############################################################################
    if(is_float($i/2)){
        $gr="gr";
    }else{
        $gr="gr2";
    }
    $unit_option1=null;
    $unit_option2=null;
    if($row['unit']=="1"){$unit_option1=' selected="selected"';}
    if($row['unit']=="2"){$unit_option2=' selected="selected"';}
    $data['table'].='<input type="hidden" name="BuyPrice'.$row['id'].'" value="'.$item_BuyPrice.'" /> <tr class="'.$gr.'">
							<td>'.$i.'</td>
							<td><input type="hidden" name="item'.$row['id'].'" value="'.$item_id.'" />'.$item_name.'</td>
							<td><input  class="'.$gr.'" type="number" name="quantity'.$row['id'].'"  value="'.$row['Quantity'].'" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
    if($Retail_Buying=="1"){
        $data['table'].='<td><select  class="'.$gr.'" name="unit'.$row['id'].'" style="height:25px; text-align:center;border:0px;"><option value="1" '.$unit_option1.'>'.$primary_unit_lang.'</option><option value="2" '.$unit_option2.'>'.$Sub_unit_lang.'</option></select></td>';
    }
    if($use_sizes==1){
        $data['table'].='<td><select  class="'.$gr.'" name="size'.$row['id'].'" style="height:25px;  width:10px; text-align:center;border:0px;">';
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

        $data['table'].='</select></td>';
    }
    if($use_colors==1){
        $data['table'].='<td><select  class="'.$gr.'" name="color'.$row['id'].'" style="height:25px; text-align:center;border:0px;">';
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
        $data['table'].='</select></td>';
    }

    $data['table'].='<td><input  class="'.$gr.'" type="text"  name="price'.$row['id'].'"  value="'.$row['BuyPrice'].'"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input  class="'.$gr.'" type="number"  name="discount'.$row['id'].'" id="discount'.$i.'" value="'.$row['Discount'].'"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td><input  class="'.$gr.'" type="text"  name="subtotal'.$row['id'].'" id="subtotal'.$i.'" value="'.$row['Total'].'"  style="width:10%; height:20px;text-align:center;border:0px;" /></td>
							<td valign="middle"><a class="addProd" par="del" attr="'.$row['id'].'"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>
					';
    $i++;
}



if ($sumTotal == null) {
} else {
   $data['table'].= '<tr>
                            
                            <td colspan="5">' . $the_total_lang . '</td>';
    if ($use_sizes == 1) {
       $data['table'].= '<td></td>';
    }
    if ($use_colors == 1) {
       $data['table'].= '<td></td>';
    }


   $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . ($sumTotal - $alldiscount) . '</font></td>';
   $data['table'].= '<td></td>';
   $data['table'].= ' </tr>';

   $data['table'].= '<tr>
                            
                            <td colspan="5">الخصم</td>';
    if ($use_sizes == 1) {
       $data['table'].= '<td></td>';
    }
    if ($use_colors == 1) {
       $data['table'].= '<td></td>';
    }


   $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . ($sumTotal * ($_POST['alldiscount'] / 100)) . '</font></td>';
   $data['table'].= '<td></td>';
   $data['table'].= ' </tr>';


   $data['table'].= '<tr>';

    if ($use_sizes == 1) {
        if ($use_colors == 1) {
           $data['table'].= '<td colspan="7">' . $the_total_after_lang . '</td>';
        } else {
           $data['table'].= '<td colspan="6">' . $the_total_after_lang . '</td>';
        }

    } else {
        if ($use_colors == 1) {
           $data['table'].= '<td colspan="6">' . $the_total_after_lang . '</td>';
        } else {
           $data['table'].= '<td colspan="5">' . $the_total_after_lang . '</td>';
        }
    }

   $data['table'].= '<td><font style="color:#060; font-weight:bold;">' . ($sumTotal - (($sumTotal * $_POST['alldiscount']) / 100)) . '</font></td>';
   $data['table'].= ' <td></td>';
   $data['table'].= ' </tr>';
}


?>



<?php
echo json_encode($data);


?>

