                                                <?php
			if($user_ReportsPurchases!=="1" and $user_IsAdmin!=1){
				echo '<div class="alert alert-warning text-right" style="margin-top:150px;">
                  '.$not_have_permission_lang.'
                            </div>';
				}else{ if(isset($_GET['from']) and isset($_GET['to'])  and isset($_GET['q'])){ ?>
<table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse;  text-align:center;">
<thead>
<td colspan="8" style="background-color:#09F;"><strong style="color:#FFF; font-size:22px;"><?php echo"$Purchases_items_lang"; ?>/ <?php echo"".$_GET['item'].""; ?> <?php echo"$from_lang"; ?> <?php echo"".$_GET['from'].""; ?> <?php echo"$to_lang"; ?> <?php echo"".$_GET['to'].""; ?></strong></td>
</thead>
  <thead style="background-color:#CCC;">
  <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$Code_lang"; ?> </a></th>
    <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$the_items_lang"; ?> </a></th>
      <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$invoice_number_lang"; ?> </a></th>
      <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$the_Quantity_lang"; ?> </a></th>
        <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$Purchasing_price_lang"; ?></a></th>
          <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$the_date_lang"; ?> </a></th>
            <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$The_Supplier_lang"; ?> </a></th>
              <th class="text-center"><a href="#" class="a_remove_underlines"> <?php echo"$the_total_lang"; ?> </a></th>
  

  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
	$tbl_name="".$prefix."_receivings";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
      $query = "SELECT COUNT(DISTINCT(".$prefix."_receivings.id)) as num  FROM  ".$prefix."_receivings  join ".$prefix."_receivings_inv on ".$prefix."_receivings.inv_id = ".$prefix."_receivings_inv.inv_id where ".$prefix."_receivings.item=".$_GET['q']." and ".$prefix."_receivings.inv_id!='' and ".$prefix."_receivings.type='1' and  left(".$prefix."_receivings_inv.date, 10) BETWEEN '$from' AND '$to'";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
	/* Setup vars for query. */
	$targetpage = "?q=".$_GET['q']."&from=".$_GET['from']."&to=".$_GET['to']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&reports=item_receivings"; 	//your file name  (the name of this file)
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

     $sql = "SELECT DISTINCT(".$prefix."_receivings.id ) ,  ".$prefix."_receivings.*  FROM  ".$prefix."_receivings  Join ".$prefix."_receivings_inv on ".$prefix."_receivings.inv_id = ".$prefix."_receivings_inv.inv_id where ".$prefix."_receivings.item=".$_GET['q']." and ".$prefix."_receivings.inv_id!='' and ".$prefix."_receivings.type='1' and  left(".$prefix."_receivings_inv.date, 10) BETWEEN '$from' AND '$to' order by date DESC LIMIT $start, $limit";

//}


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
                    $supplier_name=get_supplier_data((get_receivings_inv_data($row['inv_id'] , 1)[supplier]))[name];
                    $date=((get_receivings_inv_data($row['inv_id'] , 1)[date]));
                    //				}
				################
		$result_search_itemsid = mysqli_query($con,"SELECT item FROM items WHERE id='".$row['item']."'");
if(@mysqli_num_rows($result_search_itemsid)>0){
while($row_search_itemsid = mysqli_fetch_array($result_search_itemsid))
  {
	  $itemsname=$row_search_itemsid['item'];
  }
}
?>


  <tr class="<?php echo"".$class.""; ?>">
  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$itemsname.""; ?></td>
    <td><?php echo"".$row['inv_id'].""; ?></td>
    <td><?php echo"".$row['Quantity'].""; ?></td>
      <td><?php echo"".$row['BuyPrice'].""; ?></td>
  <td><?php echo"".$date.""; ?></td>
  <td><?php echo"".$supplier_name.""; ?></td>
  <td><?php echo"".$row['Total'].""; ?></td>
    </tr>
     
 <?php $i++; } ?>   

    <thead style="background-color:#CCC;">
    <th colspan="7" class="text-center"><?php echo"$the_total_lang"; ?></th>
    <th class="text-center"> <?php
  
$result_get = mysqli_query($con,"SELECT Total FROM ".$prefix."_receivings where item=".$_GET['q']." and type='1' and left(date,10) BETWEEN '".$from."' AND '".$to."'");
if(@mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	 $total+=$row_get['Total'];
  }
}
echo $total;
 ?></th>

  </thead>
  <tr>
  <td class="text-center" colspan="8"><?php echo"$pagination"; ?></td>
  </tr>
  </table>
  <?php }} ?>