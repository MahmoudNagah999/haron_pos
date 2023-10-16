<?php
include"includes/inc.php";
?>
   <div style="width:100%; padding-top:0px; text-align:center; margin:0 auto;border:0px dashed #CCC; border-radius:5px; height:290px; overflow:auto;">
           <form method="post">
 <?php
 
                                        $result_SupplierID = mysqli_query($con, "SELECT SupplierID FROM " . $prefix . "_sales_temporary limit 0,1");
                                        if (@mysqli_num_rows($result_SupplierID) > 0) {
                                            while ($row_SupplierID = mysqli_fetch_array($result_SupplierID)) {
                                                $result_search_client = mysqli_query($con, "SELECT id,name FROM " . $prefix . "_clients WHERE id=" . $row_SupplierID['SupplierID'] . "");
                                                if (@mysqli_num_rows($result_search_client) > 0) {
                                                    while ($row_search_client = mysqli_fetch_array($result_search_client)) {
                                                        echo"\r\n";
                                                        echo'<div style="font-size:16px;"><span dir="rtl">'.$Modify_lang.': </span> 
			<span style="color:#7D060F;" dir="rtl">' . $row_search_client['name'] . '</span></div>';
                                                        echo'<input type="hidden" name="SupplierID" value="' . $row_search_client['id'] . '" />';
                                                    }
                                                }
                                            }
                                        }
                                        ?> 
   <table  border="1" style="font-size:16px; width:100%;  direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;">
<thead>
<th width="5%" class="text-center"><?php echo"$Serial_lang"; ?></th>
<th width="35%" class="text-center">الصنف</th>
<?php
if ($Retail_allow == "1") {
    echo"<th class='text-center'>النوع</th>";
}
?>  
<th class="text-center">الكمية</th>
<?php if ($use_sizes == 1) {
    echo'<th class="text-center">المقاس</th>';
} ?>
<?php if ($use_colors == 1) {
    echo'<th class="text-center">اللون</th>';
} ?>

<th class="text-center">السعر</th>
<th class="text-center">الخصم</th>
<th class="text-center">الاجمالى</th>
<th class="text-center">حذف</th>
</thead>
<tbody>
    <?php
    $tbl_name = "" . $prefix . "sales_temporary";
    //your table name
    // How many adjacent pages should be shown on each side?
    $adjacents = 3;

    /*
      First get total number of rows in data table.
      If you have a WHERE clause in your query, make sure you mirror it here.
     */
    $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_sales_temporary order by id DESC";
    $total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
    $total_pages = $total_pages[num];

    /* Setup vars for query. */
    $targetpage = "limit=" . $_GET['limit'] . "";
    //your file name  (the name of this file)
    //how many items to show per page
    if (!empty($_GET['limit'])) {
        $_SESSION[limit] = $_GET['limit'];
    } else {
        
    }
    if (!empty($_SESSION[limit])) {
        $limit = $_SESSION[limit];
        if ($limit > 100) {
            $limit = 20;
        }
    } else {
        $limit = 100;
    }
    $page = $_GET['page'];
    if ($page)
        $start = ($page - 1) * $limit;
    //first item to display on this page
    else
        $start = 0;
    //if no page var is given, set start to 0

    /* Get data. */
    $sql = "SELECT * FROM " . $prefix . "_sales_temporary  order by id DESC";

    $result = @mysqli_query($con, $sql);
    /* Setup page vars for display. */
    if ($page == 0)
        $page = 1;
    //if no page var is given, default to 1.
    $prev = $page - 1;
    //previous page is page - 1
    $next = $page + 1;
    //next page is page + 1
    $lastpage = ceil($total_pages / $limit);
    //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;
    //last page minus 1

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
        if ($lastpage < 7 + ($adjacents * 2)) {//not enough pages to bother breaking it up
            for ($counter = 1; $counter <= $lastpage; $counter++) {
                if ($counter == $page)
                    $pagination .= "<span class=\"current\">$counter</span>";
                else
                    $pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
            }
        } elseif ($lastpage > 5 + ($adjacents * 2)) {//enough pages to hide some
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
    $i = 1;
    while ($row = @mysqli_fetch_array($result)) {
        ###########

        $result_it = mysqli_query($con, "SELECT * FROM items where id=" . $row['item'] . "");
        if (@mysqli_num_rows($result_it) > 0) {
            while ($row_it = mysqli_fetch_array($result_it)) {
                $item_name = $row_it['item'];
                $item_id = $row_it['id'];
                $item_price = $row_it['Retail_price'];
                $item_Discount = $row_it['Discount'];
                $item_BuyPrice = $row_it['price'];
            }
        }
        if ($item_Discount == null) {
            $item_Discount = 0;
        }
        /* 								if ($row['Quantity'] < 1) {
          $row['Quantity'] = 1;
          } */

        if ($item_Discount == null) {
            $item_Discount = 0;
        }
        $sumTotal+= $row['Total'];
        ###########
        #############تحديث سعر البيع#####
        if ($Update_SellBuyPrice == 1) {
            if ($row['sales_type'] == "1") {
                mysqli_query($con, "UPDATE items SET Retail_price='" . $row['Price'] . "' where id='" . $row['item'] . "'");
            } else {
                mysqli_query($con, "UPDATE items SET subprice='" . $row['Price'] . "' where id='" . $row['item'] . "'");
            }
        }
###############################################################################
        echo'<input type="hidden" name="BuyPrice' . $row['id'] . '" value="' . $item_BuyPrice . '" /><tr>
							<td>' . $i . '</td>
							<td><input type="hidden" name="item' . $row['id'] . '" value="' . $item_id . '" />' . $item_name . '</td>';
        if ($Retail_allow == "1") {
            echo'<td>';
            echo'<select name="sales_type' . $row['id'] . '" style="width:10%; height:20px; text-align:center;border:0px; background-color:#E1E1E1;">';
            ?>
        <option value="0" <?php
        if ($row['sales_type'] == "0") {
            echo' selected="selected"';
        }
            ?>>اختر النوع</option>
        <option value="1" <?php
                if ($row['sales_type'] == "1") {
                    echo' selected="selected"';
                }
                ?>>جملة</option>
        <option value="2" <?php
                if ($row['sales_type'] == "2") {
                    echo' selected="selected"';
                }
                ?>>تجزئة</option>
                <?php
                echo'</select></td>';
            }
            echo'<td><input type="number" name="quantity' . $row['id'] . '"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px; background-color:#E1E1E1;"/></td>';
            if ($use_sizes == 1) {
                echo'<td><select name="size' . $row['id'] . '" style="height:25px; text-align:center;border:0px; background-color:#E1E1E1;">';
                $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (" . rtrim(get_sizes_of_item($item_id), ",") . ") limit 15");
                $num_sizes = @mysqli_num_rows($result_sizes);
                if ($num_sizes > 0) {
                    while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                        if ($row['size'] == $row_sizes['id']) {
                            echo '<option value="' . $row_sizes['id'] . '" selected >' . $row_sizes['size'] . '</option >';
                        } else {
                            echo '<option value="' . $row_sizes['id'] . '">' . $row_sizes['size'] . '</option >';
                        }
                    }
                }

                echo'</select></td>';
            }
             if ($use_colors == 1) {
            echo'<td><select name="color' . $row['id'] . '" style="height:25px; text-align:center;border:0px; background-color:#E1E1E1;">';
            $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (" . rtrim(get_clolors_of_item($item_id), ",") . ")  ");
            $num_colors = @mysqli_num_rows($result_colors);
            if ($num_colors > 0) {
                while ($row_colors = mysqli_fetch_array($result_colors)) {
                    if ($row['color'] == $row_colors['id']) {
                        echo '<option value="' . $row_colors['id'] . '" selected >' . $row_colors['color'] . '</option >';
                    } else {
                        echo '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
                    }
                }
            }
            echo'</select></td>';
             }
            echo'<td><input type="text"  name="price' . $row['id'] . '" id="price' . $i . '" value="' . $row['Price'] . '"  style="width:10%; height:20px;text-align:center;border:0px; background-color:#E1E1E1;" /></td>
							<td><input type="text"  name="discount' . $row['id'] . '" id="discount' . $i . '" value="' . $row['Discount'] . '"  style="width:10%; height:20px;text-align:center;border:0px; background-color:#E1E1E1;" /></td>
							<td><input type="text"  name="subtotal' . $row['id'] . '" id="subtotal' . $i . '" value="' . $row['Total'] . '"  style="width:10%; height:20px;text-align:center;border:0px; background-color:#E1E1E1;" /></td>
							<td valign="middle"><a href="sales.php?del=' . $row['id'] . '"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';
            $i++;
        }
        ?>
</tbody>
<?php
if ($sumTotal == null) {
    
} else {
    echo'<tr>';

    if ($use_sizes == 1) {
        
       if ($use_colors == 1) {echo'<td colspan="8">الاجمالى</td>'; }else{ echo'<td colspan="7">الاجمالى</td>'; }
    } else {
       if ($use_colors == 1) {echo'<td colspan="7">الاجمالى</td>'; }else{ echo'<td colspan="6">الاجمالى</td>'; }
    }
    echo'<td><font style="color:#060; font-weight:bold;">' . ($sumTotal - $alldiscount) . '</font></td>
                            <td></td>
                            </tr>';
}
?>
   </table>
                              <input type="submit" name="submit" value="submit" hidden="hidden" />

                                </div>
                                <table width="100%" dir="rtl">
                                    <tr>
                                        <td style="font-size:16px;">طريقة الدفع</td>
                                        <td><select name="pay"   style="text-align:center;background-color:#CCC; float:right;">
                                                <option value="1" <?php
                                            if ($_POST['pay'] == "1") {
                                                echo ' selected="selected"';
                                            }
                                            ?>>نقدى</option>
                                                <option value="2" <?php
                                            if ($_POST['pay'] == "2") {
                                                echo ' selected="selected"';
                                            }
                                            ?>>اجل</option>
                                                <option value="3" <?php
                                            if ($_POST['pay'] == "3") {
                                                echo ' selected="selected"';
                                            }
                                            ?>>شيك</option>
                                            </select></td>
                                        <td style="font-size:16px;">المبلغ المدفوع</td>
                                        <td style="font-size:16px;"><input type="text" name="paid" value="<?php echo"" . $_POST['paid'] . ""; ?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>
                                        <td style="font-size:16px;">التاريخ</td>
                                        <td><input type="date" name="date" id="date" value="<?php if ($_POST['date'] == "") {
                                                echo date("d/m/Y");
                                            } else {
                                                echo"" . $_POST['date'] . "";
                                            } ?>"  style="text-align:center; background-color:#CCC; width:80px; height:20px;"/>
                                            <script type="text/javascript">
                                                $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:16px;">خصم</td>
                                        <td colspan="6"><input type="text" name="alldiscount" value="<?php echo"" . $_POST['alldiscount'] . ""; ?>"  style="text-align:center; background-color:#CCC; width:50px; height:20px;"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" align="center"><span style=" text-align:center; margin-right:50px;">
                                                <input type="submit" name="submit" value="<?php echo ($sumTotal - $alldiscount); ?>"  style="width:120px; height:40px;" />
                                            </span></td>
                                    </tr>
                                </table>                           

