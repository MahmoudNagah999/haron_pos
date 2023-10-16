<?php
include "../includes/inc.php";
if (isset($_POST['submit'])) {
//var_dump($_POST['submit']);
//die();
    mysqli_autocommit($con,FALSE);
    $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_temporary where user_id='$user_id' order by id DESC");
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
            mysqli_query($con, "UPDATE " . $prefix . "_order_supply_temporary SET  Quantity='" . $quantity . "',Price='" . $Price . "',Discount='" . $Discount . "',
Total='" . $Total . "',type='1',BuyPrice='" . $BuyPrice . "',order_supply_type='" . $order_supply_type . "',size='" . $size . "',color='" . $color . "',user_id='$user_id',staff='$staff'  where id='" . $row_up['id'] . "'");
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
