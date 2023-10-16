<?php

include "includes/inc.php";

$search=$_GET['search'];
$orderby=$_GET['orderby'];
$type=$_GET['type'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<title><?php echo"".$get_db_CompanyName.""; ?></title>
                  <?php include"includes/css.php"; ?>
                 <?php include"includes/js.php"; ?>
			</head>
	<body class="cmenu1 example-target">
	
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
?>
			</div>
	
		<div id='main'>
			<article style="margin-bottom:70px;">
                                                            <?php
			if($user_employee!=="1" and $user_IsAdmin!=1){
				                       echo'<div class="alert alert-warning text-right">
                             '.$not_have_permission_lang.'
                            </div>';
				}else{ ?>
                            <div class="text-center">
 <?php include"includes/config_menu.php"; ?>
</div>
   <fieldset class="clearfix">
<legend  align="right"><?php echo"$the_regions_lang"; ?>:</legend>
             <?php
if($_GET['del']!==null){
      if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{


        mysqli_query($con,"DELETE FROM ".$prefix."_region WHERE id not 
              IN(select parent_id from ".$prefix."_region) and id='".$_GET['del']."'");
          if(mysqli_affected_rows($con) > 0 ){
   echo'<div class="alert alert-success text-right">
                      '.$Deletion_successfully_lang.'
                            </div>';   
}else{

              echo '<div class="alert alert-warning text-right">
                  '.$related_alert.'
                            </div>';
          }
      }
	}
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

              $error_msg = "" ;
 for ($i=0; $i<=$countCheck; $i++) {
$del_id  = $checkbox[$i];
mysqli_query($con,"DELETE FROM ".$prefix."_region WHERE id not IN(select parent_id from ".$prefix."_region) and id='".$del_id."'");


     if(mysqli_affected_rows($con) > 0 ){
         if($i==$countCheck-1){
             if(mysqli_affected_rows($con) > 0 ){
                 echo'<div class="alert alert-success text-right">
                      '.$Deletion_successfully_lang.'
                            </div>';
             }else{
                  $error_msg .= " المنطقه كود ".$del_id." لا يمكن حذفها لترابطها بمناطق اخرى";

             }

         }
     }else{

         $error_msg .= " المنطقه كود ".$del_id." لا يمكن حذفها لترابطها بمناطق اخرى";

     }

		  }
 if ($error_msg!= ""){
     echo '<div class="alert alert-warning text-right">
                  '.$related_alert .' التفصيل :  '.$error_msg.'
                            </div>';
 }
              header("refresh:1;url=region.php");

          }
}
 //
/* if(mysqli_query($con,"DELETE FROM country_t WHERE  country_id='".$del_id."'")){
#############
	 }*/
	
     ?>
 <?php
			if(isset($_POST['add']) or isset($_POST['modification'])){
                                  if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
            $name=Trim(stripslashes($_POST['name']));
			if($name=="" or $name==null){
                                                   echo'<div class="alert alert-danger text-right">
              '.$the_region_lang.'
                            </div>';
	}else{
$parent_id=Trim(stripslashes($_POST['parent_id']));
if(isset($_POST['modification'])){

			$sql="UPDATE ".$prefix."_region SET name='".$name."',parent_id='".$parent_id."' where id=".$_POST['id']."";
	}else{
			 $sql="INSERT INTO ".$prefix."_region (name, parent_id)
VALUES ('".$name."','".$parent_id."')";
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
header("refresh:1;url=region.php?limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&type=".$_GET['type']."&page=".$_GET['page']."");

}
			}
      }
			}
?>
  <?php
 if($_GET['Edit']!==null){
$isedit=1;
			$result_region = mysqli_query($con,"SELECT * FROM ".$prefix."_region where id='".$_GET['Edit']."'");
if(mysqli_num_rows($result_region)>0){
while($row_region = mysqli_fetch_array($result_region))
  {
	 $row_region_id=$row_region['id'];
	 $row_region_name=$row_region['name'];
      $row_region_parent_id=$row_region['parent_id'];
	 
  }
}
	 }else{

		 }
	 ?>
<br />
  <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
 <table  border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
  <tr>
        <td class="text-center"><lable><?php echo"$region_name"; ?></lable></td>
        <td class="text-right">

            <div class="col-12">
 <input type="text" name="name" value="<?php echo"".$row_region_name.""; ?>"  class="form-control"/>
   
        </div>
        </td>
                       </tr>
     <tr>
        <td class="text-center"><lable><?php echo"$parent_id_lang"; ?></lable></td>
        <td class="text-right">

        <div >
            <select name="parent_id" class="form-control"   ?>>
                              <option value=""></option>
                              <?php
                             $Groups_list = mysqli_query($con, "SELECT * FROM ".$prefix."_region   order by name ASC");
                              $num_Groups_list = mysqli_num_rows($Groups_list);
                              if ($num_Groups_list > 0) {
                                  while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                                      if ($row_Groups_list['id'] == $row_region_parent_id) {
                                          echo'<option value="' . $row_Groups_list['id'] . '"   selected="selected">' . $row_Groups_list['name'] . '</option>';
                                      } else {
                                          echo'<option value="' . $row_Groups_list['id'] . '">' . $row_Groups_list['name'] . '</option>';
                                      }
                                  }
                              }
                              ?>
                          </select>
        </div>
        </td>
                       </tr>


<!--      <tr>-->
<!--        <td class="text-center"><lable>--><?php //echo"$parent_id_lang"; ?><!--</lable></td>-->
<!--          <div>-->
<!--          <select name="parent_id" class="form-control" style="width:90%; float: right;" style="background-color:#FC9698" ?>>-->
<!--              <option value=""></option>-->
<!--              --><?php
//             $Groups_list = mysqli_query($con, "SELECT * FROM ".$prefix."_region where parent_id=0  order by name ASC");
//              $num_Groups_list = mysqli_num_rows($Groups_list);
//              if ($num_Groups_list > 0) {
//                  while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
//                      if ($row_Groups_list['id'] == $row_region_id) {
//                          echo'<option value="' . $row_Groups_list['id'] . '"   selected="selected">' . $row_Groups_list['name'] . '</option>';
//                      } else {
//                          echo'<option value="' . $row_Groups_list['id'] . '">' . $row_Groups_list['name'] . '</option>';
//                      }
//                  }
//              }
//              ?>
<!--          </select>-->
<!--          </div>-->
<!--      </tr>-->
      
      
      <tr>
        <th colspan="6" class="text-center"><div>
        <?php
		if($isedit==1){
			echo'<input type="submit" name="modification" id="modification" value="'.$Modify_lang.'" class="button"  />';
			echo'<input type="hidden"  name="id" value="'.$row_region_id.'"/>';
			}else{
			echo'<input type="submit" name="add" id="add" value="'.$save_lang.'" class="button"  />';
			}
		?>
        <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href='region.php'"  />
        </div></th>
      </tr>
      <tr class="text-right">
        <td></td>
        <td class="text-right"></td>

        <td style="text-align:right; vertical-align:middle;"></td>
        <td style="text-align:right; direction:rtl;"></td>

      </tr>
  </table>
  </fieldset>        
  </form>
  <form id="mainform" action="" method="post">
  <table border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; margin-bottom:40px; text-align:center;" class="container" id="container">
  <thead style="background-color:#CCC;">
<th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="name"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="name"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=name&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_name_lang"; ?></a></th>
  

  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="parent_id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="parent_id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?orderby=parent_id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$parent_id_lang"; ?></a></th>
  <th class="text-center"></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="region";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_region order by $orderby $type";
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
					if($limit>100){$limit=$items_per_page+3;}
			}else{
				$limit = $items_per_page+2;
				}
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
		/* Get data. */
	if($orderby=="id"){
		$sql = "SELECT * FROM ".$prefix."_region  order by $orderby+0 $type LIMIT $start, $limit";
		}else{
	$sql = "SELECT * FROM ".$prefix."_region  order by `$orderby` $type LIMIT $start, $limit";
		}
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
?>


  <tr class="<?php echo"".$class.""; ?>">
   <td class="text-center"><input type="checkbox" class="idcheckbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
  <td class="text-center"><?php echo"".$row['id'].""; ?></td>
  <td class="text-center"><?php echo"".$row['name'].""; ?></td>
  <td class="text-center">



      <?php

      $result_region = mysqli_query($con,"SELECT * FROM ".$prefix."_region where id='".$row['parent_id']."'");
      if(mysqli_num_rows($result_region)>0){
      while($row_region = mysqli_fetch_array($result_region))
      {
          $row_region_name=$row_region['name'];

      }
      }else{
          $row_region_name='';

      }

      echo"".$row_region_name.""; ?></td>
  <td class="text-center">

<a  onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&del=<?php echo"".$row['id'].""; ?>" ><img src="images/erase.png"/></a>
<a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&Edit=<?php echo"".$row['id'].""; ?>"><img src="images/edit.png"/></a>

</td>
  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
  <th colspan="4"><?php echo"$pagination"; ?></th>
  <th class="text-center"><a href="#">
  <a href="#" onClick="confirmSubmit();"><img src="images/erase.png" style="border:0px;"/></a></th>
  </thead>
  </table>    
  </form>
  <?php } ?>
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

<script>
    $('#all').click(function(){
        if (this.checked) {
            $(".idcheckbox").each(function() {
                this.checked=true;
            });
        }else{
            $(".idcheckbox").each(function() {
                this.checked=false;
            });
        }

    });
</script>