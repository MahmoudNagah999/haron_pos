<?php
include "includes/inc.php";
?>
<head>
    <meta charset="UTF-8" />
    <title>طباعة الباركود</title>
</head>
<style>
@media print {
    .break {page-break-after: always;}
}
.center {
   margin: auto;
    width: 60%;
    padding: 3px;
width:145px;
hight:65px;
text-align:left;
}
.barcode{
    padding-top: 2px;
}
</style>
<body style="margin-left: 0px;">
    <?php
$id=Trim(stripslashes($_GET['id']));
$barcode="".Get_model_barcode($id)."";	

$x=0;
echo'<div class="barcode" style="width: 171px; background-color: aquamarine; font-size: 12px;">';
//echo'<div style="width: 100%; float: right;">';
//echo'<div style="float: left; width: 30%; text-align: left;white-space: nowrap;">P:'.get_price_of_item($id).' LE. </div>';
//echo'</div>';
echo'<div style="width: 100%; float: right;">
<div style="float: left; width: 50%; text-align: left;white-space: nowrap;"">'.Get_model_name($id).'</div><div style="float: left; text-align: right; width: 50%;white-space: nowrap;"">P:'.get_price_of_item($id).' LE. </div>
</div>
<div style="text-align:center;"><img  src="barcode_labels_a.php?codetype=code128&size=20&text='.$barcode.'">
</div>
</div>
<div class="break"></div>';
/*if($ii==1){
 break;
}
*/
?>
</body>
