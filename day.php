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
    $result_suppliersq = mysqli_query($con,"SELECT * FROM ".$prefix."_clients where id='".$_GET['id']."'");
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
    <td colspan="11"><img src="images/print_icon.gif" style="border:0px; float:left;  width:30px; height:30px;" />
 <span style="font-weight:bold; font-size:18px;">
  <span>
    <?php echo"$Customer_Number_Balance"; ?> <?php echo"".$row_suppliers_idq."" ?>	/ </span>	
<?php print $row_suppliers_nameq;
	 ?>
	 -  <?php echo"$from_lang"; ?> <span><?php echo"".$from.""; ?></span> <?php echo"$to_lang"; ?> <span><?php echo"".$to.""; ?></span>
</span>
     </td>
  </tr>
  <tr bgcolor="#CCEFC7">
    <td width="11%" rowspan="2"><?php echo"$the_Balance_lang"; ?></td>
    <td width="13%" rowspan="2"><?php echo"$the_total_lang"; ?></td>
    <td width="11%" rowspan="2"><?php echo"$the_Discount_lang"; ?></td>
    <td width="9%" rowspan="2"><?php echo"$the_Price_lang"; ?></td>
    <td width="9%" rowspan="2"><?php echo"$the_Quantity_lang"; ?></td>
    <td width="16%" rowspan="2"><?php echo"$Detail_lang"; ?></td>
    <td width="16%" rowspan="2"><?php echo"$The_client_lang"; ?></td>
    <td width="9%" rowspan="2"><?php echo"$invoice_number_lang"; ?></td>
    <td colspan="2"><?php echo"$the_Process_lang"; ?></td>
    <td width="11%" rowspan="2"><?php echo"$the_date_lang"; ?></td>
  </tr>
  <tr>
    <td width="6%"><?php echo"$credit_lang"; ?></td>
    <td width="5%"><?php echo"$Debit_lang"; ?></td>
  </tr>
  <?php
$result_get = mysqli_query($con,"SELECT * FROM ".$prefix."_sales_inv where left (date,10) BETWEEN '$from' AND '$to' order by date ASC");
if(mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	  $Type=$row_get['type'];
	  $date=substr($row_get['date'], 0, 10);
	  $Total=$row_get['Total'];
	  $Totalnext+=$row_get['Total'];
	  
	  if($Total<0){$totalB=$Total;}else{$totalB=""; }
	  if($Total>=0){$totalA=$Total;}else{$totalA="";}
	  
	  if($row_get['type']=="3"){$totalABtitle="$cash_lang";}else{
		   if($Total<0 and $Type==1){$totalABtitle="$Purchases_st_lang";}else{
	   if($Total<0){ $totalABtitle="$Sales_returns_lang"; }else{}
	   if($Total>=0){ $totalABtitle="$sales_st_lang";}else{}
		   }
	  }
		
	 
	  echo'
  <tr bgcolor="#CCCCCC">
    <td>'.$Totalnext.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>'.$totalABtitle.'</td>
	<td>'.$row_get['supplier'].'</td>
    <td>'.$row_get['inv_id'].'</td>
    <td>'.$totalB.'</td>
    <td>'.$totalA.'</td>
    <td>'.$date.'</td>
  </tr>
';
  $result_getinv = mysqli_query($con,"SELECT * FROM ".$prefix."_sales where inv_id='".$row_get['inv_id']."'");

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
 echo' <tr>
    <td></td>
    <td>'.$row_getinv['Total'].'</td>
    <td>'.$row_getinv['Discount'].'</td>
    <td>'.$row_getinv['Price'].'</td>
    <td>'.$row_getinv['Quantity'].'</td>
    <td>'.$item_name.'</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
  </tr>';
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td><?php echo"$the_total_lang"; ?></td>
  </tr>
</table>
<?php } ?>
