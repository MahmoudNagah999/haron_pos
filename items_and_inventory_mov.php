 <?php
include "includes/inc.php";
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
$id=stripslashes($_GET['id']);
######################################
$result_getbalance = mysqli_query($con,"SELECT Quantity FROM items where id='".$_GET['id']."'");
if(@mysqli_num_rows($result_getbalance)>0){
while($row_getbalance = mysqli_fetch_array($result_getbalance))
  {
	$totalgetbalance=$row_getbalance['Quantity'];
  }
}
############################
  $sqlalast = "SELECT item,id,Quantity,date,SupplierID FROM ".$prefix."_receivings where item='$id' and left(date,10) < '$from'  UNION ALL SELECT item,id,Quantity*-1,date,SupplierID FROM ".$prefix."_sales where item='$id'  and left(date,10) < '$from' order by DATE(date) ASC,id  ASC";
  //$sqla = "SELECT * 
  //FROM sales t1
  //LEFT JOIN receivings t2 ON t1.inv_id=t2.inv_id AND t1.item=t2.item AND t1.Quantity=t2.Quantity AND t1.SupplierID=t2.SupplierID AND t1.date=t2.date";	
$resultalast = @mysqli_query($con,$sqlalast);
while($rowalast = @mysqli_fetch_array($resultalast))
{
$Quantitytotallast+=$rowalast['Quantity'];
}
####################
$Quantitytotala=$totalgetbalance+$Quantitytotallast;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title><?php echo"".$get_db_CompanyName.""; ?></title>
        		
                <style type="text/css">

/* printer specific CSS */
@media print
{
  #contentnoprint { display:none;}
  #contentnoprint2 { display:none;}
  #contentnoprint3 { display:none;}
}
</style>
  <?php include"includes/css.php"; ?>
<?php include"includes/js.php"; ?>
        </head>
                                                <?php
			if($user_SalesReports!=="1" and $user_IsAdmin!=1){
				  echo'<div class="alert alert-warning text-right">
                            '.$not_have_permission_lang.'
                            </div>';
				}else{ ?>
<div class="text-center">
<?php

echo"$Process_item_lang  ";
if(isset($_GET['id'])){
 $result_item = mysqli_query($con,"SELECT item,subqty FROM items WHERE id=".$_GET['id']."");
if(@mysqli_num_rows($result_item)>0){
while($row_item=mysqli_fetch_array($result_item))
  {
	  print $item_name= '( ' .$row_item['item'].' ) ';
          $item_subqty=$row_item['subqty'];
  }
}
	  } echo"  $from_lang "; print $_GET['from']; echo" $to_lang "; print $_GET['to']; ?></div>
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
<table width="100%" border="1" style="border-collapse:collapse; direction:rtl; text-align:center; font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
  <tr style="background-color:#AFD0E0;">
      <th colspan="4" scope="col" class="text-center"><?php echo"$go_lang"; ?></th>
    <th colspan="4" scope="col" class="text-center"><?php echo"$go_in_lang"; ?></th>
    <th rowspan="2" scope="col" class="text-center"><?php echo"$Customer_supplier"; ?>  </th>
    <th rowspan="2" scope="col" class="text-center"><?php echo"$the_Balance_lang"; ?></th>
  </tr>
 <tr style="background-color:#AFD0E0;">
    <th scope="col" class="text-center"><?php echo"$num_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_Size_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_Color_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_date_lang"; ?></th>
    
    <th scope="col" class="text-center"><?php echo"$num_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_Size_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_Color_lang"; ?></th>
    <th scope="col" class="text-center"><?php echo"$the_date_lang"; ?></th>
  </tr>
  <tr  style="background-color:#AFD0A9;">
      <td colspan="9" class="text-center"><?php echo"$Balance_carried_lang"; ?></td>
      <?php
      $row_items_Quantityq = $Quantitytotala;
      $NumberBreakdown2q=NumberBreakdown($row_items_Quantityq, $returnUnsigned = false);
      $all_qty002q=round((abs($NumberBreakdown2q[1])*$item_subqty));
      $row_items_Quantityq="$NumberBreakdown2q[0],$all_qty002q";
      ?>
    <td class="text-center"><?php echo"".$row_items_Quantityq.""; ?></td>
  </tr>
  <?php
  $Quantitytotal=$Quantitytotala;
  $sqla = "SELECT item,subqty,unit,id,Quantity,date,SupplierID,size,color FROM ".$prefix."_receivings where item='$id' and left (date,10) BETWEEN '$from' AND '$to' UNION ALL SELECT item,subqty,sales_type,id,Quantity*-1,date,SupplierID*-1,size,color FROM ".$prefix."_sales where item='$id'   and left (date,10) BETWEEN '$from' AND '$to' order by DATE(date) ASC,id  ASC";
  //$sqla = "SELECT * 
  //FROM sales t1
  //LEFT JOIN receivings t2 ON t1.inv_id=t2.inv_id AND t1.item=t2.item AND t1.Quantity=t2.Quantity AND t1.SupplierID=t2.SupplierID AND t1.date=t2.date";	
$resulta = @mysqli_query($con,$sqla);
while($rowa = @mysqli_fetch_array($resulta))
{
	if($rowa['Quantity']<0){$q="outgoing";}else if($rowa['Quantity']>0){$q="incoming";}else{}
?>
	
  
  <tr>
    <th scope="row" class="text-center"><?php if($q=="outgoing"){

$NumberBreakdown=NumberBreakdown($rowa['Quantity'], $returnUnsigned = false);
				$all_qty00=(abs($NumberBreakdown[1])*$rowa['subqty']);
		echo'<span style="color:#F00;">'.$NumberBreakdown[0].','.$all_qty00.' </span>';
		} ?></th>
       <td class="text-center"><?php  if($q=="outgoing"){echo"".Get_size_name($rowa['size'])."";} ?></td>
     <td class="text-center"><?php  if($q=="outgoing"){echo"".get_color_name($rowa['color'])."";} ?></td>
    <th scope="row" class="text-center"><?php if($q=="outgoing"){echo"".substr($rowa['date'], 0, 10)."";} ?></th>
    <td class="text-center"><?php if($q=="incoming"){ 
	if($rowa['unit']=="2"){
		$NumberBreakdownq=NumberBreakdown($rowa['Quantity'], $returnUnsigned = false);
				$all_qtyq=(abs($NumberBreakdownq[1])*$rowa['subqty']);
		echo''.$NumberBreakdownq[0].','.$all_qtyq.'';
		}else{
	 echo"".$rowa['Quantity']."";
	}
	 
	  } ?></td>
    <td class="text-center"><?php  if($q=="incoming"){echo"".Get_size_name($rowa['size'])."";} ?></td>
     <td class="text-center"><?php  if($q=="incoming"){echo"".get_color_name($rowa['color'])."";} ?></td>
    <td class="text-center"><?php if($q=="incoming"){echo"".substr($rowa['date'], 0, 10)."";} ?></td>
    <td class="text-center"><?php if($rowa['SupplierID']==null or $rowa['SupplierID']=="0"){echo"$cash_lang";}else{
		$supp=abs($rowa['SupplierID']);
		if($rowa['SupplierID']<0){
			
			$result_suppliersw = mysqli_query($con,"SELECT id,name FROM ".$prefix."_clients WHERE id=".$supp."");
			 }else {
				$result_suppliersw = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$supp.""); 
				 }
if($rowa['SupplierID']=="" or $rowa['SupplierID']==null or $rowa['SupplierID']=="0"){}else{
if(@mysqli_num_rows($result_suppliersw)>0){
while($row_suppliersw = mysqli_fetch_array($result_suppliersw))
  {
	  print $supplier_namew=$row_suppliersw['name'];
  }
}
}
			}
 ?></td>
    <td class="text-center"><?php 
	 $Quantitytotal+=$rowa['Quantity'];
	
			
			$NumberBreakdown2=NumberBreakdown($Quantitytotal, $returnUnsigned = false);
				$all_qty002=(abs($NumberBreakdown2[1])*$rowa['subqty']);
		echo'<span style="color:#F00;">'.$NumberBreakdown2[0].','.$all_qty002.' </span>';
	 ?></td>
  </tr>
  <?php } ?>
</table>
<?php } ?>