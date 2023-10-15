<?php
include "includes/inc.php";
$result_up = mysqli_query($con, "SELECT * FROM ".$prefix."_receivings");
							while ($row_up = mysqli_fetch_array($result_up)) {
mysqli_query($con, "UPDATE ".$prefix."_receivings SET  date=(select date from ".$prefix."_receivings_inv where inv_id=".$row_up['inv_id'].") where id=".$row_up['id']."");
							}
									
									################
									$result_sales = mysqli_query($con, "SELECT * FROM ".$prefix."_sales");
							while ($row_sales = mysqli_fetch_array($result_sales)) {
mysqli_query($con, "UPDATE ".$prefix."_sales SET  date=(select date from ".$prefix."_sales_inv where inv_id=".$row_sales['inv_id'].") where id=".$row_sales['id']."");
							}
?>