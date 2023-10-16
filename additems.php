<?php
include "includes/inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo"".$get_db_CompanyName.""; ?></title>
<?php include"includes/css.php"; ?>
</head>

<body>
<div>
<?php
if(isset($_POST['submit'])){
                                if($demo==1){
echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
      }else{
$groups=Trim(stripslashes($_POST['groups']));
$items=Trim(stripslashes($_POST['items']));
$Quantity=Trim(stripslashes($_POST['Quantity']));
$price=Trim(stripslashes($_POST['price']));
$Sale_price=Trim(stripslashes($_POST['Sale_price']));
if($groups=="" or $items==""){
echo'<div class="alert alert-danger  text-right">
'.$add_itemName_group_lang.'
</div>';
	}else{
$sql="INSERT INTO items (groupid,  item, Quantity, Retail_price, price)
VALUES ('".$groups."','".$items."','".$Quantity."','".$Sale_price."','".$price."')";
if (!mysqli_query($con,$sql))
  {
	  if(mysqli_errno($con)==1062){
echo'<div class="alert alert-danger  text-right">
'.$Item_already_exists_lang.'
</div>';
		  }else{
echo'<div class="alert alert-danger  text-right">
'.$not_saved_try_lang.'
</div>';
	  }
  }else{
 echo'<div class="alert alert-success text-right">
'.$Data_is_saved_lang.'
</div>';  
//header("");
 echo "<script>window.close();</script>";
}
	}
      }}
?>
</div>
<div style="height:20px; width:100%;"></div>
<form method="post">
<table width="100%" border="1" style="border:1px; border-collapse:collapse; direction:rtl; text-align:center; padding-top:50px; margin-top:50px;">
  <tr>
    <td colspan="4" class="text-center"><?php echo"$Add_New_item"; ?></td>
  </tr>
  <tr>
      <td width="30%" class="text-center"><?php echo"$the_Group"; ?></td>
    <td  width="70%"  class="text-center"><select name="groups" size="1" class="form-control" <?php echo"$error_groups"; ?>>
            <option value=""></option>
            <?php
$Groups_list = mysqli_query($con,"SELECT * FROM products where id>0");
$num_Groups_list=mysqli_num_rows($Groups_list);
if($num_Groups_list>0){
while($row_Groups_list = mysqli_fetch_array($Groups_list))
  {
	  if($row_Groups_list['id']==$row_items_id){
		  echo'<option value="'.$row_Groups_list['id'].'"   selected="selected">'.$row_Groups_list['product_name'].'</option>';
		  }else{
echo'<option value="'.$row_Groups_list['id'].'">'.$row_Groups_list['product_name'].'</option>';
	  }
  }
}
  ?>
          </select></td>
  </tr>
  <tr>
      <td  width="30%" class="text-center"><?php echo"$item_Name_lang"; ?></td>
    <th  width="70%"  class="text-center"><input type="text" name="items" value=""  class="form-control" /></td>
  </tr>
  <tr>
    <td width="30%"  class="text-center"><?php echo"$the_Quantity_lang"; ?></td>
    <td width="70%"  class="text-center"><input type="number" name="Quantity" value=""  class="form-control" /></td>
  </tr>
  <tr>
    <td width="30%"  class="text-center"><?php echo"$Purchasing_price_lang"; ?></td>
    <td width="70%"  class="text-center"><input type="number" name="price" value=""  class="form-control" /></td>
  </tr>
    <tr>
    <td width="30%"  class="text-center"><?php echo"$Selling_price_lang"; ?></td>
    <td width="70%"  class="text-center"><input type="number" name="Sale_price" value=""  class="form-control" /></td>
  </tr>
    <tr>
        <td colspan="2"  class="text-center"><input class="btn btn-primary" type="submit" name="submit" value="حفظ" /></td>
  </tr>
</table>
</form>

</body>
</html>
<?php include 'includes/footer.php'; ?>
