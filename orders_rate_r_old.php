<?php
include "includes/inc.php";
$status=$_GET['status'];
$branch=$_GET['branch'];
$region=$_GET['region'];
$date_from=str_replace("/", "-", $_GET['date_from']);
$date_to=str_replace("/", "-", $_GET['date_to']);
$date_from=stripslashes(date('Y-m-d',strtotime($date_from)));
$date_to=stripslashes(date('Y-m-d',strtotime($date_to)));
if(count($region)==1 && $region[0]=='1000000000'){
  $skip_region=1;
}else{
  $skip_region=0;
}

//echo $status[0];
if(count($status)==1 && $status[0]=='1000000000'){
  $skip_status=1;
}else{
 $skip_status=0;
}
if(count($branch)==1 && $branch[0]=='1000000000'){
  $skip_branch=1;
}else{
 $skip_branch=0;
}
function get_all_orders_count(){
  global $con;
global $prefix;
global $status;
global $date_from;
global $date_to;
global $skip_region;
global $skip_status;

if(empty($status) || $skip_status==1){
}else{
$arr_status=implode (", ", $status);
if($arr_status==''){}else{
$q_status=" and status in ($arr_status)";
}
}
global $region;
if(empty($region)){}else{
$arr_region=implode (", ", $region);
if($arr_region=='' || $skip_region==1){}else{
$q_region=" and  region_id in ($arr_region)";
}
}

global $branch;
global $skip_branch;
if(empty($branch)  || $skip_branch==1){}else{
$arr_branch=implode (", ", $branch);
if($arr_branch==''){}else{
$q_branch=" and  branch_id in ($arr_branch)";
}
}
if($date_to=="1970-01-01" or $date_to=="0000-01-01" or $date_to==null or $date_to==""){}else{
$sql_date=" and left(date,10) BETWEEN '$date_from' AND '$date_to'";
}
$result_order_supply_status = @mysqli_query($con, "SELECT region_id,status,COUNT(*) as counts FROM " . $prefix . "_order_supply_inv where id !='0' $q_status $q_region $q_branch $sql_date GROUP BY region_id,status");
$num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
if ($num_order_supply_status > 0) {
  while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
      $data[$row_order_supply_status['region_id']][$row_order_supply_status['status']] = $row_order_supply_status['counts'];
  }
}
return $data;
echo $skip_status;
}

function get_all_orders_count_not_know(){
  global $con;
global $prefix;
global $date_from;
global $date_to;
global $status;
global $skip_status;

if(empty($status) || $skip_status==1){
}else{
$arr_status=implode (", ", $status);
if($arr_status==''){}else{
$q_status=" and status in ($arr_status)";
}
}
global $branch;
global $skip_branch;
if(empty($branch) || $skip_branch==1){}else{
$arr_branch=implode (", ", $branch);
if($arr_branch==''){}else{
$q_branch=" and  branch_id in ($arr_branch)";
}
}
if($date_to=="1970-01-01" || $date_to=="0000-01-01" || $date_to==null or $date_to==""){}else{
  $sql_date=" and left(date,10) BETWEEN '$date_from' AND '$date_to'";
  }
$result_order_supply_status = @mysqli_query($con, "SELECT status,COUNT(*) as counts,date FROM " . $prefix . "_order_supply_inv where region_id=0 $q_status $q_branch  $sql_date GROUP BY status");
$num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
if ($num_order_supply_status > 0) {
  while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
      $data[$row_order_supply_status['status']] = $row_order_supply_status['counts'];
  }
}

return $data;
}
$orders_total_value_status=get_all_orders_count();
$sumArray = array();

foreach ($orders_total_value_status as $k=>$subArray) {
  foreach ($subArray as $id=>$value) {
    $sumArray[$id]+=$value;
  }
}


$get_all_orders_count_not_know=get_all_orders_count_not_know();
//var_dump($get_all_orders_count_not_know);

//var_dump($orders_total_value_status[""]);
function get_all_oprders_status(){
        global $con;
    global $prefix;
    global $status;
    global $skip_status;
  
    if(empty($status) || $skip_status==1){
    }else{
    $arr=implode (", ", $status);
    if($arr==''){}else{
   echo  $q="where id in ($arr)";
    }
    }
    $result_order_supply_status = @mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status $q");
    $num_order_supply_status = @mysqli_num_rows($result_order_supply_status);
    if ($num_order_supply_status > 0) {
        while ($row_order_supply_status = mysqli_fetch_array($result_order_supply_status)) {
            $data['id'][] = $row_order_supply_status['id'];
            $data['name'][] = $row_order_supply_status['name'];
        }
    }
    return $data;
}
$get_all_oprders_status=get_all_oprders_status();

$Total_final= array_sum($sumArray);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
        <?php include"includes/css.php"; ?>
        <?php include"includes/js.php"; ?>
    </head>

    <body>

        <div>
            <div>
                <?php
                if ($get_db_isLogo == 1) {
                    if ($get_db_Logo == "") {
                        echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
                    } else {
                        echo '<img src="uploads/' . $get_db_Logo . '" style="float:left; border:0px;"/>';
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

   

            <!--   <p class="text-right pull-righ"><?php echo"$date_today_lang"; ?><span> <?php echo"" . $dateonly . ""; ?></span></p> -->

          <!--  <img src="images/logo.jpg" class="img-responsive" /> -->
<br />



<div class="container-fluid">
  <form class="form-inline no-print" name="form">
 
   <div class="form-group mb-2 no-print"><a target="_BLANK" href="xls/export/order_supply_rate_excel.php?date_from=<?php echo $_GET['date_from']; ?>&date_to=<?php echo $_GET['date_to']; ?>&status=<?php echo implode (", ", $status); ?>&branch=<?php echo implode (", ", $branch); ?>&region=<?php echo implode (", ", $region); ?>"><img src="data:image/png;base64,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" /></a></div>
   <div class="form-group mb-2"><input type="submit"  class="btn btn-outline-primary" name="submit" value="بحث" /></div>
 <div class="form-group mb-2">
    <input type="text" name="date_to" id="date_to" value="<?php if (isset($_GET['date_to'])) {
                                            echo"" . $_GET['date_to'] . "";
                                        } 
                                        else{
                                            echo date("d/m/Y");
                                        } ?>" class="form-control" placeholder="التاريخ الى" aria-label="التاريخ الى">
                                   
  </div>
    <script type="text/javascript">
                                            $('#date_to').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                        </script>
 <div class="form-group mb-2">
    <input type="text" name="date_from" id="date_from" value="<?php if (isset($_GET['date_from'])) {
                                            echo"" . $_GET['date_from'] . "";
                                        } 
                                        else{
                                            echo date("01/m/2019");
                                        } ?>"  class="form-control" placeholder="التاريخ من" aria-label="التاريخ من">
    <script type="text/javascript">
                                            $('#date_from').dateEntry({dateFormat: 'dmy/', spinnerImage: ''});
                                        </script>
  </div>
 <div class="form-group mb-2">
  <select name="status[]" class="form-control js-example-basic-multiple-limit" multiple>
  <option value="1000000000"  <?php if($_GET['status']==null || in_array("1000000000", $_GET['status'])){echo "selected";} ?>>اختر الحالة</option>
      <?php
      $result_search = mysqli_query($con,"SELECT id,name FROM cairo_order_supply_status order by id ASC");
if(@mysqli_num_rows($result_search)>0){
while($row_search= mysqli_fetch_array($result_search))
  {
      if(in_array($row_search['id'], $_GET['status'])) {
      echo' <option value="'.$row_search['id'].'" selected>'.$row_search['name'].'</option>';
    }else{
echo' <option value="'.$row_search['id'].'">'.$row_search['name'].'</option>';
}
   }
}
   ?>
 
</select>

  </div>

 <div class="form-group mb-2">
  <select name="branch[]" class="form-control js-example-basic-multiple-limit" multiple>
      <option  value="1000000000" selected>الفرع</option>
      <?php
      $result_search_branch= mysqli_query($con,"SELECT id,name FROM cairo_branch order by name ASC");
if(@mysqli_num_rows($result_search_branch)>0){
while($row_search_branch= mysqli_fetch_array($result_search_branch))
  {
      if(in_array($row_search_branch['id'], $_GET['branch'])) {
echo' <option value="'.$row_search_branch['id'].'"  selected>'.$row_search_branch['name'].'</option>';
    }else{
      echo' <option value="'.$row_search_branch['id'].'">'.$row_search_branch['name'].'</option>';
    }
   }
}
   ?>
 
</select>

  </div>
 <div class="form-group mb-2">
  <select name="region[]" class="form-control js-example-basic-multiple-limit" multiple>
      <option  value="1000000000"  <?php if($_GET['region']==null || in_array("1000000000", $_GET['region'])){echo "selected";} ?>>المنطقة</option>
      <?php
      $result_search_region= mysqli_query($con,"SELECT id,name FROM cairo_region order by name ASC");
if(@mysqli_num_rows($result_search_region)>0){
while($row_search_region= mysqli_fetch_array($result_search_region))
  {
    if(in_array($row_search_region['id'], $_GET['region'])) {
echo' <option value="'.$row_search_region['id'].'"  selected>'.$row_search_region['name'].'</option>';
    }else{
      echo' <option value="'.$row_search_region['id'].'">'.$row_search_region['name'].'</option>';
    }
   }
}
   ?>
 
</select>

  </div>
</form>   
</div>
     <script>
$(".js-example-basic-multiple-limit").select2({
  maximumSelectionLength: 1000
});
$(document).ready(function(){
  $('.date').mask('00-00-0000');
});
</script>
   <div class="container-fluid">
      <table class="table  table-bordered" dir="rtl" >
    
    <thead style="  background: white;
  position: sticky;
  top: 0; /* Don't forget this, required for the stickiness */
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);   background: #ff4747;
  color: white;">
      <tr>
      
      <th class="text-center"  scope="col">المنطقة</th>
      <?php


foreach($get_all_oprders_status['name'] as $value){

   echo "<th  class='text-center'  scope='col'> ".$value."</th>";

}
       ?>
 <th  class="text-center"  scope="col">اجمالي الحالات</th>
        <th  class="text-center">النسبة</th>

       


       
      </tr>
    </thead>
 
    <tbody>
    <?php
    if(empty($region)){}else{
$arr_region=implode (", ", $region);
if($arr_region=='' or $skip_region==1){}else{
$q_region="where id in ($arr_region)";
}
}
   $result = @mysqli_query($con, "SELECT * FROM cairo_region $q_region");
    $num = @mysqli_num_rows($result);
    if ($num > 0) {
        $iii=0;
         while ($row = mysqli_fetch_array($result)) {
                    $issingle=$iii/2;
			 $dot = strstr($issingle, '.');
			if($dot==""){
			    $bgcolor="style='background: #e1dada';";
			}else{
			     $bgcolor="style='background: #ffffff';";
			}

echo'<tr '.$bgcolor.'>';
echo'<td>'.$row['name'].'</td>';


foreach($get_all_oprders_status['id'] as $value){
  $sum_status[$value] +=$orders_total_value_status[$row['id']][$value];
  echo'<td>'.$orders_total_value_status[$row['id']][$value].'</td>';
}
$xyz=array_sum($orders_total_value_status[$row['id']]);
echo'<td>'.$xyz.'</td>';
$total_rate +=(($xyz/$Total_final)*100);
echo'<td>'.round((($xyz/$Total_final)*100),2).'</td>';


echo'</tr>';



 $iii ++;

        }
    }   
    if($skip_region==1 || empty($region)){
        			$issingle=$i/2;
			 $dot = strstr($issingle, '.');
			if($dot==""){
				$class="background_color_FFF";
				}else{$class='background_color_D5EFF0';}
    echo'<tr class="'.$class.'">';
echo'<td>غير معروفة</td>';

foreach($get_all_oprders_status['id'] as $value){
  $sum_status_not_know +=$get_all_orders_count_not_know[$value];
  echo'<td>'.$get_all_orders_count_not_know[$value].'</td>';
}
echo'<td>'.$sum_status_not_know .'</td>';
echo'<td>'.round((($sum_status_not_know/$Total_final)*100),2).'</td>';
$total_rate +=(($sum_status_not_know/$Total_final)*100);

echo'</tr>';
}
    echo'<tr >';
    echo'<td>اجمالي</td>';
    
  
    foreach($get_all_oprders_status['id'] as $value){
      echo'<td>'.($sum_status[$value]+$get_all_orders_count_not_know[$value]).'</td>';
    }
   
    echo'<td >'.$Total_final.'</td>';
    echo'<td>'.round($total_rate,0).'</td>';
    
    
    echo'</tr>';

  
?>
      

    </tbody>
  </table>   
        
  </div>

  

    </div>


</body>

</html>
<?php include 'includes/footer.php'; ?>

