                                                <?php
			if($user_ReportsSuppliers!=="1" and $user_IsAdmin!=1){
				echo '<div class="alert alert-warning text-right" style="margin-top:150px;">                   '.$not_have_permission_lang.'                             </div>';
				}else{ if($_GET['SupplierID']!==""){ ?>
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center; margin:0 auto;">
<thead>
<td colspan="7" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"> <?php echo"$Supplier_payments_lang"; ?> / <?php echo"".$_GET['supplier'].""; ?> - <?php echo"$from_lang"; ?> <?php echo"".$_GET['from'].""; ?> <?php echo"$to_lang"; ?> <?php echo"".$_GET['to'].""; ?></strong><a href="#" onclick="javascript:void window.open('statement_of_account_suppliers.php?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&id=<?php echo"".$_GET['SupplierID'].""; ?>','1390937502641','width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;" style="float:left;"><img src="images/arrears_list.gif" style="border:0px;" title="كشف حساب العميل" /></a></td>
</thead>
  <thead style="background-color:#CCC;">

  <th class="text-center"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"> <?php echo"$Code_lang"; ?> </a></th>
  
<th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="supplier"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="supplier"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=supplier&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$The_Supplier_lang"; ?></a></th>

    <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Total"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Total"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=Total&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_amount_lang"; ?></a></th>
    
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>
  
  

   <th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="PaymentMethod"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="PaymentMethod"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=PaymentMethod&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$payment_method_alng"; ?></a></th> 
  
  
    <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="DueDate"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="DueDate"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=DueDate&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"> <?php echo"$due_date_lang"; ?></a></th>
    
  
    <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="notes"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="notes"){echo"sort_d";}else{echo"sort0";}?>"><a href="?SupplierID=<?php echo"".$_GET['SupplierID'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&orderby=notes&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$notes_lang"; ?></a></th>

  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
	$tbl_name="".$prefix."_receivings_inv";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_receivings_inv  where supplier='".$_GET['SupplierID']."' and type='3' and left(date, 10) BETWEEN '$from' AND '$to'";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?from=".$_GET['from']."&to=".$_GET['to']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&reports=payments_suppliers"; 	//your file name  (the name of this file)
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
$sql = "SELECT * FROM ".$prefix."_receivings_inv where supplier='".$_GET['SupplierID']."' and type='3' and left(date,10) BETWEEN '$from' AND '$to' order by $orderby $type LIMIT $start, $limit";	

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
				if($_GET['SupplierID']==""){$supplier_name="";}else{
$result_suppliers = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$_GET['SupplierID']."");
if(@mysqli_num_rows($result_suppliers)>0){
while($row_suppliers = mysqli_fetch_array($result_suppliers))
  {
$supplier_name=$row_suppliers['name'];
  }
}
				}
if($row['PaymentMethod']==1){$PaymentMethod="$cash_lang";}
else if($row['PaymentMethod']==3){$PaymentMethod="$check_lang";}
else{}
#############################
if($row['DueDate']=="1970-01-01"){$row['DueDate']="";}
if($row['DueDate']=="1970-01-01"){$row['DueDate']="";}
?>


  <tr class="<?php echo"".$class.""; ?>">
  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$supplier_name.""; ?></td>
  <td><?php echo"".$row['Total'].""; ?></td>
    <td><?php echo"".$row['date'].""; ?></td>
  <td><?php echo"".$PaymentMethod.""; ?></td>

   <td><?php echo"".$row['DueDate'].""; ?></td>
    <td><?php echo"".$row['notes'].""; ?></td>

  </tr>
     
 <?php $i++; } ?>   

    <thead style="background-color:#CCC;">
    <th colspan="2" class="text-center"><?php echo"$the_total_lang"; ?></th>
    <th class="text-center"> <?php
$result_getreceivings_inv=mysqli_query($con,"SELECT SUM(Total) as Total FROM ".$prefix."_receivings_inv where type=3 and supplier='".$_GET['SupplierID']."' and left(date,10) BETWEEN '".$from."' AND '".$to."'");
$row_getreceivings_inv=@mysqli_fetch_assoc($result_getreceivings_inv); 
print $totalreceivings_inv=$row_getreceivings_inv['Total'];
 ?></th>
   <th colspan="3"></th>
  <th></th>
  </thead>
  <tr>
  <td class="text-center" colspan="7"><?php echo"$pagination"; ?></td>
  </tr>
  </table>
  <?php }} ?>