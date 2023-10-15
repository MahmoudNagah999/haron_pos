<?php
include"includes/inc.php"; ?>
                           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">المنتج</th>
                                            <th class="text-center">الموديل</th>
                                            <th class="text-center">اللون</th>
                
           <?php
                                                      $result_sizes= @mysqli_query($con,"SELECT * FROM sizes limit 15");
                                        $num_sizes=@mysqli_num_rows($result_sizes);
                                        if($num_sizes>0) {
              
                                            while ($row_sizes= mysqli_fetch_array($result_sizes)) {
                     echo $row_sizes="<th class='text-center'>".$row_sizes['size']."</th>";
                                            }
                                          
                                        }
                                            ?>
                                             <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <?php
$result_store_temp = @mysqli_query($con, "SELECT * FROM store_temp");
$num_store_temp = @mysqli_num_rows($result_store_temp);
if ($num_store_temp > 0) {

    while ($row_store_temp = mysqli_fetch_array($result_store_temp)) {
        echo' <tr><td class="text-center">' . Get_product_name($row_store_temp['product_id']) . '</td>
                                            <td class="text-center">' . Get_model_name($row_store_temp['code']) . '</td>
                                            <td class="text-center">' . get_color_name($row_store_temp['color']) . '</td>
                                            <td class="text-center">' . $row_store_temp['size1'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size2'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size3'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size4'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size5'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size6'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size7'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size8'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size9'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size10'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size11'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size12'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size13'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size14'] . '</td>
                                            <td class="text-center">' . $row_store_temp['size15'] . '</td>
<td class="text-center">
<a href="store_out.php?delid=' . $row_store_temp['id'] . '" onclick="return confirm(\'هل انت متأكد انك تريد الحذف ؟\');">
                                                <button class="btn btn-danger">

    <i class="icon-remove icon-white"></i>

     حذف

</button></a></td></tr>';
            $client_temp=$row_store_temp['client'];
    }
}
?>
                                                               <tr><td colspan="100"><a href="store_out.php?save=1&clid=<?php echo"".$client_temp.""; ?>" class="btn btn-success btn-grad btn-rect" title="حفظ">حفظ</a></td>  <tr/>
                 </table>
                            </div>
                                                              
                            </div>
                        </div>