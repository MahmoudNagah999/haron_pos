<?php
include"includes/inc.php";
?>
<html>
    <head>
<meta charset="UTF-8" />
</head>
<style>
@media print {
    .break {page-break-after: always;}
}
.center {
   margin: auto;
    width: 60%;
   // border: 1px solid #73AD21;
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
  $get_size_id_db=$_GET['sizeid'];                                              
 $result_colors= @mysqli_query($con,"SELECT * FROM colors where id in (".rtrim(get_clolors_of_item($_GET['code']), ",").")   order by id ASC");
                                        $num_colors=@mysqli_num_rows($result_colors);
                                        if($num_colors>0) {
                                             $count=0;
                                            while ($row_colors= mysqli_fetch_array($result_colors)) {
                                             $color_db=$row_colors['color'];
                                             $color_db_id=$row_colors['id'];
$color_name=get_color_name($color_db_id);   
$total=Get_total_items(''.$get_size_id_db.'',''.$color_db_id.'',$_GET['code']);  
  $code_wthedata=Get_model_barcode($_GET['code']).'-'.$get_size_id_db.'-'.$color_db_id;
                       if($total<=0){}else{
                         
    for ($index = 0; $index < $total; $index++) {
          if($count==$perline) //three images per row
            {
                        $count = 0;
            }
$barcode="".$_GET['code']."-".$get_size_id_db."-".$row_colors['id'].""; 
echo'<div class="barcode" style="width: 171px; background-color: aquamarine; font-size: 12px;">
<div style="width: 100%; float: right;">
<div style="float: left; width: 30%; text-align: left;white-space: nowrap;">'.get_color_name($row_colors['id']).' </div>
<div style="float: left; width: 35%; text-align:center;white-space: nowrap;"">S:'.Get_size_name($get_size_id_db).'</div>
<div style="float: left; text-align: right; width: 35%;white-space: nowrap;""> <span style="text-align:left;">›Ì«·Ï</span></div>
</div>
<div style="width: 100%; float: right;">
<div style="float: left; width: 30%; text-align: left;white-space: nowrap;">'.Get_model_name($_GET['code']).'</div>
<div style="float: left; width: 35%; text-align:center;white-space: nowrap;"">P:'.get_price_of_item($_GET['code']).'</div>
<div style="float: left; text-align: right; width: 35%;white-space: nowrap;""> <span style="text-align:left;">'.Get_product_name(Get_model_groupid($_GET['code'])).'</span></div>
</div>
<div style="text-align:center;"><img  src="barcode_labels_a.php?codetype=code128&size=20&text='.$barcode.'">
</div>
</div>
<div class="break"></div>';         
          
 $count++;  

    }
                      
                       }
                 
                                            }
                                        }
                                        ?>

    </body>
</html>