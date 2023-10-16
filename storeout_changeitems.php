<?php
include"includes/inc.php";
$products=Trim(stripslashes($_POST['products']));
$result_code = @mysqli_query($con, "SELECT * FROM items where groupid='$products'");
$num = @mysqli_num_rows($result_code);
?>
{
  "options": [
  {"value": "", "text": ""}
  <?php
  $i=0;
  if($num>0){ echo",";
 while ($row_code = mysqli_fetch_array($result_code)) {
  ?>
    {"value": "<?php echo $row_code['id']; ?>", "text": "<?php echo $row_code['item']; ?>"} <?php if($i==$num-1){}else{echo",";} ?>
  <?php $i++;}}else{} ?>
  ]
}