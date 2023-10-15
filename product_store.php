<?php

include "includes/inc.php";

include"includes/buttons.php";


if (($_POST['submit']) == $Save_lang and $_POST['submit'] != null) {

    if ($_POST['item'] != "") {
         $sqlDel = "DELETE FROM " . $prefix . "_product_store where  item=".$_POST['item'];
        if (mysqli_query($con, $sqlDel)) {
        }
        else{
        }
    }
    ###################################
    mysqli_autocommit($con,FALSE);
    $result_upt = mysqli_query($con, "SELECT * FROM " . $prefix . "_store where id != ''  order by id DESC");
    while ($row_upt = mysqli_fetch_array($result_upt)) {
        $quantityt = $_POST[quantity . $row_upt['id']];
        $store_id = $_POST[store_id . $row_upt['id']];
        ###############################################

        $_POST['date'] = str_replace("/", "-", $_POST['date']);
        $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));


        $CheckNumber = '';

        if ($_POST['item'] == "") {
            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							' . $must_type_item . '
							</div>';
        } else {
            $mysqli_errno = 0 ;
            ######################
            $insertSql = "INSERT INTO " . $prefix . "_product_store(item,Quantity, date,store_id,user_id)
VALUES ('" . $_POST['item'] . "','" . $quantityt . "','" . $DueDate . "','" .$store_id . "','" . $user_id . "')";
            if (mysqli_query($con, $insertSql)) {
                ###############
            } else {
                $mysqli_errno++;            }
######################
        }
    }
    if($mysqli_errno>0){ mysqli_rollback($con);

        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$error_lang.'
							</div>';

    }
    else{
        mysqli_commit($con);
        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Done_lang.'
							</div>';
        header("refresh:1;url=product_store.php?item=".$_POST['item']);

    }


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="js/shortcut_.js"></script>


    <title><?php echo"" . $get_db_CompanyName . ""; ?></title>

    <?php include"includes/css.php"; ?>
    <?php include"includes/js.php"; ?>
</head>
<?php

if (isset($_POST['item'])){

    $item_id = $_POST['item'];
}elseif (isset($_GET['item'])){

    $item_id = $_GET['item'];
}else{
    $item_id = Null ;
}

?>
<body class="cmenu1 example-target" style="text-align: center">

<form method="post" id="inv_form">

                            <?php
                            $sql = "SELECT * FROM " . $prefix . "_offers_temporary where user_id='$user_id' order by id DESC";
                            $result = @mysqli_query($con, $sql);
                            ?>

                            <div class="row" dir="rtl">
                                <div class="col-6" >

                                    <label><?php echo $the_Item_lang;?></label>
                                    <select style="width: 20%" name="item" size="1" class="js-example-placeholder-single   js-states form-control">
                                        <option value=""> <?php echo"$the_Item_lang"; ?></option>
                                        <?php
                                        $ProductsName = mysqli_query($con, "SELECT * FROM items order by OrderNo DESC ");
                                        $num_item = mysqli_num_rows($ProductsName);
                                        if ($num_item > 0) {
                                            while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                if ($row_item['id'] == $item_id) {
                                                    echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['item'] . '</option>';
                                                } else {
                                                    echo'<option value="' . $row_item['id'] . '">' . $row_item['item'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <br/>
                                    <br/>
                                    <br/>
                                </div>
                            </div>

<div id="ajaxRes">
</div>

    <?php
    if ($item_id){
    ?>
                            <table  border="1" style=" float: right; font-size:16px; width:50%;  direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;">

                                <thead style="background-color:#0076EA; color:#fff;">
                                <th width="5%" class="text-center"><?php echo"$Serial_lang"; ?></th>
                                <th width="35%" class="text-center"><?php echo"$Store_name"; ?></th>
                                <?php
                                if ($Retail_allow == "1") {
                                    echo"<th class='text-center'>$the_Type_lang</th>";
                                }
                                ?>
                                <th  width="35%" class="text-center"><?php echo"$the_Quantity_lang"; ?></th>
                                </thead>
                                <tbody id="tablee">
                                <?php
                                $sql = "SELECT * FROM " . $prefix . "_store where id != '' order by id DESC";
                                $result = @mysqli_query($con, $sql);
                                $tbl_name = "" . $prefix . "_store";
                                //your table name
                                // How many adjacent pages should be shown on each side?
                                $adjacents = 3;

                                /*
                                  First get total number of rows in data table.
                                  If you have a WHERE clause in your query, make sure you mirror it here.
                                 */
                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_store where id != ''  order by id DESC";
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

###############################################################################
                                    $quantity_post = 0 ;
                                    if($_POST['submit'] ){
                                      $quantity_post=$_POST['quantity'. $row['id']]  ;
                                  }else{
                                      $quantity_post=get_product_store_data($item_id , $row['id'])[Quantity];

                                  }
echo '							<td>' . $i . '</td>';
                                    echo'<td><input  disabled="disabled" type="text" name="store_name' . $row['id'] . '"  value="' . $row['name'] . '" style="width:50%; height:20px; text-align:center;border:0px;"/></td>';
                                    echo'<td hidden><input  type="text" name="store_id' . $row['id'] . '"  value="' . $row['id'] . '" style="width:50%; height:20px; text-align:center;border:0px;"/></td>';
                                    echo'<td><input  type="text" name="quantity' . $row['id'] . '"  value="' . $quantity_post. '" style="width:35%; height:20px; text-align:center;border:0px;"/></td>';
                                  
							echo '</tr>';
                                    $i++;
                                }
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <input  type="submit" name="submit" value="<?php echo $Save_lang  ;?>" class="btn btn-primary"  id="inv_sub" />

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <br/>
<div style="text-align: center">
    <input type="hidden" name="date" id="date" value="<?php if ($_POST['date'] == "") {
        echo date("d/m/Y");
    } else {
        echo"" . $_POST['date'] . "";
    } ?>"  style="text-align:center; background-color:#CCC; width:80px; height:20px;"/>
    <script type="text/javascript">
        $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
    </script>
</div>
    <?php
    }
    ?>
                    </div>

</form>
</body>
</html>
<script>
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    })        .on("change", function (e) {
        var selected_element = $(e.currentTarget).val();
        window.location.replace("product_store.php?item="+selected_element);

    });;
    ;
</script>