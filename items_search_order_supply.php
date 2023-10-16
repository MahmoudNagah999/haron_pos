<style>
    .item{
        background-color:#999;
    }
    .item a{
        text-decoration:none;
        color:#000;
        font-size:14px;
    }
    .item2 a{
        text-decoration:none;
        color:#000;
        font-size:14px;
    }
    .item2{
        background-color:#CCC;
    }
    .item:hover{
        background-color:#FFC;
    }
    .item2:hover{
        background-color:#FFC;
    }
</style>
<?php include_once("includes/inc.php"); ?>
<div id="suppliersName" class="text-center">

    <ul style="direction:rtl; width:45%; margin-top:0px; float:right;list-style: none;">
        <a href="<?php echo"".$_SERVER['HTTP_REFERER'].""; ?>"><img src="images/cancel.png" style="border:0px; float:left;" /></a>
        <?php

        $ser=$_GET['q'];
        $id=$_GET['id'];
        if($_GET['Barcode']!==null){
            $ser=$_GET['Barcode'];
        }

        if (!isset($_GET['order_id'])) {
            $_GET['order_user_id']='';
            $_GET['order_id']='';
        }

        /* mahmoud delete this */
        $result_search_clients = mysqli_query($con,"SELECT * FROM items  WHERE item LIKE '%$ser%' or id='$ser' or Barcode='$ser' limit 0,20");
        if(@mysqli_num_rows($result_search_clients)>0){
            $i=1;
            while($row_search_clients = mysqli_fetch_array($result_search_clients))
            {
                $issingle=$i/2;
                $dot = strstr($issingle, '.');
                if($dot==""){
                    $class="item";
                }else{
                    $class="item2";
                }

                $openQ = get_sum_product_store_data($row_search_clients['id'])[Quantity] ;

                $all_qty0 = ($openQ + GetQuantity($row_search_clients['id']));
                $NumberBreakdown = NumberBreakdown($all_qty0, $returnUnsigned = false);
                $all_qty = (abs($NumberBreakdown[1]) * $row_search_clients['subqty']);
                $whole = $NumberBreakdown[0];


                echo '<li class="'.$class.'"><a class="addProd" data_item_type="items" par="q" attr="'.$row_search_clients['id'].'" >'.$row_search_clients['item'].' ('.$whole.','.round($all_qty).')</a></li>';
                $i++;
            }
        }else{
            $no1 = 1;
        }
        /* to this */

        if ($_GET['offers']) {

            $result_search_clients = mysqli_query($con, "SELECT * FROM  " . $prefix . "_offers_inv WHERE name LIKE '%$ser%'  or id='$ser' or inv_id='$ser' limit 0,20");
            if (@mysqli_num_rows($result_search_clients) > 0) {
//	$i=1;
                while ($row_search_clients = mysqli_fetch_array($result_search_clients)) {

                    $issingle = $i / 2;
                    $dot = strstr($issingle, '.');
                    if ($dot == "") {
                        $class = "item";
                    } else {
                        $class = "item2";
                    }


                    $all_qty0 = '';
                    $NumberBreakdown = NumberBreakdown($all_qty0, $returnUnsigned = false);
                    $all_qty = (abs($NumberBreakdown[1]) * $row_search_clients['subqty']);
                    $whole = $NumberBreakdown[0];


                    echo  '<li class="' . $class . '"><a  class="addProd" par="q" data_item_type="offers" attr="'.$row_search_clients['id'].'">' . $row_search_clients['name'] . '(Offer)' . ')</a></li>';
                    $i++;
                }
            } else {

                $no2 = 2;
            }

        }
        else {

            $no2 = 2;
        }


        if($no1 == 1 and  $no2 ==2){
            echo'<li  class="item2"><a href="#">'.$no_data_lang.'</a></li>';

        }
//        echo json_encode($data);

        ?>
    </ul>
</div>
