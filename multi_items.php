<?php
include"includes/inc.php";
$code=$_GET['code'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
        <?php include"includes/css.php"; ?>
    </head>
    <body>
        <div id="content">
            <table  class="table table-striped table-bordered table-hover text-center">
                <form method="get">
                <tr>
                                            <th class="text-center">
                                                <select class="chosen-select"   name="products" id="products" onchange="this.form.submit()">
                                                    <option value=""></option>
<?php products_option(); ?>
                                                </select>
                                                                                                                                               
                                                
                                            </th>
                                            <th class="text-center">

 <select class="chosen-select"  name="code" id="code" onchange="this.form.submit()">
     <?php
$products=Trim(stripslashes($_GET['products']));
if(isset($_GET['products'])){
$result_code = @mysqli_query($con, "SELECT * FROM items where groupid='$products'");
}else{
    $result_code = @mysqli_query($con, "SELECT * FROM items");
}
$num = @mysqli_num_rows($result_code);
  if($num>0){ 
 while ($row_code = mysqli_fetch_array($result_code)) {
     if($row_code['id']==$_GET['code']){$sel="selected='selected'";}else{$sel=null;}
     echo"<option value='".$row_code['id']."' $sel>".$row_code['item']."</option>";
 }
  }
     ?>

                                                </select>

                                            </th>
                </tr>
                </form>
            </table>
           
      
<?php
  if(isset($_POST['submit'])){
          mysqli_autocommit($con,FALSE);
$size1=$_POST['size1'];
$size2=$_POST['size2'];
$size3=$_POST['size3'];
$size4=$_POST['size4'];
$size5=$_POST['size5'];
$size6=$_POST['size6'];
$size7=$_POST['size7'];
$size8=$_POST['size8'];
$size9=$_POST['size9'];
$size10=$_POST['size10'];
$size11=$_POST['size11'];
$size12=$_POST['size12'];
$size13=$_POST['size13'];
$size14=$_POST['size14'];
$size15=$_POST['size15'];
$size16=$_POST['size16'];
$size17=$_POST['size17'];
$size18=$_POST['size18'];
$size19=$_POST['size19'];
$size20=$_POST['size20'];
$size21=$_POST['size21'];
$size22=$_POST['size22'];
$size23=$_POST['size23'];
$size24=$_POST['size24'];
$size25=$_POST['size25'];
$size26=$_POST['size26'];
$size27=$_POST['size27'];
$size28=$_POST['size28'];
$size29=$_POST['size29'];
$size30=$_POST['size30'];
$size31=$_POST['size31'];
$size32=$_POST['size32'];
$size33=$_POST['size33'];
$size34=$_POST['size34'];
$size35=$_POST['size35'];
                      $colors = $_POST['color'];
                      ##########################
          $i=0;
          if($_SESSION['token_key']==$token_key){
                        foreach ($colors as $color){
                              if($use_sizes==1){
                             $result_sizes= @mysqli_query($con,"SELECT * FROM sizes   where id in(" . rtrim(get_sizes_of_item($code), ",") . ") limit 35");
$num_sizes=@mysqli_num_rows($result_sizes);
if($num_sizes>0) {
      $ii=0;        
while ($row_sizes= mysqli_fetch_array($result_sizes)) {
###################
   // echo $row_sizes['id'];
  //  echo"";
    if(${'size'.$row_sizes['id']}[$i]<=0){
     // echo"no <br />";//
        }else{
  //    echo"yes<br />";
$Qty=${'size'.$row_sizes['id']}[$i];
$sql="INSERT INTO ".$prefix."_receivings_temporary (item, Price, Quantity, color, size, unit, Discount, Total, SupplierID, BuyPrice, date, type, subqty, user_id)
VALUES ('".$code."',(select price FROM items where id='".$code."'),'".${'size'.$row_sizes['id']}[$i]."','".$color."','".$row_sizes['id']."','1','0',((select price FROM items where id='".$code."') * $Qty),'-1',(select price FROM items where id='".$code."'),'$datetime','1','1','".$user_id."')";
if(mysqli_query($con, $sql)){
  // echo"Thank you<br />";
}else{
 //  echo"Error ".mysqli_errno($con)."<br />";
      $mysqli_errno++;
}
################
    }
$ii++;
}
  ##########################                             
                  $i++;
                                     } 
    ####################
                              }else{
$sql="INSERT INTO ".$prefix."_receivings_temporary (item, Price, Quantity, color, size, unit, Discount, Total, SupplierID, BuyPrice, date, type, subqty, user_id)
VALUES ('".$code."',(select price FROM items where id='".$code."'),'".$qty."','".$color."','".$row_sizes['id']."','1','0',($qty * (select price FROM items where id='".$code."')),'-1',(select price FROM items where id='".$code."'),'$datetime','1','1','".$user_id."')";
if(mysqli_query($con, $sql)){}else{
    $mysqli_errno++;
}
                              }
                                   
                              }
          }else{
            $mysqli_errno++;
          }
                              /*
$result_colors= @mysqli_query($con,"SELECT * FROM colors  where id  in(".rtrim(get_clolors_of_item($code), ",").") order by id ASC");
$num_show_colors=@mysqli_num_rows($result_colors);
if($num_show_colors>0){
    $ii=0;
 $x=0;
while($row_show_colors= mysqli_fetch_array($result_colors))
  {
$result_sizes=@mysqli_query($con,"SELECT * FROM sizes  where id in(".rtrim(get_sizes_of_item($code), ",").") limit 35");
                                       $num_sizes=@mysqli_num_rows($result_sizes);                                          
  while ($row_sizess = mysqli_fetch_array($result_sizes)) {
##################################################

##################################################      
 $x++; } 
                                  
    
$ii++;}}
                                     */  
                              
 if($mysqli_errno>0){ mysqli_rollback($con); }else{
     header("Location: receivings.php");
 }
                       mysqli_commit($con);                              
}   
?>
<?php if($_GET['code']==null){}else{ ?>
            <div class="row">

                <div class="col-lg-12">
                    <div>
                        <div class=""  style="width:100%;">
                            <div class="">

                                <div class="">
                                    <table class="table table-striped table-bordered table-hover" style="background-color:#ffffff;">
                                        <thead>
                                            <tr>
                                                <th colspan="1">#<?php echo Get_model_name($_GET['code']); ?></th>



                                                <th colspan="25" class="text-center"><?php echo"$sizes_lang"; ?></th>


                                            </tr>
                                            <tr>


                                                <th  class="text-center"><?php echo"$color_lang"; ?></th>
                                                <?php
                                                $result_sizes = @mysqli_query($con, "SELECT * FROM sizes  where id in(" . rtrim(get_sizes_of_item($code), ",") . ") limit 35");
                                                $num_sizes = @mysqli_num_rows($result_sizes);
                                                if ($num_sizes > 0) {

                                                    while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                                                        if ($transaction_id_db == 0) {
                                                            //  echo'<th class="text-center">'.$row_sizes['size'].' <a href="beginning_inventory_barcode.php?code='.$code_db[0].'&amp;sizeid='.$row_sizes['id'].'&amp;transaction_id=0"><i class="fa fa-barcode fa-xs text-danger" style="float:left"></i></a></th>';
                                                            echo'<th class="text-center">' . $row_sizes['size'] . ' <a href="barcodes_labels.php?code=' . $code_db[0] . '&amp;sizeid=' . $row_sizes['id'] . '&amp;transaction_id=0"><i class="fa fa-barcode fa-xs text-danger" style="float:left"></i></a></th>';
                                                        } else {
                                                            echo'<th class="text-center">' . $row_sizes['size'] . ' <a href="barcodes_labels.php?code=' . $code_db[0] . '&amp;sizeid=' . $row_sizes['id'] . '&amp;transaction_id=0"><i class="fa fa-barcode fa-xs text-danger" style="float:left"></i></a></th>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        <form method="post">
                                                 <?php
    $hash = md5(mt_rand(1,1000000) . $salt);
    $_SESSION['token_key'] = $hash;
    ?>
                                    <input type="hidden" name="token_key" value="<?php echo $hash; ?>" />  
<?php
                                            $result_colors= @mysqli_query($con, "SELECT * FROM colors  where id in(" . rtrim(get_clolors_of_item($code), ",") . ")");
                                                        $num_colors= @mysqli_num_rows($result_colors);
                                                        if ($num_colors > 0) {
                                                            while ($row_colors= mysqli_fetch_array($result_colors)) {
                                                                ?>
  <tr>
<td  class="text-center"> <?php echo'<input type="hidden" name="orid[]" value="' . $row_colors['id'] . '" />'; ?><?php echo $row_colors['color']; ?><input type="hidden" name="color[<?php echo $row_colors['id']; ?>]" value="<?php echo $row_colors['id']; ?>" /></td>
                                                        <?php
                                                        $iiii = 1;
                                                        $result_sizes = @mysqli_query($con, "SELECT * FROM sizes  where id in(" . rtrim(get_sizes_of_item($code), ",") . ") limit 35");
                                                        $num_sizes = @mysqli_num_rows($result_sizes);
                                                        if ($num_sizes > 0) {
                                                            while ($row_sizess = mysqli_fetch_array($result_sizes)) {
                                                                //$qty=get_model_qty($row_sizess['id'],$row_show_colors['color'],$code);
                                                                $qty = $row_show_colors[size . $row_sizess['id']];
                                                                $qty_total_size+=$qty;
                                                                echo'<td class="text-center"><input class="form-control" type="text" name="size' . $row_sizess['id'] . '[]" value="' . $qty . '" /></td>';
                                                            } $iiii++;
                                                        }
?>


                                                    </tr>                                                            
                                            
                                            <?php
                                                        }}
                                                        ?>
                                                   

                        
                                            <tr>
                                                <td colspan="36" class="text-center"> <input type="submit" name="submit" value="submit" /></td>
                                            
                                            </tr>     

                                        </form>
                                        </tbody>

                                    </table>  
                                </div>

                                <div class="modal-footer">


                                    <!--<button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>



            </div>
<?php } ?>
        </div>
    </div>

    <div id="toolbar">

    </div>
</body>

  <script src="chosen_v1.6.2/chosen.jquery.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
</html>
<?php include 'includes/footer.php'; ?>