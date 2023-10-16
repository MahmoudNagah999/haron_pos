<?php








include ("includes/inc.php");
   $sql ="SELECT * From " . $prefix . "_sales_inv where  inv_id=''  and Total < 0 ";
$result = @mysqli_query($con, $sql);
$num = @mysqli_num_rows($result);
if ($num > 0) {
    $i = 0;

    while ($row = mysqli_fetch_array($result)) {
          $sql1 ="SELECT * From " . $prefix . "_sales_inv where  id = ".($row['id']+1);
       $result1 = @mysqli_query($con, $sql1);


        while ($row1 = mysqli_fetch_array($result1)) {

            if (($row['Total']*-1) == $row1['paid']){
                $upsql="UPDATE " . $prefix . "_sales_inv SET order_suppy_num =". $row1['inv_id']."  where id='" . $row['id'] . "' and type='3'";
        mysqli_query($con, $upsql);
        $i++;


            }

        }

    }
    }
echo 'succes';