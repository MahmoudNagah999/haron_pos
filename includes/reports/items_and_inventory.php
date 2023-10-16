                                                <?php
			if($user_InventoryReports!=="1" and $user_IsAdmin!=1){
				echo '<div class="alert alert-warning text-right" style="margin-top:150px;">                   '.$not_have_permission_lang.'                             </div>';
				}else{ ?>
<table width="70%" border="1" style="direction:rtl; border-collapse:collapse; margin:0 auto;">
  <tr style="background-color:#71B8FF;">
    <td colspan="3"><?php echo"$best_selling_items_lang"; ?></td>
  </tr>
  <tr>
    <td width="50%"><?php echo"$the_items_lang"; ?></td>
    <td width="25%"><?php echo"$quantity_sold_lang"; ?></td>
    <td width="25%"><?php echo"$the_Group"; ?></td>
  </tr>
                            <?php
$result_sale_items= mysqli_query($con,"SELECT *,sum(Quantity) as sq FROM ".$prefix."_sales where type='1'  GROUP BY item order by sq DESC limit 0,10");
if(@mysqli_num_rows($result_sale_items)>0){
while($row_sale_items=mysqli_fetch_array($result_sale_items))
  {
$result_items= mysqli_query($con,"SELECT item,groupid FROM items WHERE  id='".$row_sale_items['item']."'");
if(@mysqli_num_rows($result_items)>0){
while($row_result_items = mysqli_fetch_array($result_items))
  {
	  $nameofitem=$row_result_items['item'];
	$itemgroupid=$row_result_items['groupid'];
  }
}else{$nameofitem=$row_sale_items['item'];}
####################
$result_groupsi = mysqli_query($con,"SELECT product_name FROM products where id='$itemgroupid'");
if(@mysqli_num_rows($result_groupsi)>0){
while($row_groupsi=mysqli_fetch_array($result_groupsi))
  {
	  $grname=$row_groupsi['product_name'];
  }
}else{}
####################
				$NumberBreakdown00=NumberBreakdown($row_sale_items['sq'], $returnUnsigned = false);
				$all_qty00=(abs($NumberBreakdown00[1])*$row_sale_items['subqty']);
				$whole00=$NumberBreakdown00[0];
echo"<tr>
    <td>".$nameofitem."</td>
    <td>".$whole00.",".$all_qty00."</td>
    <td>".$grname."</td>
  </tr>";
  }
}
							?>


</table>
<?php } ?>
							