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
                                                            <?php
			if($user_Expenses!=="1" and $user_IsAdmin!=1){
				echo"<div style='margin-top:200px;text-align:center;font-family:Tahoma, Geneva, sans-serif;color:#666; font-weight:bold; font-size:14px;'>عفواً , ليست لديك الصلاحية لدخول هذه الصفحة</div>";
				}else{ ?>
            <?php
if($_GET['del']!==null){
 mysqli_query($con,"DELETE FROM ".$prefix."_fawry WHERE id='".$_GET['del']."'");
	}
?>
     <?php

 $checkbox = $_POST['cb']; //from name="checkbox[]"
$countCheck = count($_POST['cb']);
 for ($i=0; $i<=$countCheck; $i++) {
$del_id  = $checkbox[$i];
mysqli_query($con,"DELETE FROM ".$prefix."_fawry WHERE id='".$del_id."'");
if($i==$countCheck-1){
		echo'<div style="text-align:center; background-color:#95D183; border-radius:5px;float:right;width:100%; margin:0 auto;"">
<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
تم الحذف بنجاح
</div>';  
header("refresh:1;url=fawry_pay.php");
	}
		  }
 //
/* if(mysqli_query($con,"DELETE FROM country_t WHERE  country_id='".$del_id."'")){
#############
	 }*/
	
     ?>
            <?php
			if(isset($_POST['add']) or isset($_POST['modification'])){
$type=Trim(stripslashes($_POST['type']));
$Amount=Trim(stripslashes($_POST['Amount']))*-1;
$_POST['date']=str_replace("/", "-", $_POST['date']);
$date=Trim(date('Y-m-d',strtotime($_POST['date'])));
if($Amount==null){
							echo'<div style="text-align:center;  background-color:#E18C80; border-radius:5px;float:right;width:100%; margin:0 auto;">
<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
لم يتم حفظ البيانات , برجاء ادخال نوع الخدمة و المبلغ و التاريخ
</div>';
}else{
$Employee=Trim(stripslashes($_POST['Employee']));
$details=Trim(stripslashes($_POST['details']));

if(isset($_POST['modification'])){

			$sql="UPDATE ".$prefix."_fawry SET type='".$type."',Amount='".$Amount."',date='".$date."',Employee='".$Employee."',details='".$details."' where id=".$_POST['id']."";
	}else{
			$sql="INSERT INTO ".$prefix."_fawry (type, Amount, date, Employee, details)
VALUES ('0','".$Amount."','".$date."','".$Employee."','".$details."')";
	}
if (!mysqli_query($con,$sql))
  {
	echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;float:right;width:100%; margin:0 auto;">
<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
لم يتم حفظ البيانات , برجاء اعد المحاولة
</div>';
  }else{
	echo'<div style="text-align:center; background-color:#95D183; border-radius:5px;float:right;width:100%; margin:0 auto;"">
<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
تم حفظ البيانات
</div>';  
######################
					if($type==0){$ex_typex="مدفوعات فورى";}
$sqlt="INSERT INTO ".$prefix."_treasury (type, Amount, date, notes)
VALUES ('55','".($Amount)."','".date("Y-m-d G:i:s")."','".$ex_typex."')";

	if (!mysqli_query($con,$sqlt))
  {
	 // die($paid);
  }
######################
header("refresh:1;url=fawry_pay.php?limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&page=".$_GET['page']."");
}
			}
			}
?>
<?php /*?><div class="text-center">
<button onclick="javascript:location.href='users.php'" style="width:150px; height:50px;">المستخدمين و الصلاحيات</button>
<button onclick="javascript:location.href='groups.php'" style="width:100px; height:50px;">المجموعات</button>
<button onclick="javascript:location.href='config.php'" style="width:100px; height:50px;">الاعدادات العامة</button>
</div><?php */?>
   <fieldset class="clearfix">
<legend  align="right">مدفوعات فورى:</legend> 
 <?php /*?>   <div id="add"></div><?php */?>
 <?php
 if($_GET['Edit']!==null){
$isedit=1;
			$result_expenses = mysqli_query($con,"SELECT * FROM ".$prefix."_fawry where id='".$_GET['Edit']."'");
if(mysqli_num_rows($result_expenses)>0){
while($row_expenses = mysqli_fetch_array($result_expenses))
  {
	 $row_expenses_id=$row_expenses['id'];
	 $row_expenses_Amount=$row_expenses['Amount'];
	 $row_expenses_Employee=$row_expenses['Employee'];
	 $row_expenses_method=$row_expenses['method'];
	 $row_expenses_type=$row_expenses['type'];
	 $row_expenses_number=$row_expenses['number']; 

	 $row_expenses_details=$row_expenses['details'];
	 $row_expenses_user=$row_expenses['user'];
	 $row_expenses_date=$row_expenses['date'];
	 $row_expenses_date=date('d/m/Y',strtotime($row_expenses_date));
	 $row_expenses_state=$row_expenses['state'];
	 
  }
}
	 }else{
		 
		 }
	 ?>
  <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
 <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
  <tr>
        <th><h2>الخدمة</h2></th>
        <td>
        <div class="row">
 <select name="type" size="1" class="w100">
<option value="" <?php echo" selected"; ?>>مدفوعات فورى</option>


          </select>
   
        </div>
        </td>
        <td style="text-align:right; direction:rtl;"><h2>المبلغ</h2></td>
        <td width="24%" style="text-align:right; direction:rtl;"><div class="row"><input type="text" name="Amount" value="<?php echo"".$row_expenses_Amount.""; ?>"  class="w100"/></div></td>
        <td width="14%" style="text-align:right; direction:rtl;"><h2>التاريخ</h2></td>
        <td width="22%"><div class="row"><input type="text" name="date" value="<?php if($row_expenses_date==""){echo date("d/m/Y");}else{echo"".$row_expenses_date."";} ?>" id="date"  class="w100" />
                  <script type="text/javascript">
				$('#date').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script></div></td>
      </tr>       
      <tr>
        <th width="8%" ><h2>الموظف</h2></th>
        <td width="22%"><div class="row"><input type="text" name="Employee" value="<?php echo"".$row_expenses_Employee.""; ?>"  class="w100"/></div>
</td>
        <td width="10%" ><h2>تفاصيل</h2></td>
        <td colspan="3" ><div class="row"><textarea name="details" class="w100"><?php echo"".$row_expenses_details.""; ?></textarea></div></td>
      </tr>
      
      <tr>
        <th colspan="6" class="text-center"><div class="row">
        <?php
		if($isedit==1){
			echo'<input type="submit" name="modification" id="modification" value="تعديل" class="button"  />';
			echo'<input type="hidden"  name="id" value="'.$row_expenses_id.'"/>';
			}else{
			echo'<input type="submit" name="add" id="add" value="حفظ" class="button"  />';
			}
		?>
        <input type="button" class="button"  value="الغاء" onclick="javascript:location.href='staff.php'"  />
        </div></th>
      </tr>
      <tr  class="text-right">
        <th ></th>
        <td></td>
        <td style="text-align:right; vertical-align:middle;"></td>
        <td style="text-align:right; direction:rtl;"></td>

      </tr>
  </table>
  </fieldset>        
  </form>
    <form id="mainform" action="" method="post">
  <table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;" class="container" id="container">
<!--    <header style="background-color:#CCC;">
sdfsdfsdf
  </header>-->
  <thead style="background-color:#CCC;">
<th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>
  
  <th class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">الكود</a></th>
  
  <th class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="type"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="type"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=type&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">الخدمة</a></th>
  
  <th class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="Amount"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Amount"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=Amount&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">المبلغ</a></th>
  
  <th class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">التاريخ</a></th>
  
  <th  class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="Employee"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Employee"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=Employee&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">الموظف</a></th>
  
  <th  class="<?php if($_GET['type']=="ASC" and $_GET['orderby']=="details"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="details"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=details&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines">تفاصيل</a></th>
  <th></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="fawry";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_fawry where type='0' order by $orderby $type";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
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
	$sql = "SELECT * FROM ".$prefix."_fawry where type='0'  order by $orderby $type LIMIT $start, $limit";			
	$result = @mysqli_query($con,$sql);
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage&page=$prev\">>></a>";
		else
			$pagination.= "<span class=\"disabled\">>></span>";	
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
				if($row['type']==1){$ex_type="شحن فودافون";}
				else if($row['type']==2){$ex_type="شحن اتصالات";}
				else if($row['type']==3){$ex_type="شحن موبينيل";}
				else if($row['type']==4){$ex_type="المصرية للاتصالات";}
				else if($row['type']==5){$ex_type="TD-DATA";}
				else if($row['type']==6){$ex_type="LINK-DSL";}
				else{$ex_type="مدفوعات فورى";}
?>


  <tr class="<?php echo"".$class.""; ?>">
  <td><input type="checkbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
  <td><?php echo"".$row['id'].""; ?></td>
  <td><?php echo"".$ex_type.""; ?></td>
  <td><?php echo"".$row['Amount'].""; ?></td>
  <td><?php echo"".substr($row['date'], 0, 10).""; ?></td>
  <td><?php echo"".$row['Employee'].""; ?></td>
   <td><?php echo"".$row['details'].""; ?></td>
  <td>
 
<a  onclick="return confirm('هل أنت متأكد أنك تريد الحذف؟');" href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&del=<?php echo"".$row['id'].""; ?>" ><img src="images/erase.png"/></a>
<a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&Edit=<?php echo"".$row['id'].""; ?>"><img src="images/edit.png"/></a></td>
  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
  <th colspan="7"><?php echo"$pagination"; ?></th>
 <th><a href="#">
  <a href="#" onClick="confirmSubmit();"><img src="images/erase.png"/></a></th>
  </thead>
  </table> 
  </form>   
   <?php } ?>
							</article>

							<!--    <nav>nav</nav>-->
							<!-- <aside>aside</aside>-->
							</div>

                            <div id="toolbar">
							<footer>
 <?php include"includes/scroller_container.php"; ?>
							</footer>
        </div>
							</body>

							</html>
<?php include 'includes/footer.php'; ?>
