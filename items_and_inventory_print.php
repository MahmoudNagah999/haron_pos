<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php include"includes/css.php"; ?>
</head>
<body  onload="window.print()" >

<table width="101%" border="1"    class="container" id="container" style="font-size: 16px; width: 100%; direction: rtl; border: 1px; border-collapse: collapse; margin-top: 10px;text-align:center; table-layout: fixed;">
    <thead style="background-color:#CCC;">
    <th colspan="5" style="width:5%;" class="text-center"> <?php echo get_store_data($_GET['store_id'])[name] ; ?> - <?php echo date('Y-m-d') ; ?></th>
    </thead>
</table>
<table width="101%" border="1"    class="container" id="container" style="font-size: 16px; width: 100%; direction: rtl; border: 1px; border-collapse: collapse; margin-top: 10px;text-align:center; table-layout: fixed;">
    <thead style="background-color:#CCC;">
    <th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>

    <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><?php echo"$Code_lang"; ?></th>

    <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="item"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="item"){echo"sort_d";}else{echo"sort0";}?>"><?php echo"$the_items_lang"; ?></th>

    <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="groupid"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="groupid"){echo"sort_d";}else{echo"sort0";}?>"><?php echo"$the_Group"; ?></th>

    <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Quantity"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Quantity"){echo"sort_d";}else{echo"sort0";}?>"><?php echo"$the_Quantity_lang"; ?></th>
    <!--  <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="price"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="price"){echo"sort_d";}else{echo"sort0";}?><!--"><a href="?groups=--><?php //echo"".$_GET['groups'].""; ?><!--&search=--><?php //echo"".$_GET['search'].""; ?><!--&limit=--><?php //echo"".$_GET['limit'].""; ?><!--&orderby=price&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?><!--&page=--><?php //echo"".$_GET['page'].""; ?><!--" class="a_remove_underlines">--><?php //echo"$Purchasing_price_lang"; ?><!--</a></th>-->

    <!--  <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="Retail_price"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Retail_price"){echo"sort_d";}else{echo"sort0";}?><!--"><a href="?groups=--><?php //echo"".$_GET['groups'].""; ?><!--&search=--><?php //echo"".$_GET['search'].""; ?><!--&limit=--><?php //echo"".$_GET['limit'].""; ?><!--&orderby=Retail_price&type=--><?php //if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?><!--&page=--><?php //echo"".$_GET['page'].""; ?><!--" class="a_remove_underlines">--><?php //echo"$Selling_price_lang"; ?><!--</a></th>-->

<!--    <th  class="text-center --><?php //if($_GET['type']=="ASC" and $_GET['orderby']=="Discount"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Discount"){echo"sort_d";}else{echo"sort0";}?><!--">--><?php //echo"$the_Discount_lang"; ?><!--</th>-->
    <?php
    $store_id=$_GET['store_id'];
    $search=$_GET['search'];
    $orderby=$_GET['orderby'];
    $type=$_GET['type'];
    if($orderby==null){$orderby="id";}
    if($type==null){$type="DESC";}
    ###########################################
    $tbl_name="items";		//your table name
    // How many adjacent pages should be shown on each side?
    $adjacents = 3;

    /*
       First get total number of rows in data table.
       If you have a WHERE clause in your query, make sure you mirror it here.
    */
    if ($_GET['search'] == "" or $_GET['search'] == null) {
        if ($_GET['groups'] == "" or $_GET['groups'] == null) {
            $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") ";
        } else {
            if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") and  groupid='" . $_GET['groups'] . "' and companies=='" . $_GET['companies'] . "' ";
            } else {
                $query = "SELECT COUNT(*) as num  FROM  items  where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "'  ";
            }
        }
    } else {
        $query = "SELECT COUNT(*) as num  FROM  items where id NOT IN(".get_hide_items().") and  id='$search'  and groupid='" . $_GET['groups'] . "'  ";
    }
    $total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
    $total_pages = $total_pages[num];
    /* Setup vars for query. */
    $targetpage = "?groups=".$_GET['groups']."&search=".$_GET['search']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
    //how many items to show per page
    if(!empty($_GET['limit'])){
        $_SESSION[limit]=$_GET['limit'];
    }else{}
    if(!empty($_SESSION[limit])){
        $limit = $_SESSION[limit];
        if($limit>100){$limit=$items_per_page;}
    }else{
        $limit = $items_per_page;
    }
    $page = $_GET['page'];
    if($page)
        $start = ($page - 1) * $limit; 			//first item to display on this page
    else
        $start = 0;								//if no page var is given, set start to 0

    /* Get data. */
    if ($orderby == "item") {
        /* 			SELECT
          A.id AS Id,
          A.nome AS Nome,
          JT.id as OB_FIELD
          FROM main_table A
          JOIN joined_table JT ON JT.id = A.id_cat

          ORDER BY OB_FIELD */
        if ($_GET['search'] == "" or $_GET['search'] == null) {
            if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") ";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' ";
                }
            } else {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "' ";
                } else {
                    $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and groupid='" . $_GET['groups'] . "' ";
                }
            }
        }
        else {
            if ($_GET['groups'] == null) {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  ";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'  ";
                }
            } else {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'   and groupid='" . $_GET['groups'] . "' ";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'   and groupid='" . $_GET['groups'] . "' ";
                }
            }
        }
    }
    else if ($orderby == "groupid") {
        if ($_GET['search'] == "" or $_GET['search'] == null) {
            if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                $sql = "SELECT i.id as id,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  order by g.GroupName  $type";
            } else {
                if ($_GET['groups'] == null) {
                    if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                        $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid order by g.GroupName  $type";
                    } else {
                        $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid order by g.GroupName  $type";
                    }
                } else {
                    if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                        $sql = "SELECT i.id as id,i.groupid as groupid,i.companies as companies,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid where groupid='" . $_GET['groups'] . "' order by g.GroupName  $type";
                    } else {
                        $sql = "SELECT i.id as id,i.groupid as groupid,i.companies as companies,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid where groupid='" . $_GET['groups'] . "' order by g.GroupName  $type";
                    }
                }
            }
        } else {
            if ($_GET['groups'] == null) {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   order by g.GroupName  $type";
                } else {
                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   order by g.GroupName  $type";
                }
            } else {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   and groupid='" . $_GET['groups'] . "' order by g.GroupName  $type";
                } else {
                    $sql = "SELECT i.id as id,i.companies as companies,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i  where companies='" . $_GET['companies'] . "' JOIN " . $prefix . "_groups g ON g.id=i.groupid  where id='$search'   and groupid='" . $_GET['groups'] . "' order by g.GroupName  $type";
                }
            }
        }
    }
    else {
        if ($_GET['search'] == "" or $_GET['search'] == null) {
            if ($_GET['groups'] == "" or $_GET['groups'] == null) {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") order by $orderby+0 $type";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and  companies='" . $_GET['companies'] . "' order by $orderby+0 $type";
                }
            } else {
                if ($_GET['groups'] == null) {
                    if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                        $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") order by $orderby+0 $type";
                    } else {
                        $sql = "SELECT * FROM items  where id NOT IN(".get_hide_items().") and  companies='" . $_GET['companies'] . "' order by $orderby+0 $type";
                    }
                } else {
                    if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                        $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and groupid='" . $_GET['groups'] . "'  order by $orderby+0 $type";
                    } else {
                        $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and groupid='" . $_GET['groups'] . "'  order by $orderby+0 $type";
                    }
                }
            }
        } else {
            if ($_GET['groups'] == null) {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  order by $orderby+0 $type";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and id='$search'  order by $orderby+0 $type";
                }
            } else {
                if ($_GET['companies'] == "" or $_GET['companies'] == null) {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and id='$search'  and groupid='" . $_GET['groups'] . "' order by $orderby+0 $type";
                } else {
                    $sql = "SELECT * FROM items where id NOT IN(".get_hide_items().") and companies='" . $_GET['companies'] . "' and  id='$search'  and groupid='" . $_GET['groups'] . "' order by $orderby+0 $type";
                }
            }
        }
    }


    $result = @mysqli_query($con,$sql);
    /* Setup page vars for display. */
    if ($page == 0) $page = 1;					//if no page var is given, default to 1.
    $prev = $page - 1;							//previous page is page - 1
    $next = $page + 1;							//next page is page + 1
    $lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;						//last page minus 1

    /*
        Now we apply our rules and draw the pagination object.
        We're actually saving the code to a variable in case we want to draw it more than once.
//    */
//    $pagination = "";
//    if($lastpage > 1)
//    {
//        $pagination .= "<div class=\"pagination\">";
//        //previous button
//        if ($page > 1)
//            $pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
//        else
//            $pagination.= "<span class=\"disabled\">>></span>";
//
//        //pages
//        if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
//        {
//            for ($counter = 1; $counter <= $lastpage; $counter++)
//            {
//                if ($counter == $page)
//                    $pagination.= "<span class=\"current\">$counter</span>";
//                else
//                    $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
//            }
//        }
//        elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
//        {
//            //close to beginning; only hide later pages
//            if($page < 1 + ($adjacents * 2))
//            {
//                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
//                {
//                    if ($counter == $page)
//                        $pagination.= "<span class=\"current\">$counter</span>";
//                    else
//                        $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
//                }
//                $pagination.= "...";
//                $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
//                $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
//            }
//            //in middle; hide some front and some back
//            elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
//            {
//                $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
//                $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
//                $pagination.= "...";
//                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
//                {
//                    if ($counter == $page)
//                        $pagination.= "<span class=\"current\">$counter</span>";
//                    else
//                        $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
//                }
//                $pagination.= "...";
//                $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
//                $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
//            }
//            //close to end; only hide early pages
//            else
//            {
//                $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
//                $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
//                $pagination.= "...";
//                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
//                {
//                    if ($counter == $page)
//                        $pagination.= "<span class=\"current\">$counter</span>";
//                    else
//                        $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
//                }
//            }
//        }
//
//        //next button
//        if ($page < $counter - 1)
//            $pagination.= "<a href=\"$targetpage&page=$next\"><<</a>";
//        else
//            $pagination.= "<span class=\"disabled\"><<</span>";
//        $pagination.= "</div>\n";
//    }
    ###############
    $i=0;
    while($row = @mysqli_fetch_array($result))
    {
        #################
        $Groups_list = mysqli_query($con, "SELECT product_name FROM products where id=" . $row['groupid'] . "");
        $num_Groups_list = mysqli_num_rows($Groups_list);
        if ($num_Groups_list > 0) {
            while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                $row_Groups = $row_Groups_list['product_name'];
            }
        }
        $issingle=$i/2;
        $dot = strstr($issingle, '.');
        if($dot==""){
            $class="background_color_FFF";
        }else{$class='background_color_D5EFF0';}

        $QuID=$row['Quantity']+GetQuantity($row['id']);




        $openQ = get_sum_product_store_data($row['id'], $_GET['store_id'])[Quantity] ;
        $all_qty0 = ($openQ + GetQuantity($row['id'],null , $store_id));
        $NumberBreakdown23 = NumberBreakdown($all_qty0, $returnUnsigned = false);
        $all_qty000 = (abs($NumberBreakdown23[1]) * $row['subqty']);
        $whole00 = $NumberBreakdown23[0];
        
        
//        $NumberBreakdown23=NumberBreakdown($QuID, $returnUnsigned = false);
//        $whole00=$NumberBreakdown23[0];
//        $qty000=(abs($NumberBreakdown23[1])*$row['subqty']);
if($whole00==0){}else{
        ?>


        <tr class="<?php echo"".$class.""; ?>">
            <td><input type="checkbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
            <td><?php echo"".$row['id'].""; ?></td>
            <td><?php echo"".$row['item'].""; ?></td>
            <td><?php echo"".$row_Groups.""; ?></td>
            <td><?php echo"".$whole00."";
            //','.round($qty000)."
            ?></td>
            <!--  <td>--><?php //echo"".$row['price'].""; ?><!--</div></td>-->
            <!--   <td>--><?php //echo"".$row['Retail_price'].""; ?><!--</td>-->
<!--            <td>--><?php //echo"".$row['Discount'].""; ?><!--</td>-->
        </tr>

        <?php } $i++; } ?>
    <thead style="background-color:#CCC;">
<!--    <th colspan="6">--><?php //echo"$pagination"; ?><!--</th>-->
</table>
</body>
</html>
<?php include 'includes/footer.php'; ?>