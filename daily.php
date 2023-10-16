<?php
include "includes/inc.php";
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <style type="text/css">

/* printer specific CSS */
@media print
{
  #contentnoprint { display:none;}
  #contentnoprint2 { display:none;}
  #contentnoprint3 { display:none;}
}
</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title><?php echo"".$get_db_CompanyName.""; ?></title>
                <?php include"includes/css.php"; ?>
                <?php include"includes/js.php"; ?>
	</head>
    <div>
					<?php
					if ($get_db_isLogo == 1) {
						if ($get_db_Logo=="") {
							echo '<a href="index.php"><img src="images/yourLogoHere.png" style="float:left; border:0px;"/></a>';
						} else {
							echo '<a href="index.php"><img src="uploads/'.$get_db_Logo.'" style="float:left; border:0px;"/></a>';
						}
					} else {
						//echo"<div class='logodiv'>$get_db_CompanyName</div>";
					}
					?>
				</div>
    <div style="padding-bottom:20px; width:100%; text-align:center; margin:0 auto;">
    <form method="get" id="contentnoprint">
    <div style="width:30%; float:right;"><label style="float:right; font-size:16px;"><?php echo"$from_lang"; ?></label><input type="date" name="from" id="from" value="<?php if(isset($_GET['from'])){echo"".$_GET['from']."";}else{echo date("d/m/Y");}?>" class="w100" /> 
     <script type="text/javascript">
				$('#from').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script>
        </div>
    <input type="submit" value="<?php echo"$View_report_lang"; ?> " class="button" style="float:right;" />
        <input type="hidden" name="id" value="<?php echo"".$_GET['id'].""; ?>" />
    </form>
</div>
<?php
if(isset($_GET['from'])){ ?> 
<table width="200" border="1" style="width:100%; border-collapse:collapse; text-align:center; font-size:15px; font-family:Tahoma, Geneva, sans-serif;">
 <tr bgcolor="#CCCCCC">
    <td colspan="12">
    <a href="#" onClick="window.print()"><img src="images/print_icon.gif" style="border:0px; float:left;  width:30px; height:30px;" /></a>
 <span style="font-weight:bold; font-size:18px;">
  <span>
   <?php echo"$daily_report_lang"; ?>  </span>	
<?php print $row_suppliers_nameq;
	 ?>
	 -  <span><?php echo"".$from.""; ?></span>
</span>
     </td>
  </tr>
  <tr bgcolor="#CCEFC7">
    <td width="11%" rowspan="2"><?php echo"".$The_client_lang.""; ?></td>
    <td width="13%" rowspan="2"><?php echo"".$the_total_lang.""; ?></td>
    <td width="11%" rowspan="2"><?php echo"".$the_Discount_lang.""; ?></td>
    <td width="9%" rowspan="2"><?php echo"".$the_Price_lang.""; ?></td>
    <td width="9%" rowspan="2"><?php echo"".$the_Quantity_lang.""; ?></td>
     <?php  if($use_sizes==1){echo' <td width="9%" rowspan="2">'.$the_Size_lang.'</td>'; } ?>
   <?php  if($use_colors==1){echo' <td width="9%" rowspan="2">'.$the_Color_lang.'</td>'; } ?>
    <td width="16%" rowspan="2"><?php echo"$Detail_lang"; ?></td>
    <td width="9%" rowspan="2"> <?php echo"$invoice_num_lang"; ?></td>
    <td colspan="2"><?php echo"$the_Process_lang"; ?></td>
    <td width="11%" rowspan="2"><?php echo"$the_date_lang"; ?></td>
  </tr>
  <tr>
    <td width="6%"><?php echo"$credit_lang"; ?></td>
    <td width="5%"><?php echo"$Debit_lang"; ?></td>
  </tr>
  
  <?php
$result_get = mysqli_query($con,"SELECT id,inv_id,date,Total,supplier,PaymentMethod,paid,DueDate,CheckNumber,notes,type FROM ".$prefix."_sales_inv where  left (date,10)='$from'  UNION ALL SELECT     id*-1,inv_id,date,Total,supplier,PaymentMethod,paid,DueDate,CheckNumber,notes,type FROM ".$prefix."_receivings_inv where  left (date,10)='$from'  order by date ASC,id DESC");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	  $Type=$row_get['type'];
	  $date=substr($row_get['date'], 0, 10);
	  $Total=$row_get['Total'];
	  $notes=$row_get['notes'];
if($row_get['id']<1){
	if($Total<0){$totalA=$Total;}else{$totalA="";}
	  if($Total>=0){$totalB=$Total;}else{$totalB=""; } 
	  
	  if($row_get['type']=="3"){
		   if($notes=="$Cash_discount_lang"){
			  $totalABtitle="$Cash_discount_lang";
			  }else{
			  $totalABtitle="$cash_lang";
			  }
		  }else{
	   if($Total<0 and $Type==1){$totalABtitle="$sales_st_lang";}else{  
	   if($Total<0){ $totalABtitle="$Returns_Purchases_lang"; }else{}
	   if($Total>=0){ $totalABtitle="$Purchases_st_lang";}else{}
	   }
	  }
	}else{
	  
	  if($Total<0){$totalB=$Total;}else{$totalB=""; }
	  if($Total>=0){$totalA=$Total;}else{$totalA="";}
	  
	  if($row_get['type']=="3"){$totalABtitle="$cash_lang";}else{
		   if($Total<0 and $Type==1){$totalABtitle="$Purchases_st_lang";}else{
	   if($Total<0){ $totalABtitle="$Sales_returns_lang"; }else{}
	   if($Total>=0){ $totalABtitle="$sales_st_lang";}else{}
		   }
	  }
		
	}
	if($row_get['id']<1){
		$result_suppliersw = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$row_get['supplier'].""); 
		if(@mysqli_num_rows($result_suppliersw)>0){
while($row_suppliersw = mysqli_fetch_array($result_suppliersw))
  {
	  $supplier_namew=$row_suppliersw['name'];
  }
}
		}else if($row_get['id']>0){
			
	$result_suppliersw = mysqli_query($con,"SELECT id,name FROM ".$prefix."_clients WHERE id=".$row_get['supplier'].""); 
		if(@mysqli_num_rows($result_suppliersw)>0){
while($row_suppliersw = mysqli_fetch_array($result_suppliersw))
  {
	  $supplier_namew=$row_suppliersw['name'];
  }
}		
			}else{$supplier_namew="";}
			if($row_get['supplier']==null){$supplier_namew=null;}else{}
	  echo'
  <tr bgcolor="#CCCCCC">
    <td>'.$supplier_namew.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>';
         if($use_sizes==1){echo'<td>&nbsp;</td>'; }
     if($use_colors==1){echo'<td>&nbsp;</td>'; }
    echo'<td>'.$totalABtitle.'</td>
    <td>'.$row_get['inv_id'].'</td>
    <td>'.$totalB.'</td>
    <td>'.$totalA.'</td>
    <td>'.$date.'</td>
  </tr>
';
if($row_get['id']<1){
  $result_getinv = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings where inv_id='".$row_get['inv_id']."'");	
	}else{
  $result_getinv = mysqli_query($con,"SELECT * FROM ".$prefix."_sales where inv_id='".$row_get['inv_id']."'");
}

if(mysqli_num_rows($result_getinv)>0){
while($row_getinv = mysqli_fetch_array($result_getinv))
  {
	  	  ####################
	  if($row_getinv['item']==null or $row_getinv['item']==""){
		  $item_name=$row_getinv['item'];
		  }else{
	  $result_item = mysqli_query($con,"SELECT item FROM items WHERE id=".$row_getinv['item']."");
if(@mysqli_num_rows($result_item)>0){
while($row_item=mysqli_fetch_array($result_item))
  {
	  $item_name=$row_item['item'];
  }
}
	  }
	  	if($totalABtitle=="مرتجعات مشتريات" or $totalABtitle=="مشتريات"){
			$R_Price=$row_getinv['BuyPrice'];
		  				$QuID=$row_getinv['Quantity'];
						 // 		$whole00 = floor($QuID); 
			//$qty00=round((($QuID-$whole00)*$row_getinv['subqty']));
						$NumberBreakdown23=NumberBreakdown($QuID, $returnUnsigned = false);
						$whole00=$NumberBreakdown23[0];
				$qty00=(abs($NumberBreakdown23[1])*$row_getinv['subqty']);

			if($row_getinv['unit']=="2"){
				$Qty="".round($whole00).','.round($qty00)."";
				}else{
				$Qty=round($QuID);
				}
	}else{
		$QuID=$row_getinv['Quantity'];
							$NumberBreakdown23=NumberBreakdown($QuID, $returnUnsigned = false);
						$whole00=$NumberBreakdown23[0];
				$whole00=(abs($NumberBreakdown23[1])*$row_getinv['subqty']);

			if($row_getinv['sales_type']=="2"){
								$Qty="".$whole00.','.round($qty00)."";
				}else{
				$Qty=round($QuID);
				}
			//$QuID=$row_getinv['Quantity'];
			$R_Price=$row_getinv['Price'];
		}
	  #####################
 echo' <tr>
    <td></td>
    <td>'.$row_getinv['Total'].'</td>
    <td>'.$row_getinv['Discount'].'</td>
    <td>'.$R_Price.'</td>
    <td>'.$Qty.'</td>';
     if($use_sizes==1){echo'<td>'.Get_size_name($row_getinv['size']).'</td>'; }
    if($use_colors==1){ echo'<td>'.get_color_name($row_getinv['color']).'</td>';}
        
    echo'<td>'.$item_name.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$row_getinv['supplier'].'</td>
  </tr>';
  }
}
   $i++;
 }

  }
  ?>

</table>
<?php } ?>
