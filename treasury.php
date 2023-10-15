<?php
include "includes/inc.php";
$safe_id=$_GET['safe_id'];
$sqlCon='';
if ($safe_id!=null and $safe_id!=''){
    $sqlCon.=' and  safe_id = '.$safe_id.'   ';

}
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
?>			</div>

		<div id='main'>
			<article style="margin-bottom:70px;">
                                                           
   <fieldset class="clearfix">
<legend  align="right"><?php echo"$Treasury_lang"; ?>:</legend> 
 <?php
			if($user_user_treasury!=="1" and $user_IsAdmin!=1){
echo"<div class='alert alert-warning text-right'>'.$not_have_permission_lang.'</div>";
				}else{ ?>
            <?php
if($_GET['del']!==null){
                                if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
 if(mysqli_query($con,"DELETE FROM ".$prefix."_treasury WHERE id='".$_GET['del']."'")){
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
mysqli_query($con,"DELETE FROM ".$prefix."_treasury WHERE id='".$del_id."'");
if($i==$countCheck-1){
 echo'<div class="alert alert-success text-right">
              '.$Deletion_successfully_lang.'
                            </div>'; 
header("refresh:1;url=treasury.php");
	}
		  }
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
$safe_id=Trim(stripslashes($_POST['safe_id']));
$type=Trim(stripslashes($_POST['type']));

$Amount=Trim(stripslashes(round($_POST['Amount'],3)));
$_POST['date']=str_replace("/", "-", $_POST['date']);
$date=Trim(date('Y-m-d',strtotime($_POST['date'])));
if($type==1){$Amount=$Amount*-1;}
//var_dump($type);

                                if ($type == 3){


                                    mysqli_autocommit($con, FALSE);

                                    ###############################################

                                    $_POST['date'] = str_replace("/", "-", $_POST['date']);
                                    $DueDate = Trim(date('Y-m-d', strtotime($_POST['date'])));


                                    $CheckNumber = '';

                                    if ($_POST['safe_id'] == "") {
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							' . $must_type_safe_from . '
							</div>';
                                    }
                                    elseif ($_POST['safe_to_id'] == "") {
                                        //print $paid;
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							' . $must_type_safe_to . '
							</div>';
                                    }
                                    elseif ($_POST['Amount'] == "") {
                                        //print $paid;
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							' . $must_type_amount . '
							</div>';
                                    }
                                    else {


                                        ############################


######################
                                        ######################

                                        $result_gettreasury = mysqli_query($con, "SELECT SUM(Amount) as Amount FROM " . $prefix . "_treasury  where safe_id = " . $_POST['safe_id']);
                                        $row_gettreasury = mysqli_fetch_assoc($result_gettreasury);
                                        $treasuryBlance = round($row_gettreasury['Amount'], 3);

//                                var_dump($treasuryBlance);
                                        $_POST['Amount'];
                                        if ($treasuryBlance < $_POST['Amount']) {


                                            echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $treasuryBlance_not_allow_lang . '
							</div>';


                                            ######################
                                        } else {


                                            $notes = $_POST['notes'];
                                                $sql = "INSERT INTO " . $prefix . "_treasury (user_id,safe_id,type, Amount, date, notes)
VALUES ('" .$user_id."','". $_POST['safe_id'] . "','1','" . ($_POST['Amount'] * -1) . "','" . $DueDate . "','$notes - سحب')";
                                                if (!mysqli_query($con, $sql)) {

                                                }

                                                $sql = "INSERT INTO " . $prefix . "_treasury (user_id,safe_id,type, Amount, date, notes)
VALUES ('" .$user_id."','". $_POST['safe_to_id'] . "','2','" . $_POST['Amount'] . "','" . $DueDate . "','$notes - ايداع')";
                                                if (!mysqli_query($con, $sql)) {

                                                }else{
                                                    header("refresh:1;url=treasury.php?limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&safe_id=" . $_GET['safe_id'] . "&type=" . $_GET['type'] . "&page=" . $_GET['page'] . "");

                                                }


                                                ###############



################
                                            ################################

                                            //echo $inv_Total;
                                            ######################
                                        }

                                        if ($mysqli_errno > 0) {
                                            mysqli_rollback($con);
                                        }
                                        mysqli_commit($con);

                                    }


                                    ###########################################
                                    if ($error_reports == "1") {
                                        echo '<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/chmarkicon.png" style="border:0px;" /></span>
							' . $quantity_not_zero_lang . '
							</div>';
                                    }

                                }else {
                                    if ($type == "" or $type == null or $Amount == null or $Amount == null or $date == null or $date == null) {
                                        echo '<div class="alert alert-danger  text-right">
' . $type_amount_date_lang . '
                            </div>';
                                    } else {
                                        $notes = Trim(stripslashes($_POST['notes']));


                                        if (isset($_POST['modification'])) {

                                            $sql = "UPDATE " . $prefix . "_treasury SET type='" . $type . "', safe_id='" . $safe_id . "', Amount='" . $Amount . "', date='" . $date . "', notes='" . $notes . "' where id='" . $_POST['id'] . "'";
                                        } else {


                                            $sql = "INSERT INTO " . $prefix . "_treasury (user_id,safe_id,type, Amount, date, notes)
VALUES ('" .$user_id."','". $safe_id . "','" . $type . "','" . $Amount . "','" . $date . "','" . $notes . "')";
                                        }
                                        if (!mysqli_query($con, $sql)) {
                                            echo '<div class="alert alert-danger  text-right">
      ' . $not_saved_try_lang . '
                            </div>';
                                        } else {
                                            echo '<div class="alert alert-success text-right">
   ' . $Data_is_saved_lang . '
                            </div>';
                                            header("refresh:1;url=treasury.php?limit=" . $_GET['limit'] . "&orderby=" . $_GET['orderby'] . "&safe_id=" . $_GET['safe_id'] . "&type=" . $_GET['type'] . "&page=" . $_GET['page'] . "");
                                        }

                                    }
                                }
      }
			}
?>
 <?php

 $row_treasury_Amount=$_POST['Amount'];
 $row_treasury_type=$_POST['type'];
 $row_treasury_safe_id=$_POST['safe_id'];
 $row_treasury_number=$_POST['number'];
 $row_treasury_details=$_POST['notes'];

 $row_treasury_date=$_POST['date'];
// $row_treasury_date=date('d/m/Y',strtotime($row_treasury_date));
 $row_treasury_date=$row_treasury_date;



 if($_GET['Edit']!==null){
$isedit=1;
			$result_treasury = mysqli_query($con,"SELECT * FROM ".$prefix."_treasury where id='".$_GET['Edit']."'");
if(mysqli_num_rows($result_treasury)>0){
while($row_treasury = mysqli_fetch_array($result_treasury))
  {
	 $row_treasury_id=$row_treasury['id'];
      $row_treasury_Amount=$row_treasury['Amount'];

      if ($row_treasury['Amount'] < 0 ){

         $row_treasury_Amount=$row_treasury['Amount'] * -1;
     }
	 $row_treasury_type=$row_treasury['type'];
	 $row_treasury_safe_id=$row_treasury['safe_id'];
	 $row_treasury_number=$row_treasury['number'];

	 $row_treasury_details=$row_treasury['notes'];

	 $row_treasury_date=$row_treasury['date'];
	 $row_treasury_date=date('d/m/Y',strtotime($row_treasury_date));
	 
  }
}
	 }else{
		 
		 }
	 ?>
  <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
 <table   border="0" dir="rtl" cellpadding="0" style="padding-top:30px; text-align:right; color:#009; width:100%;">
  <tr>
      <td class="text-right"><lable><?php echo"$Process_lang"; ?></lable></th>
      <td>

          <select  name="type" size="1" class="transfer form-control">
              <option value=""></option>
              <option id="HaveBalance" value="1" <?php if($row_treasury_type=="1"){echo" selected";} ?>><?php echo"$Withdrawal_lang"; ?></option>
              <option value="2" <?php if($row_treasury_type=="2"){echo" selected";} ?>><?php echo"$Deposit_lang"; ?></option>
              <option value="3" <?php if($row_treasury_type=="3"){echo" selected";} ?>><?php echo"$transfer_lang"; ?></option>
          </select>




      </td>
       <td class="text-right"><lable><?php echo"$treasury_name_lang"; ?></lable></th>
       <td class="text-right">
           <select name="safe_id" size="1" class="formsafe  js-states form-control">
               <option value=""> <?php echo"$treasury_name_lang"; ?></option>
               <?php
               $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id ASC");
               $num_item = mysqli_num_rows($ProductsName);
               if ($num_item > 0) {
                   while ($row_item = mysqli_fetch_array($ProductsName)) {
                       if ($row_item['id'] == $row_treasury_safe_id) {
                           echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                       } else {
                           echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                       }
                   }
               }
               ?>
           </select>

      </th>

              <?php
              if ($_POST['type'] == 3 ){
              ?>
                  <td  class="safe_to text-right"><lable><?php echo"$treasury_to_lang"; ?></lable></th>
                  <td  class="safe_to text-right">
                      <select name="safe_to_id" size="1" class="formsafe2  js-states form-control">
                          <option value=""> <?php echo"$treasury_name_lang"; ?></option>
                          <?php
                          $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id ASC");
                          $num_item = mysqli_num_rows($ProductsName);
                          if ($num_item > 0) {
                              while ($row_item = mysqli_fetch_array($ProductsName)) {
                                  if ($row_item['id'] == $_POST['safe_to_id']) {
                                      echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                  } else {
                                      echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                  }
                              }
                          }
                          ?>
                      </select>

                  </th>
              <?php }else{?>
                   <td style="display: none"  class="safe_to text-right"><lable><?php echo"$treasury_to_lang"; ?></lable></th>
      <td style="display: none"  class="safe_to text-right">
          <select name="safe_to_id" size="1" class="formsafe2  js-states form-control">
              <option value=""> <?php echo"$treasury_name_lang"; ?></option>
              <?php
              $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by id ASC");
              $num_item = mysqli_num_rows($ProductsName);
              if ($num_item > 0) {
                  while ($row_item = mysqli_fetch_array($ProductsName)) {
                      if ($row_item['id'] == $_POST['safe_to_id']) {
                          echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                      } else {
                          echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                      }
                  }
              }
              ?>
          </select>

      </th>
            <?php  }?>

       <td class="text-right"><lable><?php echo"$the_amount_lang"; ?></lable></td>
     <td class="text-right">
                <input type="text" name="Amount" value="<?php echo"".$row_treasury_Amount.""; ?>"  class="form-control"/></td>
        <td class="text-right"><lable><?php echo"$the_date_lang"; ?></lable></td>
       <td class="text-right">
            <input type="text" name="date" value="<?php if($row_treasury_date==""){echo date("d/m/Y");}else{echo"".$row_treasury_date."";} ?>" id="date"  class="form-control" />
                  <script type="text/javascript">
				$('#date').dateEntry({dateFormat: 'dmy/', spinnerImage:''});
			</script>





        </div>
      </tr>       
      <tr>
       <td class="text-right"><lable>تفاصيل</lable></td>
        <td class="text-right"><textarea name="notes" class="form-control"><?php echo"".$row_treasury_details.""; ?></textarea>
         
   
       
        </td>
     <td class="text-right">&nbsp;</td>
      <td class="text-right">


          <spam  ><?php echo"$Treasury_balance_lang"; ?>
              </span><span id="treasuryBalance"></span>
        </spam>
      </br>
<!--          --><?php
//          if ($_POST['type'] == 3){
//          ?>
      <spam id="safe_to_balance" style="display: none"  ><?php echo"$Treasury_balance_to_lang"; ?>
              </span><span id="treasuryBalance2"></span>
        </spam>
<!--     --><?php //} ?>

      <tr>
          <th colspan="" class="text-center"><div class="row">
        <?php

		if($isedit==1){
			echo'<input type="submit" name="modification" id="modification" value="'.$Modify_lang.'" class="button"  />';
			echo'<input type="hidden"  name="id" value="'.$row_treasury_id.'"/>';
			}else{
			echo'<input type="submit" name="add" id="add" value="حفظ" class="button"  />';
			}
		?>
        <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href='treasury.php'"  />
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


            <div class="row" style=" float:center; padding-top:20px; text-align:center;">
                <a href="#" id="excel">
                    <i class="fa fa-file-excel-o"> <?php echo"$export_report_lang"; ?></i>

                    <a href="#" id="multiPrint"><i class="fa fa-print"> </i><?php echo"$print_lang"; ?>   </a>
            </div>

            <form method="get">

                <div dir="rtl">
<label><?php echo  $treasury_name_lang ;?></label>
                <select name="safe_id" id="safe_id" size="1" class="js-example-placeholder-single w25 js-states form-control">
                    <option value=""><?php echo"$the_Item_lang"; ?></option>
                    <?php
                    $ProductsName = mysqli_query($con, "SELECT * FROM ".$prefix."_safe order by name ASC");
                    $num_item = mysqli_num_rows($ProductsName);
                    if ($num_item > 0) {
                        while ($row_item = mysqli_fetch_array($ProductsName)) {
                            if ($row_item['id'] == $_GET['search']) {
                                echo'<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                            } else {
                                echo'<option value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <input type="submit" value="<?php echo"$Search_lang"; ?>" />
                </div>
            </form>

            <form id="mainform" action="" method="post">
  <table  id="tablePrint" border="1" style="font-size:16px; width:100%; direction:rtl; border:1px; border-collapse:collapse; margin-top:10px; text-align:center;" class="container" id="container">
<!--    <header style="background-color:#CCC;">
sdfsdfsdf
  </header>-->
  <thead style="background-color:#CCC;">
<th style="width:5%;"><input type="checkbox" name="all" value="1" id="all" /></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Code_lang"; ?></a></th>
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="client_supp_name"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"اسم الجهه"; ?></a></th>
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="safe_id"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="safe_id"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=safe_id&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$treasury_name_lang"; ?></a></th>

  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="type"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="type"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=type&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Process_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="Amount"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="Amount"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=Amount&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_amount_lang"; ?></a></th>
  
  <th class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="date"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="date"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=date&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$the_date_lang"; ?></a></th>
  
  
  <th  class="text-center <?php if($_GET['type']=="ASC" and $_GET['orderby']=="notes"){echo"sort_t";}else if($_GET['type']=="DESC" and $_GET['orderby']=="notes"){echo"sort_d";}else{echo"sort0";}?>"><a href="?limit=<?php echo"".$_GET['limit'].""; ?>&orderby=notes&type=<?php if($_GET['type']=="ASC"){echo"DESC";}else if($_GET['type']=="DESC"){echo"ASC";}else{echo"DESC";} ?>&page=<?php echo"".$_GET['page'].""; ?>" class="a_remove_underlines"><?php echo"$Details_lang"; ?></a></th>
  <th></th>
  </thead>
  <?php
if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
	$tbl_name="treasury";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num  FROM  ".$prefix."_treasury where id!= '' $sqlCon order by $orderby $type";
	$total_pages = @mysqli_fetch_array(mysqli_query($con,$query));
	$total_pages = $total_pages[num];
		
	/* Setup vars for query. */
	$targetpage = "?limit=".$_GET['limit']."&orderby=".$_GET['orderby']."&safe_id=".$_GET['safe_id']."&type=".$_GET['type'].""; 	//your file name  (the name of this file)
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
	
	/* Get data. */
//		if($orderby=="item"){
/*			SELECT 
	A.id AS Id, 
	A.nome AS Nome,
	JT.id as OB_FIELD
FROM main_table A
    JOIN joined_table JT ON JT.id = A.id_cat

ORDER BY OB_FIELD*/
//$sql = "SELECT * FROM treasury  order by $orderby $type LIMIT $start, $limit";		
//		}else if($orderby=="groupid"){
//			$sql = "SELECT i.id as id,i.groupid as groupid,i.item as item,i.Quantity as Quantity,i.Retail_price as Retail_price,i.price as price,i.Discount as Discount,i.Barcode as Barcode,g.GroupName as OB_FIELD  FROM items i JOIN groups g ON g.id=i.groupid  order by g.GroupName  $type LIMIT $start, $limit";
//			}else{
			
	$sql = "SELECT * FROM ".$prefix."_treasury  where id!= '' $sqlCon order by $orderby $type LIMIT $start, $limit";
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
				if($row['type']==1){$ex_type="$Withdrawal_lang";}
				else if($row['type']==2){$ex_type="$Deposit_lang";}
				else if($row['type']==3){$ex_type="$Purchases_cash_lang";}
				else if($row['type']==4){$ex_type="$Cash_sales_lang";}
				else if($row['type']==5){$ex_type="$Expenses_lang";}
				else if($row['type']==6){$ex_type="$Payment_suppliers_lang";}
				else if($row['type']==7){$ex_type="$Collection_customers";}
				else if($row['type']==8){$ex_type="$Sales_returns_lang";}
				else if($row['type']==9){$ex_type="$Returns_Purchases_lang";}
                                else if($row['type']==50){$ex_type="$commission_lang";}
				else{}


            $noteArray = explode(' ',$row['notes']);
            if ($row['type']=="5"){
                $expenses_id=$row['expenses_id'];
                $nameVal=get_expenses_set_data($expenses_id) ["name"];
                $name='مصروف  \ '.$nameVal;

            } elseif ($row['type']=="1" || $row['type']=="2"){
                $name=$ex_type .' \ '.$row['notes'];
            }elseif ($row['type']=="3"){
                $supplier_id=$row['client_supp_name'];
                $name='مورد  \ '.get_supplier_data($supplier_id)[name];
            }elseif ($row['type']=="4"){
                $client_id=$row['client_supp_name'];
                if ($client_id == 0){
                    $name='فاتوره  \ '.$row[inv_id];

                }else{
                    $name='عميل  \ '.get_client_data($client_id)[name];
                }
            }elseif ($row['type']=="6"){
                $name='مورد  \ '.get_supplier_data($noteArray[count($noteArray) - 1])[name];
            }elseif ($row['type']=="7"){
                $client_id=substr($noteArray[count($noteArray) - 1],12);
                $name='عميل  \ '.get_client_data($client_id)[name];
            }elseif ($row['type']=="8"){
                $inv_id=substr($noteArray[count($noteArray) - 1],1);
                $name='فاتوره  \ '.$inv_id;
            }else{
                $name ='';
            }
?>


  <tr class="<?php echo"".$class.""; ?>">
      <td class="text-center"><input class="idcheckbox" type="checkbox" name="cb[]" value="<?php echo"".$row['id'].""; ?>"></td>
  <td class="text-center"><?php echo"".$row['id'].""; ?></td>
  <td class="text-center"><?php echo"".$name.""; ?></td>
  <td class="text-center"><?php echo"".get_safe_data($row['safe_id'])[name].""; ?></td>
  <td class="text-center"><?php echo"".$ex_type.""; ?></td>
  <td class="text-center"><?php echo"".$row['Amount'].""; ?></td>
  <td class="text-center"><?php echo"".substr($row['date'], 0, 10).""; ?></td>
   <td class="text-center"><?php echo"".$row['notes'].""; ?></td>
  <td class="text-center">
 
<a class="noprint" onclick="return confirm('<?php echo"$sure_delete_lang"; ?>');" href="?limit=<?php echo"".$_GET['limit'].""; ?>&safe_id=<?php echo"".$_GET['safe_id'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&del=<?php echo"".$row['id'].""; ?>" ><img src="images/erase.png"/></a>
<a class="noprint" href="?limit=<?php echo"".$_GET['limit'].""; ?>&safe_id=<?php echo"".$_GET['safe_id'].""; ?>&orderby=<?php echo"".$_GET['orderby'].""; ?>&type=<?php echo"".$_GET['type'].""; ?>&page=<?php echo"".$_GET['page'].""; ?>&Edit=<?php echo"".$row['id'].""; ?>"><img src="images/edit.png"/></a></td>
  </tr>
     
 <?php $i++; } ?>   
    <thead style="background-color:#CCC;">
  <th colspan="8"><?php echo"$pagination"; ?></th>
 <th class="text-center "><a href="#">
  <a class="noprint" href="#" onClick="confirmSubmit();"><img src="images/erase.png"/></a></th>
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
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
    $('.transfer').change(function () {
if ($(this).val() == '3'){
    $('.safe_to').show();
    $('#safe_to_balance').show();
}   else{
    $('.safe_to').hide();

}
    });
    $(".formsafe").select2({
        placeholder: "اختر",
        allowClear: true
    })
        .on("change", function (e) {
        var selected_element = $(e.currentTarget).val();
        $.ajax({
            url: 'ajax/get_safe_baance.php',
            dataType: 'text',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: {'safe_id':selected_element},
            success: function (data, textStatus, jQxhr) {
                if (data >0){
                    $('#treasuryBalance').html('<span style="color:green">'+data+'</span>');
                    $('#HaveBalance').show();
                    // $('#NotHaveBalance').hide();
                }else{
                    $('#treasuryBalance').html('<span style="color:red">'+data+'</span>');
                    $('#HaveBalance').hide();
                  // $('#NotHaveBalance').show();
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    });;
  $(".formsafe2").select2({
        placeholder: "اختر",
        allowClear: true
    })
        .on("change", function (e) {
        var selected_element = $(e.currentTarget).val();
        $.ajax({
            url: 'ajax/get_safe_baance.php',
            dataType: 'text',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            data: {'safe_id':selected_element},
            success: function (data, textStatus, jQxhr) {
                if (data >0){
                    $('#treasuryBalance2').html('<span style="color:green">'+data+'</span>');
                    // $('#HaveBalance').show();
                    // $('#NotHaveBalance').hide();
                }else{
                    $('#treasuryBalance2').html('<span style="color:red">'+data+'</span>');
                    // $('#HaveBalance').hide();
                  // $('#NotHaveBalance').show();
                }
            },
            error: function (jqXhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    });;


    $('#excel').click(function(e){
        var values = '';

        values=values + 'safe_id='+'<?php echo $_GET['safe_id'];?>'+'&orderby='+'<?php echo $_GET['orderby'];?>'+'&type='+'<?php echo $_GET['type'];?>' ;
        var url = 'xls/export/treasury_excel.php?'+values;
        window.open(url, '_blank');
    });
    $('#multiPrint').click(function(e){
        var ids = [];

        $(".idcheckbox").each(function(e , i) {
            if (i.checked) {
                ids.push(i.value);
            }
        });

        var values = '';
        values=values + 'ids='+ids+'&safe_id='+'<?php echo $_GET['safe_id'];?>'+'&orderby='+'<?php echo $_GET['orderby'];?>'+'&type='+'<?php echo $_GET['type'];?>' ;
        var url = 'pdf/export/treasury_print.php?'+values;
        window.open(url, '_blank');
    });
</script>
