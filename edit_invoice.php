<?php
include "includes/inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo"".$get_db_CompanyName.""; ?></title>
<?php include"includes/css.php"; ?>
<?php include"includes/js.php"; ?>
</head>
<?php
if(isset($_POST['submit'])){
              if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
    if($user_IsAdmin!=1){
	                       echo'<div class="alert alert-warning text-right">
                             '.$permission_to_admin_lang.'
                            </div>';
				}else{
// Check if button name "Submit" is active, do this
$count=count($_POST['id']);
$Quantity=$_POST['Quantity'];
$Discount=$_POST['Discount'];
$Price=$_POST['Price'];
$item=$_POST['item'];
$unit=$_POST['unit'];
$item_name=$_POST['item_name'];
$id=$_POST['id'];
$subqty=$_POST['subqty'];
$sales_type=$_POST['sales_type'];
$name=$_POST['name'];
$method=$_POST['method'];
$size=$_POST['size'];
$color=$_POST['color'];
$inv_paid=$_POST['inv_paid'];
$alldiscount=$_POST['alldiscount'];
$_POST['date']=str_replace("/", "-", $_POST['date']);
$date=Trim(date('Y-m-d',strtotime($_POST['date'])));
//$cur_discount=$_POST['cur_discount'];
//echo $discount_diff=$_POST['cur_discount']-abs($alldiscount);
for($i=0;$i<$count;$i++){
	#############
	if ($Discount_type == 1) {
		#######التأثير على المخزون######
		$result_itemsINV = mysqli_query($con,"SELECT Quantity FROM ".$prefix."_sales where id='".$id[$i]."' limit 0,1");
	}
if(@mysqli_num_rows($result_itemsINV)>0){
	while($row_itemsINV=mysqli_fetch_array($result_itemsINV))
  {
$diff=$row_itemsINV[Quantity]-$Quantity[$i];
//if(mysqli_query($con, "UPDATE items SET Quantity=(Quantity+$diff) where id=$item[$i]")){}else{}
  }
#########################################################################

													$item_total_new=$Price[$i]*$Quantity[$i]-$Discount[$i];
													$INV_total_new+=$Price[$i]*$Quantity[$i]-$Discount[$i];
												} else if ($Discount_type==2) {
													$item_total_new=$Price[$i]*$Quantity[$i]-(($Price[$i]) *$Quantity[$i]* ($Discount[$i] / 100));
													$INV_total_new+=$Price[$i]*$Quantity[$i]-(($Price[$i]) *$Quantity[$i]* ($Discount[$i] / 100));
												} else {$item_total_new=$Price[$i]*$Quantity[$i];
												$INV_total_new+=$Price[$i]*$Quantity[$i];
												}
												//$INV_total_new=$INV_total_new-$alldiscount;
	#############
//echo"".$item_total_new."_".$Quantity[$i]."_".$Price[$i]."_".$Discount[$i]."_".$Discount[$i]."_".$id[$i]."<br />";
if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
	if($unit[$i]=="2"){
		$EditQuantity=$Quantity[$i]/$subqty[$i];
		}else{
			$EditQuantity=$Quantity[$i];
			}
$sql1="UPDATE ".$prefix."_receivings SET Quantity='$EditQuantity',unit='$unit[$i]', BuyPrice='$Price[$i]', Discount='$Discount[$i]', Total='$item_total_new', item='$item_name[$i]', size='$size[$i]', color='$color[$i]', SupplierID='$name', date='$date' WHERE id='$id[$i]'";	
	}else{
		if($sales_type[$i]=="2"){
		$EditQuantity=null;
$EditQuantity=$Quantity[$i]/$subqty[$i];
		}else{
					$EditQuantity=null;
$EditQuantity=$Quantity[$i];
			}
$sql1="UPDATE ".$prefix."_sales SET Quantity='$EditQuantity', Price='$Price[$i]', Discount='$Discount[$i]', Total='$item_total_new', item='$item_name[$i]', sales_type='$sales_type[$i]', size='$size[$i]', color='$color[$i]', SupplierID='$name', date='$date' WHERE id='$id[$i]'";
}
$result1=mysqli_query($con, $sql1);
}

if($result1){
##########
$INV_total_new=($INV_total_new-$alldiscount);
if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
$sql1u="UPDATE ".$prefix."_receivings_inv SET Total='$INV_total_new',discount='$alldiscount',supplier='$name',PaymentMethod='$method',date='$date',paid='$inv_paid' WHERE inv_id='".$_GET['id']."'";	
	}else{
$sql1u="UPDATE ".$prefix."_sales_inv SET Total='$INV_total_new',discount='$alldiscount',supplier='$name',PaymentMethod='$method',date='$date',paid='$inv_paid' WHERE inv_id='".$_GET['id']."'";
}
if(mysqli_query($con, $sql1u)){}else{	print "".mysqli_errno($con)."";};
#########
}else{}
}}}
          		if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
$result_sales_inv = mysqli_query($con,"SELECT *,left(date,10) as date FROM ".$prefix."_receivings_inv where inv_id='".$_GET['id']."' limit 0,1");		
		}else{
$result_sales_inv = mysqli_query($con,"SELECT *,left(date,10) as date FROM ".$prefix."_sales_inv where inv_id='".$_GET['id']."' limit 0,1");
	}
if(@mysqli_num_rows($result_sales_inv)>0){
	while($row_sales_inv = mysqli_fetch_array($result_sales_inv))
  {
?>
    <div class="table-responsive">
<form action="" method="post">

   <table class="table" dir="rtl">
            <tr>
 <?php    
 if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
    $result_clients = mysqli_query($con,"SELECT * FROM ".$prefix."_suppliers");
 }else{
     
      $result_clients = mysqli_query($con,"SELECT * FROM ".$prefix."_clients");
 }    
 ?>
            <td colspan="4" claas="text-right"><lable><?php echo"$Customer_supplier"; ?></lable>
                <select class="form-control chosen-select-width" id="name" name="name">
<?php
                    if($row_sales_inv['supplier']==""){
                    echo'<option value="">'.$cash_lang.'</option>';
                    }
if(mysqli_num_rows($result_clients)>0){
while($row_clients = mysqli_fetch_array($result_clients))
  {
    if($row_clients['id']==$row_sales_inv['supplier']){
 echo'<option value="'.$row_clients['id'].'" selected="selected">'.$row_clients['name'].'</option>';       
    }else{
echo'<option value="'.$row_clients['id'].'">'.$row_clients['name'].'</option>';
    }
  }
}
?>
                </select>
            </td>
                  
             <td colspan="2" claas="text-right"><lable> <?php echo"$payment_method_lang"; ?></lable>
                 <select  class="form-control" id="method" name="method">
  <option value="1" <?php if($row_sales_inv['PaymentMethod']=="1"){echo'selected="selected"';} ?>><?php echo"$cash_lang"; ?></option>
                     <option value="2" <?php if($row_sales_inv['PaymentMethod']=="2"){echo'selected="selected"';} ?>><?php echo"$On_credit_lang"; ?></option>
                     <option value="3" <?php if($row_sales_inv['PaymentMethod']=="3"){echo'selected="selected"';} ?>><?php echo"$check_lang"; ?></option>
                 </select>
             </td>
                <td colspan="2"><lable><?php echo"$the_date_lang"; ?></lable><input type="text" style="max-height:29px;" name="date"   id="date" value="<?php echo"".date('d/m/Y',strtotime($row_sales_inv['date'])).""; ?>" class="form-control"/></td>
                 <script type="text/javascript">
				$('#date').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script>
            </tr>    
  <tr>
      <th class="text-center"><?php echo"$Serial_lang"; ?></th>
    <th class="text-center"><?php echo"$the_items_lang"; ?></th>
    <th class="text-center"><?php echo"$the_Quantity_lang"; ?></th>
   <?php
	if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
                if($Retail_Buying=="1"){
								echo'<th scope="col">'.$measruing_unit.'</th>';
								}
	}
		if($_GET['type']=="sales_returns" or $_GET['type']=="sale"){
                    if($Retail_allow=="1"){
		echo'<th scope="col">'.$the_Type_lang.'</th>';
                    }
	}
	
	?>
          <?php if($use_sizes==1){echo' <th  scope="col">'.$the_Size_lang.'</th>'; } ?>
         <?php if($use_colors==1){echo' <th  class="text-center">'.$the_Color_lang.'</th>'; } ?>
    <th class="text-center"><?php echo"$the_Price_lang"; ?></th>
    <th class="text-center"><?php echo"$the_Discount_lang"; ?></th>
   
    <th class="text-center"><?php echo"$the_total_lang"; ?></th>
   
  </tr>
  <?php
	if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
		$tbl_name = "".$prefix."_receivings";
		}else{
							$tbl_name = "".$prefix."_sales";
	}
							//your table name
							// How many adjacent pages should be shown on each side?
							$adjacents = 3;

							/*
							 First get total number of rows in data table.
							 If you have a WHERE clause in your query, make sure you mirror it here.
							 */
							$query = "SELECT COUNT(*) as num  FROM $tbl_name where inv_id=".$_GET['id']." order by id ASC";
							$total_pages = @mysqli_fetch_array(mysqli_query($con, $query));
							$total_pages = $total_pages[num];

							/* Setup vars for query. */
							$targetpage = "limit=" . $_GET['limit'] . "";
							//your file name  (the name of this file)
							//how many items to show per page
							if (!empty($_GET['limit'])) {
								$_SESSION[limit] = $_GET['limit'];
							} else {
							}
							if (!empty($_SESSION[limit])) {
								$limit = $_SESSION[limit];
								if ($limit > 100) {$limit = 20;
								}
							} else {
								$limit = 100;
							}
							$page = $_GET['page'];
							if ($page)
								$start = ($page - 1) * $limit;
							//first item to display on this page
							else
								$start = 0;
							//if no page var is given, set start to 0

							/* Get data. */
							$sql = "SELECT * FROM $tbl_name where inv_id=".$_GET['id']." order by id ASC";

							$result = @mysqli_query($con, $sql);
							/* Setup page vars for display. */
							if ($page == 0)
								$page = 1;
							//if no page var is given, default to 1.
							$prev = $page - 1;
							//previous page is page - 1
							$next = $page + 1;
							//next page is page + 1
							$lastpage = ceil($total_pages / $limit);
							//lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;
							//last page minus 1

							/*
							 Now we apply our rules and draw the pagination object.
							 We're actually saving the code to a variable in case we want to draw it more than once.
							 */
							$pagination = "";
							if ($lastpage > 1) {
								$pagination .= "<div class=\"pagination\">";
								//previous button
								if ($page > 1)
									$pagination .= "<a href=\"$targetpage&page=$prev\">>></a>";
								else
									$pagination .= "<span class=\"disabled\">>></span>";

								//pages
								if ($lastpage < 7 + ($adjacents * 2))//not enough pages to bother breaking it up
								{
									for ($counter = 1; $counter <= $lastpage; $counter++) {
										if ($counter == $page)
											$pagination .= "<span class=\"current\">$counter</span>";
										else
											$pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
									}
								} elseif ($lastpage > 5 + ($adjacents * 2))//enough pages to hide some
								{
									//close to beginning; only hide later pages
									if ($page < 1 + ($adjacents * 2)) {
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
											if ($counter == $page)
												$pagination .= "<span class=\"current\">$counter</span>";
											else
												$pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
										}
										$pagination .= "...";
										$pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
										$pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
									}
									//in middle; hide some front and some back
									elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
										$pagination .= "<a href=\"$targetpage&page=1\">1</a>";
										$pagination .= "<a href=\"$targetpage&page=2\">2</a>";
										$pagination .= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
											if ($counter == $page)
												$pagination .= "<span class=\"current\">$counter</span>";
											else
												$pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
										}
										$pagination .= "...";

										$pagination .= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
										$pagination .= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
									}
									//close to end; only hide early pages
									else {
										$pagination .= "<a href=\"$targetpage&page=1\">1</a>";
										$pagination .= "<a href=\"$targetpage&page=2\">2</a>";
										$pagination .= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
											if ($counter == $page)
												$pagination .= "<span class=\"current\">$counter</span>";
											else
												$pagination .= "<a href=\"$targetpage&page=$counter\">$counter</a>";
										}
									}
								}

								//next button
								if ($page < $counter - 1)
									$pagination .= "<a href=\"$targetpage&page=$next\"><<</a>";
								else
									$pagination .= "<span class=\"disabled\"><<</span>";
								$pagination .= "</div>\n";
							}
							###############
							$i = 1;
							while ($row = @mysqli_fetch_array($result)) {
 $row_date=date('d/m/Y',strtotime($row['date']));
								###########
$result_it = mysqli_query($con, "SELECT * FROM items where id=".$row['item']."");
								if (@mysqli_num_rows($result_it) > 0) {
									while ($row_it=mysqli_fetch_array($result_it)) {
										$item_name=$row_it['item'];
                                                                                $item_size=$row_it['size'];
                                                                                $item_color=$row_it['color'];
										$item_id=$row_it['id'];
											if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
										//$item_price=$row_it['Retail_price'];
										$item_price= $row_it['price'];
											}else{
										$item_price=$row_it['Retail_price'];
										$item_BuyPrice= $row_it['price'];
											}
										$item_Discount = $row_it['Discount'];
										
									}
								}
								if ($item_Discount == null) {
									$item_Discount = 0;
								}
/*								if ($row['Quantity'] < 1) {
									$row['Quantity'] = 1;
								}*/

								if ($item_Discount == null) {
									$item_Discount = 0;
								}
								$sumTotal+= $row['Total'];
								###########
if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
								$ppr=$row['BuyPrice'];
									}else{
								$ppr=$row['Price'];
										}
							
  echo'<tr>
  <td class="text-center">'.$i.'  <input type="hidden" name="id[]" value="'.$row['id'].'" />
  <input type="hidden" name="item[]" value="'.$row['item'].'" /></td>
    <td class="text-center">';
	   echo'<input type="hidden" name="subqty[]" value="'.$row['subqty'].'" />';
	?>
 
    
      <select name="item_name[]"   class="form-control chosen-select-width">

	<?php
				$result_items = mysqli_query($con,"SELECT * FROM items order by groupid,item DESC");
if(mysqli_num_rows($result_items)>0){
while($row_items = mysqli_fetch_array($result_items))
  {
	  if($row_items[id]==$row['item']){
		   echo'<option value="'.$row_items[id].'" selected="selected">'.$row_items[item].'</option>';
		  }else{
		   echo'<option value="'.$row_items[id].'">'.$row_items[item].'</option>';
		  }
	   
  }
}
if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
     if($Retail_Buying==1){
	$unit_option1=null;
$unit_option2=null;
if($row['unit']=="1"){$unit_option1=' selected="selected"';}
if($row['unit']=="2"){$unit_option2=' selected="selected"';}
$unit_select='<td><select name="unit[]"><option value="1" '.$unit_option1.'>'.$primary_unit_lang.'</option><option value="2" '.$unit_option2.'>'.$Sub_unit_lang.'</option></select></td>';
}
if($row['unit']=="2"){
		$show_QTY=$row['subqty']*$row['Quantity'];
		}else{
				$show_QTY=$row['Quantity'];
			}
     }else{
						$sales_type_option1=null;
$sales_type_option2=null;
if($row['sales_type']=="1"){$sales_type_option1=' selected="selected"';}
if($row['sales_type']=="2"){$sales_type_option2=' selected="selected"';}
if($Retail_allow=="1"){
						$sales_type_select='<td><select name="sales_type[]">
						<option value="1" '.$sales_type_option1.'> '.$Wholesaling_lang.'</option>
						<option value="2" '.$sales_type_option2.'>'.$Retail_lang.'</option></select></td>';
}
		 if($row['sales_type']=="2"){
			$show_QTY= $row['Quantity']*$row['subqty']; 
		
		 }else{
			 $show_QTY=$row['Quantity'];
			 }
		}
		
  ?>

  </select>
	<?php echo'</td>
    <td class="text-center"><input type="text" name="Quantity[]" id="Quantity"  value="'.round($show_QTY).'"    class="form-control" style="max-width:50px;"/></td>
	'.$unit_select.'
	'.$sales_type_select.'';
                                                         if($use_sizes==1){
                                        echo'<td class="text-center"><select name="size[]" class="form-control">';
                                                                          $result_sizes = @mysqli_query($con, "SELECT * FROM sizes where id in (".rtrim(get_sizes_of_item($row['item']), ",").")");
                                                                        $num_sizes = @mysqli_num_rows($result_sizes);
                                                                        if ($num_sizes > 0) {
                                                                            while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                    if ($row['size'] == $row_sizes['id']) {
                        echo '<option value="' . $row_sizes['id'] . '" selected >' . $row_sizes['size'] . '</option >';
                    } else {
                        echo '<option value="' . $row_sizes['id'] . '">' . $row_sizes['size'] . '</option >';
                    }
                                                                            }
                                                                        }
                                                
                                              echo'</select></td>';
                                         }
                                                if($use_colors==1){
                                                    echo'<td class="text-center"><select name="color[]"  class="form-control">';
                                                                   $result_colors = @mysqli_query($con, "SELECT * FROM colors where status!=3 and  id in (".rtrim(get_clolors_of_item($row['item']), ",").")  ");
            $num_colors = @mysqli_num_rows($result_colors);
            if ($num_colors > 0) {
                while ($row_colors = mysqli_fetch_array($result_colors)) {
                    if ($row['color'] == $row_colors['id']) {
                        echo '<option value="' . $row_colors['id'] . '" selected >' . $row_colors['color'] . '</option >';
                    } else {
                        echo '<option value="' . $row_colors['id'] . '">' . $row_colors['color'] . '</option >';
                    }
                }
            }
                                               echo'</select></td>';
                                                }
             
                                                                echo'
    <td class="text-center"><input type="text" name="Price[]" id="Price" value="'.$ppr.'"    class="form-control" style="min-width:50px;"/></td>
    <td class="text-center"><input type="text" name="Discount[]" id="Discount" value="'.$row['Discount'].'"   class="form-control"  style="max-width:50px;"/></td>
    <td class="text-center">'.$row['Total'].'</td>
  </tr>';
                                                $i++;
                   
                                                        }


							
	$sales_inv_discount=$row_sales_inv['discount'];	
        $sales_inv_paid=$row_sales_inv['paid'];	
        $sales_inv_Total=$row_sales_inv['Total'];	
            }
							?>
                              <tr>
  <td class="text-center">&nbsp;</td>
      <?php if($use_colors==1){echo' <td>&nbsp;</td>';} ?>
     <?php if($use_sizes==1){echo' <td>&nbsp;</td>';} ?>
    <td  class="text-center" colspan="3"><?php echo"$the_Discount_lang"; ?></td>
    <td class="text-center">
    <input type="hidden" name="cur_discount" value="<?php echo"".$row_sales_inv['discount'].""; ?>" />
    <input type="text" value="<?php echo"".$sales_inv_discount.""; ?>" name="alldiscount"   class="form-control" style="max-width:50px;"/>
    </td>

    <td class="text-center"><?php echo"".$row['Total']-$sales_inv_discount.""; ?></td>
  </tr>
              <tr>
           <td class="text-center" colspan="4"><?php echo"$payment_method_lang"; ?></td>
    <td class="text-center" colspan="2">
        <input type="text" value="<?php echo"".$sales_inv_paid.""; ?>" name="inv_paid"   class="form-control" style="main-width:50px;"/></td>
  </tr>
  <tr>
  <td class="text-center">&nbsp;</td>
    <td  class="text-center" colspan="4"><input type="submit" value="<?php echo"$Modify_lang"; ?>" name="submit" /></td>
    <?php if($use_colors==1){echo' <td>&nbsp;</td>';} ?>
     <?php if($use_sizes==1){echo' <td>&nbsp;</td>';} ?>
    <td class="text-center"><?php echo"".$sales_inv_Total.""; ?></td>
  </tr>

</table>


</form>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn').click(function () {
            window.opener.location.reload(true);
            window.close();
        });
    });
</script>
<input type='button' id='btn' value='<?php echo"$Close_window_lang"; ?>' />
<script src="chosen_v1.4.2/chosen.jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"97%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>