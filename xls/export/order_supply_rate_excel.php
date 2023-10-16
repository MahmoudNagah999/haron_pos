<?php
include dirname(__FILE__) . "/../../includes/inc.php";
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$dateSqlCon = "";
if ($date_from != '' and $date_to != '') {
    $date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
    $date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
    $dateSqlCon .= "and left(date,10) BETWEEN '" . $date_from . "' AND '" . $date_to . "'";
} elseif ($from == '' and $date_to != '') {
    $date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
    $dateSqlCon .= "and left(date,10)  <=  '" . $date_to . "'";
} elseif ($date_from != '' and $date_to == '') {
    $date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
    $dateSqlCon .= "and left(date,10)  >=  '" . $date_from . "'";
} else {
    if (!isset($_GET['date_from']) and !isset($_GET['date_from'])) {
        $dateSqlCon .= "and left(date,10) BETWEEN '" . date("d/m/Y") . "' AND '" . date("d/m/Y") . "'";
    }
}
$status = $_GET['status'];
$branch = $_GET['branch'];
$region = $_GET['region'];

if ($region == '1000000000') {
    $skip_region = 1;
} else {
    $skip_region = 0;
}
if ($status == '1000000000') {
    $skip_status = 1;
} else {
    $skip_status = 0;
}

if ($branch == '1000000000') {
    $skip_branch = 1;
} else {
    $skip_branch = 0;
}
##############################
function get_all_orders_count()
{
    global $con;
    global $prefix;
    global $status;
    global $date_from;
    global $date_to;
    global $skip_status;
    global $skip_region;

//    if (empty($status) || $skip_status == 1) {
//    } else {
//        if ($status == '') {
//        } else {
//            $q_status = " and status in ($status)";
//        }
//    }

    global $region;
    if (empty($region)) {
    } else {
        if ($region == '' || $skip_region == 1) {
        } else {
            $q_region = " and  region_id in ($region)";
        }
    }

    global $branch;
    global $skip_branch;
    if (empty($branch) || $skip_branch == 1) {
    } else {
        if ($branch == '') {
        } else {
            $q_branch = " and  branch_id in ($branch)";
        }
    }
    if ($date_to == "1970-01-01" or $date_to == "0000-01-01" or $date_to == null or $date_to == "") {
    } else {
        $sql_date = " and left(date,10) BETWEEN '$date_from' AND '$date_to'";
    }
    $result_order_supply_status = @mysqli_query($con, "SELECT region_id,status,COUNT(*) as counts FROM " . $prefix . "_order_supply_inv where id !='0' $q_status $q_region $q_branch $sql_date GROUP BY region_id,status");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data[$row_order_supply_status['region_id']][$row_order_supply_status['status']] = $row_order_supply_status['counts'];
        }
    }
    return $data;
}

##################
function get_all_orders_count_not_know()
{
    global $con;
    global $prefix;
    global $date_from;
    global $date_to;
    global $status;
    global $skip_status;
    if (empty($status) || $skip_status == 1) {
    } else {
        if ($status == '') {
        } else {
            $q_status = " and status in ($status)";
        }
    }
    global $branch;
    global $skip_branch;
    if (empty($branch) || $skip_branch == 1) {
    } else {
        if ($branch == '') {
        } else {
            $q_branch = " and  branch_id in ($branch)";
        }
    }
    if ($date_to == "1970-01-01" or $date_to == "0000-01-01" or $date_to == null or $date_to == "") {
    } else {
        $sql_date = " and left(date,10) BETWEEN '$date_from' AND '$date_to'";
    }
    $result_order_supply_status = @mysqli_query($con, "SELECT status,COUNT(*) as counts,date FROM " . $prefix . "_order_supply_inv where region_id=0 $q_status $q_branch  $sql_date GROUP BY status");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data[$row_order_supply_status['status']] = $row_order_supply_status['counts'];
        }
    }
    return $data;
}

/////////////////////
$orders_total_value_status = get_all_orders_count();
$sumArray = array();

foreach ($orders_total_value_status as $k => $subArray) {
    foreach ($subArray as $id => $value) {
        $sumArray[$id] += $value;
    }
}


$get_all_orders_count_not_know = get_all_orders_count_not_know();
//var_dump($get_all_orders_count_not_know);

//var_dump($orders_total_value_status[""]);
function get_all_oprders_status()
{
    global $con;
    global $prefix;
    global $status;
    global $skip_status;
    if (empty($status) || $skip_status == 1) {
    } else {
        if ($status == '') {
        } else {
            $q = "where id in ($status)";
        }
    }
    $result_order_supply_status = @mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status $q");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data['id'][] = $row_order_supply_status['id'];
            $data['name'][] = $row_order_supply_status['name'];
        }
    }
    return $data;
}

$get_all_oprders_status = get_all_oprders_status();

$Total_final = array_sum($sumArray);
#########################
$file_ending = "xls";
//header info for browser

/*******Start of Formatting for Excel*******/
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
////start of printing column names as names of MySQL fields
//for ($i = 0; $i < mysql_num_fields($result); $i++) {
//    echo mysql_field_name($result,$i) . "\t";
//
//}
//print("\n");
//header("content-type:application/xls;charset=UTF-8");
//header("Content-Disposition: attachment; filename=$filename.'.'.$file_ending");
//header("Pragma: no-cache");
//header("Expires: 0");

//end of printing column names
//start while loop to get data
//while($row = mysql_fetch_row($result))
//{

$schema_insert = "";
$schema_insert .= '<table border="1">';
//make the column headers what you want in whatever order you want
$schema_insert .= '<td><u>المنطقة</u></td>';

foreach ($get_all_oprders_status['name'] as $value) {

    $schema_insert .= "<td> <u>" . $value . "</u></td>";

}
$schema_insert .= "<td><u>المجموع</u></td>";
$schema_insert .= "<td><u>اجمالي الحالات</u></td>";
$schema_insert .= "<td><u>النسبة</u></td>";
$schema_insert .= '</tr>';
if (empty($region) || $skip_region == 1) {
} else {
    if ($region == '') {
    } else {
        $q_region = "where id in ($region)";
    }
}
$result = @mysqli_query($con, "SELECT * FROM cairo_region $q_region");
$num = @mysqli_num_rows($result);
$SumOfValueArr = [];
if ($num > 0) {
    while ($row = mysqli_fetch_array($result)) {
        #################
        $schema_insert .= '<tr>';
        $schema_insert .= '<td>' . $row['name'] . '</td>';

        $SumOfValue=0;
        foreach ($get_all_oprders_status['id'] as $value) {
            $sum_status[$value] += $orders_total_value_status[$row['id']][$value];
            $SumOfValue += $orders_total_value_status[$row['id']][$value];
            $schema_insert .= '<td>' . $orders_total_value_status[$row['id']][$value] . '</td>';
        }
        $SumOfValueArr[] = $SumOfValue;
        $schema_insert .= '<td>' . $SumOfValue . '</td>';

        $xyz = array_sum($orders_total_value_status[$row['id']]);
        $percent = round((($SumOfValue / $xyz) * 100), 2);
        $schema_insert .= '<td>' . $xyz . '</td>';
        $total_rate += (($xyz / $Total_final) * 100);
        $schema_insert .= '<td>' . $percent . ' % </td>';


        $schema_insert .= '</tr>';


    }
}
if ($skip_region == 1 || empty($region)) {
    $schema_insert .= '<tr>';
    $schema_insert .= '<td>غير معروفة</td>';

    foreach ($get_all_oprders_status['id'] as $value) {
        $sum_status_not_know += $get_all_orders_count_not_know[$value];
        $schema_insert .= '<td>' . $get_all_orders_count_not_know[$value] . '</td>';
    }
    $schema_insert .= '<td></td>';
    $schema_insert .= '<td>' . $sum_status_not_know . '</td>';
    $schema_insert .= '<td>' . round((($sum_status_not_know / $Total_final) * 100), 2) . '</td>';
    $total_rate += (($sum_status_not_know / $Total_final) * 100);

    $schema_insert .= '</tr>';
}
$schema_insert .= '<tr>';
$schema_insert .= '<td>اجمالي</td>';


foreach ($get_all_oprders_status['id'] as $value) {
    $schema_insert .= '<td>' . ($sum_status[$value] + $get_all_orders_count_not_know[$value]) . '</td>';
}

$schema_insert .= '<td>' . $Total_final . '</td>';
$schema_insert .= '<td>' . array_sum($SumOfValueArr) . '</td>';
$schema_insert .= '<td>' . round($total_rate, 0) . '</td>';


$schema_insert .= '</tr>';
$schema_insert .= '</table>';
$filename = "orders_report_collection_" . date();
header("content-type:application/xls;charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
print chr(255) . chr(254) . mb_convert_encoding($schema_insert, 'UTF-16LE', 'UTF-8');
//print(trim($schema_insert));
print "\n";
?>