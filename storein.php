 <?php
 include"includes/inc.php";
                    if (isset($_POST['products'])) {
                        $products =$_POST['products'];
                        $code = $_POST['code'];
                         if($use_sizes==1){
                        $size1 = $_POST['size1'];
                        $size2 = $_POST['size2'];
                        $size3 = $_POST['size3'];
                        $size4 = $_POST['size4'];
                        $size5 = $_POST['size5'];
                        $size6 = $_POST['size6'];
                        $size7 = $_POST['size7'];
                        $size8 = $_POST['size8'];
                        $size9 = $_POST['size9'];
                        $size10 = $_POST['size10'];
                        $size11 = $_POST['size11'];
                        $size12 = $_POST['size12'];
                        $size13 = $_POST['size13'];
                        $size14 = $_POST['size14'];
                        $size15 = $_POST['size15'];
                        $size16 = $_POST['size16'];
                        $size17 = $_POST['size17'];
                        $size18 = $_POST['size18'];
                        $size19 = $_POST['size19'];
                        $size20 = $_POST['size20'];
                        $size21 = $_POST['size21'];
                        $size22 = $_POST['size22'];
                        $size23 = $_POST['size23'];
                        $size24 = $_POST['size24'];
                        $size25 = $_POST['size25'];
                         }else{
                             $qty=$_POST['qty'];
                         }
                      $colors = $_POST['color'];
                      ##########################
          $i=0;
                        foreach ($colors as $color){
                              if($use_sizes==1){
                             $result_sizes= @mysqli_query($con,"SELECT * FROM sizes limit 26");
$num_sizes=@mysqli_num_rows($result_sizes);
if($num_sizes>0) {
      $ii=1;        
while ($row_sizes= mysqli_fetch_array($result_sizes)) {
###################
    if(${'size'.$row_sizes['id']}<=0){}else{
$sql="INSERT INTO ".$prefix."_receivings_temporary (item, Price, Quantity, color, size, unit, Discount, Total, SupplierID, BuyPrice, date, type, subqty, user_id)
VALUES ('".$code."',(select price FROM items where id='".$code."'),'".${'size'.$ii}."','".$color."','".$row_sizes['id']."','1','0',(${'size'.$ii} * (select price FROM items where id='".$code."')),'-1',(select price FROM items where id='".$code."'),'$datetime','1','1','".$user_id."')";
if(mysqli_query($con, $sql)){}else{
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
mysqli_query($con, $sql);
                              }
                                            }
        
                      ####################

                          if(mysqli_errno($con)>0){
                               echo '<div class="alert alert-warning">error '.mysqli_errno($con).'</div>';
                          }else{
                                     echo '<div class="alert alert-success">success</div>';  
                          }     
                    }
                    ?>