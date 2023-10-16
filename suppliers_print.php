 <?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    		
                <?php include"includes/css.php"; ?>
        </head>
        <body  onload="window.print()" >
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center; margin-bottom:30px;" class="container" id="container">
  <thead style="background-color:#CCC;">
<th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="name"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="name"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=name&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_name_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="phone"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="phone"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=phone&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Phone_number_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="address1"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="address1"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=address1&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Address1_lang"; ?></a></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="address2"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="address2"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=address2&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"> <?php echo"$Address2_lang"; ?></a></th>
  
  <th class="text-center"><?php echo"$Supplier_balance_lang"; ?></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="notes"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="notes"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=notes&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$notes_lang"; ?></a></th>

  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="suppliers";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	if($_GET['search']=="" or $_GET['search']==null){
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_suppliers order by $orderby $type";
	}else{
		$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_suppliers where id='$search' or name like '%$search%' order by $orderby $type";
		}
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?search=".$_GET['search']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
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
	
	/* Get data. */
	if($orderby=="id"){
		if($_GET['search']=="" or $_GET['search']==null){
		$sql = "SELECT * FROM ".$prefix."_suppliers  order by $orderby+0 $type LIMIT $start, $limit";
		}else{
			$sql = "SELECT * FROM ".$prefix."_suppliers where id='$search' or name like '%$search%' order by $orderby+0 $type LIMIT $start, $limit";
			}
		}else{
			if($_GET['search']=="" or $_GET['search']==null){
	$sql = "SELECT * FROM ".$prefix."_suppliers  order by $orderby $type LIMIT $start, $limit";
			}else{
			$sql = "SELECT * FROM ".$prefix."_suppliers where id='$search' or name like '%$search%' order by $orderby $type LIMIT $start, $limit";	
				}
		}
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
?>


  <tr class="<?php echo"".$class.""; ?>">
 <td><input type="checkbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
  <td><a href="payments_suppliers.php?id=<?php echo"".$row['id'].""; ?>"><?php echo"".$row['id'].""; ?></a></td>
  <td><?php echo"".$row['name'].""; ?></td>
  <td><?php echo"".$row['phone'].""; ?></td>
  <td><?php echo"".$row['address1'].""; ?></td>
  <td><?php echo"".$row['address2'].""; ?></td>
   <td><?php
$result_get=mysqli_query($con,"SELECT SUM(Total) as SUMTotal FROM ".$prefix."_receivings_inv where supplier=".$row['id']."");
$row_get=mysqli_fetch_assoc($result_get); 
$totalreceivings=$row_get['SUMTotal'];
echo ($row['balance']+$totalreceivings);
?>
</td>
  <td><?php echo"".$row['notes'].""; ?></td>

  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
  <th colspan="8"><?php echo"$pagination"; ?></th>

  </thead>
  </table>
  </body>
  <html>