                                                <?php
			if($user_user_treasury!=="1" and $user_IsAdmin!=1){
	       echo '<div class="alert alert-warning text-right" style="margin-top:150px;">
                  '.$not_have_permission_lang.'
                            </div>';
				}else{ ?>
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
<thead>
<td colspan="7" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"> <?php echo"رصيد الخزينة"; ?></strong></td>
</thead>
  <thead style="background-color:#CCC;">

  <th  class="text-center">الكود</th>
  
  
  <th  class="text-center">نوع العملية</th>
  
  
  <th  class="text-center">التاريخ</th>
  
  
  <th  class="text-center">المبلغ</th>
  
  
  <th   class="text-center">ملاحظات</th>

 
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
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_treasury where left(date, 10) BETWEEN '".$from."' AND '".$to."'";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?reports=".$_GET['reports']."&item=".$_GET['item']."&safe_id=".$_GET['safe_id']."&tore_id=".$_GET['tore_id']."&branch_id=".$_GET['branch_id']."&to=".$_GET['to']."&from=".$_GET['from']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
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
$sql = "SELECT * FROM ".$prefix."_treasury where  left(date,10) BETWEEN '".$from."' AND '".$to."' order by $orderby $type LIMIT $start, $limit";	
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
						if($row['type']==1){$ex_type="$Withdrawal_lang";}
				else if($row['type']==2){$ex_type="$Deposit_lang";}
				else if($row['type']==3){$ex_type="$Purchases_cash_lang";}
				else if($row['type']==4){$ex_type="$Cash_sales_lang";}
				else if($row['type']==5){$ex_type="$Expenses_lang";}
				else if($row['type']==6){$ex_type="$Payment_suppliers_lang";}
				else if($row['type']==7){$ex_type="$Collection_customers";}
				else if($row['type']==8){$ex_type="$Sales_returns_lang";}
				else if($row['type']==9){$ex_type="$Returns_Purchases_lang";}
				else{}
?>


  <tr class="<?php echo"".$class.""; ?>">
  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$ex_type.""; ?></td>
  <td><?php echo"".substr($row['date'], 0, 10).""; ?></td>
  <td><?php echo"".$row['Amount'].""; ?></td>
 <td><?php echo"".$row['notes'].""; ?></td>
  </tr>
     
 <?php $i++; } ?>   

    <thead style="background-color:#CCC;">
    <th colspan="3" class="text-center"><?php echo"$the_total_lang"; ?></th>
    <th class="text-center"> <?php
  
$result_get = mysqli_query($con,"SELECT Amount FROM ".$prefix."_treasury where  left(date,10) BETWEEN '".$from."' AND '".$to."'");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	 $total+=($row_get['Amount']);
  }
}
echo $total;
 ?></th>
  <th></th>
  </thead>
  <tr>
  <td class="text-center" colspan="7"><?php echo"$pagination"; ?></td>
  </tr>
  </table>
  <?php } ?>