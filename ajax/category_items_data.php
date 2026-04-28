<?php

include "../includes/inc.php";

$data = [] ;

if (isset($_GET['cat_show'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET cat_items_show=" . $_GET['cat_show'] . " where id=" . $get_db_id . "");
//    header("refresh:0;url=stores_change.php");




    $data['items'] = '';




    if ($_GET['cat_show'] != '0') {

        $sql = "SELECT * FROM items where OrderNo!='0' and OrderNo!='' and groupid=" . $_GET['cat_show'] . " AND id NOT IN(".get_hide_items().")  order by OrderNo ASC";
        $result = @mysqli_query($con, $sql);
        while ($row = @mysqli_fetch_array($result)) {
            $qty_it = GetQuantity($row['id'], '1');
            $bg_style = $row['Background'] ? "style='background-color:" . $row['Background'] . ";'" : "";
            
            $data["items"] .= "<div class='draggable-demo-product' title='$qty_it' $bg_style>";
            $data["items"] .= "<div class='draggable-demo-product-header'>
                                    <div class='draggable-demo-product-header-label'>
                                        <a class='addProd' data_item_type='items' par='q' attr='" . $row['id'] . "'>" . $row['item'] . "</a>
                                    </div>
                                  </div>";
                                  
            if ($row['image'] != null and $row['useimage'] == 1) {
                $data["items"] .= "<a class='addProd' data_item_type='items' par='q' attr='" . $row['id'] . "'>
                                        <img src='uploads/" . $row['image'] . "' class='img-responsive' style='height:100px; width:100%; object-fit:cover;' />
                                      </a>";
            }
            $data["items"] .= "</div>";
        }

    }
    else {
        $data["items"].= '<div class="categories-wrapper">';
        $result_cat = mysqli_query($con, "SELECT * FROM products where `rank`!='0' and `rank`!='' and id>0  order by `rank` ASC");
        if (@mysqli_num_rows($result_cat) >= 1) {
            while ($row_cat = mysqli_fetch_array($result_cat)) {
                $class = ($row_cat['id'] == $db_cat_items_show) ? "draggable-demo-product3" : "draggable-demo-product2";
                $data["items"] .= "<div class='$class'>
                                        <div class='draggable-demo-product-header'>
                                            <a class='addProd' par='cat_show' attr='" . $row_cat['id'] . "'>";
                if ($row_cat['useimage'] == 1) {
                    $data["items"] .= "<img src='uploads/" . $row_cat['image'] . "' class='img-responsive' style='max-height:35px;' />";
                } else {
                    $data["items"] .= $row_cat['product_name'];
                }
                $data["items"] .= "</a></div></div>";
            }
        }
        $data["items"] .= "</div>";
    }






}
if (isset($_POST['ch_status']) and $_POST['ch_status']=='chngeQ') {
    mysqli_autocommit($con,FALSE);
    $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_stores_change_temporary where user_id='$user_id' order by id DESC");
    while ($row_up = mysqli_fetch_array($result_up)) {
        $item = $_POST['item' . $row_up['id']];
        $quantity = $_POST['quantity' . $row_up['id']];
        if(GetQuantity($item,'1')>=$quantity){}else{
            $quantity=GetQuantity($item,'1');
        }

        $Price = $_POST['price' . $row_up['id']];
        $staff = $_POST['staff' . $row_up['id']];
        $Discount = $_POST['discount' . $row_up['id']];

        $BuyPrice = $_POST['BuyPrice' . $row_up['id']];
        $stores_change_type = $_POST['stores_change_type' . $row_up['id']];
        $size = $_POST['size' . $row_up['id']];
        $color = $_POST['color' . $row_up['id']];
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
echo json_encode($data);
