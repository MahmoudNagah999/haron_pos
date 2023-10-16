<style>
.item{
background-color:#999;
}
.item a{
text-decoration:none;
color:#000;
font-size:14px;
}
.item2 a{
text-decoration:none;
color:#000;
font-size:14px;
}
.item2{
background-color:#CCC;
}
.item:hover{
background-color:#FFC;
}
.item2:hover{
background-color:#FFC;
}
</style>
<?php include_once("includes/inc.php"); ?>
<!--<div style="background-color:#C9C9C9; width:200px; float:right; border:0px;">

</div>-->
  <div id="suppliersName" class="text-center">
 
  <ul style="direction:rtl; width:45%; margin-top:0px; float:right;list-style: none;">
 <a href="<?php echo"".$_SERVER['HTTP_REFERER'].""; ?>"><img src="images/cancel.png" style="border:0px; float:left;" /></a>
<?php
$ser=$_GET['q'];
$result_search_suppliers = mysqli_query($con,"SELECT * FROM ".$prefix."_suppliers WHERE  name LIKE '%$ser%' or id='$ser' limit 0,20");
if(@mysqli_num_rows($result_search_suppliers)>0){
	$i=1;
while($row_search_suppliers = mysqli_fetch_array($result_search_suppliers))
  {
	  $issingle=$i/2;
	   $dot = strstr($issingle, '.');
			if($dot==""){
				$class="item";
			}else{
				$class="item2";
				}
  echo'<li class="'.$class.'"><a href="?reports=suppliers_receivings&SupplierID='.$row_search_suppliers['id'].'">'.$row_search_suppliers['name'].'</a></li>';
  $i++;
   }
}else{
	echo'<li class="item2"><a href="#">'.$no_data_lang.'</a></li>';
	}
  ?>
  </ul>
  </div>