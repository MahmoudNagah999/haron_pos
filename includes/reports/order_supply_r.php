<?php
$targetpage = "?UerID=" . $_GET['UerID'] . "&mobile2=" . $_GET['mobile2'] . "&mobile1=" . $_GET['mobile1'] . "&reports=" . $_GET['reports'] . "&doc=" . $_GET['doc'] . "&inv=" . $_GET['inv'] . "&from=" . $_GET['from'] . "&to=" . $_GET['to'] . "&limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "";     //your file name  (the name of this file)

function mergeSimilarItems($array) {
    $mergedItems = [];

    foreach ($array as $item) {
        $itemValue = $item['item'];
        $quantity = $item['Quantity'];

        // Check if item value exists in merged array
        $index = array_search($itemValue, array_column($mergedItems, 'item'));

        if ($index !== false) {
            $mergedItems[$index]['Quantity'] += $quantity;
        } else {
            $mergedItems[] = $item;
        }
    }

    return $mergedItems;
}

if ($user_order_supply_report !== "1" and $user_IsAdmin != 1) {
    echo '

<br/>
<div  class="alert alert-warning text-right" style="margin-top:150px;">
                  ' . $not_have_permission_lang . '
                            </div>';
} else { ?>

    <?php
    if (($_POST['submit']) == $transfer_lang and $_POST['submit'] != null) {
        if ($_POST['store_from_id'] == "") {
            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;margin-top:135px">
                        <span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
                        ' . $must_type_store_from . '
                </div>';
        } elseif ($_POST['store_to_id'] == "") {
            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;margin-top:135px">
                        <span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
                        ' . $must_type_store_to . '
                </div>';
        }else{
            if (isset($_POST['cb'])) {
                mysqli_autocommit($con,FALSE);
                $cbs = $_POST['cb'];
    
                $_POST['date'] = str_replace("/", "-", $_POST['date']);
                $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));

                mysqli_query($con, "UPDATE " . $prefix . "_config SET  Laststores_changeInvoiceNo = Laststores_changeInvoiceNo + 1 where id=" . $get_db_id . "");
    
                mysqli_query($con, "select Laststores_changeInvoiceNo FRom  " . $prefix . "_config  where id=" . $get_db_id . "");
                $configSql = "SELECT Laststores_changeInvoiceNo FROM " . $prefix . "_config where id='1'";
                $result_LastInvoiceNo = mysqli_query($con, $configSql);
                while ($row_LastInvoiceNo = mysqli_fetch_array($result_LastInvoiceNo)) {
                    $get_LastInvoiceNo = $row_LastInvoiceNo['Laststores_changeInvoiceNo'];
                }
    
                $insertSql = "INSERT INTO " . $prefix . "_stores_change_inv(`store_from_id`,`inv_id`, `DueDate`,`date` ,`store_to_id`, `notes` , `user_id`)
                                VALUES ('" . $_POST['store_from_id'] . "','" . $get_LastInvoiceNo . "','" . $DueDate . "','" . $DueDate . "','" . $_POST['store_to_id'] . "', '' ,'" . $user_id . "')";
    
                if (mysqli_query($con, $insertSql)) {
                    $Report_Create_Invoice = 1;
                } else {
                    $Report_Create_Invoice = 0;
                    $mysqli_errno ++;
                }
    
    
                if ($Report_Create_Invoice == 1) {
                    $items = [];
    
                    $result_up = mysqli_query($con, "SELECT {$prefix}_order_supply.item_status as itemstatus, {$prefix}_order_supply.* , {$prefix}_order_supply_inv.* FROM " . $prefix . "_order_supply_inv Join " . $prefix . "_order_supply on " . $prefix . "_order_supply_inv.inv_id=" . $prefix . "_order_supply.inv_id  where (" . $prefix . "_order_supply_inv.transfer_status != 1 or " . $prefix . "_order_supply_inv.transfer_status is null " . " ) and " . $prefix . "_order_supply_inv.id in (" . implode(',', $cbs) . ") ");
    
                    while ($row_up = mysqli_fetch_array($result_up)) {
                        $found = false;
                        if ($row_up['itemstatus'] == "offers") {
                            $presult_total_expenses = mysqli_query($con, "SELECT item,SUM(Quantity) as Quantity FROM " . $prefix . "_offers_inv JOIN cairo_offers ON cairo_offers_inv.inv_id = cairo_offers.inv_id WHERE cairo_offers_inv.id  = {$row_up['item']} GROUP BY cairo_offers.item  ");
    
                            if (@mysqli_num_rows($presult_total_expenses) > 0) {
                                while ($row = mysqli_fetch_array($presult_total_expenses)) {
    
                                    $q = $row_up['Quantity'] * $row['Quantity'];
                                    foreach ($items as $index => $item12) {
                                        if ($item12['item'] == $row['item'] && $item12['item_status'] == $row_up['itemstatus']) {
                                            $items[$index]['Quantity'] += $q;
                                            $found = true;
                                        }
                                    }
                                    if ($found === false) {
                                        $items[] = [
                                            "item" => $row['item'],
                                            "Quantity" => $q,
                                            "item_status" => $row_up['itemstatus']
                                        ];
                                    }
                                }
                            }
                        } elseif ($row_up['itemstatus'] == "items") {
                            $ProductsName = mysqli_query($con, "SELECT * FROM items  where  id = {$row_up['item']}");
    
                            while ($row = mysqli_fetch_object($ProductsName)) {
                                $q = $row_up['Quantity'];
    
                                foreach ($items as $index => $item12) {
                                    if ($item12['item'] == $row->id && $item12['item_status'] == $row_up['itemstatus']) {
                                        $items[$index]['Quantity'] += $q;
                                        $found = true;
                                    }
                                }
    
                                if ($found === false) {
                                    $items[] = [
                                        "item" => $row->id,
                                        "Quantity" => $q,
                                        "item_status" => $row_up['itemstatus']
                                    ];
                                }
                            }
                        }
                    }

                    $allItems = mergeSimilarItems($items);

                    foreach ($allItems as $index => $item22) {
    
                        $offerSql = "INSERT INTO {$prefix}_stores_change (Quantity, date, inv_id, item, user_id ,item_status) 
                            VALUES ('{$item22['Quantity']}','{$DueDate}','{$get_LastInvoiceNo}','{$item22['item']}','{$user_id}' , 'items' )";
                        if (mysqli_query($con, $offerSql)) {
                            mysqli_query($con, "UPDATE {$prefix}_order_supply_inv SET transfer_status=1 where id={$item22['item']}");
                            $Report_Record_purchases = 1;
                        } else {
                            $Report_Record_purchases = 0;
                            $mysqli_errno++;
                        }
                    }
                }
            }else{
                echo "<div class='alert alert-danger text-center' style='margin-top: 150px;'>يجب تحديد العناصر اولاَ</div>";
            }
        }
        if ($mysqli_errno > 0) {
            mysqli_rollback($con);
            echo "<div class='alert alert-danger text-center'>error</div>";
        }else{
            mysqli_commit($con);
            $filter = '';
            if (!empty($_GET['from']) && !empty($_GET['to'])) {
                $filter .= "&from=" . $_GET['from'] . "&to=" . $_GET['to'];
            }
            if (!empty($_GET['inv'])) {
                $filter .= "&inv=" . $_GET['inv'];
            }
            if (!empty($_GET['UerID'])) {
                $filter .= "&UerID=" . $_GET['UerID'];
            }
            if (!empty($_GET['mobile1'])) {
                $filter .= "&mobile1=" . $_GET['mobile1'];
            }
            if (!empty($_GET['mobile2'])) {
                $filter .= "&mobile2=" . $_GET['mobile2'];
            }
            if (!empty($_GET['region_id'])) {
                foreach ($_GET['region_id'] as $regionFilter)
                    $filter .= "&region_id[]=" . $regionFilter;
            }
            if (!empty($_GET['status'])) {
                foreach ($_GET['status'] as $regionFilter)
                    $filter .= "&status[]=" . $regionFilter;
            }
            if (!empty($_GET['centers_id'])) {
                foreach ($_GET['centers_id'] as $regionFilter)
                    $filter .= "&centers_id[]=" . $regionFilter;
            }
            if (!empty($_GET['Alpha'])) {
                foreach ($_GET['Alpha'] as $regionFilter)
                    $filter .= "&Alpha[]=" . $regionFilter;
            }
            $headerPage = "reports.php?reports=order_supply" . $filter;
            header("refresh:1;url=" . $headerPage . "");
        }
    }

    ?>

    <?php
    // if (($_POST['submit']) == $transfer_lang and $_POST['submit'] != null) {
    //     if (isset($_POST['cb'])) {
    //         $cbs = $_POST['cb'];
    //         foreach ($cbs as $cbb) {
    //             $cb =  explode("-",$cbb)[0];
    //             $RealInv_id = explode("-",$cbb)[1];
    //             ###############################################
    //             $_POST['date'] = str_replace("/", "-", $_POST['date']);
    //             $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));
    //             $CheckNumber = '';
    //             if ($_POST['store_from_id'] == "") {
    //                 echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
    // 			<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
    // 			' . $must_type_store_from . '
    // 			</div>';
    //             } elseif ($_POST['store_to_id'] == "") {
    //                 //print $paid;
    //                 echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
    // 			<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
    // 			' . $must_type_store_to . '
    // 			</div>';
    //             } else {
    //                 ############################
    //                 mysqli_query($con, "UPDATE " . $prefix . "_config SET Laststores_changeInvoiceNo = Laststores_changeInvoiceNo + 1 where id=" . $get_db_id . "");

    //                 $configSql = "SELECT Laststores_changeInvoiceNo FROM " . $prefix . "_config where id='1'";

    //                 $result_LastInvoiceNo = mysqli_query($con, $configSql);
    //                 while ($row_LastInvoiceNo = mysqli_fetch_array($result_LastInvoiceNo)) {
    //                     $get_LastInvoiceNo = $row_LastInvoiceNo['Laststores_changeInvoiceNo'];
    //                 }
    //                 ######################
    //                 ######################

    //                 ######################
    //                 $insertSql = "INSERT INTO " . $prefix . "_stores_change_inv(store_from_id,inv_id, date, store_to_id, user_id,ExportOrderId) 
    //                 VALUES ('" . $_POST['store_from_id'] . "','" . $get_LastInvoiceNo . "','" . $DueDate . "','" . $_POST['store_to_id'] . "','" . $user_id . "','" . $RealInv_id . "')";

    //                 if (mysqli_query($con, $insertSql)) {
    //                     $Report_Create_Invoice = 1;
    //                     //     ##############
    //                     // echo "SELECT * FROM " . $prefix . "_order_supply_inv Join " . $prefix . "_order_supply on " . $prefix . "_order_supply_inv.inv_id=" . $prefix . "_order_supply.inv_id  where " . $prefix . "_order_supply_inv.transfer_status != '1' and " . $prefix . "_order_supply_inv.id=$cb ";

    //                     $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_inv Join " . $prefix . "_order_supply on " . $prefix . "_order_supply_inv.inv_id=" . $prefix . "_order_supply.inv_id  where (" . $prefix . "_order_supply_inv.transfer_status != 1 OR " . $prefix . "_order_supply_inv.transfer_status IS NULL) and " . $prefix . "_order_supply_inv.id=$cb ");
    //                     while ($row_up = mysqli_fetch_array($result_up)) {
    //                         $Quantity = $row_up['Quantity'];
    //                         $item = $row_up['item'];
    //                         $offerSql = "INSERT INTO " . $prefix . "_stores_change (Quantity, date, inv_id, item, user_id)
    //                             VALUES ('" . $Quantity . "','"  . $DueDate . "','" . $get_LastInvoiceNo . "','" . $item . "','" . $user_id . "')";
    //                         // echo '<br>';
    //                     }
    //                     if (mysqli_query($con, $offerSql)) {
    //                         mysqli_query($con, "UPDATE " . $prefix . "_order_supply_inv SET  transfer_status=  1 where id=" . $cb . "");
    //                         $Report_Record_purchases = 1;
    //                     } else {
    //                         $Report_Record_purchases = 0;
    //                         $mysqli_errno++;
    //                     }
    //                     //     ###############
    //                 }else {
    //                     $Report_Create_Invoice = 0;
    //                 }
    //                 ################
    //                 ################################

    //                 // echo $inv_Total;
    //                 ######################
    //             }
    //         }
    //     }
    //     if ($mysqli_errno > 0) {
    //         mysqli_rollback($con);
    //     }
    //     mysqli_commit($con);
    //     // header("refresh:1;url=reports.php?from=" . $_GET['from'] . "&to=" . $_GET['to'] . "&inv=" . $_GET['inv'] . "&UerID=" . $_GET['UerID'] . "&region_id=" . implode(',', $_GET['region_id']) . "&alpha=" . implode(',', $_GET['Alpha']) . "&reports=order_supply");
    // }

    ?>
    <style>
        .tableFixHead {
            overflow-y: auto;
            width: 100%;
            height: 500px;
        }

        .tableFixHead thead th {
            position: sticky;
            top: 0;
        }

        /* Just common table stuff. Really. */
        table {
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px 16px;
        }

        .head {
            background: #CCC;
        }
    </style>
    <form method="Post" id="ids_form">
        <div class="tableFixHead">
            <div id="ajaxRes"></div>
            <table id="tablee" border="1" style="font-size:14px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
                <thead>
                    <td colspan="16" style="background-color:#09F;"><strong style="color:#FFF; font-size:18px;"> <?php echo "$order_supply_report_lang"; ?></strong></td>
                    <td colspan="2" style="background-color:#09F;">
                        <?php if ($user_pdf_order_supply !== "1" and $user_IsAdmin != 1) {
                        } else { ?>

                            <a href="#" id="multiPrint"><img src="images/print_icon.gif" style="width:30px; height:30px; float:left; border:0px;" title="
                                                                                <?php echo "$print_lang"; ?>
                                " /></a>
                        <?php } ?>

                    </td>
                </thead>
                <thead>

                    <th style="width: 3%; " class="head text-center e">
                        <!-- <a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                        } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                            echo "ASC";
                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                        } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines">  -->
                            <?php echo "$select_all_lang"; ?><input style="min-width: 10px;" type="checkbox" name="all" value="1" id="all" />
                        <!-- </a> -->
                    </th>
                    <!--            <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}
                                                                ?><!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                                                                                                                                                                                                                                                ?><!--&from=--><?php //echo"".$_GET['from'].""; 
                                                                                                                                                                                                                                                                                                                    ?><!--&to=--><?php //echo"".$_GET['to'].""; 
                                                                                                                                                                                                                                                                                                                                                                    ?><!--&orderby=id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                                                                                                                                                                                                                                                                                                                                                                                                            ?><!--&page=--><?php //echo"".$_GET['page'].""; 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?><!--" class="a_remove_underlines"> --><?php //echo"$Code_lang"; 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ?><!--  </a></th>-->
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "user_id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "user_id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=user_id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } ?>" class="a_remove_underlines"> <?php echo "$user_name_lang"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "edit_user") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "edit_user") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=edit_user&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                        echo "ASC";
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } ?>" class="a_remove_underlines"> <?php echo "$edit_user_name_lang"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "branch_id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "branch_id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=branch_id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                        echo "ASC";
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } ?>" class="a_remove_underlines"> <?php echo "$the_branch_name_lang"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "alpha") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "alpha") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=alpha&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                            echo "ASC";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } ?>" class="a_remove_underlines"> <?php echo "alpha"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "address") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "address") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=address&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } ?>" class="a_remove_underlines"> <?php echo "$Address1_lang"; ?> </a></th>

                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "region_id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "region_id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=region_id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                        echo "ASC";
                                                                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                                                        echo "DESC";
                                                                                                                                                                                                                                                                                                    } ?>" class="a_remove_underlines"> <?php echo "$region_lang"; ?> </a></th>


                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "centers_id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "centers_id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=centers_id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                                        } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                            echo "ASC";
                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                                        } ?>" class="a_remove_underlines"> <?php echo "المركز"; ?> </a></th>



                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "mobile1") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "mobile1") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=mobile1&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                } ?>" class="a_remove_underlines"> <?php echo "$Mobile1_lang"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=address&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                            } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"> <?php echo "$Products_lang"; ?> </a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "inv_id") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "inv_id") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=inv_id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } ?>" class="a_remove_underlines"> <?php echo "$order_supply_number_lang"; ?></a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "date") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "date") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=date&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                            echo "ASC";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } ?>" class="a_remove_underlines"><?php echo "$the_date_lang"; ?></a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Total") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Total") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=Total&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                            echo "ASC";
                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                            echo "DESC";
                                                                                                                                                                                                                                                                                        } ?>" class="a_remove_underlines"><?php echo "$the_total_lang"; ?></a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "Total") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "Total") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=shipping&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } ?>" class="a_remove_underlines"><?php echo "م.النقل"; ?></a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "client") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "client") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=client&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } ?>" class="a_remove_underlines"><?php echo "$The_client_lang"; ?></a></th>
                    <th class="head text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "status") {
                                                    echo "sort_t";
                                                } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "status") {
                                                    echo "sort_d";
                                                } else {
                                                    echo "sort0";
                                                } ?>"><a href="<?php echo "" . $targetpage . ""; ?>&orderby=status&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                            } ?>" class="a_remove_underlines"><?php echo "$status_name"; ?></a></th>
                    <th class="head text-center"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=transfer_status&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                } else if ($_GET['transfer_status'] == "DESC") {
                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo "$transfer_status_name"; ?></a></th>
                    <th class="head text-center"><?php echo $action_lang; ?></th>
                </thead>
                <?php

                $search = $_GET['search'];
                $orderby = $_GET['orderby'];
                $type = $_GET['type'];
                if (count(explode('_id', $_GET[$orderby])) > 1 or $orderby == 'edit_user' or $orderby == 'Total' or $orderby == 'shipping') {
                    $orderby = $_GET['orderby'] . '+0';
                }
                if ($orderby == null) {
                    $orderby = "id";
                }
                if ($type == null) {
                    $type = "ASC";
                }
                ###########################################
                $from = str_replace("/", "-", $_GET['from']);
                $to = str_replace("/", "-", $_GET['to']);
                $dateSqlCon = "";
                if ($from != '' and $to != '') {
                    $from = stripslashes(date('Y-m-d', strtotime($from)));
                    $to = stripslashes(date('Y-m-d', strtotime($to)));
                    $dateSqlCon .= "and left(date,10) BETWEEN '" . $from . "' AND '" . $to . "'";
                } elseif ($from == '' and $to != '') {
                    $to = stripslashes(date('Y-m-d', strtotime($to)));
                    $dateSqlCon .= "and left(date,10)  <=  '" . $to . "'";
                } elseif ($from != '' and $to == '') {
                    $from = stripslashes(date('Y-m-d', strtotime($from)));
                    $dateSqlCon .= "and left(date,10)  >=  '" . $from . "'";
                } else {
                    if (!isset($_GET['from']) and !isset($_GET['from'])) {
                        $dateSqlCon .= "and left(date,10) BETWEEN '" . date("d/m/Y") . "' AND '" . date("d/m/Y") . "'";
                    }
                }
                $mobile1 = stripslashes($_GET['mobile1']);
                $mobile2 = stripslashes($_GET['mobile2']);
                $status_array = array();
                foreach ($_GET['status'] as $one_status) {
                    if ($one_status != '') {
                        $status_array[] = $one_status;
                    }
                }
                if (count($status_array) > 0) {

                    $status = implode(',', $status_array);
                } else {
                    $status = '';
                }


                $alpha_array = array();
                foreach ($_GET['Alpha'] as $one_alpha) {
                    if ($one_alpha != '') {
                        $alpha_array[] = $one_alpha;
                    }
                }
                if (count($alpha_array) > 0) {

                    $alpha = implode(",", $alpha_array);
                } else {
                    $alpha = '';
                }

                $alpha_joins = join("','", $_GET['Alpha']);

                $inv = stripslashes($_GET['inv']);
                $UerID = stripslashes($_GET['UerID']);
                // $products=$_GET['products'];
                // $products = array();
                $products = implode(',', $_GET['products']);

                // $branch = array();
                $branch = implode(',', $_GET['branch_id']);


                if ($inv == "" or $inv == null) {
                } else {
                    $add_sql .= "inv_id='$inv' and ";
                }


                $status_array = array();
                if ($_GET['region_id'] != '') {
                    $i = 0;
                    if (!is_array($_GET['region_id'])) {
                        $_GET['region_id']  = explode(',', $_GET['region_id']);
                    }
                    foreach ($_GET['region_id'] as $region) {
                        if ($region == "" or $region == null) {
                        } else {
                            $region_childs = get_region_childs($region);
                            $region_childs = implode(',', $region_childs);
                            if ($i == 0) {
                                $add_sql .= " ( ";
                                $add_sql .= "    region_id IN ($region_childs )  ";
                            } else {
                                $add_sql .= "  or   region_id IN ($region_childs )  ";
                            }
                        }
                        $i++;
                    }
                    $add_sql .= "   ) and   ";
                }

                if ($_GET['centers_id'] != '') {
                    $i = 0;
                    if (!is_array($_GET['centers_id'])) {
                        $_GET['centers_id']  = explode(',', $_GET['centers_id']);
                    }

                    foreach ($_GET['centers_id'] as $centers_id) {
                        if ($centers_id == "" or $centers_id == null) {
                        } else {
                            if ($i == 0) {
                                $add_sql .= " ( ";
                                $add_sql .= "    centers_id = $centers_id  ";
                            } else {
                                $add_sql .= "  or   centers_id = $centers_id  ";
                            }
                        }
                        $i++;
                    }
                    $add_sql .= "   ) and   ";
                }

                if ($user_branch_id && $user_branch_id > 0) {
                    $add_sql .= "branch_id IN ($user_branch_id) and ";
                } else {
                    if ($branch == "" or $branch == null) {
                    } else {
                        $add_sql .= "branch_id IN ($branch) and ";
                    }
                }
                //  if($user_branch_id && $user_branch_id > 0){$add_sql.="user_id IN ($branch) and ";}

                $add_sql_doc = '';
                if ($UerID == "" or $UerID == null) {
                } else {
                    $add_sql_UerID = "user_id='$UerID' and ";
                }

                if (empty($products)) {
                } else {
                    $arr_product_id = $products;
                    $add_sql_products_in_offer = " item in (SELECT id FROM cairo_offers_inv WHERE inv_id IN (SELECT inv_id FROM cairo_offers WHERE item IN(SELECT id FROM items WHERE groupid IN ($arr_product_id))))";
                    $add_sql_products = "and inv_id in (SELECT inv_id from cairo_order_supply where (item_status LIKE 'offers' AND " . $add_sql_products_in_offer . ") OR (item in (select id from items where groupid in ($arr_product_id))))";
                    // $add_sql_products = "  "
                }

                if ($mobile1 == "" or $mobile1 == null) {
                } else {
                    $add_sql_doc .= " (mobile1 like '%$mobile1%' or  mobile2 like '%$mobile1%') and ";
                }
                //            if($mobile2=="" or $mobile2==null){}else{$add_sql_doc.=" mobile2 like '%$mobile2%' and ";}
                if ($status == "" or $status == null) {
                } else {
                    $add_sql_doc .= " status IN ($status) and ";
                }
                if ($_GET['Alpha'] == "" or $_GET['Alpha'] == null) {
                } else {
                    $add_sql_doc .= " alpha IN ('" . $alpha_joins . "') and ";
                }




                $tbl_name = "" . $prefix . "_order_supply_inv";        //your table name
                // How many adjacent pages should be shown on each side?
                $adjacents = 3;
                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_order_supply_inv where $add_sql $add_sql_UerID $add_sql_doc  type in('1','2')  $dateSqlCon $add_sql_products";

                $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
                $total_pages = $total_pages['num'];

                /* Setup vars for query. */
                foreach ($_GET['region_id'] as $region) {
                    $targetpage .= "&region_id%5B%5D=" . $region;
                }

                foreach ($_GET['centers_id'] as $region) {
                    $targetpage .= "&centers_id%5B%5D=" . $region;
                }
                foreach ($_GET['branch_id'] as $branch) {
                    $targetpage .= "&branch_id%5B%5D=" . $branch;
                }
                foreach ($_GET['Alpha'] as $alpha) {
                    $targetpage .= "&alpha%5B%5D=" . $alpha;
                }
                foreach ($_GET['status'] as $status) {
                    $targetpage .= "&status%5B%5D=" . $status;
                }
                //how many items to show per page
                if (!empty($_GET['limit'])) {
                    $_SESSION['limit'] = $_GET['limit'];
                } else {
                }
                if (!empty($_SESSION['limit'])) {
                    $limit = $_SESSION['limit'];
                    if ($limit > 100) {
                        $limit = $items_per_page;
                    }
                } else {
                    $limit = $items_per_page;
                }
                //            $limit = 1;

                $page = $_GET['page'];
                if ($page)
                    $start = ($page - 1) * $limit;             //first item to display on this page
                else
                    $start = 0;                                //if no page var is given, set start to 0

                $sql = "SELECT * FROM " . $prefix . "_order_supply_inv where $add_sql $add_sql_UerID $add_sql_doc  type in('1','2') $dateSqlCon $add_sql_products order by $orderby $type LIMIT $start, $limit";
                // echo '<br>';

                $result = @mysqli_query($con, $sql);
                /* Setup page vars for display. */
                if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
                $prev = $page - 1;                            //previous page is page - 1
                $next = $page + 1;                            //next page is page + 1
                $lastpage = ceil($total_pages / $limit);        //lastpage is = total pages / items per page, rounded up.
                $lpm1 = $lastpage - 1;                        //last page minus 1

                /*
                Now we apply our rules and draw the pagination object.
                We're actually saving the code to a variable in case we want to draw it more than once.
            */
                $pagination = " ";


                if ($lastpage > 1) {
                    $pagination .= "<div class=\"pagination\">";
                    //previous button
                    if ($page > 1)
                        $pagination .= "<a href=\"$targetpage&page=$prev\">>></a>";
                    else
                        $pagination .= "<span class=\"disabled\">>></span>";

                    //pages
                    if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
                    {
                        for ($counter = 1; $counter <= $lastpage; $counter++) {
                            if ($counter == $page)
                                $pagination .= "<span class=\"current\">$counter</span>";
                            else
                                $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                        }
                    } elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
                    {
                        //close to beginning; only hide later pages
                        if ($page < 1 + ($adjacents * 2)) {
                            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                                if ($counter == $page)
                                    $pagination .= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                            $pagination .= "...";
                            $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                            $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                        }
                        //in middle; hide some front and some back
                        elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                            $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                            $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                            $pagination .= "...";
                            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                                if ($counter == $page)
                                    $pagination .= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                            $pagination .= "...";
                            $pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                            $pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                        }
                        //close to end; only hide early pages
                        else {
                            $pagination .= "<a href=\"$targetpage&page=1\">1</a>";
                            $pagination .= "<a href=\"$targetpage&page=2\">2</a>";
                            $pagination .= "...";
                            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                                if ($counter == $page)
                                    $pagination .= "<span class=\"current\">$counter</span>";
                                else
                                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                            }
                        }
                    }

                    //next button
                    if ($page < $counter - 1)
                        $pagination .= "<a href=\"$targetpage&page=$next\"><<</a>";
                    else
                        $pagination .= "<span class=\"disabled\"><<</span>";
                    $pagination .= "</div>\n";
                }
                ###############
                $i = 0;

                while ($row = @mysqli_fetch_array($result)) {
                    // var_dump($row);
                    // echo '<br>';
                    $products = '';

                    $sub_sql = "SELECT * FROM " . $prefix . "_order_supply  where inv_id=" . $row['inv_id'] . " order by id   $type ";
                    $sub_result = @mysqli_query($con, $sub_sql);

                    while ($roww = @mysqli_fetch_array($sub_result)) {
                        // var_dump($roww);
                        // echo '<br>';
                        if ($roww['item_status'] == 'offers') {
                            $sub_sql1 = "SELECT name  FROM " . $prefix . "_offers_inv  where id=" . $roww['item'];
                            $sub_result1 = @mysqli_query($con, $sub_sql1);
                            if (mysqli_num_rows($sub_result1) > 0) {
                                while ($sub_row1 = @mysqli_fetch_array($sub_result1)) {
                                    $products .= "(" . $roww['Quantity'] . ") - " . $sub_row1['name'] . " <br/> ";
                                }
                            }
                        } else {
                            $sub_sql1 = "SELECT item  FROM items  where id=" . $roww['item'];
                            $sub_result1 = @mysqli_query($con, $sub_sql1);

                            if (mysqli_num_rows($sub_result1) > 0) {
                                while ($sub_row = @mysqli_fetch_array($sub_result1)) {
                                    $products .= "(" . $roww['Quantity'] . ") - " . $sub_row['item'] . " <br/> ";
                                }
                            }
                        }
                    }
                    // var_dump($products);
                    $issingle = $i / 2;
                    $dot = strstr($issingle, '.');
                    if ($dot == "") {
                        $class = "background_color_FFF";
                    } else {
                        $class = 'background_color_D5EFF0';
                    }
                    if ($row['PaymentMethod'] == 1) {
                        $PaymentMethod = "$cash_lang";
                    } else if ($row['PaymentMethod'] == 2) {
                        $PaymentMethod = "$On_credit_lang";
                    } else if ($row['PaymentMethod'] == 3) {
                        $PaymentMethod = "$check_lang";
                    } else {
                    }
                    #############################
                    if ($Discount_type == 1) {
                        $total_val = $row['Total'] - ($row['discount']);
                    } else if ($Discount_type == 2) {
                        $total_val = $row['Total'] - ($row['Total'] * $row['discount'] / 100);
                    } else {
                        $total_val = $row['Total'] - ($row['discount']);
                    }
                    //                Mahmoud Kamal
                    //                $total_val_after_tax_and_shipping=  $total_val+$row['shipping'];
                    $total_val_after_tax_and_shipping =  $total_val;

                ?>


                    <?php
                    if (get_order_supply_status_data($row['status'])['name'] == "متأخر") {
                    ?>
                        <tr id="del_<?php echo $row['inv_id'] ?>" style="background-color: #ff0b0b36" class="<?php echo "" . $class . ""; ?>">
                        <?php
                    } else {

                        ?>
                        <tr id="del_<?php echo $row['inv_id'] ?>" style="height: 1px" class="<?php echo "" . $class . ""; ?>">


                        <?php
                    }
                        ?>
                        <td>
                            <!--<input style="min-width: 10px;" type="checkbox" name="cb[]" class="idcheckbox" value="<?php echo "" . $row['id'] . "-" . $row['inv_id']; ?>">-->
                            <input style="min-width: 10px;" type="checkbox" name="cb[]" class="idcheckbox" value="<?php echo "" . $row['id'] . ""; ?>">
                        </td>
                        <!--                <td >--><?php //echo"".$row['id'].""; 
                                                    ?><!--</td>-->
                        <td><?php echo "" . get_user_data($row['user_id'])['name'] . ""; ?></td>
                        <td><?php echo "" . get_user_data($row['edit_user'])['name'] . ""; ?></td>
                        <td><?php echo "" . get_branch_data($row['branch_id'])['name'] . ""; ?></td>
                        <td width="15%"><?php echo "" . $row['alpha'] . ""; ?></td>
                        <td width="15%"><?php echo "" . $row['address'] . ""; ?></td>

                        <td><?php echo "" . get_region_data($row['region_id'])['name'] . ""; ?></td>

                        <td><?php echo "" . get_centers_data($row['centers_id'])['name'] . ""; ?></td>

                        <td><?php echo "" . $row['mobile1'] . "  - <br/>" . $row['mobile2']; ?></td>
                        <td width="10%"><?php echo "" . $products . ""; ?></td>
                        <td><?php echo "" . $row['inv_id'] . ""; ?></td>
                        <!--    <td >--><?php //echo"".$row['doc'].""; 
                                        ?><!--</td>-->
                        <td><?php echo "" . substr($row['date'], 0, 10) . ""; ?></td>
                        <td><?php echo "" . $total_val_after_tax_and_shipping . ""; ?></td>
                        <td><?php echo "" . $row['shipping'] . ""; ?></td>
                        <td><?php echo "" . $row['client'] . ""; ?></td>
                        <td><?php echo "" . get_order_supply_status_data($row['status'])['name'] . ""; ?></td>
                        <?php
                        if ($row['transfer_status'] == '1') {
                        ?>
                            <td><?php echo "تم نقله الى مخزن"; ?></td>
                        <?php
                        } else {
                        ?><td><?php echo "لم يتم  نقله الى مخزن"; ?></td>
                        <?php
                        }
                        ?>
                        <!--   <td >--><?php //echo"".$PaymentMethod.""; 
                                        ?><!--</td>-->
                        <td>
                            <?php /*?>
  <img src="images/erase.png"/>
<img src="images/edit.png"/><?php */ ?>
                            <?php if ($row['confirm_status'] == 0) {
                                if ($user_delete_order_supply !== "1" and $user_IsAdmin != 1) {
                                } else { ?>
                                    <a class="addProd" par="del" attr="<?php echo $row['inv_id']; ?>" onclick="return confirm('<?php echo "$sure_delete_lang"; ?>');"><img src="images/erase.png" /></a>
                                    &nbsp;<?php } ?>
                                    &nbsp;
                                    <?php if ($user_edit_order_supply !== "1" and $user_IsAdmin != 1) {
                                    } else { ?>

                                        <a href="order_supply_edit.php?id=<?php echo "" . $row['inv_id'] . ""; ?>" target="_BLANK"><img src="images/edit.png" /></a>
                                        <!--<a href="#" onclick="javascript:void window.open('pdf/export/order_supply_inv.php?id=<?php /*echo"".$row['inv_id'].""; */ ?>//&type=sale','1390937502641','width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;"><img src="images/view.png"/></a>
-->
                                <?php }
                                } ?>

                                <select style="width: 90%" name="status" size="1" class="js-example-placeholder-single w25 js-states  form-control">
                                    <option value=""> <?php echo "$region_lang"; ?></option>
                                    <?php
                                    $status_expl = explode(',', $user_status);
                                    $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status order by name ASC");
                                    $num_item = mysqli_num_rows($ProductsName);
                                    if ($num_item > 0) {
                                        while ($row_item = mysqli_fetch_array($ProductsName)) {
                                            if ($row_item['id'] == $row['status']) {
                                                echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                            } else {
                                                if ($user_IsAdmin == 1) {
                                                    echo '<option data-invidid ="' . $row['inv_id'] . '"  data-attrchangeid ="' . $row['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                } else {
                                                    if (in_array($row_item['id'], $status_expl)) {
                                                        echo '<option data-invidid ="' . $row['inv_id'] . '" data-attrchangeid ="' . $row['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    } else {
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                                <input type="button" order_confirm_status="<?php echo $row['confirm_status']; ?>" order_user_id="<?php echo $row['user_id']; ?>" confirmed_id="<?php echo $row['id']; ?>" value="<?php echo "$confirm_order_supply_lang"; ?>" class="confirm_to_inv button" />

                        </td>
                        </tr>

                    <?php $i++;
                } ?>

                    <tfoot style="background-color:#CCC;">
                        <th colspan="12" class="text-center"><?php echo "$the_total_lang"; ?></th>
                        <th class="text-center"> <?php

                                                    $result_get = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_inv where " . $add_sql . " " . $add_sql_UerID . " " . $add_sql_doc . " type in('1','2') $dateSqlCon $add_sql_products");
                                                    if (mysqli_num_rows($result_get) > 0) {
                                                        while ($row_get = mysqli_fetch_array($result_get)) {
                                                            ###################
                                                            if ($Discount_type == 1) {
                                                                $total_val2 = $row_get['Total'] - ($row_get['discount']);
                                                            } else if ($Discount_type == 2) {
                                                                $total_val2 = $row_get['Total'] - ($row_get['Total'] * $row_get['discount'] / 100);
                                                            } else {
                                                                $total_val2 = $row_get['Total'] - ($row_get['discount']);
                                                            }
                                                            //                Mahmoud Kamal
                                                            //                        $total_val_after_tax_and_shipping2+=  $total_val2+$row_get['tax']+$row_get['shipping'];
                                                            $total_val_after_tax_and_shipping2 +=  $total_val2 + $row_get['tax'];
                                                            #################
                                                        }
                                                    }
                                                    echo $total_val_after_tax_and_shipping2;
                                                    ?></th>
                        <th colspan="4"></th>
                        <th></th>

                    </tfoot>

            </table>
        </div>
        <table border="1" style="font-size:14px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
            <tfoot>
                <tr>
                    <td class="text-center" colspan="15">

                        <?php echo $i + (($page - 1) * $limit) . ' من : ' . $total_pages; ?> </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="15"><?php echo "$pagination"; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $stores_change_lang; ?></td>
                    <td colspan="5"> <label><?php echo $store_from; ?></label>
                        <select name="store_from_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                            <option value=""> <?php echo "$Store_name"; ?></option>
                            <?php
                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_store order by id ASC");
                            $num_item = mysqli_num_rows($ProductsName);
                            if ($num_item > 0) {
                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                    if ($row_item['id'] == $_POST['store_from_id']) {
                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                    </td>
                    <td colspan="5"> <label><?php echo $store_to; ?></label>
                        <select name="store_to_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                            <option value=""> <?php echo "$Store_name"; ?></option>
                            <?php
                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_store order by id ASC");
                            $num_item = mysqli_num_rows($ProductsName);
                            if ($num_item > 0) {
                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                    if ($row_item['id'] == $_POST['store_to_id']) {
                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                    } else {
                                        echo '<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                        <input type="hidden" name="date" id="date" value="<?php if ($_POST['date'] == "") {
                                                                                echo date("d/m/Y");
                                                                            } else {
                                                                                echo "" . $_POST['date'] . "";
                                                                            } ?>" style="text-align:center; background-color:#CCC; width:80px; height:20px;" />
                        <script type="text/javascript">
                            $('#date').dateEntry({
                                dateFormat: 'dmy/',
                                spinnerImage: ''
                            });
                        </script>
                    </td>
                    <td colspan="4">
                        <input type="submit" name="submit" value="<?php echo $transfer_lang  ?>" style="width:120px; height:40px;" />
                    </td>
                </tr>
            </tfoot>

        </table>
    </form>
<?php } ?>

<script>
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
    $('.js-example-placeholder-single').on('select2:select', function(e) {
        var data = e.params.data;

        $.ajax({
            url: 'ajax/change_order_supply_status.php',
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: {
                'status': data.id,
                'invidid': data.element.attributes['data-invidid'].value,
                'id': data.element.attributes['data-attrchangeid'].value
            },
            success: function(data, textStatus, jQxhr) {

                location.relreload();
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });


    });


    $('.confirm_to_inv').click(function(e) {

        var order_id = $(this).attr('confirmed_id');
        var order_user_id = $(this).attr('order_user_id');
        var order_confirm_status = $(this).attr('order_confirm_status');
        if (order_confirm_status != '1') {
            var url = 'sales.php?order_status=order&order_id=' + order_id + '&order_user_id=' + order_user_id;
            window.open(url);
        } else {
            alert('تم ترحيل هذا التوريد كفاتوره من قبل ')
        }

    });


    $('#all').click(function() {
        if (this.checked) {
            $(".idcheckbox").each(function() {
                this.checked = true;
            });
        } else {
            $(".idcheckbox").each(function() {
                this.checked = false;
            });
        }

    });
    $('#multiPrint').click(function(e) {
        // alert('multi here print')
        var ids = [];

        $(".idcheckbox").each(function(e, i) {
            if (i.checked) {
                ids.push(i.value);
            }
        });

        var url = 'pdf/export/order_supply_print.php?ids=' + ids;
        window.open(url, '_blank');
    });
    $(document).on("click", '.addProd', function() {
        // alert('hereeeee class add prod');
        var par = $(this).attr('par');
        var val = $(this).attr('attr');

        if (par == 'del') {
            $.ajax({
                url: 'ajax/order_supply_add_delete.php',
                dataType: 'text',
                type: 'GET',
                contentType: 'application/x-www-form-urlencoded',
                data: {
                    'del': $(this).attr('attr')
                },
                success: function(data, textStatus, jQxhr) {
                    data = JSON.parse(data);
                    $(document).ready(function() {

                        console.log('--------------------')
                        console.log(val)
                        console.log('--------------------')
                        $('#del_' + val).remove();

                    })
                    $('#ajaxRes').html(data['status']);

                    // $('#item_type_val').val($(this).attr('data_item_type'));
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

        }
    });
</script>