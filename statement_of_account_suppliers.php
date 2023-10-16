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
							echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
						} else {
							echo '<img src="uploads/'.$get_db_Logo.'" style="float:left; border:0px;"/>';
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
    <div style="width:30%; float:right;"><label style="float:right; font-size:16px;"><?php echo"$to_lang"; ?></label> <input type="date" name="to" id="to" value="<?php if(isset($_GET['to'])){echo"".$_GET['to']."";}else{echo date("d/m/Y");}?>" class="w100" />  
	<script type="text/javascript">
				$('#to').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script>
            
        </div><input type="submit" value="<?php echo"$View_report_lang"; ?>" class="button" style="float:right;" />
        <input type="hidden" name="id" value="<?php echo"".$_GET['id'].""; ?>" />
    </form>
</div>
<?php
if(isset($_GET['id']) and isset($_GET['from']) and isset($_GET['to'])){ ?> 
    <?php
    $result_suppliersq = mysqli_query($con,"SELECT * FROM ".$prefix."_suppliers where id='".$_GET['id']."'");
if(mysqli_num_rows($result_suppliersq)>0){
while($row_suppliersq = mysqli_fetch_array($result_suppliersq))
  {
	 $row_suppliers_idq=$row_suppliersq['id'];
	 $row_suppliers_nameq=$row_suppliersq['name'];
  }
}
?>
<table width="200" border="1" style="width:100%; border-collapse:collapse; text-align:center; font-size:15px; font-family:Tahoma, Geneva, sans-serif;">
 <tr bgcolor="#CCCCCC">
    <td colspan="12"><a href="#" onClick="window.print()"><img src="images/print_icon.gif" style="border:0px; float:left;  width:30px; height:30px;" /></a>
 <span style="font-weight:bold; font-size:18px;">
  <span>
    <?php echo"$Supplier_balance_lang"; ?><?php print $row_suppliers_idq; ?>	/ </span>	
<?php print $row_suppliers_nameq;
	 ?>
	 -  <?php echo"$from_lang"; ?><span><?php echo"".$from.""; ?></span> <?php echo"$to_lang"; ?> <span><?php echo"".$to.""; ?></span>
</span>
     </td>
  </tr>
  <tr bgcolor="#CCEFC7">
    <td width="11%" rowspan="2"><?php echo"$the_Balance_lang"; ?></td>
    <td width="13%" rowspan="2"><?php echo"$the_total_lang"; ?></td>
    <td width="11%" rowspan="2"><?php echo"$the_Discount_lang"; ?></td>
    <td width="9%" rowspan="2"><?php echo"$the_Price_lang"; ?></td>
      <?php  if($use_colors==1){ echo'<td width="9%" rowspan="2">'.$the_Color_lang.'</td>'; } ?>
         <?php  if($use_sizes==1){ echo'<td width="9%" rowspan="2">'.$the_Size_lang.'</td>'; } ?>
    <td width="9%" rowspan="2"><?php echo"$the_Quantity_lang"; ?></td>
    <td width="16%" rowspan="2"><?php echo"$Detail_lang"; ?></td>
    <td width="9%" rowspan="2"> <?php echo"$invoice_number_lang"; ?></td>
    <td colspan="2"><?php echo"$the_Process_lang"; ?></td>
    <td width="11%" rowspan="2"><?php echo"$the_date_lang"; ?></td>
  </tr>
  <tr>
    <td width="6%"><?php echo"$credit_lang"; ?></td>
    <td width="5%"><?php echo"$Debit_lang"; ?></td>
  </tr>
  <?php
  $result_getw = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings_inv where supplier='".$_GET['id']."' and left(date,10) < '$from'");

if(mysqli_num_rows($result_getw)>0){
while($row_getw = mysqli_fetch_array($result_getw))
  {
	$Totallast+=$row_getw['Total'];
  }
  }
  ######################
  $result_getbalance = mysqli_query($con,"SELECT balance FROM ".$prefix."_suppliers where id='".$_GET['id']."'");
if(@mysqli_num_rows($result_getbalance)>0){
while($row_getbalance = mysqli_fetch_array($result_getbalance))
  {
	$totalgetbalance=$row_getbalance['balance'];
  }
}
####################
$Totalnext=$totalgetbalance+$Totallast;
  ?>
  <tr bgcolor="#CCCCCC">
    <td><?php echo $Totalnext; ?></td>
    <td colspan="5"><?php echo"$Balance_carried_lang"; ?></td>
    <td></td>
    <td></td>
    <td></td>
   <?php  if($use_colors==1){ echo'<td></td>'; } ?>
         <?php  if($use_sizes==1){ echo'<td></td>'; } ?>
    <td></td>
  </tr>
  <?php
$result_get = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings_inv where supplier='".$_GET['id']."' and left (date,10) BETWEEN '$from' AND '$to' order by date ASC,id ASC");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	   $Type=$row_get['type'];
	  $date=substr($row_get['date'], 0, 10);
	  $Total=$row_get['Total'];
	  $Totalnext+=$row_get['Total'];
	   $notes=$row_get['notes'];
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
	   if($Total>=0 and $Type==2){ $totalABtitle="$cash_lang";}else{
	   if($Total<0){ $totalABtitle="$Returns_Purchases_lang"; }else{}
	   if($Total>=0){ $totalABtitle="$Purchases_st_lang";}else{}
	   }
	   }
	  }
		
	 
	  echo'
  <tr bgcolor="#CCCCCC">
    <td>'.$Totalnext.'</td>
    <td>&nbsp;</td>';
    if($use_colors==1){echo' <td>&nbsp;</td>'; }
      if($use_sizes==1){echo' <td>&nbsp;</td>'; }
    echo'<td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$totalABtitle.'</td>
    <td>'.$row_get['inv_id'].'</td>
    <td>'.$totalB.'</td>
    <td>'.$totalA.'</td>
    <td>'.$date.'</td>
  </tr>
';
  $result_getinv = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings where inv_id='".$row_get['inv_id']."'");
 if($row_get['type']=="3"){}else{
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
	  #####################
	  
	  				$QuID=$row_getinv['Quantity'];
						  		$whole00 = floor($QuID); 
			$qty00=round((($QuID-$whole00)*$row_getinv['subqty']));
		if($row_getinv['unit']=="2"){
			$Qty="".$whole00.','.$qty00."";
		}else{
			$Qty=$row_getinv['Quantity'];
			}
 echo' <tr>
    <td></td>
    <td>'.$row_getinv['Total'].'</td>
    <td>'.$row_getinv['Discount'].'</td>
    <td>'.$row_getinv['BuyPrice'].'</td>';
         if($use_colors==1){echo'<td>'.get_color_name($row_getinv['color']).'</td>'; }
   if($use_sizes==1){echo' <td>'.Get_size_name($row_getinv['size']).'</td>'; }
   echo' <td>'.$Qty.'</td>
    <td>'.$item_name.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>';
  }
}
 }
   $i++;
 }

  }
  ?>
  <tr>
    <td><?php echo"".$Totalnext.""; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php  if($use_colors==1){echo'<td></td>'; } ?>
    <?php  if($use_sizes==1){echo'<td></td>'; } ?>
    <td>&nbsp;</td>
    <td><?php echo"$the_total_lang"; ?></td>
  </tr>
</table>
<?php } ?>
