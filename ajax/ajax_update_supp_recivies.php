<?php
include "../includes/inc.php";

if(isset($_GET['SupplierID']) and $_GET['SupplierID']!==null){
$SupplierID=$_GET['SupplierID'];
if(mysqli_query($con,"UPDATE ".$prefix."_receivings_temporary SET SupplierID=".$SupplierID." where user_id='$user_id'")){
//header("refresh:0;url=receivings.php");
}else{
echo"$Please_try_again_lang";
}
}
echo json_encode($data);
?>