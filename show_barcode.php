<?php
include "includes/inc.php";
?>
<?php /*?><img src="barcode.php?text=1&size=20" style="border:0px;"/><?php */?>
<table width='100%' align='center' cellpadding='20'><tr>
            <?php
$Barcode = mysqli_query($con,"SELECT * FROM items where id='".$_GET['id']."'");
$num_Barcode=mysqli_num_rows($Barcode);
if($num_Barcode>0){
while($row_Barcode = mysqli_fetch_array($Barcode))
  {
echo"
<td><img src='barcode_a.php?codetype=code128&size=100&text=".$row_Barcode['Barcode']."' /></td>
";
  }
}
  ?></tr>
</table>