<?php
include "includes/inc.php";
$status = $_GET['status'];
$branch = $_GET['branch'];
$region = $_GET['region'];
$user_id = $_GET['user_id'];
$Alpha = $_GET['Alpha'];
$product_id = $_GET['products'];
$date_from = str_replace("/", "-", $_GET['date_from']);
$date_to = str_replace("/", "-", $_GET['date_to']);
$date_from = stripslashes(date('Y-m-d', strtotime($date_from)));
$date_to = stripslashes(date('Y-m-d', strtotime($date_to)));
if (count($region) == 1 && $region[0] == '1000000000') {
    $skip_region = 1;
} else {
    $skip_region = 0;
}

//echo $status[0];
if (count($status) == 1 && $status[0] == '1000000000') {
    $skip_status = 1;
} else {
    $skip_status = 0;
}
if (count($branch) == 1 && $branch[0] == '1000000000') {
    $skip_branch = 1;
} else {
    $skip_branch = 0;
}
function get_all_orders_count()
{
    global $con;
    global $prefix;
    global $status;
    global $date_from;
    global $date_to;
    global $skip_region;
    global $skip_status;
    global $region;

    if (empty($region)) {
    } else {
        $arr_region = implode(", ", $region);
        if ($arr_region == '' || $skip_region == 1) {
        } else {
            $q_region = " and  region_id in ($arr_region)";
        }
    }

    global $branch;
    global $skip_branch;
    if (empty($branch) || $skip_branch == 1) {
    } else {
        $arr_branch = implode(", ", $branch);
        if ($arr_branch == '') {
        } else {
            $q_branch = " and  branch_id in ($arr_branch)";
        }
    }
    if ($date_to == "1970-01-01" or $date_to == "0000-01-01" or $date_to == null or $date_to == "") {
    } else {
        $sql_date = " and left(date,10) BETWEEN '$date_from' AND '$date_to'";
    }
    global $user_id;
    if (empty($user_id)) {
    } else {
        $arr_userid = implode(", ", $user_id);
        $q_user_id = " and user_id in ($arr_userid)";
    }
    global $Alpha;
    if (empty($Alpha)) {
    } else {
        foreach ($Alpha as $char) {
            $AlphaX[] = "'" . $char . "'";
        }
        $arr_alpha = implode(", ", $AlphaX);
        $q_alpha = " and alpha in ($arr_alpha)";
    }
    global $product_id;
    if (empty($product_id)) {
    } else {
        // $q_products="SELECT inv_id from  cairo_order_supply where item in (select id from items where groupid= $product_id)";
        $arr_product_id = implode(", ", $product_id);
        $add_sql_products_in_offer = " item in (SELECT id FROM cairo_offers_inv WHERE inv_id IN (SELECT inv_id FROM cairo_offers WHERE item IN(SELECT id FROM items WHERE groupid IN ($arr_product_id))))";
        $q_products_sql = " and inv_id in (SELECT inv_id from  cairo_order_supply where (item_status LIKE 'offers' AND " . $add_sql_products_in_offer . ") OR (item in (select id from items where groupid in ($arr_product_id))))";
    }
    // echo "SELECT branch_id,status,COUNT(*) as counts FROM " . $prefix . "_order_supply_inv where id !='0' $q_status $q_region $q_branch $q_user_id $q_products_sql $sql_date GROUP BY branch_id,status";
    $result_order_supply_status = @mysqli_query($con, "SELECT branch_id,status,COUNT(*) as counts FROM " . $prefix . "_order_supply_inv where id !='0' $q_status $q_region $q_branch $q_user_id $q_alpha $q_products_sql $sql_date GROUP BY branch_id,status");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data[$row_order_supply_status['branch_id']][$row_order_supply_status['status']] = $row_order_supply_status['counts'];
        }
    }
    return $data;
    echo $skip_status;
}

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
        $arr_status = implode(", ", $status);
        if ($arr_status == '') {
        } else {
            $q_status = " and status in ($arr_status)";
        }
    }
    global $branch;
    global $skip_branch;

    if (empty($branch) || $skip_branch == 1) {
    } else {
        $arr_branch = implode(", ", $branch);
        if ($arr_branch == '') {
        } else {
            $q_branch = " AND branch_id IN ($arr_branch)";
        }
    }

    if ($date_to == "1970-01-01" || $date_to == "0000-01-01" || $date_to == null or $date_to == "") {
    } else {
        $sql_date = " and left(date,10) BETWEEN '$date_from' AND '$date_to'";
    }
    ################  
    global $product_id;
    $arr_product_id = implode(", ", $product_id);
    $q_products_sql = " and inv_id in (SELECT inv_id from  cairo_order_supply where item in (select id from items where groupid in ($arr_product_id)))";

    if (empty($product_id)) {
    } else {
        // $q_products="SELECT inv_id from  cairo_order_supply where item in (select id from items where groupid= $product_id)";
        $q_products_sql = " and inv_id in (SELECT inv_id from  cairo_order_supply where item in (select id from items where groupid in ($arr_product_id)))";
    }
    #############
    global $user_id;
    if (empty($user_id)) {
    } else {
        $arr_userid = implode(", ", $user_id);
        $q_user_id = " and user_id in ($arr_userid)";
    }
    ############################
    global $Alpha;
    if (empty($Alpha)) {
    } else {
        foreach ($Alpha as $char) {
            $AlphaX[] = "'" . $char . "'";
        }
        $arr_alpha = implode(", ", $AlphaX);
        $q_alpha = " and alpha in ($arr_alpha)";
    }
    // echo "SELECT status,COUNT(*) as counts,date FROM " . $prefix . "_order_supply_inv where region_id=0 $q_status $q_branch  $q_user_id $q_products_sql $sql_date GROUP BY status";
    $result_order_supply_status = @mysqli_query($con, "SELECT status,COUNT(*) as counts,date FROM " . $prefix . "_order_supply_inv where region_id=0 $q_status $q_branch $q_user_id $q_alpha $q_products_sql $sql_date GROUP BY status");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data[$row_order_supply_status['status']] = $row_order_supply_status['counts'];
        }
    }

    return $data;
}

$orders_total_value_status = get_all_orders_count();
$sumArray = array();


foreach ($orders_total_value_status as $k => $subArray) {
    foreach ($subArray as $id => $value) {
        $sumArray[$id] += $value;
    }
}

$get_all_orders_count_not_know = get_all_orders_count_not_know();

function get_all_oprders_status()
{
    global $con;
    global $prefix;
    global $status;
    global $skip_status;

    if (empty($status) || $skip_status == 1) {
    } else {
        $arr = implode(", ", $status);
        if ($arr == '') {
        } else {
            $q = "where id in ($arr)";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo "" . $get_db_CompanyName . ""; ?></title>
    <?php include "includes/css.php"; ?>
    <?php include "includes/js.php"; ?>
</head>

<body>

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
        include "includes/buttons.php";
        ?>

    </div>


    <!--   <p class="text-right pull-righ"><?php echo "$date_today_lang"; ?><span> <?php echo "" . $dateonly . ""; ?></span></p> -->

    <!--  <img src="images/logo.jpg" class="img-responsive" /> -->
    <br />


    <div class="container-fluid">
        <form class="form-inline no-print" name="form">

            <div class="form-group mb-1 no-print">
                <a target="_BLANK" href="xls/export/order_supply_rate_excel.php?date_from=<?php echo $_GET['date_from']; ?>&date_to=<?php echo $_GET['date_to']; ?>&status=<?php echo implode(", ", $status); ?>&branch=<?php echo implode(", ", $branch); ?>&region=<?php echo implode(", ", $region); ?>" class="btn btn-danger"> تصدير اكسل <i class="fa fa-file-excel-o" aria-hidden="true"></i> </a>
            </div>

            <div class="form-group mb-2"><button type="submit" class="btn btn-success" name="submit">بحث <i class="fa fa-search" aria-hidden="true"></i> </button>
            </div>
            <div class="form-group mb-1">
                <select name="products[]" class="form-control js-example-basic-multiple-limit" multiple>
                    <option value="">المجموعة</option>
                    <?php
                    $result_search_products = mysqli_query($con, "SELECT id,product_name FROM products order by product_name ASC");
                    if (@mysqli_num_rows($result_search_products) > 0) {
                        while ($row_search_products = mysqli_fetch_array($result_search_products)) {
                            if (in_array($row_search_products['id'], $_GET['products'])) {
                                echo ' <option value="' . $row_search_products['id'] . '"  selected>' . $row_search_products['product_name'] . '</option>';
                            } else {
                                echo ' <option value="' . $row_search_products['id'] . '">' . $row_search_products['product_name'] . '</option>';
                            }
                        }
                    }
                    ?>

                </select>

            </div>
            <div class="form-group mb-2">
                <input type="text" name="date_to" id="date_to" value="<?php if (isset($_GET['date_to'])) {
                                                                            echo "" . $_GET['date_to'] . "";
                                                                        } else {
                                                                            echo date("d/m/Y");
                                                                        } ?>" class="form-control" placeholder="التاريخ الى" aria-label="التاريخ الى">

            </div>
            <script type="text/javascript">
                $('#date_to').dateEntry({
                    dateFormat: 'dmy/',
                    spinnerImage: ''
                });
            </script>
            <div class="form-group mb-2">
                <input type="text" name="date_from" id="date_from" value="<?php if (isset($_GET['date_from'])) {
                                                                                echo "" . $_GET['date_from'] . "";
                                                                            } else {
                                                                                echo date("01/m/2019");
                                                                            } ?>" class="form-control" placeholder="التاريخ من" aria-label="التاريخ من">
                <script type="text/javascript">
                    $('#date_from').dateEntry({
                        dateFormat: 'dmy/',
                        spinnerImage: ''
                    });
                </script>
            </div>
            <div class="form-group mb-2">
                <select name="status[]" class="form-control js-example-basic-multiple-limit" multiple>
                    <option value="1000000000" <?php if ($_GET['status'] == null || in_array("1000000000", $_GET['status'])) {
                                                    echo "selected";
                                                } ?>>اختر الحالة
                    </option>
                    <?php
                    $result_search = mysqli_query($con, "SELECT id,name FROM cairo_order_supply_status order by id ASC");
                    if (@mysqli_num_rows($result_search) > 0) {
                        while ($row_search = mysqli_fetch_array($result_search)) {
                            if (in_array($row_search['id'], $_GET['status'])) {
                                echo ' <option value="' . $row_search['id'] . '" selected>' . $row_search['name'] . '</option>';
                            } else {
                                echo ' <option value="' . $row_search['id'] . '">' . $row_search['name'] . '</option>';
                            }
                        }
                    }
                    ?>

                </select>

            </div>

            <?php $alphapatic = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z']; ?>
            <div class="form-group mb-2">
                <select id="Alpha" multiple="multiple" name="Alpha[]" size="1" class="w100 placeholder-single_order_status js-states form-control">
                    <?php
                    foreach ($alphapatic as $value) {
                        if (in_array($value, $_GET['Alpha'])) {
                            echo '<option data-attrchangeid ="' . $value . '" value="' . $value . '"   selected="selected">' . $value . '</option>';
                        } else {
                            echo '<option data-attrchangeid ="' . $value . '" value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="form-group mb-2">
                <select name="branch[]" class="form-control js-example-basic-multiple-limit" multiple>
                    <option value="1000000000" selected>الفرع</option>
                    <?php
                    $result_search_branch = mysqli_query($con, "SELECT id,name FROM cairo_branch order by name ASC");
                    if (@mysqli_num_rows($result_search_branch) > 0) {
                        while ($row_search_branch = mysqli_fetch_array($result_search_branch)) {
                            if (in_array($row_search_branch['id'], $_GET['branch'])) {
                                echo ' <option value="' . $row_search_branch['id'] . '"  selected>' . $row_search_branch['name'] . '</option>';
                            } else {
                                echo ' <option value="' . $row_search_branch['id'] . '">' . $row_search_branch['name'] . '</option>';
                            }
                        }
                    }
                    ?>

                </select>

            </div>
            <div class="form-group mb-2">
                <select name="region[]" class="form-control js-example-basic-multiple-limit" multiple>
                    <option value="1000000000" <?php if ($_GET['region'] == null || in_array("1000000000", $_GET['region'])) {
                                                    echo "selected";
                                                } ?>>المنطقة
                    </option>
                    <?php
                    $result_search_region = mysqli_query($con, "SELECT id,name FROM cairo_region order by name ASC");
                    if (@mysqli_num_rows($result_search_region) > 0) {
                        while ($row_search_region = mysqli_fetch_array($result_search_region)) {
                            if (in_array($row_search_region['id'], $_GET['region'])) {
                                echo ' <option value="' . $row_search_region['id'] . '"  selected>' . $row_search_region['name'] . '</option>';
                            } else {
                                echo ' <option value="' . $row_search_region['id'] . '">' . $row_search_region['name'] . '</option>';
                            }
                        }
                    }
                    ?>

                </select>

            </div>

            <div class="form-group mb-1">
                <select name="user_id[]" class="form-control js-example-basic-multiple-limit" multiple>
                    <option value=""></option>
                    <?php
                    $result_search_user_id = mysqli_query($con, "SELECT id,name FROM cairo_users order by name ASC");
                    if (@mysqli_num_rows($result_search_user_id) > 0) {
                        while ($row_search_user_id = mysqli_fetch_array($result_search_user_id)) {
                            if (in_array($row_search_user_id['id'], $_GET['user_id'])) {
                                echo ' <option value="' . $row_search_user_id['id'] . '"  selected>' . $row_search_user_id['name'] . '</option>';
                            } else {
                                echo ' <option value="' . $row_search_user_id['id'] . '">' . $row_search_user_id['name'] . '</option>';
                            }
                        }
                    }
                    ?>

                </select>

            </div>


        </form>
    </div>
    <script>
        $(".js-example-basic-multiple-limit").select2({
            maximumSelectionLength: 1000
        });
        $(document).ready(function() {
            $('.date').mask('00-00-0000');
        });
        $(".placeholder-single_order_status").select2({
            placeholder: "Alpha",
            allowClear: true,
            multiple: true
        });
    </script>
    <div class="container-fluid">
        <table class="table table-bordered" dir="rtl">

            <thead style="background: white;position: sticky;top: 0; /* Don't forget this, required for the stickiness */box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);background: #ff4747;color: white;">
                <tr>
                    <th class="text-center" scope="col">اجمالي الحالات</th>
                    <?php
                    foreach ($get_all_oprders_status['name'] as $value) {

                        echo "<th  class='text-center'  scope='col'> " . $value . "</th>";
                    }
                    ?>
                    <th class="text-center" style="width:260px" scope="col">الفروع</th>
                    <th class="text-center">المجموع</th>
                    <th class="text-center">النسبة</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($branch)) {
                } else {
                    $arr_branch = implode(", ", $branch);
                    // var_dump($arr_branch);
                    if ($arr_branch == '' or $skip_branch == 1) {
                    } else {
                        $q_branch = "where id in ($arr_branch)";
                    }
                }
                $result = @mysqli_query($con, "SELECT * FROM cairo_branch $q_branch");
                $num = @mysqli_num_rows($result);
                $SumOfValuesArr = [];
                if ($num > 0) {
                    $iii = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $issingle = $iii / 2;
                        $dot = strstr($issingle, '.');
                        if ($dot == "") {
                            $bgcolor = "style='background: #e1dada';";
                        } else {
                            $bgcolor = "style='background: #ffffff';";
                        }

                        $trrr =  '<tr ' . $bgcolor . '>';

                        $xyz = array_sum($orders_total_value_status[$row['id']]);
                        $xyzVal = ($xyz != '') ? $xyz : '-';
                        $trrr .= '<td style="text-align:center;font-size:17px;border:1px solid #000;color:black">' . $xyzVal . '</td>';

                        $SumOfValues = 0;
                        foreach ($get_all_oprders_status['id'] as $value) {
                            $sum_status[$value] += $orders_total_value_status[$row['id']][$value];
                            $value1 = ($orders_total_value_status[$row['id']][$value] != '') ? $orders_total_value_status[$row['id']][$value] : '-';
                            $SumOfValues += $value1;
                            $trrr .= '<td style="text-align:center;font-size:17px;border:1px solid #000;color:black">' . $value1 . '</td>';
                        }
                        $trrr .= '<td style="text-align:center;font-size:17px;border:1px solid #000;color:black">' . $row['name'] . '</td>';
                        $trrr .= '<td style="text-align:center;font-size:17px;border:1px solid #000;color:black">' . $SumOfValues . '</td>';
                        $SumOfValuesArr[] = $SumOfValues;
                        $total_rate += (($xyz / $Total_final) * 100);
                        //                var_dump($value1);
                        //                var_dump($Total_final);
                        $percent = ($xyz > 0) ? round((($SumOfValues / $xyz) * 100), 2) : 0;
                        $trrr .= '<td style="text-align:center;font-size:17px;border:1px solid #000;color:black">' . $percent . ' % </td>';
                        $trrr .= '</tr>';
                        if ($SumOfValues > 0){
                            echo $trrr;
                        }
                        $iii++;
                    }
                }
                if ($skip_region == 1 || empty($region)) {
                    $issingle = $i / 2;
                    $dot = strstr($issingle, '.');
                    if ($dot == "") {
                        $class = "background_color_FFF";
                    } else {
                        $class = 'background_color_D5EFF0';
                    }
                    echo '<tr class="' . $class . '">';
                    echo '<td style="text-align:center;font-size:20px;border:2px solid #000">غير معروفة</td>';

                    foreach ($get_all_oprders_status['id'] as $value) {
                        $sum_status_not_know += $get_all_orders_count_not_know[$value];
                        echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . $get_all_orders_count_not_know[$value] . '</td>';
                    }
                    echo '<td style="text-align:center;font-size:20px;border:2px solid #000"></td>';
                    echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . $sum_status_not_know . '</td>';
                    echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . round((($sum_status_not_know / $Total_final) * 100), 2) . '</td>';
                    $total_rate += (($sum_status_not_know / $Total_final) * 100);

                    echo '</tr>';
                }
                echo '<tr >';

                echo '<td  style="text-align:center;font-size:20px;border:2px solid #000">' . $Total_final . '</td>';

                $SumOfTotals = 0;
                foreach ($get_all_oprders_status['id'] as $value) {
                    $SumOfTotals += ($sum_status[$value] + $get_all_orders_count_not_know[$value]);
                    echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . ($sum_status[$value] + $get_all_orders_count_not_know[$value]) . '</td>';
                }
                echo '<td style="text-align:center;font-size:20px;border:2px solid #000">الاجماليات</td>';
                $SumOfPercent = round(($SumOfTotals / $Total_final) * 100, '2');

                echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . array_sum($SumOfValuesArr) . ' </td>';
                echo '<td style="text-align:center;font-size:20px;border:2px solid #000">' . $SumOfPercent . ' % </td>';


                echo '</tr>';


                ?>


            </tbody>
        </table>

    </div>


    </div>


</body>

</html>
<?php include 'includes/footer.php'; ?>