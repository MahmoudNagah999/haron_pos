<?php
include"includes/inc.php";
if ($_GET['q'] == "d") {
if (mysqli_query($con, "DELETE FROM " . $prefix . "_sales_temporary")) {
echo"$Deletion_successfully_lang";
                                        }
                                    } else {
                                        if ($_GET['q'] == null) {
                                            //	header( "refresh:0;url=sales.php" );
                                        } else {
                                            if(GetQuantity($_GET['q'])<=0){
                                                  echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$no_stock_lang.'
							</div>'; 
                                            }else{
                                                $result_new = mysqli_query($con, "SELECT * FROM items where id='".$_GET['q']."'");
                                                if (@mysqli_num_rows($result_new) >= 1) {

                                                    while ($row_new = mysqli_fetch_array($result_new)) {
                                                        $item_name_new = $row_new['item'];
                                                        $item_id_new = $row_new['id'];

                                                        $item_Discount_new = $row_new['Discount'];
                                                        $item_price_new = $row_new['price'];
                                                        $item_subqty = $row_new['subqty'];
                                                        if ($get_db_sales_type == "1") {
                                                            $item_Retail_price_new = $row_new['Retail_price'];
                                                        } else {
                                                            $item_Retail_price_new = $row_new['subprice'];
                                                        }
                                                        if ($Discount_type == 1) {
                                                            $item_total_new = $item_Retail_price_new - $row_new['Discount'];
                                                        } else if ($Discount_type == 2) {
                                                            $item_total_new = $item_Retail_price_new - (($item_Retail_price_new) * ($row_new['Discount'] / 100));
                                                        } else {
                                                            $item_total_new = $item_Retail_price_new;
                                                        }
                                                        $sql = "INSERT INTO " . $prefix . "_sales_temporary (item, Price, Quantity, Discount, Total, type, date, BuyPrice, subqty, sales_type, size, color)
							VALUES ('" . $item_id_new . "','" . $item_Retail_price_new . "','1','" . $row_new['Discount'] . "','" . $item_total_new . "','1','" . $DueDate . "','" . $item_price_new . "','" . $item_subqty . "','" . $get_db_sales_type . "','" . $size . "','" . $color . "')";
                                                    }
                                                    if (!mysqli_query($con, $sql)) {
                                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$not_saved_try_lang.'
							</div>';
                                                      // header("refresh:1;url=sales.php");
                                                    } else {
                                                        echo '<div style="text-align:center; background-color:#95D183; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$Added_Item_lang.'
							</div>';
                                                      //  header("refresh:1;url=sales.php");
                                                    }
                                                } else {
                                                    echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							'.$item_not_found_lang.'
							</div>';
                                                }
                                        }
                                        }
                                    }
                                    ?>