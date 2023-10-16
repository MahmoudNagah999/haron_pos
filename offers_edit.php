<?php
include "includes/inc.php";
$inv_id=$_GET['id'];
$data=get_offers_data($inv_id);
if($data[id]==null){
     header("refresh:0;url=index.php");
    die();}
########################
if (isset($_GET['cat_show'])) {
    mysqli_query($con, "UPDATE " . $prefix . "_config SET cat_items_show=" . $_GET['cat_show'] . " where id=" . $get_db_id . "");
    header("refresh:0;url=offers_edit.php?id=".$_GET['id']."");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <script>
            function popupCenter(pageURL, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
               <script type="text/javascript" src="js/shortcut_.js"></script>


        <script>
            function showResultsOfItems(str) {
                if (str.length == 0) {
                    document.getElementById("livesearch").innerHTML = "";
                    document.getElementById("livesearch").style.border = "0px";
                    return;
                }
                if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {// code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                        document.getElementById("livesearch").style.border = "0px solid #A5ACB2";
                    }
                }
                xmlhttp.open("GET", "items_search.php?id=<?php echo $_GET['id']; ?>&q=" + str, true);
                xmlhttp.send();
            }
        </script>
                <title><?php echo"" . $get_db_CompanyName . ""; ?></title>

        <script type="text/javascript">

            // $(function () {
            //     // Set up the number formatting.
            //
            //     $('#number_container').slideDown('fast');
            //
            //     $('#price').on('change', function () {
            //         console.log('Change event.');
            //         var val = $('#price').val();
            //         $('#the_number').text(val !== '' ? val : '(empty)');
            //     });
            //
            //     $('#price').change(function () {
            //         console.log('Second change event...');
            //     });
            //
            //     $('#price').number(true, 0, ',', '');
            //
            //
            //     // Get the value of the number for the demo.
            //     $('#get_number').on('click', function () {
            //
            //         var val = $('#price').val();
            //
            //         $('#the_number').text(val !== '' ? val : '(empty)');
            //     });
            // });
        </script>
        <?php include"includes/css.php"; ?>
<?php include"includes/js.php"; ?>
    </head>

    <body class="cmenu1 example-target">

            <div>
                <div>
                    <?php
                    if (isset($_GET['offers_cat'])) {
                        mysqli_query($con, "UPDATE " . $prefix . "_config SET offers_cat_items_show=" . $_GET['offers_cat'] . " where id=" . $get_db_id . "");
                        header("refresh:0;url=offers_edit.php?id=".$_GET['id']."");
                    }
                    ?>
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

        <div id='main'  class="noprint">
            <article style="margin-bottom:70px;">
                <?php
                if ($user_edit_offers !== "1" and $user_IsAdmin != 1) {
                    echo"<div style='margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;'>'.$not_have_permission_lang.'</div>";
                } else {
                    ?>
                    <div class="noprint">
                        <div style="width:60%;border:1px solid #CCC; border-radius:5px; float:right; ">
                            <div>
                               <div id="livesearchcl" style="z-index:1000000000; width:45%;  text-align:right; margin-top:30px;  float:right; position:fixed; border:0px; "></div>
                                <div style="width:100%; padding-top:0px; text-align:center; margin:0 auto;border:0px dashed #CCC; border-radius:5px; height:290px; overflow:auto;">
                                    <?php
                                    if (($_POST['submit']) == $Save_lang and $_POST['submit'] != null) {
                                        ###################################

                                        $result_upt = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers where inv_id='$inv_id' order by id DESC");

                                        while ($row_upt = mysqli_fetch_array($result_upt)) {
                                            //echo $row_up['id'];
                                            $quantityt = $_POST[quantity . $row_upt['id']];
                                        }
                                        ###############################################

                                        $_POST['date'] = str_replace("/", "-", $_POST['date']);
                                        $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));
                                        $CheckNumber = '';
                                        ##########مدفوعات العملاء############
									//	echo ($inv_Totalt);
//                                        if ($_POST['SupplierID'] == "" and $paid != $total_inv_after_alldiscount_and_tax) {
//                                            //print $paid;
//                                            echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
//							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
//							'.$must_choose_customer.'
//							</div>';
//                                        } else {
                                            ######################
                                            $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers where inv_id='$inv_id' order by id DESC");
                                            while ($row_up = mysqli_fetch_array($result_up)) {
                                                //echo $row_up['id'];
                                                $item = round($_POST[item . $row_up['id']]);
                                                $quantity = $_POST[quantity . $row_up['id']];

                                                 $updateSqlStatement="UPDATE " . $prefix . "_offers SET Quantity='" . $quantity . "',
date='" . $DueDate . "' where user_id='$user_id' and id='" . $row_up['id'] . "'";
if (mysqli_query($con, $updateSqlStatement)) {
#############التأثير على المخزون###########
//if(mysqli_query($con, "UPDATE items SET Quantity=Quantity-$quantity where  id='".$row_up['item']."'")){}
###########################################
        header("refresh:0;url=offers_edit.php?id=".$_GET['id']."");
                                                }
                                                //echo"echo mysqli_errno($con);<br />";
                                            }
                                            ######################
####
//                                        }
                                    }

                                    if ($_GET['del'] !== null) {
                                        if (mysqli_query($con, "DELETE FROM " . $prefix . "_offers where id=" . $_GET['del'] . "")) {
                                            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Item_deleted_lang.'
							</div>';
                                            header("refresh:0;url=offers_edit.php?id=".$_GET['id']."");
                                        }
                                    }
                                    if (isset($_POST['submit'])) {

                                        $submit_data=($_POST);
                               //         echo 555555555555;
 $date_edita=str_replace("/", "-", $_POST['date']);
$date_edit= Trim(date('Y-m-d', strtotime($date_edita)));
#####################################################
                                          $upSql = "UPDATE " . $prefix . "_offers_inv SET date='" . $date_edit ."',Total='" . $_POST['total'] ."',name='" . $_POST['name']   . "'  where inv_id='" . $inv_id . "' " ;
    mysqli_query($con, $upSql);
//mysqli_errno($con);
#####################################################
                                        $result_up = mysqli_query($con, "SELECT * FROM " . $prefix . "_offers where inv_id='$inv_id' order by id DESC");
                                        while ($row_up = mysqli_fetch_array($result_up)) {
                                            //echo $row_up['id'];
                                            $item = $_POST[item][$row_up['id']];
                                           $quantity = $_POST[quantity][$row_up['id']];

                                          //  echo $quantity;
                                         //   echo"<br />";
                                            if ($quantity == 0 or $quantity == ""  or $quantity == null) {
                                                $error_reports = 1;
                                            } else {
                                                mysqli_query($con, "UPDATE " . $prefix . "_offers SET  Quantity='" . $quantity . "',user_id='$user_id'  where id='" . $row_up['id'] . "'");
                                            }
                                            //echo"<br />";
                                        }
                                        header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                    }
                                    ###########################################
                                    if ($error_reports == "1") {
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$quantity_not_zero_lang.'
							</div>';
                                    }
                                    ?>
                                    <?php
                                    if (isset($_GET['SupplierID']) and $_GET['SupplierID'] !== null) {
                                        $SupplierID = $_GET['SupplierID'];
                                        if (mysqli_query($con, "UPDATE ".$prefix."_offers SET SupplierID=".$SupplierID." where inv_id='$inv_id'")) {
                                            header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                        } else {
                                            echo"$Please_try_again_lang";
                                        }
                                    }
                                    if (isset($_GET['barcode']) and $_GET['barcode'] !== null and $_GET['barcode'] !== "'.$barcode_lang.'") {
                                        $get_barcode= explode("-", $_GET['barcode']);
                                        $get_barcode_code=$get_barcode[0];
                                        $get_barcode_size=$get_barcode[1];
                                        $get_barcode_color=$get_barcode[2];
                                        $result_barcode = mysqli_query($con, "SELECT id FROM items where Barcode='" . $get_barcode_code . "'");
                                        if (@mysqli_num_rows($result_barcode) >= 1) {
                                            while ($row_barcode = mysqli_fetch_array($result_barcode)) {
                                                $db_item_id = $row_barcode['id'];
                                            }
                                        }
//$db_item_id;
###################
######################
####################
                                        if ($_GET['barcode'] == null) {
                                            //	header( "refresh:0;url=offers.php" );
                                        } else {

                                                $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $db_item_id . "'");
                                                if (@mysqli_num_rows($result_new) >= 1) {

                                                    while ($row_new = mysqli_fetch_array($result_new)) {
                                                        $item_name_new = $row_new['item'];
                                                        $item_id_new = $row_new['id'];

                                            echo            $sql = "INSERT INTO " . $prefix . "_offers (item, Quantity, date, user_id)
							VALUES ('" . $item_id_new  . "','1','"  . $DueDate  . "','".$user_id."')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"></span>
							'.$not_saved_try_lang.'
							</div>';
                                                          header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                          header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                                    }
                                                } else {
                                                echo'<div class="alert alert-warning text-center">
							'.$item_not_found_lang.'
							 </div>';
                                                }

                                        }

#####################
#####################
#####################
                                    }

                                    if ($_GET['q'] == "d") {
                                        if (mysqli_query($con, "DELETE FROM " . $prefix . "_offers where user_id='$user_id'")) {
                                               header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                        }
                                    } else {
                                        if ($_GET['q'] == null) {
                                            //	header( "refresh:0;url=offers.php" );
                                        } else {
//                                            if(GetQuantity($_GET['q'],1)<=0){
//                                                  echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
//							<span style="float:left; padding-left:20px;"><img src="images/erase.png" style="border:0px;" /></span>
//							'.$no_stock_lang.'
//							</div>';
//                                            }else{
                                                $result_new = mysqli_query($con, "SELECT * FROM items where id='" . $_GET['q'] . "'");
                                                if (@mysqli_num_rows($result_new) >= 1) {

                                                    while ($row_new = mysqli_fetch_array($result_new)) {
                                                        $item_name_new = $row_new['item'];
                                                        $item_id_new = $row_new['id'];


                                                         $sql = "INSERT INTO " . $prefix . "_offers (item, Quantity,  date, user_id, inv_id)
							VALUES ('" . $item_id_new.  "','1','"  . $DueDate . "','".$user_id."','".$inv_id."')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"></span>
							'.$not_saved_try_lang.'
							</div>';
                                                           header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                          header("refresh:1;url=offers_edit.php?id=".$_GET['id']."");
                                                    }
                                                } else {
                                                    echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
                                                }
//                                        }
                                        }
                                    }
                                    ?>
                                    <form method="post">
                                        <?php
//                                        var_dump($data);
//                                        die();

                                     /*   $result_SupplierID = mysqli_query($con, "SELECT SupplierID FROM " . $prefix . "_offers where user_id='$user_id' limit 0,1");
                                        if (@mysqli_num_rows($result_SupplierID) > 0) {
                                            while ($row_SupplierID = mysqli_fetch_array($result_SupplierID)) {
                                                $result_search_client = mysqli_query($con, "SELECT id,name FROM " . $prefix . "_clients WHERE id=" . $row_SupplierID['SupplierID'] . "");
                                                if (@mysqli_num_rows($result_search_client) > 0) {
                                                    while ($row_search_client = mysqli_fetch_array($result_search_client)) {
                                                      echo" <span dir=\"rtl\"  style=\"color:#7D060F;\" dir=\"rtl\">$The_client_lang :".$row_search_client['name']."</span>";

                                                        echo'<input type="hidden" name="SupplierID" value="' . $row_search_client['id'] . '" />';
                                                    }
                                                }
                                            }
                                        }*/
                                        ?>

                                        <div class="row" dir="rtl">
                                            <div class="col-12" >

                                                <label><?php echo $the_name_lang;?></label>
                                                <input type="text" placeholder=" <?php echo"$the_name_lang"; ?>" name="name" value="<?php echo"" . $data['name'] . ""; ?>"  />
                                                <br/>
                                                <br/>
                                                <br/>
                                            </div>
                                        </div>
                                        <table  border="1" style="font-size:16px; width:100%;  direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;">

                                            <thead style="background-color:#0076EA; color:#fff;">
                                            <th width="5%" class="text-center"><?php echo"$Serial_lang"; ?></th>
                                            <th width="35%" class="text-center"><?php echo"$the_Item_lang"; ?></th>
                                                <?php
                                                if ($Retail_allow == "1") {
                                                    echo"<th class='text-center'>$the_Type_lang</th>";
                                                }
                                                ?>
                                            <th class="text-center"><?php echo"$the_Quantity_lang"; ?></th>
                                           <?php if($use_sizes==1){echo'<th class="text-center">'.$the_Size_lang.'</th>';} ?>
                                                       <?php if($use_sizes==1){echo'<th class="text-center">'.$the_Color_lang.'</th>';} ?>
                                            <th class="text-center"><?php echo"$Delete_lang"; ?></th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tbl_name = "" . $prefix . "offers";
                                                //your table name
                                                // How many adjacent pages should be shown on each side?
                                                $adjacents = 3;

                                                /*
                                                  First get total number of rows in data table.
                                                  If you have a WHERE clause in your query, make sure you mirror it here.
                                                 */
                                                $query = "SELECT COUNT(*) as num  FROM  " . $prefix . "_offers where inv_id='$inv_id' order by id DESC";
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
                                                 $sql = "SELECT * FROM " . $prefix . "_offers where inv_id='$inv_id' order by id DESC";

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

                                                        }
                                                    }

                                                    /* 								if ($row['Quantity'] < 1) {
                                                      $row['Quantity'] = 1;
                                                      } */


                                                    ###########
###############################################################################
                                                    if(is_float($i/2)){
                                                        $gr="gr";
                                                    }else{
                                                        $gr="gr2";
                                                    }
                                                     echo'<input type="hidden" name="id[]" value="' . $row['id'] . '" />';
                                                    echo'<input type="hidden" name="BuyPrice[' . $row['id'] . ']" value="' . $item_BuyPrice . '" /><tr class="'.$gr.'">
							<td>' . $i . '</td>
							<td><input type="hidden" name="item[' . $row['id'] . ']" value="' . $item_id . '" />' . $item_name . '</td>';
                                                    if ($Retail_allow == "1") {
                                                        echo'<td>';
                                                        echo'<select  class="'.$gr.'"  name="offers_type[' . $row['id'] . ']" style="width:10%; height:20px; text-align:center;border:0px;>';
                                                        ?>
                                                    <option value="0" <?php if ($row['offers_type'][$row['id']] == "0") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Select_Type_lang"; ?></option>
                                                    <option value="1" <?php if ($row['offers_type'][$row['id']] == "1") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Wholesaling_lang"; ?></option>
                                                    <option value="2" <?php if ($row['offers_type'][$row['id']] == "2") {
                                            echo' selected="selected"';
                                        } ?>><?php echo"$Retail_lang"; ?></option>
                                                    <?php
                                                    echo'</select></td>';
                                                }
                                                echo'<td><input  class="'.$gr.'" type="text" name="quantity[' . $row['id'] . ']"  value="' . $row['Quantity'] . '" style="width:10%; height:20px; text-align:center;border:0px;"/></td>';
                                                if($use_sizes==1){
                                                echo'<td><select  class="'.$gr.'" name="size'.$row['id'].'" style="height:25px; width:10px; text-align:center;border:0px;">';
                                                                          $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (".rtrim(get_sizes_of_item($item_id), ",").") limit 15");
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
                                                 if($use_colors==1){
                                                                               echo'<td><select  class="'.$gr.'" name="color['.$row['id'].']" style="height:25px; text-align:center;border:0px;">';
                                  $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (".rtrim(get_clolors_of_item($item_id), ",").")  ");
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
                                                echo'<td valign="middle"><a href="offers_edit.php?id=' . $_GET['id'] . '&del=' . $row['id'] . '"><img src="images/erase.png" style="border:0px;" /></a></td>
							</tr>';
                                                $i++;
                                            }
                                            ?>
                                            </tbody>
    <?php
    if ($sumTotal == null) {

    } else {
        echo'<tr>';

     if($use_sizes==1){
       if ($use_colors == 1) {echo'<td colspan="7">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="6">'.$the_total_lang.'</td>'; }

     }else{
        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_lang.'</td>'; }
     }
                            echo'<td><font style="color:#060; font-weight:bold;">' . ($sumTotal) . '</font></td>
                            <td></td>
                            </tr>';

                                    echo'<tr>';


     if($use_sizes==1){
       if ($use_colors == 1) {echo'<td colspan="7">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="6">'.$the_total_after_lang.'</td>'; }

     }else{
        if ($use_colors == 1) {echo'<td colspan="6">'.$the_total_after_lang.'</td>'; }else{ echo'<td colspan="5">'.$the_total_after_lang.'</td>'; }
     }
     if($Discount_type==2){
         $print_total_disc=$sumTotal*$data['discount']/100;
     }
     else if($Discount_type==1){
        $print_total_disc=$_POST['alldiscount'];
     }else{}
                            echo'<td><font style="color:#060; font-weight:bold;">'.($sumTotal-$print_total_disc).'</font></td>
                            <td></td>
                            </tr>';
    }
//    echo"<tr>";
//    if($db_tax>0){
//    echo'<td  colspan="5">'.$tax_lang.'</td>
//                            <td><font style="color:#060; font-weight:bold;">'.(($sumTotal-$print_total_disc)*$db_tax/100).'</font></td><td></td>
//                            </tr>';
//        echo'<tr><td  colspan="5">'.$Total_after_TAX_lang.'</td>
//                            <td><font style="color:#060; font-weight:bold;">'.((($sumTotal-$print_total_disc)*$db_tax/100)+($sumTotal-$print_total_disc)).'</font></td><td></td>
//                            </tr>';
//    }
//     echo'<tr>';


                              #############################################

//     $updatessQl="UPDATE " . $prefix . "_offers_inv SET Total='" . $_POST['total']  . "'  where inv_id='" . $inv_id . "'";
//     mysqli_query($con, $updatessQl);

                              ##############################################
    ?>
                                        </table>

                                        <input type="submit" name="submit" value="submit" hidden="hidden" />

                                </div>
                                <table width="100%" dir="rtl">
                                    <tr>

                                        <td>
                                            <label><?php echo $the_total_lang;?></label></td>
                                        <td>
                                            <input type="text" placeholder=" <?php echo"$the_total_lang"; ?>" name="total" value="<?php echo"" . $data['Total'] . ""; ?>"  />

                                        </td>
                                        <td style="font-size:16px;" class="text-center">التــاريخ</td>
                                        <td><input type="text" name="date" id="date" value="<?php echo date("d/m/Y",strtotime($data[date])); ?>"  style="text-align:center; background-color:#CCC; width:80px; height:20px;"/>
                                            <script type="text/javascript">
                                                $('#date').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                            </script>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td colspan="6" align="center"><span style=" text-align:center; margin-right:50px;">
                                                <input type="submit" name="submit" value="<?php echo $Save_lang ; ?>"  style="width:120px; height:40px;" />
                                            </span></td>
                                    </tr>
                                </table>
                                <div style="text-align:right; float:right;">
                                    <div style="float:right; width:200px; margin-right:150px; vertical-align:middle;">




                                    </div>
                                    <div style="float:right; text-align:center; margin-right:50px;">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="inv" value="offers" />
                            </form>
                        </div>
                        <div style="width:100%;border:1px solid #CCC; border-radius:5px;">
                            <div style="height:500px; overflow:auto;">
                                <script>
                                    window.onload = function () {
                                        document.getElementById("barcode").focus();
                                    };

                                </script>
                                <form method="get" class="noprint" style="padding-bottom:20px;">
                                    <div class="text-center">
                                    <?php if ($run_barcode == 0) {

                                    } else { ?>
                                        <input type="text" value="<?php
                                        if ($_GET['barcode'] == null) {

                                        } else {
                                            echo "" . $_GET['barcode'] . "";
                                        }
                                        ?>"
                                         autofocus onfocus="this.select()" name="barcode" id="barcode"   style="background-color:#CCC; text-align: center;"
                       onblur="this.value=!this.value?'<?php echo"$barcode_lang"; ?>':this.value;"/>
                                    <?php } ?>
                                        <a href="#" onclick="javascript:void window.open('additems.php', '1390937502641', 'width=400,height=400,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');
                                                return false;">
                                            <i class="fa fa-plus-square"  title="<?php echo"$Add_New_item"; ?>"></i>
                                        </a>
                                        <span style="padding-right:20px;"></span><input type="text" value="<?php echo"$item_Name_lang"; ?>"  style="background-color:#CCC; z-index:100000000000;"  onkeyup="showResultsOfItems(this.value)" autocomplete="off"    onclick="this.value = '';" onfocus="this.select()"  onblur="this.value = !this.value ? '<?php echo"$item_Name_lang"; ?>' : this.value;"/>
                                        <div id="livesearch" style="z-index:1000000000; width:45%;  text-align:right; margin-top:0px;  float:right; position:fixed; border:0px; "></div>
                                        <input type="submit" hidden="hidden"/>
                                    <?php
                                    if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {

                                    } else {
                                      echo'<a href="?id='.$_GET['id'].'&cat_show=0"><i class="fa fa-list" title="'.$All_groups_lang.'"></i></a>';
                                    }
                                    ?>
                                    </div></form>
                                    <?php
                                    if ($showGroups == 0) {

                                    } else {
                                        ?>
                                        <?php if ($db_cat_items_show > 0) {

                                        } else { ?>
                                        <div style="width:100%; margin:0 auto; text-align:center; float:right; text-align:center;">

                                            <?php
                                            $result_cat = mysqli_query($con, "SELECT * FROM products where rank!='0' and rank!='' and id>0  order by rank ASC");
                                            if (@mysqli_num_rows($result_cat) >= 1) {
                                                while ($row_cat = mysqli_fetch_array($result_cat)) {
                                                    if ($row_cat['id'] == $db_cat_items_show) {
                                                        $class = "draggable-demo-product3";
                                                    } else {
                                                        $class = "draggable-demo-product2";
                                                    }
                                                    if ($row_cat['useimage'] == 1) {
                                                     echo "<div class=\"" . $class . " jqx-rc-all\" style='background-color:" . $row_cat['background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
<a href=\"?id=" . $_GET['id'] . "&cat_show=" . $row_cat['id'] . "\" class='a_cat_underlines'><img src=\"uploads/" . $row_cat['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"30\" /></a></div>

							</div>";

                                                    } else {
                                                       echo "<div   class=\"" . $class . " jqx-rc-all\" style='background-color:" . $row_cat['background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
							<div class=\"draggable-demo-product-header-label\"> <a href=\"?id=" . $_GET['id'] . "&cat_show=" . $row_cat['id'] . "\">" . $row_cat['product_name'] . "</a></div></div>

							</div>";

                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <?php } ?>
                                    <?php } ?>
                                <div id="items">
                                    <?php
                                    ###########################################
                                    $tbl_name = "items";
                                    //your table name
                                    // How many adjacent pages should be shown on each side?
                                    $adjacents = 3;

                                    /*
                                      First get total number of rows in data table.
                                      If you have a WHERE clause in your query, make sure you mirror it here.
                                     */
                                 //   if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                     //   $query = "SELECT COUNT(*) as num  FROM  items where OrderNo!='0' and OrderNo!=''  order by OrderNo ASC";
                                 //   } else {
                                        $query = "SELECT COUNT(*) as num  FROM  items  where OrderNo!='0' and OrderNo!='' and groupid=" . $db_cat_items_show . " order by OrderNo ASC";
                                  //  }
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
                                 //   if ($db_cat_items_show == 0 or $db_cat_items_show == null or $db_cat_items_show == "") {
                                  //      $sql = "SELECT * FROM items where OrderNo!='0' and OrderNo!='' order by OrderNo ASC";
                                 //   } else {
                                        $sql = "SELECT * FROM items where OrderNo!='0' and OrderNo!='' and groupid=" . $db_cat_items_show . "  order by OrderNo ASC";
                              //      }
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
                                    while ($row = @mysqli_fetch_array($result)) {

                                        if ($row['image'] == null or $row['useimage'] == 0) {
                                            ###################
                                            $qty_it=GetQuantity($row['id'],'1');
                                            echo "<div title= '$qty_it' class=\"draggable-demo-product jqx-rc-all\"  style='background-color:" . $row['Background'] . ";'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
							<div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\">" . $row['item'] . "</a></div></div>

							</div>";
                                            /* 	echo"<div class=\"draggable-demo-product jqx-rc-all\"  style='background-color:".$row['Background']."; height:50px;'>
                                              <div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\" >
                                              <div class=\"draggable-demo-product-header-label\" style='background-color:#fff;'> <a href=\"?q=".$row['id']."\">".$row['item']."</a></div></div>

                                              </div>"; */
                                            ###################
                                        } else {
                                            echo "<div class=\"draggable-demo-product jqx-rc-all\" title='$qty_it'>
							<div class=\"jqx-rc-t draggable-demo-product-header jqx-widget-header-theme1 jqx-fill-state-normal-theme\">
							<div class=\"draggable-demo-product-header-label\"><a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\">" . $row['item'] . "</a></div></div>

							<a href=\"?id=" . $_GET['id'] . "&q=" . $row['id'] . "\"><img src=\"uploads/" . $row['image'] . "\" class=\"img-responsive\" width=\"115\" height=\"100\" /></a>
							</div>";
                                        }
                                    }
                                    ?>

    <?php
    if ($total_pages == 0 and $db_cat_items_show!=0) {
	                       echo'<div class="alert alert-warning text-right" style="margin-top:100px;">
        '.$no_items_group_lang.'
                            </div>';
    }
    ?>

                                </div>
                            </div>

                        </div>

                    </div>
<?php } ?>
                <?php
                if($use_colors=='0' and $use_sizes=='0'){}else{
                 if($user_offers!=="1" and $user_IsAdmin!=1){}else{
echo'<button  type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" id="multi_items">'.$Insert_a_multi_alng.'</button>';
               }} ?>
            </article>

            <!--    <nav>nav</nav>-->
            <!-- <aside>aside</aside>-->
        </div>
        <div id="toolbar" class="noprint">
            <footer>
<?php include"includes/scroller_container.php"; ?>
            </footer>
        </div>
<!-- Trigger the modal with a button -->


<!-- Modal -->
<div id="myModal" class="modal fade"  role="dialog">
  <div class="modal-dialog" style="width:100%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title"><?php echo"$Insert_a_multi_alng"; ?></h4>
      </div>
        <div id="response"></div>
        <div class="modal-body" id="data">

      </div>
      <div class="modal-footer">
        <button  onClick="window.location.href=window.location.href" type="button" class="btn btn-default" data-dismiss="modal"><?php echo"$Close_lang"; ?></button>
      </div>
    </div>

  </div>
</div>
    </body>
<script>
    $(function() {
        (function($){
        function processForm( e ){
            $.ajax({
                url: 'storein_offers.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#response').html( data );
                          var $container = $("#data");
        $container.load('multi_items_offers.php');
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

            e.preventDefault();
        }

        $('#multi_items').click( processForm );
    })(jQuery);
    });
</script>
      <script type="text/javascript">//<![CDATA[
            window.onload = function() {
                $(document).ready(function() {
                    shortcut.add("Ctrl+i", function() {
                      //  $('span').html("أحسنت. لقد ضغطت على حرفي : Ctrl+i");
                    });
                                 shortcut.add("Ctrl+B", function() {
                      //  $('span').html("أحسنت. لقد ضغطت على حرفي : Ctrl+i");
                    });
                });
            }//]]>
          $(document).on("change",'.gr,.gr2',function() {
              $('#inv_sub').click();
          });
        </script>
</html>
<?php //include 'includes/footer.php'; ?>