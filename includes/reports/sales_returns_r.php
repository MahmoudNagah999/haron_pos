                                                <?php
			if($user_SalesReports!=="1" and $user_IsAdmin!=1){
				echo '<div class="alert alert-warning text-right" style="margin-top:150px;">                   '.$not_have_permission_lang.'                             </div>';
				}else{ ?>
                            <?php
if($_GET['del']!==null){
                           if($demo==1){
echo '<div class="alert alert-warning text-right" style="margin-top:80px;">
                  '.$demo_alert.'
                            </div>';
      }else{
                    if($user_IsAdmin!=1){
	                       echo'<div class="alert alert-warning text-right" style="margin-top:80px;">
                             '.$permission_to_admin_lang.'
                            </div>';
                                }else{
 if(mysqli_query($con,"DELETE FROM ".$prefix."_sales_inv WHERE inv_id='".$_GET['del']."' or order_suppy_num='".$_GET['del']."'")){
	 if(mysqli_query($con,"DELETE FROM ".$prefix."_sales WHERE inv_id='".$_GET['del']."'")){
echo'<div style="text-align:center; background-color:#95D183; border-radius:5px;float:right;width:100%; margin:0 auto;"">
<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
'.$bill_deleted_successfully_lang.'
</div>';
	 }
	 }
}}}
	?>
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
<thead>
<td colspan="7" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"> <?php echo"$Sales_returns_lang"; ?></strong></td>
</thead>
  <thead style="background-color:#CCC;">

  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"> <?php echo"$Code_lang"; ?> </a></th>
  
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="inv_id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="inv_id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=inv_id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$invoice_number_lang"; ?></a></th>
  
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>
  
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Total"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Total"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=Total&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_total_lang"; ?></a></th>
  
  
  <th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="supplier"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="supplier"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=supplier&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$The_Supplier_lang"; ?></a></th>
  
  
  <th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$payment_method_alng"; ?></a></th>
  <th></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
	$tbl_name="".$prefix."_sales_inv";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_sales_inv where  where type='2' and  left(date, 10) BETWEEN '".$from."' AND '".$to."'";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?from=".$_GET['from']."&to=".$_GET['to']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&reports=sales_returns"; 	//your file name  (the name of this file)
	 								//how many items to show per page
										if(!empty($_GET['limit'])){
		$_SESSION[limit]=$_GET['limit'];
		}else{}
		if(!empty($_SESSION[limit])){
					$limit = $_SESSION[limit];
					if($limit>100){$limit=$items_per_page+20;}
			}else{
				$limit = $items_per_page+20;
				}
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

$sql = "SELECT * FROM ".$prefix."_sales_inv where type='2' and left(date,10) BETWEEN '".$from."' AND '".$to."' order by $orderby $type LIMIT $start, $limit";	

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
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
		else
			$pagination.= "<span class=\"disabled\">>></span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&page=$next\"><<</a>";
		else
			$pagination.= "<span class=\"disabled\"><<</span>";
		$pagination.= "</div>\n";		
	}
###############
$i=0;
while($row = @mysqli_fetch_array($result))
		{
			$issingle=$i/2;
			 $dot = strstr($issingle, '.');
			if($dot==""){
				$class="background_color_FFF";
				}else{$class='background_color_D5EFF0';}
//				if($row['supplier']==""){$supplier_name="";}else{
//$result_suppliers = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$row['supplier']."");
//if(@mysqli_num_rows($result_suppliers)>0){
//while($row_suppliers = mysqli_fetch_array($result_suppliers))
//  {
//	  $supplier_name=$row_suppliers['name'];
//  }
//}
//				}
if($row['PaymentMethod']==1){$PaymentMethod="نقدى";}
else if($row['PaymentMethod']==2){$PaymentMethod="اجل";}
else if($row['PaymentMethod']==3){$PaymentMethod="شيك";}
else{}
#############################
?>


  <tr class="<?php echo"".$class.""; ?>">

  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$row['inv_id'].""; ?></td>
  <td><?php echo"".$row['date'].""; ?></td>
  <td><?php echo"".$row['Total']-$row['discount'].""; ?></td>
  <td><?php echo"".get_client_data($row['supplier'])[name].""; ?></td>
   <td><?php echo"".$PaymentMethod.""; ?></td>
  <td>
 <a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&del=<?php echo"".$row['inv_id'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>" ><img src="images/erase.png"/></a>
 <a href="sales_returns_edit.php?id=<?php echo"".$row['inv_id'].""; ?>&type=sales_returns"><img src="images/edit.png"/></a>
<a href="#" onclick="javascript:void window.open('invoice.php?id=<?php echo"".$row['inv_id'].""; ?>&type=sales_returns','1390937502641','width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;"><img src="images/view.png"/></a>
  
  </td>
  </tr>
     
 <?php $i++; } ?>   

    <thead style="background-color:#CCC;">
    <th colspan="3" class="text-center"><?php echo"$the_total_lang"; ?></th>
    <th class="text-center"> <?php
  
$result_get = mysqli_query($con,"SELECT Total FROM ".$prefix."_sales_inv where  type='2' and left(date,10) BETWEEN '".$from."' AND '".$to."'");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	 $total+=$row_get['Total'];
  }
}
echo $total;
 ?></th>
   <th colspan="2"></th>
  <th></th>
  </thead>
  <tr>
  <td class="text-center" colspan="7"><?php echo"$pagination"; ?></td>
  </tr>
  </table>
  <?php } ?>