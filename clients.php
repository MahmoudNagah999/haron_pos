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
    <body class="cmenu1 example-target">

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
            ?>
        </div>

        <div id='main'>
            <article style="margin-bottom:70px;">
                <?php
                if ($user_Customers !== "1" and $user_IsAdmin != 1) {
                    echo'<div class="alert alert-warning text-right">
                            ' . $not_have_permission_lang . '
                            </div>';
                } else {
                    ?>

                    <fieldset class="clearfix">
                        <legend  align="right"><?php echo"$Clients_lang"; ?>:</legend> 
                        <?php
                        if ($_GET['del'] !== null) {
                            if ($demo == 1) {
                                echo '<div class="alert alert-warning text-right">
                  ' . $demo_alert . '
                            </div>';
                            } else {
                                if (mysqli_query($con, "DELETE FROM " . $prefix . "_clients WHERE id='" . $_GET['del'] . "'")) {
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
                                    mysqli_query($con, "DELETE FROM " . $prefix . "_clients WHERE id='" . $del_id . "'");
                                    if ($i == $countCheck - 1) {
                                        echo'<div class="alert alert-success text-right">
             ' . $Deletion_successfully_lang . '
                            </div>';
                                        header("refresh:1;url=clients.php");
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
                                $name = Trim(stripslashes($_POST['name']));
                                if ($name == "" or $name == null) {
                                    echo'<div class="alert alert-danger  text-right">
    ' . $must_add_customer_name . '
                            </div>';
                                } else {
                                    $phone = Trim(stripslashes($_POST['phone']));
                                    $_POST['date'] = str_replace("/", "-", $_POST['date']);
                                    $date = Trim(date('Y-m-d', strtotime($_POST['date'])));
                                    $address1 = Trim(stripslashes($_POST['address1']));
                                    $address2 = Trim(stripslashes($_POST['address2']));
                                    $email = Trim(stripslashes($_POST['email']));
                                    $notes = Trim(stripslashes($_POST['notes']));
                                    $balance = Trim(stripslashes($_POST['balance']));
                                    $state = Trim(stripslashes($_POST['state']));
                                    if (isset($_POST['modification'])) {

                                        $sql = "UPDATE " . $prefix . "_clients SET name='" . $name . "',phone='" . $phone . "',address1='" . $address1 . "',address2='" . $address2 . "',email='" . $email . "',notes='" . $notes . "',balance='" . $balance . "',date='" . $date . "',state='" . $state . "' where id=" . $_POST['id'] . "";
                                    } else {
                                        $sql = "INSERT INTO " . $prefix . "_clients (name, phone, date, address1, address2, email, notes, balance, state)
VALUES ('" . $name . "','" . $phone . "','" . $date . "','" . $address1 . "','" . $address2 . "','" . $email . "','" . $notes . "','" . $balance . "','" . $state . "')";
                                    }
                                    if (!mysqli_query($con, $sql)) {
                                        echo'<div class="alert alert-danger  text-right">
        ' . $not_saved_try_lang . '
                            </div>';
                                    } else {
                                        echo'<div class="alert alert-success text-right">
      ' . $Data_is_saved_lang . '
                            </div>';
                                        header("refresh:1;url=clients.php?limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "&page=" . $_GET['page'] . "");
                                    }
                                }
                            }
                        }
                        ?>
                        <?php
                        if ($_GET['Edit'] !== null) {
                            $isedit = 1;
                            $result_clients = mysqli_query($con, "SELECT * FROM " . $prefix . "_clients where id='" . $_GET['Edit'] . "'");
                            if (mysqli_num_rows($result_clients) > 0) {
                                while ($row_clients = mysqli_fetch_array($result_clients)) {
                                    $row_clients_id = $row_clients['id'];
                                    $row_clients_name = $row_clients['name'];
                                    $row_clients_phone = $row_clients['phone'];
                                    $row_clients_address1 = $row_clients['address1'];
                                    $row_clients_address2 = $row_clients['address2'];
                                    $row_clients_email = $row_clients['email'];
                                    $row_clients_notes = $row_clients['notes'];
                                    $row_clients_balance = $row_clients['balance'];
                                    $row_clients_date = $row_clients['date'];
                                    $row_clients_date = date('d/m/Y', strtotime($row_clients_date));
                                    $row_clients_state = $row_clients['state'];
                                }
                            }
                        } else {
                            
                        }
                        ?>
                        <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
                            <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
                                <tr>
                                    <td class="text-right"><lable><?php echo"$customer_name_lang"; ?></lable></td>
                                <td class="text-right">


                                    <input type="text" name="name" value="<?php echo"" . $row_clients_name . ""; ?>"  class="form-control"/>


                                </td>
                                <td class="text-right"><lable><?php echo"$Phone_number_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="phone" value="<?php echo"" . $row_clients_phone . ""; ?>"   class="form-control"/></td>
                                <td class="text-right"><lable><?php echo"$the_date_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="date" value="<?php if ($row_clients_date == "") {
                        echo date("d/m/Y");
                    } else {
                        echo"" . $row_clients_date . "";
                    } ?>" id="date"  class="form-control" />
                                    <script type="text/javascript">
                                        $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                    </script></td>
                                </tr>       
                                <tr>
                                    <td class="text-right"><lable><?php echo"$Address1_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="address1" value="<?php echo"" . $row_clients_address1 . ""; ?>"   class="form-control"/>
                                </td>
                                <td class="text-right"><lable><?php echo"$Address2_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="address2"  value="<?php echo"" . $row_clients_address2 . ""; ?>"  class="form-control" />

                                </td>
                                <td class="text-right"><lable><?php echo"$Email_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="email" value="<?php echo"" . $row_clients_email . ""; ?>"    class="form-control"/>

                                </td>

                                </tr>
                                <tr>
                                    <td  class="text-right"><lable><?php echo"$notes_lang"; ?></lable></td>
                                <td  class="text-right"><span>
                                        <textarea name="notes" class="form-control"><?php echo"" . $row_clients_notes . ""; ?></textarea>
                                    </span></td>
                                <td class="text-right"><lable><?php echo"$opening_balance_lang"; ?></lable></td>
                                <td class="text-right"><input type="text" name="balance" value="<?php echo"" . $row_clients_balance . ""; ?>"  class="form-control"/></td>
                                </tr>

                                <tr>
                                    <td  class="text-right">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><div>
                                            <?php
                                            if ($isedit == 1) {
                                                echo'<input type="submit" name="modification" id="modification" value="' . $Modify_lang . '" class="button"  />';
                                                echo'<input type="hidden"  name="id" value="' . $row_clients_id . '"/>';
                                            } else {
                                                echo'<input type="submit" name="add" id="add" value="' . $save_lang . '" class="button"  />';
                                            }
                                            ?>
                                            <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href = 'clients.php'"  />
                                        </div></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>
                                    <td class="text-right"></td>

                                </tr>
                            </table>
                    </fieldset>        
                    </form>
                    <div>
                        <form method="get">
                            <input type="text" name="search" style="height:20px; width:20%;"/>
                            <input type="submit" value="بحث" />
                        </form>
                    </div>
                    <form id="mainform" action="" method="post">
                        <table border="1" style="font-size:16px; width:100%; direction:rtl; margin-bottom:40px; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;" class="container" id="container">
                            <thead style="background-color:#CCC;">
                            <th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>

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

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "name") {
                                            echo"sort_t";
                                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "name") {
                                            echo"sort_d";
                                        } else {
                                            echo"sort0";
                                        } ?>"><a href="?orderby=name&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$the_name_lang"; ?></a></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "phone") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "phone") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=phone&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Phone_number_lang"; ?></a></th>

                            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "address1") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "address1") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=address1&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Address1_lang"; ?></a></th>

                            <th  class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "address2") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "address2") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=address2&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$Address2_lang"; ?></a></th>

                            <th class="text-center "><?php echo"$client_balance_lang"; ?></th>

                            <th  class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "notes") {
                            echo"sort_t";
                        } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "notes") {
                            echo"sort_d";
                        } else {
                            echo"sort0";
                        } ?>"><a href="?orderby=notes&type=<?php if ($_GET['type'] == "ASC") {
                            echo"DESC";
                        } else if ($_GET['type'] == "DESC") {
                            echo"ASC";
                        } else {
                            echo"DESC";
                        } ?>&page=<?php echo"" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo"$notes_lang"; ?></a></th>
                            <th class="text-center"><a href="#" onclick="javascript:void window.open('clients_print.php?search=<?php echo"" . $_GET['search'] . ""; ?>&limit=<?php echo"" . $_GET['limit'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>', '13909375026416900', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
              return false;"><img width="25" height="25" src="images/print_icon.gif" style="border:0px;"></a></th>
                            </thead>
                            <?php
                            $search = trim($_GET['search']);
                            if ($orderby == null) {
                                $orderby = "id";
                            }
                            if ($type == null) {
                                $type = "DESC";
                            }
###########################################
                            $tbl_name = "" . $prefix . "_clients";  //your table name
                            // How many adjacent pages should be shown on each side?
                            $adjacents = 3;

                            /*
                              First get total number of rows in data table.
                              If you have a WHERE clause in your query, make sure you mirror it here.
                             */
                            if ($_GET['search'] == "" or $_GET['search'] == null) {
                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_clients order by $orderby $type";
                            } else {
                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_clients where id='$search' or name like '%$search%' order by $orderby $type";
                            }
                            $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                            $total_pages = $total_pages[num];

                            /* Setup vars for query. */
                            $targetpage = "?search=" . $_GET['search'] . "&limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "";  //your file name  (the name of this file)
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

                                /* Get data. */
                            if ($orderby == "id") {
                                if ($_GET['search'] == "" or $_GET['search'] == null) {
                                    $sql = "SELECT * FROM " . $prefix . "_clients  order by $orderby+0 $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT * FROM " . $prefix . "_clients  where id='$search' or name like '%$search%' order by $orderby+0 $type LIMIT $start, $limit";
                                }
                            } else {
                                if ($_GET['search'] == "" or $_GET['search'] == null) {
                                    $sql = "SELECT * FROM " . $prefix . "_clients  order by `$orderby` $type LIMIT $start, $limit";
                                } else {
                                    $sql = "SELECT * FROM " . $prefix . "_clients where id='$search' or name like '%$search%' order by `$orderby` $type LIMIT $start, $limit";
                                }
                            }
                            $result = @mysqli_query($con, $sql);
                            /* Setup page vars for display. */
                            if ($page == 0)
                                $page = 1;     //if no page var is given, default to 1.
                            $prev = $page - 1;       //previous page is page - 1
                            $next = $page + 1;       //next page is page + 1
                            $lastpage = ceil($total_pages / $limit);  //lastpage is = total pages / items per page, rounded up.
                            $lpm1 = $lastpage - 1;      //last page minus 1

                            /*
                              Now we apply our rules and draw the pagination object.
                              We're actually saving the code to a variable in case we want to draw it more than once.
                             */
                            $pagination = "";
                            if ($lastpage > 1) {
                                $pagination .= "<div class=\"pagination\">";
                                //previous button
                                if ($page > 1)
                                    $pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
                                else
                                    $pagination.= "<span class=\"disabled\">>></span>";

                                //pages	
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
                                $issingle = $i / 2;
                                $dot = strstr($issingle, '.');
                                if ($dot == "") {
                                    $class = "background_color_FFF";
                                } else {
                                    $class = 'background_color_D5EFF0';
                                }
                                ?>


                                <tr class="<?php echo"" . $class . ""; ?>">
                                    <td class="text-center"><input type="checkbox" name="cb[]" value="<?php echo"" . $row['id'] . ""; ?>"></td>
                                    <td class="text-center"><a href="customer_payments.php?id=<?php echo"" . $row['id'] . ""; ?>"><?php echo"" . $row['id'] . ""; ?></a></td>
                                    <td class="text-center"><?php echo"" . $row['name'] . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $row['phone'] . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $row['address1'] . ""; ?></td>
                                    <td class="text-center"><?php echo"" . $row['address2'] . ""; ?></td>
                                    <td class="text-center"><?php
                                $result_get = mysqli_query($con, "SELECT SUM(Total) as SUMTotal  FROM " . $prefix . "_sales_inv where supplier=" . $row['id'] . "");
                                $row_get = mysqli_fetch_assoc($result_get);
                                        $totalreceivings = $row_get['SUMTotal'];

//                                        $result_get = mysqli_query($con, "SELECT SUM(discount) as SUMDiscount FROM " . $prefix . "_sales_inv where type = '1' and  supplier=" . $row['id'] . "");
//                                $row_get = mysqli_fetch_assoc($result_get);
//                                $totaldiscount = $row_get['SUMDiscount'];
                                $totaldiscount = 0;

                                /* $result_getpayments=mysqli_query($con,"SELECT SUM(Amount) as Amount FROM customer_payments where client=".$row['id']."");
                                  $row_getpayments=mysqli_fetch_assoc($result_getpayments);
                                  $totalgetpayments=$row_getpayments['Amount'];
                                 */
                                print round(($totalreceivings + $row['balance']- $totaldiscount), 2);
                                ?></td>
                                    <td class="text-center"><?php echo"" . $row['notes'] . ""; ?></td>
                                    <td class="text-center">

                                        <a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&del=<?php echo"" . $row['id'] . ""; ?>" ><img src="images/erase.png"/></a>
                                        <a href="?limit=<?php echo"" . $_GET['limit'] . ""; ?>&orderby=<?php echo"" . $_GET['orderby'] . ""; ?>&type=<?php echo"" . $_GET['type'] . ""; ?>&page=<?php echo"" . $_GET['page'] . ""; ?>&Edit=<?php echo"" . $row['id'] . ""; ?>"><img src="images/edit.png"/></a>
                                        <a href="#" onclick="javascript:void window.open('statement_of_account_client.php?id=<?php echo"" . $row['id'] . ""; ?>&from=<?php echo"" . date("Y-m-01") . ""; ?>&to=<?php echo"" . date("Y-m-d") . ""; ?>', '1390937502641', 'width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                return false;"><img src="images/arrears_list.gif" style="border:0px;" title="<?php echo"$client_statement_lang"; ?>" /></a>
                                    </td>
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

        </div>

        <div id="toolbar">
            <footer>
<?php include"includes/scroller_container.php"; ?>
            </footer>
        </div>
    </body>

</html><?php include 'includes/footer.php'; ?>