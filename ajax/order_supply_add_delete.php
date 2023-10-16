<?php
include "../includes/inc.php";
$data = [] ;

if($_GET['del']!==null) {
    if ($user_delete_order_supply !== "1" and $user_IsAdmin != 1) {
        $data['status'] = '<div style="margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;">
      ' . $permission_delete_lang . '</div>';
    } else {
        $sql = "DELETE FROM " . $prefix . "_order_supply_inv WHERE confirm_status = 0 and  inv_id='" . $_GET['del'] . "'";
        mysqli_query($con, $sql);

        if (mysqli_affected_rows($con) > 0) {
            if (mysqli_query($con, "DELETE FROM " . $prefix . "_order_supply WHERE inv_id='" . $_GET['del'] . "'")) {
                $data['status'] = '<div style="text-align:center; background-color:#95D183; border-radius:5px;float:right;width:100%; margin:0 auto;"">
<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
' . $bill_order_deleted_successfully_lang . '
</div>';
            }
        } else {
            $error_msg .= "  لا يمكن حذفها لترابطها بفاتوره اخرى";

            $data['status'] = '<div class="btn-warning" style="text-align:center; border-radius:5px;float:right;width:100%; margin:0 auto;"">
<span style="float:left; padding-left:20px;"> </span>
' . $error_msg . '
</div>';
        }
    }
}




echo json_encode($data);


?>

