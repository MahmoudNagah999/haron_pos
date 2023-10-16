<?php
include "includes/inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo"".$get_db_CompanyName.""; ?></title>
<style>
    @media print
{
  #contentnoprint { display:none;}
}
body
{
	background-color:#FFFFFF;
	font-size:75%;	
}
#receipt_general_info{
	float:right;
	padding-right:5px;}
#employee{
	float:right;padding-right:5px;}	
#menubar,#footer
{
	display:none;
}

#content_area
{
	width:100%;
}

#content_area_wrapper
{
	border:0px;
}

#sale_return_policy
{
	width:100%;
	text-align:center;
}

.long_name
{
	display:none;
}

.short_name
{
	display:inline;
}

#receipt_items td
{
	white-space:nowrap;
}
#receipt_wrapper
{
	font-family:Tahoma, Geneva, sans-serif;
	width:100%;	
}

#receipt_header
{
	text-align:center;
}

#company_name
{
	font-size:150%;
	font-weight:bold;
}

#company_phone
{
	margin-bottom:15px;

}

#sale_time
{
	margin-bottom:5px;
}

#receipt_items
{
	position:relative;
	border-collapse:collapse;
	margin-top:15px;
	margin-bottom:15px;
	width:100%;
	direction:rtl;
}

#receipt_items td
{
	position:relative;
	padding:3px;	
}

.short_name
{
	display:none;
}

#sale_return_policy
{
	width:80%;
	margin:0 auto;
	text-align:center;
}

#barcode
{
	margin-top:10px;
	text-align:center;
}
</style>
  <?php include"includes/css.php"; ?>
</head>
    <?php
	if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
		$result_sales_inv = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings_inv where inv_id='".$_GET['id']."' limit 0,1");
		}else{
			$result_sales_inv = mysqli_query($con,"SELECT * FROM ".$prefix."_sales_inv where inv_id='".$_GET['id']."' limit 0,1");
			}

if(@mysqli_num_rows($result_sales_inv)>0){
	while($row_sales_inv = mysqli_fetch_array($result_sales_inv))
  {
	
	?>
<body <?php if($get_db_PrintingAftermarket=="1"){?> onload="window.print()" <?php } ?>>
<div id="content_area_wrapper">
<div id="content_area">
<div id="receipt_wrapper">
	<div id="receipt_header">
		<div>
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
		<?php echo"".$get_db_CompanyName.""; ?></div>
		<div><?php echo"".$Address.""; ?></div>
		<div><?php echo"".$get_db_Phone.""; ?></div>
		<div><?php if($row_sales_inv['type']=="1"){
			if($_GET['type']=="receivings"){echo"مشتريات";}else{
			echo"مبيعات";
			
			}
			
			}else if($row_sales_inv['type']=="2"){
				if($_GET['type']=="receivings_returns"){echo"مرتجعات مشتريات";}else{
				echo"مرتجع مبيعات";
				}
				}else{} ?></div>
		<div><?php echo"".substr($row_sales_inv['date'], 0, 10).""; ?></div>
	</div>
	<div id="receipt_general_info">
				<div id="sale_id"><span dir="rtl">رقم:</span><span dir="rtl"><?php echo"".$row_sales_inv['inv_id'].""; ?></span></div>
<div id="employee"><span dir="rtl">الموظف:</span><span dir="rtl"><?php echo"".$user_name.""; ?></span></div>

        
	</div>
    <?php
	if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
			   $result_search_suppliers = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$row_sales_inv['supplier']."");
if(@mysqli_num_rows($result_search_suppliers)>0){
while($row_search_suppliers= mysqli_fetch_array($result_search_suppliers))
  {
	  echo'<div style="text-align:center;"><br /><span dir="rtl">المورد:</span><span dir="rtl">'.$row_search_suppliers['name'].'</span></div>';
  }
}
	}
	
	if($_GET['type']=="sales_returns" or $_GET['type']=="sales" or $_GET['type']=="sale"){
		$result_search_clients = mysqli_query($con,"SELECT id,name FROM ".$prefix."_clients WHERE id=".$row_sales_inv['supplier']."");
if(@mysqli_num_rows($result_search_clients)>0){
while($row_search_clients= mysqli_fetch_array($result_search_clients))
  {
	  echo'<div style="text-align:center;"><br /><span dir="rtl">العميل:</span><span dir="rtl">'.$row_search_clients['name'].'</span></div>';
  }
}
		}
	#############################
	?>
    <div id="contentnoprint">
    <a href="#" onclick="javascript:void window.open('edit_invoice.php?id=<?php echo"".$_GET['id'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>','139093750264661','width=700,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;"><img src="images/edit.png" style="border:0px;"/></a>
    </div>
	<table id="receipt_items" border="1" style="text-align:center; border:1px;">
            <tr style="background-color:#CCC;" class="text-center">
	<th style="width:25%;" class="text-center">المسلسل</th>
	<th style="width:25%;" class="text-center">المنتج</th>
    <th style="width:16%;text-align:center;">الكمية</th>
      <?php if($use_sizes==1){echo' <th style="width:16%;text-align:center;">المقاس</th>'; } ?>
        <th style="width:16%;text-align:center;">اللون</th>
	<th style="width:17%;" class="text-center">السعر</th>
	
	<th style="width:16%;text-align:center;">خصم <?php if($Discount_type=="2"){echo"%";} ?></th>
	<th style="width:17%;text-align:right;">الاجمالى</th>
	</tr>
    <?php
    		if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
$result_inv = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings where inv_id='".$_GET['id']."'");
		}else{
$result_inv = mysqli_query($con,"SELECT * FROM ".$prefix."_sales where inv_id='".$_GET['id']."'");			
			}
if(@mysqli_num_rows($result_inv)>0){
	$i=1;
while($row_inv = mysqli_fetch_array($result_inv))
  {
	  ####################
	  if($row_inv['item']==null or $row_inv['item']==""){
		  $item_name=$row_inv['item'];
		  }else{
	  $result_item = mysqli_query($con,"SELECT item FROM items WHERE id=".$row_inv['item']."");
if(@mysqli_num_rows($result_item)>0){
while($row_item=mysqli_fetch_array($result_item))
  {
	  $item_name=$row_item['item'];
  }
}
	  }
	  #####################
	  
	  echo"
			<tr>
		<td>".$i."</td>
		<td>".$item_name."</td>
		<td style='text-align:center;'>";
      if($row_inv['sales_type']=="2"){
		  	//	$whole00 = floor($row_inv['Quantity']); 
			//	echo $all_qty00=round((($row_inv['Quantity']-$whole00)*$row_inv['subqty']));
				
				
				$NumberBreakdown=NumberBreakdown($row_inv['Quantity'], $returnUnsigned = false);
				echo $all_qty00=($NumberBreakdown[1]*$row_inv['subqty']);
      }else{
      if($row_inv['unit']=="2"){ 
	  echo 		round($row_inv['Quantity']*$row_inv['subqty']);
	   }else{
		    echo round($row_inv['Quantity']);
			}
      }
    if($use_sizes==1){  echo"<td>".Get_size_name($row_inv['size'])."</td>"; }
      echo"<td>".get_color_name($row_inv['color'])."</td>";
if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
	$it_price=$row_inv['BuyPrice'];
	}else{
		$it_price=$row_inv['Price'];
		}
      echo"</td>
		<td>".$it_price." ".$get_db_Currency."</td>
		
		<td style='text-align:center;'>".$row_inv['Discount']."</td>
		<td style='text-align:right;'>".$row_inv['Total']." ".$get_db_Currency."</td>
		</tr>";

		$i++;
		$total+=$row_inv['Total'];
		$totalQuantity+=$row_inv['Quantity'];
        }
}
        ?>

		<tr>
		  <td style='text-align:right;border-top:2px solid #000000;'>الاجمالى</td>
		  <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td style='text-align:center;border-top:2px solid #000000;'></td>
		  <td style='text-align:center;border-top:2px solid #000000;'></td>
                  <td style='text-align:center;border-top:2px solid #000000;'></td>
                  
                <?php  if($use_sizes==1){ echo"<td style='text-align:center;border-top:2px solid #000000;'></td>";} ?>
          <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td  style='text-align:center;border-top:2px solid #000000;'><?php echo"".$total." ".$get_db_Currency.""; ?></td>
	    </tr>
        		<tr>
		  <td style='text-align:right;border-top:2px solid #000000;'>خصم</td>
		  <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td style='text-align:center;border-top:2px solid #000000;'></td>
		  <td style='text-align:center;border-top:2px solid #000000;'></td>
                   <td style='text-align:center;border-top:2px solid #000000;'></td>
                                 <?php  if($use_sizes==1){ echo"<td style='text-align:center;border-top:2px solid #000000;'></td>";} ?>
          <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td  style='text-align:center;border-top:2px solid #000000;'><?php echo"".$row_sales_inv['discount']."".$get_db_Currency.""; ?></td>
	    </tr>
		<tr>
		  <td style='text-align:right;border-top:2px solid #000000;'><span style="text-align:right;">طريقة الدفع</span></td>
		  <td style='text-align:center;border-top:2px solid #000000;'><span style="text-align:right;"><?php
		  if($row_sales_inv['PaymentMethod']=="1"){
		   echo"نقدى";
		  }else if($row_sales_inv['PaymentMethod']=="2"){
			  echo"آجل";
			  }else if($row_sales_inv['PaymentMethod']=="3"){
				echo"شيك";  
			  }else{}
		    ?></span></td>
		  <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td style='text-align:center;border-top:2px solid #000000;'>&nbsp;</td>
                   <td style='text-align:center;border-top:2px solid #000000;'>&nbsp;</td>
                <?php  if($use_sizes==1){ echo"<td style='text-align:center;border-top:2px solid #000000;'></td>";} ?>
		  <td style='text-align:right;border-top:2px solid #000000;'>&nbsp;</td>
		  <td  style='text-align:center;border-top:2px solid #000000;'><?php if($row_sales_inv['type']=="1"){echo"-";} ?><?php echo"".$row_sales_inv['paid']." ".$get_db_Currency.""; ?></td>
	    </tr>
        <tr>
		  <td style='text-align:right;'>المبلغ المتبقى</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
                  <td style='text-align:center;'>&nbsp;</td>
                              <?php  if($use_sizes==1){ echo"<td style='text-align:center;border-top:2px solid #000000;'></td>";} ?>
		  <td  style='text-align:center;'><span style="text-align:right"><?php
		  /*if($row_sales_inv['type']==1){
		   echo"".($Totalnext-$total-$row_sales_inv['paid'])." ".$get_db_Currency."";
		  }else if($row_sales_inv['type']==2){
			  echo"".($Totalnext-$total+$row_sales_inv['paid'])." ".$get_db_Currency."";
			  }else{}*/
			  print (abs($total)-$row_sales_inv['paid']-$row_sales_inv['discount']);
		    ?></span></td>
	    </tr>
		<tr>
		  <td style='text-align:right;'>اجمالى الرصيد</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
		  <td style='text-align:center;'>&nbsp;</td>
                   <td style='text-align:center;'>&nbsp;</td>
                <?php  if($use_sizes==1){ echo"<td style='text-align:center;border-top:2px solid #000000;'></td>";} ?>
		  <td  style='text-align:center;'>
            <?php
            if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings"){
                $result_getx = mysqli_query($con,"SELECT Total FROM ".$prefix."_receivings_inv where supplier=".$row_sales_inv['supplier']."");
            }else{
                $result_getx = mysqli_query($con,"SELECT Total FROM ".$prefix."_sales_inv where supplier=".$row_sales_inv['supplier']."");
            }

if(@mysqli_num_rows($result_getx)>0){
while($row_getx = mysqli_fetch_array($result_getx))
  {
	$totalreceivingsx+=$row_getx['Total'];
  }
}
            if($_GET['type']=="receivings_returns" or $_GET['type']=="receivings") {
                $result_getbalancex = mysqli_query($con, "SELECT balance FROM ".$prefix."_suppliers where id='" . $row_sales_inv['supplier'] . "'");
            }else{

                $result_getbalancex = mysqli_query($con, "SELECT balance FROM ".$prefix."_clients where id='" . $row_sales_inv['supplier'] . "'");
            }
if(@mysqli_num_rows($result_getbalancex)>0){
while($row_getbalancex= mysqli_fetch_array($result_getbalancex))
  {
	 $totalgetbalancex=$row_getbalancex['balance'];
  }
}
/*        $result_getpayments = mysqli_query($con,"SELECT Amount FROM ".$prefix."_customer_payments where  client='".$_GET['SupplierID']."'");
if(@mysqli_num_rows($result_getpayments)>0){
while($row_getgetpayments = mysqli_fetch_array($result_getpayments))
  {
	$totalgetpayments+=$row_getgetpayments['Amount'];
  }
}*/
print ($totalreceivingsx+$totalgetbalancex);
####################
	//print $Totalnext=($totalgetbalance+$Totallast);
	if(abs($totalreceivingsx+$totalgetbalancex)>0){ print "$get_db_Currency"; }
  ?>
          
          </td>
	    </tr>
        
		

	</table>
    
<?php
if($get_db_ReturnPolicy!==""){
	echo'<div id="sale_return_policy">
	'.$get_db_ReturnPolicy.'</div>';
}
?>
<?php
if($get_db_CustomField1!==""){
	echo'<div id="sale_return_policy">
	'.$get_db_CustomField1.'</div>';
}
?>
<?php
if($get_db_CustomField2!==""){
	echo'<div id="sale_return_policy">
	'.$get_db_CustomField2.'</div>';
}
?>
<?php
if($inv_barcode==1){ ?>
	<div id='barcode'>
    
	<img src='barcode_a.php?codetype=code128&size=100&text=<?php echo"000000".$row_sales_inv['inv_id'].""; ?>&text2=<?php echo""; ?>' /></div>
    <?php  } ?>
</div>
</div>
</div>
</body>
<script type="text/javascript">
$(window).load(function()
{
	window.print();
});
</script>
<?php }} ?>