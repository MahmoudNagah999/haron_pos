<?php
$from = str_replace("/", "-", $_GET['from']);
$to = str_replace("/", "-", $_GET['to']);
$from = stripslashes(date('Y-m-d', strtotime($from)));
$to = stripslashes(date('Y-m-d', strtotime($to)));
$invidd = $_GET['inv_idid'];
$addq = '';

if ($user_Revenue !== "1" && $user_IsAdmin != '1') {
    echo '<div class="alert alert-warning text-right" style="margin-top:150px;">
            ' . $not_have_permission_lang . '
        </div>';
} else { ?>
    <?php
    if (isset($_GET['from']) and isset($_GET['to'])) { ?>
        <table width="50%" border="1" style="border-collapse:collapse; text-align:center; margin:0 auto; margin-top:100px; direction:rtl;">
            <thead style="background-color:#CCC;">
                <tr>
                    <td>اسم المستخدم</td>
                    <td>رقم امر التوريد</td>
                    <td> تاريخ التعديل </td>
                    <td>الحاله القديمه</td>
                    <td>الحاله الجديده</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($invidd !== '') {
                    $addq = " and inv_id = {$invidd} ";
                }
                $presult_total_expenses = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_log where left(date,10) BETWEEN '" . $from . "' AND '" . $to . "' {$addq} order by id desc limit 200");
                if (@mysqli_num_rows($presult_total_expenses) > 0) {
                    while ($row = mysqli_fetch_array($presult_total_expenses)) {
                        $trr = "<tr>";
                        $trr .= "<td>{$row['user_name']}</td>";
                        $trr .= "<td>{$row['inv_id']}</td>";
                        $trr .= "<td>{$row['date']}</td>";

                        $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status where id = {$row['old_status']}");
                        $num_item = mysqli_fetch_object($ProductsName);
                        $trr .= "<td>{$num_item->name}</td>";

                        $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status where id = {$row['new_status']}");
                        $num_item = mysqli_fetch_object($ProductsName);
                        $trr .= "<td>{$num_item->name}</td>";

                        $trr .= "</tr>";
                        echo $trr;
                    }
                } ?>
            </tbody>

            <tr>
        </table>
    <?php } ?>
<?php } ?>