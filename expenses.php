<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
        <?php include"includes/css.php"; ?>
        <?php include"includes/js.php"; ?>
    </head>
    <body  class="cmenu1 example-target">

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
            include"includes/buttons.php";
            ?>			</div>

        <div id='main'>
            <article style="margin-bottom:70px;">
                <fieldset class="clearfix">
                    <legend  align="right"><?php echo"$Expenses_lang"; ?>:</legend> 
                    <?php
                    if ($user_Expenses !== "1" and $user_IsAdmin != 1) {
                        echo"<div class='alert alert-warning text-right'>'.$not_have_permission_lang.'</div>";
                    } else {
                        ?>
                        <?php
                        if ($_GET['del'] !== null) {
                            if ($demo == 1) {
                                echo '<div class="alert alert-warning text-right">
                  ' . $demo_alert . '
                            </div>';
                            } else {
                                if (mysqli_query($con, "DELETE FROM " . $prefix . "_expenses WHERE id='" . $_GET['del'] . "'")) {
                                    echo'<div class="alert alert-success text-right">
           ' . $Deletion_successfully_lang . '
                            </div>';
                                }
                            }
                        }
                        ?>
                        <?php
                        $checkbox = $_POST['cb']; //from name="checkbox[]"
                        $countCheck = count($_POST['cb']);
                        if ($countCheck > 0) {
                            if ($demo == 1) {
                                echo '<div class="alert alert-warning text-right">
                  ' . $demo_alert . '
                            </div>';
                            } else {
                                for ($i = 0; $i <= $countCheck; $i++) {
                                    $del_id = $checkbox[$i];
                                    mysqli_query($con, "DELETE FROM " . $prefix . "_expenses WHERE id='" . $del_id . "'");
                                    if ($i == $countCheck - 1) {
                                        echo'<div class="alert alert-success text-right">
              ' . $Deletion_successfully_lang . '
                            </div>';

                                        header("refresh:1;url=expenses.php");
                                    }
                                }
                            }
                        }
                        //
                        /* if(mysqli_query($con,"DELETE FROM country_t WHERE  country_id='".$del_id."'")){
                          #############
                          } */
                        ?>
                        <?php
                        if (isset($_POST['add']) or isset($_POST['modification'])) {
                            if ($demo == 1) {
                                echo '<div class="alert alert-warning text-right">
                  ' . $demo_alert . '
                            </div>';
                            } else {
                                $type = Trim(stripslashes($_POST['type']));
                                $Amount = Trim(stripslashes($_POST['Amount']));
                                $safe_id = Trim(stripslashes($_POST['safe_id']));
                                $_POST['date'] = str_replace("/", "-", $_POST['date']);
                                $date = Trim(date('Y-m-d', strtotime($_POST['date'])));
                                if ($safe_id=="" or $type == "" or $type == null or $Amount == null or $Amount == null or $date == null or $date == null) {
                                    echo'<div class="alert alert-danger  text-right">
   ' . $expense_amount_lang . '
                            </div>';
                                } else {
                                    $Employee = Trim(stripslashes($_POST['Employee']));
                                    $details = Trim(stripslashes($_POST['details']));

                                    if (isset($_POST['modification'])) {

                                        $sql = "UPDATE " . $prefix . "_expenses SET safe_id='" . $_POST['safe_id'] . "',type='" . $type . "',Amount='" . $Amount . "',date='" . $date . "',Employee='" . $Employee . "',details='" . $details . "' where id=" . $_POST['id'] . "";
                                        mysqli_query($con, "DELETE FROM " . $prefix . "_treasury WHERE expenses_id='" .$_POST['id'] . "'");


                                    } else {
                                        $sql = "INSERT INTO " . $prefix . "_expenses (safe_id,type, Amount, date, Employee, details)
VALUES ('" . $_POST['safe_id'] . "','". $type . "','" . $Amount . "','" . $date . "','" . $Employee . "','" . $details . "')";
                                    }

                                    if (!mysqli_query($con, $sql)) {

                                        echo'<div class="alert alert-danger  text-right">
           ' . $not_saved_try_lang . '
                            </div>';
                                    }
                                    else {
                                        $expenses_id = mysqli_insert_id($con);
                                        echo'<div class="alert alert-success text-right">
       ' . $Data_is_saved_lang . '
                            </div>';
######################


                                        $expensesName_list = mysqli_query($con, "SELECT expensestype FROM " . $prefix . "_expenses_set where id=" . $type . "");
                                        $num_expensesName_list = mysqli_num_rows($expensesName_list);
                                        if ($num_expensesName_list > 0) {
                                            while ($row_expensesName_list = mysqli_fetch_array($expensesName_list)) {
                                                $ex_typex = $row_expensesName = $row_expensesName_list['expensestype'];
                                            }
                                        }

                                        $sqlt = "INSERT INTO " . $prefix . "_treasury (user_id,type, Amount, date,safe_id, expenses_id, notes)
VALUES ('$user_id','5','" . ($Amount * -1) . "','" . $date . "',' ". $_POST['safe_id']. "',' ". $expenses_id . "',' " . $ex_typex . "')";

                                        if (!mysqli_query($con, $sqlt)) {
                                            // die($paid);
                                        }
######################
                                        header("refresh:1;url=expenses.php?limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "&page=" . $_GET['page'] . "");
                                    }
                                }
                            }
                        }
                        ?>
                        <?php
                        if ($_GET['Edit'] !== null) {
                            $isedit = 1;
                            $result_expenses = mysqli_query($con, "SELECT * FROM " . $prefix . "_expenses where id='" . $_GET['Edit'] . "'");
                            if (mysqli_num_rows($result_expenses) > 0) {
                                while ($row_expenses = mysqli_fetch_array($result_expenses)) {
                                    $row_expenses_id = $row_expenses['id'];
                                    $row_expenses_Amount = $row_expenses['Amount'];
                                    $row_expenses_Employee = $row_expenses['Employee'];
                                    $row_expenses_method = $row_expenses['method'];
                                    $row_expenses_type = $row_expenses['type'];
                                    $row_expenses_safe_id = $row_expenses['safe_id'];
                                    $row_expenses_number = $row_expenses['number'];

                                    $row_expenses_details = $row_expenses['details'];
                                    $row_expenses_user = $row_expenses['user'];
                                    $row_expenses_date = $row_expenses['date'];
                                    $row_expenses_date = date('d/m/Y', strtotime($row_expenses_date));
                                    $row_expenses_state = $row_expenses['state'];
                                }
                            }
                        } else {
                            
                        }
                        ?>
                        <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
                            <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
                                <tr>
                                    <td class="text-right"><label><?php echo"$Expense_lang"; ?></label></td>
                                    <td class="text-right">


                                        <select name="type" size="1" class="form-control">
                                            <option value=""></option>
    <?php
    $expensestype = mysqli_query($con, "SELECT * FROM " . $prefix . "_expenses_set order by id ASC");
    $num_expensestype = mysqli_num_rows($expensestype);
    if ($num_expensestype > 0) {
        while ($row_expensestype = mysqli_fetch_array($expensestype)) {
            if ($row_expensestype['id'] == $row_expenses_type) {
                echo'<option value="' . $row_expensestype['id'] . '"   selected="selected">' . $row_expensestype['expensestype'] . '</option>';
            } else {
                echo'<option value="' . $row_expensestype['id'] . '">' . $row_expensestype['expensestype'] . '</option>';
            }
        }
    }
    ?>
                                        </select>


                                    </td>
                                    <td class="text-right"><label><?php echo"$the_amount_lang"; ?></label></td>
                                    <td class="text-right"><input type="text" name="Amount" value="<?php echo"" . $row_expenses_Amount . ""; ?>"  class="form-control"/></td>
                                    <td class="text-right"><label><?php echo"$Safe_name"; ?></label></td>
                                    <td >

                                        <select name="safe_id" size="1" class="js-example-placeholder-single  js-states form-control">
                                            <option value=""> <?php echo"$Safe_name"; ?></option>
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id DEsc");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if (isset($row_expenses_safe_id) ){
                                                     if ($row_item['id'] == $row_expenses_safe_id) {
                                                        echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }elseif (isset($_POST['safe_id']) ){
                                                     if ($row_item['id'] == $_POST['safe_id']) {
                                                        echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }else{
                                                        echo'<option selected="selected" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </td>


                                    <td class="text-right"><label><?php echo"$the_date_lang"; ?></label></td>
                                    <td class="text-right"><input type="text" name="date" value="<?php if ($row_expenses_date == "") {
                                            echo date("d/m/Y");
                                        } else {
                                            echo"" . $row_expenses_date . "";
                                        } ?>" id="date"  class="form-control" />
                                        <script type="text/javascript">
                                            $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                        </script></td>
                                </tr>       
                                <tr>
                                    <td class="text-right"><label><?php echo"$the_Employee"; ?></label></td>
                                    <td class="text-right">
                                        <select name="Employee" size="1" class="form-control">
                                            <option value=""></option>
                                            <?php
                                            $expensesstaff = mysqli_query($con, "SELECT * FROM " . $prefix . "_staff order by id ASC");
                                            $num_expensesstaff = mysqli_num_rows($expensesstaff);
                                            if ($num_expensesstaff > 0) {
                                                while ($row_expensesstaff = mysqli_fetch_array($expensesstaff)) {
                                                    if ($row_expensesstaff['id'] == $row_expenses_Employee) {
                                                        echo'<option value="' . $row_expensesstaff['id'] . '"   selected="selected">' . $row_expensesstaff['name'] . '</option>';
                                                    } else {
                                                        echo'<option value="' . $row_expensesstaff['id'] . '">' . $row_expensesstaff['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>   
                                    </td>
                                    <td class="text-right"><label><?php echo"$Details_lang"; ?></label></td>
                                    <td class="text-right"><textarea name="details" class="form-control"><?php echo"" . $row_expenses_details . ""; ?></textarea></td>
                                </tr>

                                <tr>
                                    <td class="text-right"><div class="row">
                                            <?php
                                            if ($isedit == 1) {
                                                echo'<input type="submit" name="modification" id="modification" value="' . $Modify_lang . '" class="button"  />';
                                                echo'<input type="hidden"  name="id" value="' . $row_expenses_id . '"/>';
                                            } else {
                                                echo'<input type="submit" name="add" id="add" value="' . $save_lang . '" class="button"  />';
                                            }
                                            ?>
                                            <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href = 'staff.php'"  />
                                        </div></td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>

                                </tr>
                            </table>
                    </fieldset>        
                    </form>
                    <form id="mainform" action="" method="post">
                        <table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;" class="container" id="container">
                            <thead style="background-color:#CCC;">
                            <th class="text-center"> <input type="checkbox" name="all" value="1" id="all" /></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                                            echo"sort_t";
                                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                                            echo"sort_d";
                                        } else {
                                            echo"sort0";
                                        } ?>"><a href="?orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                                            echo"DESC";
                                        } else if ($_GET['type'] == "DESC") {
                                            echo"ASC";
                                        } else {
                                            echo"DESC";
                                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
<th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                                            echo"sort_t";
                                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                                            echo"sort_d";
                                        } else {
                                            echo"sort0";
                                        } ?>"><a href="?orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                                            echo"DESC";
                                        } else if ($_GET['type'] == "DESC") {
                                            echo"ASC";
                                        } else {
                                            echo"DESC";
                                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Safe_name"; ?></a></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "type") {
                                            echo"sort_t";
                                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "type") {
                                            echo"sort_d";
                                        } else {
                                            echo"sort0";
                                        } ?>"><a href="?orderby=type&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Expense_lang"; ?></a></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Amount") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Amount") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=Amount&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_amount_lang"; ?></a></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "date") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "date") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=date&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>

                            <th  class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Employee") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Employee") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=Employee&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_Employee"; ?></a></th>

                            <th  class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "details") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "details") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=details&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Details_lang"; ?></a></th>
                            <th class="text-center"></th>
                            </thead>
                            <?php
                            if ($orderby == null) {
                                $orderby = "id";
                            }
                            if ($type == null) {
                                $type = "DESC";
                            }
###########################################
                            $tbl_name = "" . $prefix . "_expenses";  //your table name
                            // How many adjacent pages should be shown on each side?
                            $adjacents = 3;

                            /*
                              First get total number of rows in data table.
                              If you have a WHERE clause in your query, make sure you mirror it here.
                             */
                            $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_expenses order by $orderby $type";
                            $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                            $total_pages = $total_pages[num];

                            /* Setup vars for query. */
                            $targetpage = "?limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "";  //your file name  (the name of this file)
                            //how many items to show per page
                            if (!empty($_GET['limit'])) {
                                $_SESSION[limit] = $_GET['limit'];
                            } else {
                                
                            }
                            if (!empty($_SESSION[limit])) {
                                $limit = $_SESSION[limit];
                                if ($limit > 100) {
                                    $limit = $items_per_page + 20;
                                }
                            } else {
                                $limit = $items_per_page + 20;
                            }
                            $page = $_GET['page'];
                            if ($page)
                                $start = ($page - 1) * $limit;    //first item to display on this page
                            else
                                $start = 0;        //if no page var is given, set start to 0
                            $sql = "SELECT * FROM " . $prefix . "_expenses  order by $orderby $type LIMIT $start, $limit";
                            $result = @mysqli_query($con, $sql);
                            if ($page == 0)
                                $page = 1;     //if no page var is given, default to 1.
                            $prev = $page - 1;       //previous page is page - 1
                            $next = $page + 1;       //next page is page + 1
                            $lastpage = ceil($total_pages / $limit);  //lastpage is = total pages / items per page, rounded up.
                            $lpm1 = $lastpage - 1;      //last page minus 1
                            $pagination = "";
                            if ($lastpage > 1) {
                                $pagination .= "<div class=\"pagination\">";
                                if ($page > 1)
                                    $pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
                                else
                                    $pagination.= "<span class=\"disabled\">>></span>";
                                if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
                                    for ($counter = 1; $counter <= $lastpage; $counter++) {
                                        if ($counter == $page)
                                            $pagination.= "<span class=\"current\">$counter</span>";
                                        else
                                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                    }
                                }
                                elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
                                    //close to beginning; only hide later pages
                                    if ($page < 1 + ($adjacents * 2)) {
                                        for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                            if ($counter == $page)
                                                $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                        }
                                        $pagination.= "...";
                                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                    }
                                    //in middle; hide some front and some back
                                    elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                                        $pagination.= "...";
                                        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                            if ($counter == $page)
                                                $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                        }
                                        $pagination.= "...";
                                        $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                                        $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                                    }
                                    //close to end; only hide early pages
                                    else {
                                        $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                                        $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                                        $pagination.= "...";
                                        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                            if ($counter == $page)
                                                $pagination.= "<span class=\"current\">$counter</span>";
                                            else
                                                $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                                        }
                                    }
                                }

                                //next button
                                if ($page < $counter - 1)
                                    $pagination.= "<a href=\"$targetpage&page=$next\"><<</a>";
                                else
                                    $pagination.= "<span class=\"disabled\"><<</span>";
                                $pagination.= "</div>\n";
                            }
###############
                            $i = 0;
                            while ($row = @mysqli_fetch_array($result)) {
                                #################
                                $issingle = $i / 2;
                                $dot = strstr($issingle, '.');
                                if ($dot == "") {
                                    $class = "background_color_FFF";
                                } else {
                                    $class = 'background_color_D5EFF0';
                                }
                                $expensesName_list2 = mysqli_query($con, "SELECT expensestype FROM " . $prefix . "_expenses_set where id=" . $row['type'] . "");
                                $num_expensesName_list2 = mysqli_num_rows($expensesName_list2);
                                if ($num_expensesName_list2 > 0) {
                                    while ($row_expensesName_list2 = mysqli_fetch_array($expensesName_list2)) {
                                        $ex_type = $row_expensesName_list2['expensestype'];
                                    }
                                }

                                if ($row['Employee'] !== "") {
                                    $result_staff_name = mysqli_query($con, "SELECT id,name FROM " . $prefix . "_staff where id='" . $row['Employee'] . "'");
                                    if (mysqli_num_rows($result_staff_name) > 0) {
                                        while ($row_staf = mysqli_fetch_array($result_staff_name)) {
                                            $row_staff_id = $row_staf['id'];
                                            $row_staff_name = $row_staf['name'];
                                        }
                                    }
                                } else {
                                    $row_staff_name = '';
                                }
                                ?>


                                <tr class="text-center <?php echo"" . $class . ""; ?>">
                                    <td class="text-center"><input type="checkbox" name="cb[]" value="<?php echo"" . $row['id'] . ""; ?>"></td>
                                    <td class="text-center"><?php echo"" . $row['id'] . ""; ?></td>
                                    <td class="text-center"><?php echo"" . get_safe_data($row['safe_id'])[name] . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $ex_type . ""; ?></td>
                                    <td class="text-center"><?php echo"" . round($row['Amount'], 3) . ""; ?></td>
                                    <td class="text-center"><?php echo"" . substr($row['date'], 0, 10) . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $row_staff_name . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $row['details'] . ""; ?></td>
                                    <td class="text-center">

                                        <a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&del=<?php echo"" . $row['id'] . ""; ?>" ><img src="images/erase.png"/></a>
                                        <a href="?limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&Edit=<?php echo"" . $row['id'] . ""; ?>"><img src="images/edit.png"/></a></td>
                                </tr>

        <?php $i++;
    } ?>   
                            <thead style="background-color:#CCC;">
                            <th colspan="8"><?php echo"$pagination"; ?></th>
                            <th class="text-center"><a href="#">
                                    <a href="#" onClick="confirmSubmit();"><img src="images/erase.png"/></a></th>
                            </thead>
                        </table> 
                    </form>   
<?php } ?>
            </article>

            <!--    <nav>nav</nav>-->
            <!-- <aside>aside</aside>-->
        </div>

        <div id="toolbar">
            <footer>
<?php include"includes/scroller_container.php"; ?>
            </footer>
        </div>
    </body>

</html>
<?php include 'includes/footer.php'; ?>
<script>
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
</script>