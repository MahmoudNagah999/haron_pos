<?php
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
$exp_type=$_GET['exp_type'];
?>
                                                <?php
			if($user_ExpenseReports!=="1" and $user_IsAdmin!=1){
		       echo '<div class="alert alert-warning text-right" style="margin-top:150px;">
                  '.$not_have_permission_lang.'
                            </div>';
				}else{ ?>
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;">
<thead>
<td colspan="6" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"> <?php echo"$Expenses_lang"; ?><?php if($_GET['from']=="" or $_GET['to']==""){}else{ ?> <?php echo"$from_lang"; ?> <?php echo"".$from.""; ?> <?php echo"$to_lang"; ?>   <?php echo"".$to.""; ?><?php } ?></strong></td>
</thead>
  <thead style="background-color:#CCC;">
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="type"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="type"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=type&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Expense_lang"; ?></a></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Amount"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Amount"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=Amount&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_amount_lang"; ?></a></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>
  
  <th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Employee"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Employee"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=Employee&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_Employee"; ?></a></th>
  
  <th   class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="details"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="details"){echo"sort_d";}else{echo"sort0";}?>"><a href="?from=<?php echo"".$_GET['from'].""; ?>&to=<?php echo"".$_GET['to'].""; ?>&reports=<?php echo"".$_GET['reports'].""; ?>&orderby=details&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Details_lang"; ?></a></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="".$prefix."_expenses";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_expenses  left(date,10) BETWEEN '".$from."' AND '".$to."' and type='$exp_type' order by $orderby $type";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&reports=expenses"; 	//your file name  (the name of this file)
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
	$sql = "SELECT * FROM ".$prefix."_expenses where left(date,10) BETWEEN '".$from."' AND '".$to."' and type='$exp_type' order by $orderby $type LIMIT $start, $limit";			

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
			#################
			$issingle=$i/2;
			 $dot = strstr($issingle, '.');
			if($dot==""){
				$class="background_color_FFF";
				}else{$class='background_color_D5EFF0';}
$expensesName_list2 = mysqli_query($con,"SELECT expensestype FROM ".$prefix."_expenses_set where id=".$row['type']."");
$num_expensesName_list2=mysqli_num_rows($expensesName_list2);
if($num_expensesName_list2>0){
while($row_expensesName_list2 = mysqli_fetch_array($expensesName_list2))
  {
$ex_type=$row_expensesName_list2['expensestype'];
  }
}
if($row['Employee']!==""){
$result_staff_name = mysqli_query($con,"SELECT id,name FROM ".$prefix."_staff where id='".$row['Employee']."'");
if(mysqli_num_rows($result_staff_name)>0){
while($row_staf = mysqli_fetch_array($result_staff_name))
  {
	 $row_staff_id=$row_staf['id'];
	 $row_staff_name=$row_staf['name'];
}
}
}else{$row_staff_name='';}
?>


  <tr class="<?php echo"".$class.""; ?>">
  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$ex_type.""; ?></td>
  <td><?php echo"".round($row['Amount'],3).""; ?></td>
  <td><?php echo"".substr($row['date'], 0, 10).""; ?></td>
  <td><?php echo"".$row_staff_name.""; ?></td>
   <td><?php echo"".$row['details'].""; ?></td>
  
  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
    <th colspan="2" class="text-center"><?php echo"$the_total_lang"; ?></th>
  <th class="text-center"> <?php
  
$result_get = mysqli_query($con,"SELECT Amount FROM ".$prefix."_expenses where left(date,10) BETWEEN '".$from."' AND '".$to."' and type='$exp_type'");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	 $total+=$row_get['Amount'];
  }
}
echo $total;
 ?></th>
   <th colspan="3"></th>


  </thead>
  </table>
    <?php } ?>