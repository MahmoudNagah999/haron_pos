<?php
include "../includes/inc.php";

if (isset($_POST['id'])) {
    $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_order_supply_inv   where  id IN (" . $_POST['id'] . ")");
    while ($row = mysqli_fetch_object($ProductsName)) {
        $old = $row->status;
    }

    $update_temp_sql="UPDATE " . $prefix . "_order_supply_inv SET status=".$_POST['status']." where  id IN (" . $_POST['id'] . ")";
    if (mysqli_query($con, $update_temp_sql)) {
        $invidid = $_POST['invidid'];
        $idd = $_POST['id'];

        if ($_POST['id']  != $old){
            $update_temp_sql="INSERT INTO {$prefix}_order_supply_log (`user_name`, `user_id`, `inv_id`, `order_id` ,`old_status`,`new_status`) VALUES ('{$user_username}' , {$user_id} , {$invidid} , {$idd} , {$old} , {$_POST['status']})";
            mysqli_query($con, $update_temp_sql);
        }
        echo json_encode('success');

    }else{
        echo json_encode('error');

//        echo 'error / '.$update_temp_sql;
    }

}else{
    echo json_encode('asasas');

//    echo 'dsdsa';
}
