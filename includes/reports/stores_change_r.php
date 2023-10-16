<?php
if ($user_stores_change !== "1" and $user_IsAdmin != 1) {
    echo '<div class="alert alert-warning text-right" style="margin-top:150px;">
                  ' . $not_have_permission_lang . '
                            </div>';
} else { ?>
    <?php
    if ($_GET['del'] !== null) {
        if ($user_IsAdmin == 1) {

            $delSql = "DELETE FROM " . $prefix . "_stores_change_inv WHERE    inv_id='" . $_GET['del'] . "'";

            mysqli_query($con, $delSql);

            if (mysqli_affected_rows($con) > 0) {
                if (mysqli_query($con, "DELETE FROM " . $prefix . "_stores_change WHERE inv_id='" . $_GET['del'] . "'")) {
                    echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;float:right;width:100%; margin:0 auto;"">
                            <span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
                            ' . $bill_order_deleted_successfully_lang . '
                            </div>';
                }
            } else {
                $error_msg .= "  لا يمكن حذفها لترابطها بفاتوره اخرى";

                echo '<div class="btn-warning" style="text-align:center; border-radius:5px;float:right;width:100%; margin:0 auto;"">
                    <span style="float:left; padding-left:20px;"> </span>
                    ' . $error_msg . '
                    </div>';
            }
        } else {
            echo '<div style="margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;">
      ' . $permission_delete_lang . '</div>';
        }
    }
    
    ?>
    <table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
        <thead>
            <td colspan="11" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"> <?php echo "$stores_change_lang"; ?></strong></td>
            <!--        <td colspan="1" style="background-color:#09F;">-->
            <!--            <a href="#" id="multiPrint"><img src="images/print_icon.gif" style="width:30px; height:30px; float:left; border:0px;" title="-->
            <!--                                                                                --><?php //echo"$print_lang"; 
                                                                                                    ?>
            <!--                                " /></a>   </td>-->
        </thead>
        <thead style="background-color:#CCC;">

            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                    ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines"> --><?php //echo"$select_all_lang"; 
                                                    ?>
            <!--<input type="checkbox" name="all" value="1" id="all" />  </a></th>-->
            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                            } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"> <?php echo "$Code_lang"; ?> </a></th>
            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                    ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines"> --><?php //echo"$Address1_lang"; 
                                                    ?>
            <!--  </a></th>-->
            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                    ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines"> --><?php //echo"$region_lang"; 
                                                    ?>
            <!--  </a></th>-->
            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                    ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines"> --><?php //echo"$Mobile1_lang"; 
                                                    ?>
            <!--  </a></th>-->
            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "id") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "id") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=id&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                            } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"> <?php echo "$Products_lang"; ?> </a></th>


            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="inv_id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="inv_id"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=inv_id&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                        ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines"> --><?php //echo"$stores_change_number_lang"; 
                                                    ?>
            <!--</a></th>-->

            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "name") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "name") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=doc&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>&name=<?php echo "" . $_GET['name'] . ""; ?>" class="a_remove_underlines"> <?php echo $stores_change_name_lang; ?></a></th>
            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "date") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "date") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=date&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo "$the_date_lang"; ?></a></th>
            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "date") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "date") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=date&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                    echo "ASC";
                                                                                                                                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                                                                                                                                    echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo "$notes_lang"; ?></a></th>


            <!--        <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="Total"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Total"){echo"sort_d";}else{echo"sort0";}
                                                    ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=Total&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                        ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines">--><?php //echo"$the_total_lang"; 
                                                    ?>
            <!--</a></th>-->


            <th class="text-center <?php if ($_GET['type'] == "ASC" and $_GET['orderby'] == "supplier") {
                                        echo "sort_t";
                                    } else if ($_GET['type'] == "DESC" and $_GET['orderby'] == "supplier") {
                                        echo "sort_d";
                                    } else {
                                        echo "sort0";
                                    } ?>"><a href="?reports=<?php echo "" . $_GET['reports'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&orderby=supplier&type=<?php if ($_GET['type'] == "ASC") {
                                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                            } else if ($_GET['type'] == "DESC") {
                                                                                                                                                                                                                                                                                                                                                                                echo "ASC";
                                                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                                                echo "DESC";
                                                                                                                                                                                                                                                                                                                                                                            } ?>&page=<?php echo "" . $_GET['page'] . ""; ?>" class="a_remove_underlines"><?php echo $store_from; ?></a></th>
            <th class="text-center" class="a_remove_underlines"><?php echo $store_to; ?></a></th>
            <!--        <th   class="text-center"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=status&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['status']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                        ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines">--><?php //echo"$status_name"; 
                                                    ?>
            <!--</a></th>-->

            <!--  <th   class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}
                                                ?>
            <!--"><a href="?reports=--><?php //echo"".$_GET['reports'].""; 
                                        ?>
            <!--&from=--><?php //echo"".$_GET['from'].""; 
                            ?>
            <!--&to=--><?php //echo"".$_GET['to'].""; 
                        ?>
            <!--&orderby=date&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                        ?>
            <!--&page=--><?php //echo"".$_GET['page'].""; 
                            ?>
            <!--" class="a_remove_underlines">--><?php //echo"$payment_method_alng"; 
                                                    ?>
            <!--</a></th>-->
            <th></th>
        </thead>
        <?php

        $search = $_GET['search'];
        $orderby = $_GET['orderby'];
        $type = $_GET['type'];
        if ($orderby == null) {
            $orderby = "id";
        }
        if ($type == null) {
            $type = "DESC";
        }
        ###########################################
        $from = str_replace("/", "-", $_GET['from']);
        $to = str_replace("/", "-", $_GET['to']);
        $from = stripslashes(date('Y-m-d', strtotime($from)));
        $to = stripslashes(date('Y-m-d', strtotime($to)));
        $notes = stripslashes($_GET['notes']);
        $inv = stripslashes($_GET['inv']);
        $name = stripslashes($_GET['name']);
        $store_from_id = stripslashes($_GET['store_from_id']);
        $store_to_id = stripslashes($_GET['store_to_id']);
        $UerID = stripslashes($_GET['UerID']);
        if ($inv == "" or $inv == null) {
        } else {
            $add_sql .= "inv_id.='$inv' and ";
        }
        if ($store_from_id == "" or $store_from_id == null) {
        } else {
            $add_sql .= "store_from_id='$store_from_id' and ";
        }
        if ($store_to_id == "" or $store_to_id == null) {
        } else {
            $add_sql .= "store_to_id='$store_to_id' and ";
        }
        if ($notes == "" or $notes == null) {
        } else {
            $add_sql .= "notes like '%$notes%' and ";
        }
        if ($name == "" or $name == null) {
        } else {
            $add_sql .= "name='$name' and ";
        }
        if ($UerID == "" or $UerID == null) {
        } else {
            $add_sql_UerID .= "user_id='$UerID' and ";
        }
        $tbl_name = "" . $prefix . "_stores_change_inv";        //your table name
        // How many adjacent pages should be shown on each side?
        $adjacents = 3;
        $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_stores_change_inv where $add_sql $add_sql_UerID  inv_id!='' and  date BETWEEN '" . $from . "' AND '" . $to . "'";
        $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
        $total_pages = $total_pages['num'];

        /* Setup vars for query. */
        $targetpage = "?UerID=" . $_GET['UerID'] . "&store_to_id=" . $_GET['store_to_id'] . "&store_from_id=" . $_GET['store_from_id'] . "&notes=" . $_GET['notes'] . "&reports=" . $_GET['reports'] . "&name=" . $_GET['name'] . "&inv=" . $_GET['inv'] . "&from=" . $_GET['from'] . "&to=" . $_GET['to'] . "&limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&type=" . $_GET['type'] . "";     //your file name  (the name of this file)
        //how many items to show per page
        if (!empty($_GET['limit'])) {
            $_SESSION['limit'] = $_GET['limit'];
        } else {
        }
        if (!empty($_SESSION['limit'])) {
            $limit = $_SESSION['limit'];
            if ($limit > 100) {
                $limit = $items_per_page + 20;
            }
        } else {
            $limit = $items_per_page + 20;
        }
        $page = $_GET['page'];
        if ($page)
            $start = ($page - 1) * $limit;             //first item to display on this page
        else
            $start = 0;                                //if no page var is given, set start to 0
        $sql = "SELECT * FROM " . $prefix . "_stores_change_inv where $add_sql $add_sql_UerID   inv_id!='' and date BETWEEN '" . $from . "' AND '" . $to . "' order by $orderby $type LIMIT $start, $limit";
        // echo '<hr>';
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
        $pagination = "";
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
            $products = '';
            $CheckIfOffer = mysqli_query($con,"SELECT * FROM cairo_order_supply WHERE inv_id LIKE '".$row['ExportOrderId']."'");
            while($CheckIfOfferFetch = mysqli_fetch_array($CheckIfOffer)){
                if($CheckIfOfferFetch['item_status'] == 'offers'){
                    $sub_sql = "SELECT `name` FROM cairo_offers_inv where id=" . $CheckIfOfferFetch['item'] . " order by name $type ";
                    // echo '<br>';
                    $sub_result = @mysqli_query($con, $sub_sql);
        
                    if (mysqli_num_rows($sub_result) > 0) {
                        while ($sub_row = @mysqli_fetch_array($sub_result)) {
                            $products .= "(" . $CheckIfOfferFetch['Quantity'] . ") - " . $sub_row['name'] . " <br/> ";
                        }
                    }
                }else{
                    $sub_sql = "SELECT `item` FROM items where id=" . $CheckIfOfferFetch['item'] . " order by item $type ";
                    $sub_result = @mysqli_query($con, $sub_sql);
        
                    if (mysqli_num_rows($sub_result) > 0) {
                        while ($sub_row = @mysqli_fetch_array($sub_result)) {
                            $products .= "(" . $CheckIfOfferFetch['Quantity'] . ") - " . $sub_row['item'] . " <br/> ";
                        }
                    }
                }
            }
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
            $total_val_after_tax_and_shipping =  $total_val + $row['tax'] + $row['shipping'];
        ?>


            <tr class="<?php echo "" . $class . ""; ?>">
                <td><?php echo "" . $row['id'] . ""; ?></td>
                <td><?php echo "" . $products . ""; ?></td>
                <td><?php echo "" . $row['name'] . ""; ?></td>
                <td><?php echo "" . substr($row['date'], 0, 10) . ""; ?></td>
                <td><?php echo "" . $row['notes']; ?></td>
                <td><?php echo "" . get_store_data($row['store_from_id'])['name'] . ""; ?></td>
                <td><?php echo "" . get_store_data($row['store_to_id'])['name'] . ""; ?></td>
                <td>
                    <?php if ($DeleteStoresChange !== "1" and $user_IsAdmin != 1) {
                    } else {
                    ?>
                        <a onclick="return confirm('<?php echo $sure_delete_lang; ?>');" href="?limit=<?php echo "" . $_GET['limit'] . ""; ?>&orderby=<?php echo "" . $_GET['orderby'] . ""; ?>&type=<?php echo "" . $_GET['type'] . ""; ?>&page=<?php echo "" . $_GET['page'] . ""; ?>&del=<?php echo "" . $row['inv_id'] . ""; ?>&from=<?php echo "" . $_GET['from'] . ""; ?>&store_from_id=<?php echo "" . $_GET['store_from_id'] . ""; ?>&store_to_id=<?php echo "" . $_GET['store_to_id'] . ""; ?>&to=<?php echo "" . $_GET['to'] . ""; ?>&notes=<?php echo "" . $_GET['notes'] . ""; ?>&reports=<?php echo "" . $_GET['reports'] . ""; ?>">
                            <img src="images/erase.png" />
                        </a>
                    <?php } ?>
                    <a href="stores_change_edit.php?id=<?php echo "" . $row['inv_id'] . ""; ?>" target="_BLANK"><img src="images/edit.png" /></a>
                    <a href="#" onclick="javascript:void window.open('pdf/export/stores_change_inv.php?id=<?php echo  $row['inv_id']; ?>&type=stores_change', '13909375026416', 'width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                            return false;"><img src="images/print_icon.gif" style="width:30px; height:30px; float:left; border:0px;" title="<?php echo "$Print_previous_bill_lang"; ?>" /></a>
                    <?php /*?> 
  <img src="images/erase.png"/>
<img src="images/edit.png"/><?php */ ?>

                    <!--  <a  onclick="return confirm('<?php /*echo"$sure_delete_lang"; */ ?>');" href="?limit=<?php /*echo"".$_GET['limit'].""; */ ?>&orderby=<?php /*echo"".$_GET['orderby'].""; */ ?>&type=<?php /*echo"".$_GET['type'].""; */ ?>&page=<?php /*echo"".$_GET['page'].""; */ ?>&del=<?php /*echo"".$row['inv_id'].""; */ ?>&from=<?php /*echo"".$_GET['from'].""; */ ?>&to=<?php /*echo"".$_GET['to'].""; */ ?>&reports=<?php /*echo"".$_GET['reports'].""; */ ?>" ><img src="images/erase.png"/></a>
                    <a href="stores_change_edit.php?id=<?php /*echo"".$row['inv_id'].""; */ ?>" target="_BLANK"><img src="images/edit.png"/></a>
                   -->
                    <!--<a href="#" onclick="javascript:void window.open('pdf/export/stores_change_inv.php?id=<?php /*echo"".$row['inv_id'].""; */ ?>//&type=sale','1390937502641','width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;"><img src="images/view.png"/></a>
-->



                </td>
            </tr>

        <?php $i++;
        } ?>


        <tr>
            <td class="text-center" colspan="11"><?php echo "$pagination"; ?></td>
        </tr>
    </table>
<?php } ?>

<script>
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
    $('.js-example-placeholder-single').on('select2:select', function(e) {
        var data = e.params.data;


        $.ajax({
            url: 'ajax/change_stores_change_status.php',
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: {
                'status': data.id,
                'id': data.element.attributes['data-attrchangeid'].value
            },
            success: function(data, textStatus, jQxhr) {
                // if( data === "success") {
                //     alert(data);
                //var url = 'reports.php?from=<?php //echo"".$_GET['from'].""; 
                                                ?>//&to=<?php //echo"".$_GET['to'].""; 
                                                                                        ?>//&orderby=id&type=<?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} 
                                                                                                                                            ?>//&page=<?php //echo"".$_GET['page'].""; 
                                                                                                                                                                                                                                                                ?>//'+'&inv='+'<?php //echo"".$_GET['inv'].""; 
                                                                                                                                                                                                                                                                                                                ?>//'+'&UerID='+'<?php //echo"".$_GET['UerID'].""; 
                                                                                                                                                                                                                                                                                                                                                                ?>//'+'&region_id='+'<?php //echo"".$_GET['region_id'].""; 
                                                                                                                                                                                                                                                                                                                                                                                                                        ?>//'+'&reports=stores_change';
                // window.open(url, '_blank');
                // $('#response').html( data );
                // var $container = $("#data");
                // $container.load('multi_items_stores_change.php');
                location.reload();

                // }else{
                //     alert(no)
                // }
            },
            error: function(jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });


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

        var url = 'pdf/export/stores_change_print.php?ids=' + ids + '&from=' + $('#from').val() + '&to=' + $('#to').val();
        window.open(url, '_blank');
    });
</script>