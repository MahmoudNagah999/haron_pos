<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title><?php echo"".$get_db_CompanyName.""; ?></title>
                  <?php include"includes/css.php"; ?>
                 <?php include"includes/js.php"; ?>
	</head>
	<body  class="cmenu1 example-target">
	
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
<?php
include"includes/buttons.php";
?>			</div>
		
		<div id='main'>
			<article style="margin-bottom:70px;">
   <fieldset class="clearfix">
<legend  align="right"><?php echo"$Supplier_payments_lang"; ?>:
</legend> 
            <?php
if($_GET['del']!==null){
                                          if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
 if(mysqli_query($con,"DELETE FROM ".$prefix."_receivings_inv WHERE id='".$_GET['del']."'")){
         echo'<div class="alert alert-success text-right">
                      '.$Deletion_successfully_lang.'
                            </div>'; 
 }
      }}
?>
     <?php

 $checkbox = $_POST['cb']; //from name="checkbox[]"
$countCheck = count($_POST['cb']);
if($countCheck>0){
                                          if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
 for ($i=0; $i<=$countCheck; $i++) {
$del_id  = $checkbox[$i];
mysqli_query($con,"DELETE FROM ".$prefix."_receivings_inv WHERE id='".$del_id."'");
if($i==$countCheck-1){
		echo'<div class="alert alert-success text-right">
'.$Deletion_successfully_lang.'
</div>';  
header("refresh:1;url=payments_suppliers.php?id=".$_GET['id']."");
	}
		  }
}}
 //
/* if(mysqli_query($con,"DELETE FROM ".$prefix."_country_t WHERE  country_id='".$del_id."'")){
#############
	 }*/
	
     ?>
            <?php
			if(isset($_POST['add']) or isset($_POST['modification'])){
                                                                  if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else  if ($_POST['safe_id'] == "" ) {
                                                                      echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_safe.'
							</div>';
                                                                  }else{
$PaymentMethod=Trim(stripslashes($_POST['PaymentMethod']));
$Amount=Trim(stripslashes($_POST['Amount']));
$_POST['Date']=str_replace("/", "-", $_POST['Date']);
$Date=Trim(date('Y-m-d',strtotime($_POST['Date'])));
$_POST['Due_Date']=str_replace("/", "-", $_POST['Due_Date']);
$Due_Date=Trim(date('Y-m-d',strtotime($_POST['Due_Date'])));
$SupplierID=Trim(stripslashes($_GET['id']));
$notes=Trim(stripslashes($_POST['notes']));
if($SupplierID=="" or $Amount==null){
echo'<div class="alert alert-danger  text-right">
'.$enter_data_correctly_lang.'
</div>';
}else{


if(isset($_POST['modification'])){

			$sql="UPDATE ".$prefix."_receivings_inv SET supplier='".$SupplierID."',Total='".$Amount."',date='".$Date."',PaymentMethod='".$PaymentMethod."',DueDate='".$Due_Date."',notes='".$notes."',type='3' where id=".$_POST['id']."";
	}else{
			$sql="INSERT INTO ".$prefix."_receivings_inv (supplier, Total, date, PaymentMethod, DueDate, notes, type)
VALUES ('".$SupplierID."','".($Amount*-1)."','".$Date."','".$PaymentMethod."','".$Due_Date."','".$notes."','3')";
	}
if (!mysqli_query($con,$sql))
  {
 echo'<div class="alert alert-danger  text-right">
                    '.$not_saved_try_lang.'
                            </div>';
  }else{
 echo'<div class="alert alert-success text-right">
                          '.$Data_is_saved_lang.'
                            </div>';  
######################
$sqlt="INSERT INTO ".$prefix."_treasury (safe_id,type, Amount, date, notes)
VALUES ('".$_POST['safe_id']."','6','".($Amount*-1)."','".date("Y-m-d G:i:s")."','.$Pay_supplier_lang ".$SupplierID."')";

	if (!mysqli_query($con,$sqlt))
  {
	 // die($paid);
  }
######################
header("refresh:1;url=payments_suppliers.php?id=".$_GET['id']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&page=".$_GET['page']."");
}
			}
                        }}
 if($_GET['Edit']!==null){
$isedit=1;
			$result_payments = mysqli_query($con,"SELECT * FROM ".$prefix."_receivings_inv where id='".$_GET['Edit']."'");
if(mysqli_num_rows($result_payments)>0){
while($row_payments= mysqli_fetch_array($result_payments))
  {
	 $row_payments_id=$row_payments['id'];
	 $row_payments_Supplier=$row_payments['supplier'];
	 $row_payments_Amount=$row_payments['Total'];
	 $row_payments_Date=$row_payments['date'];
	 
	 $row_payments_PaymentMethod=$row_payments['PaymentMethod'];
	 $row_payments_Due_Date=$row_payments['DueDate']; 
    $row_payments_type=$row_payments['type'];
	 $row_payments_notes=$row_payments['notes'];
	 if($row_payments_Date=="1970-01-01"){$row_payments_Date="";}else{
		 $row_payments_Date=date('d/m/Y',strtotime($row_payments_Date));
		 }
	  if($row_payments_Due_Date=="1970-01-01"){$row_payments_Due_Date="";}else{
		   $row_payments_Due_Date=date('d/m/Y',strtotime($row_payments_Due_Date));
		  }
	 
	 
  }
}
	 }else{
		 
		 }
	 ?>
  <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
 <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
  <tr>
        <th class="text-right"><lable><?php echo"$The_Supplier_lang"; ?></lable></th>
        <td width="22%">
            <?php
$result_search_suppli = mysqli_query($con,"SELECT name FROM ".$prefix."_suppliers WHERE id='".$_GET['id']."'");
if(@mysqli_num_rows($result_search_suppli)>0){
while($row_search_suppliersid = mysqli_fetch_array($result_search_suppli))
  {
$suppliername=$row_search_suppliersid['name'];
  }
}
		 ?>
          
 
      
 <input type="text" name="SupplierName" disabled value="<?php echo"".$suppliername.""; ?>" onkeyup="showResults(this.value)"  autocomplete="off"   class="form-control"/>
 <div id="livesearchcl" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
   <input type="hidden" name="SupplierID" value="<?php echo"".$_GET['id'].""; ?>" />
    
        </td>
        <td class="text-right"><lable><?php echo"$the_amount_lang"; ?></lable></td>
        <td class="text-right">
                <input type="text" name="Amount" value="<?php echo"".$row_payments_Amount.""; ?>"  class="form-control"/>
         </td>

      <td class="text-right"><lable><?php echo"$Safe_name"; ?></lable></td>
      <td class="text-right">
          <select name="safe_id" size="1" class="js-example-placeholder-single  js-states form-control">
              <option value=""> <?php echo"$Safe_name"; ?></option>
              <?php
              $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id ASC");
              $num_item = mysqli_num_rows($ProductsName);
              if ($num_item > 0) {
                  while ($row_item = mysqli_fetch_array($ProductsName)) {
                      if ($row_item['id'] == $_POST['safe_id']) {
                          echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                      } else {
                          echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                      }
                  }
              }
              ?>
          </select>

      </td>

        <td class="text-right"><lable><?php echo"$the_date_lang"; ?></lable></td>
        <td class="text-right"><input type="text" name="Date" value="<?php if($row_payments_date==""){echo date("d/m/Y");}else{echo"".$row_payments_date."";} ?>" id="Date"  class="form-control" />
                  <script type="text/javascript">
				$('#Date').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script></td>
      </tr>       
      <tr>
        <td class="text-right"><lable><?php echo"$payment_method_lang"; ?></lable></td>
        <td class="text-right">
          <select name="PaymentMethod" size="1" class="form-control">
            <option value=""></option>
            <option value="1" <?php if($row_payments_PaymentMethod=="1"){echo" selected";} ?>><?php echo"$cash_lang"; ?></option>
            <option value="3" <?php if($row_payments_PaymentMethod=="3"){echo" selected";} ?>><?php echo"$check_lang"; ?></option>
          </select>
       </td>
        <td><lable><?php echo"$due_date_lang"; ?></lable></td>
        <td class="text-right">
          <input type="text" name="Due_Date" value="<?php if($row_payments_Due_Date==""){}else{
			  echo"".$row_payments_Due_Date."";} ?>" id="Due_Date"  class="form-control" />
                            <script type="text/javascript">
				$('#Due_Date').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script>
        </td>
        <td>&nbsp;</td>
        <td class="text-right">
        <?php
		if($_GET['id']!==null){ ?>
         <span><?php echo"$Supplier_balance_lang"; ?> : <?php
        $result_get = mysqli_query($con,"SELECT Total FROM ".$prefix."_receivings_inv where supplier=".$_GET['id']."");
if(@mysqli_num_rows($result_get)>0){
while($row_get = mysqli_fetch_array($result_get))
  {
	$totalreceivings+=$row_get['Total'];
  }
}

/*        $result_getpayments = mysqli_query($con,"SELECT Amount FROM ".$prefix."_payments_suppliers where Supplier='".$_GET['SupplierID']."'");
if(@mysqli_num_rows($result_getpayments)>0){
while($row_getgetpayments = mysqli_fetch_array($result_getpayments))
  {
	$totalgetpayments+=$row_getgetpayments['Amount'];
  }
}*/
$result_getbalance = mysqli_query($con,"SELECT balance FROM ".$prefix."_suppliers where id='".$_GET['id']."'");
if(@mysqli_num_rows($result_getbalance)>0){
while($row_getbalance = mysqli_fetch_array($result_getbalance))
  {
	$totalgetbalance=$row_getbalance['balance'];
  }
}
echo ($totalreceivings+$totalgetbalance);
?>
        </span>
        <a href="#" onclick="javascript:void window.open('statement_of_account_suppliers.php?id=<?php echo"".$_GET['id'].""; ?>&from=<?php echo"".date("Y-m-01").""; ?>&to=<?php echo"".date("Y-m-d").""; ?>','13909375026412','width=1024,height=600,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0,menubar=0');return false;"><img src="images/arrears_list.gif" style="border:0px;" title="<?php echo"$supplier_statement_lang"; ?>" /></a>
        <?php } ?>
        
        </td>
      </tr>
      <tr>
        <td class="text-right"><lable><?php echo"$Details_lang"; ?></lable></td>
        <td class="text-right"><lable>
          <textarea name="notes"   class="form-control"><?php echo"".$row_payments_notes.""; ?></textarea>
      </lable>         </td>
        </tr>
      
      <tr>
        <td class="text-right">
        <?php
		if($isedit==1){
			echo'<input type="submit" name="modification" id="modification" value="'.$Modify_lang.'" class="button"  />';
			echo'<input type="hidden"  name="id" value="'.$row_payments_id.'"/>';
			}else{
			echo'<input type="submit" name="add" id="add" value="'.$save_lang.'" class="button"  />';
			}
		?>
        <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href='suppliers.php'"  />
       </td>
      </tr>
      <tr>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>
        <td class="text-right"></td>

      </tr>
  </table>
  </fieldset>        
  </form>
    <form id="mainform" action="" method="post">
  <table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;" class="container" id="container">
  <thead style="background-color:#CCC;">
<th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?id=<?php echo"".$_GET['id'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
  
  <th class="text-center"><?php echo"$The_Supplier_lang"; ?></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Amount"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Amount"){echo"sort_d";}else{echo"sort0";}?>"><a href="?id=<?php echo"".$_GET['id'].""; ?>&orderby=Amount&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_amount_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?id=<?php echo"".$_GET['id'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>
  
  <th class="text-center"><?php echo"$payment_method_lang"; ?></th>
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Due_Date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Due_Date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?id=<?php echo"".$_GET['id'].""; ?>&orderby=Due_Date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"> <?php echo"$due_date_lang"; ?></a></th>
  <th class="text-center"><?php echo"$notes_lang"; ?></th>
  <th class="text-center"></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="".$prefix."_receivings_inv";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	if($_GET['orderby']==null){$_GET['orderby']="id";}
	if($_GET['type']==null){$_GET['type']="DESC";}
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_receivings_inv where type='3' and supplier='".$_GET['id']."' order by $orderby $type";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?id=".$_GET['id']."&limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
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

	$sql = "SELECT * FROM ".$prefix."_receivings_inv where type='3'  and supplier='".$_GET['id']."' order by $orderby $type LIMIT $start, $limit";			
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
			#################
			$issingle=$i/2;
			 $dot = strstr($issingle, '.');
			if($dot==""){
				$class="background_color_FFF";
				}else{$class='background_color_D5EFF0';}
				if($row['PaymentMethod']==1){$Payment_type="$cash_lang";}
				else if($row['PaymentMethod']==3){$Payment_type="$check_lang";}
				else{}
				######################
$result_search_suppliers = mysqli_query($con,"SELECT name FROM ".$prefix."_suppliers WHERE id='".$row['supplier']."'");
if(@mysqli_num_rows($result_search_suppliers)>0){

while($row_search_suppliers = mysqli_fetch_array($result_search_suppliers))
  {
	  $suppliersName=$row_search_suppliers['name'];
  }
}
if($row['DueDate']=="1970-01-01"){$row['DueDate']=null;}
?>


  <tr class="text-center <?php echo"".$class.""; ?>">
  <td class="text-center"><input type="checkbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
  <td class="text-center"><?php echo"".$row['id'].""; ?></td>
  <td class="text-center"><?php echo"".$suppliersName.""; ?></td>
  <td class="text-center"><?php echo"".$row['Total'].""; ?></td>
  <td class="text-center"><?php echo"".substr($row['date'], 0, 10).""; ?></td>
  <td class="text-center"><?php echo"".$Payment_type.""; ?></td>
   <td class="text-center"><?php echo"".$row['DueDate'].""; ?></td>
   <td class="text-center"><?php echo"".$row['notes'].""; ?></td>
  <td class="text-center">
 
<a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?id=<?php echo"".$_GET['id'].""; ?>&limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&del=<?php echo"".$row['id'].""; ?>" ><img src="images/erase.png"/></a>
<a href="?id=<?php echo"".$row['supplier'].""; ?>&SupplierID=<?php echo"".$row['supplier'].""; ?>&limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&Edit=<?php echo"".$row['id'].""; ?>"><img src="images/edit.png"/></a></td>
  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
  <th colspan="8"><?php echo"$pagination"; ?></th>
 <th class="text-center">
  <a href="#" onClick="confirmSubmit();"><img src="images/erase.png"/></a></th>
  </thead>
  </table> 
  </form>   
							</article>

							</div>

                            <div id="toolbar">
							<footer>
 <?php include"includes/scroller_container.php"; ?>
							</footer>
        </div>
							</body>

							</html>
                                                        <?php include 'includes/footer.php'; ?>


