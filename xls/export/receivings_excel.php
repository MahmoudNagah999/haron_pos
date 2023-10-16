<?php
include dirname(__FILE__)."/../../includes/inc.php";


if($orderby==null){$orderby="id";}
if($type==null){$type="DESC";}
###########################################
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
$supplier_id=stripslashes($_GET['supplier_id']);
$inv=stripslashes($_GET['inv']);
if($inv=="" or $inv==null){}else{$add_sql.="inv_id='$inv' and ";}
if($supplier_id=="" or $supplier_id==null){}else{$add_sql.="supplier='$supplier_id' and ";}

//MySQL Database Name
$filename = 'order_supply';         //File Name
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
//create MySQL connection
//   $sql = "SELECT * FROM ".$prefix."_order_supply_inv where $add_sql $add_sql_UerID $add_sql_doc type in('1','2') $dateSqlCon";
   $sql = "SELECT * FROM ".$prefix."_receivings_inv where $add_sql type='1' and left(date,10) BETWEEN '$from' AND '$to' order by $orderby $type ";
 $result = @mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0) {

    $file_ending = "xls";
//header info for browser

    /*******Start of Formatting for Excel*******/
//define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character
////start of printing column names as names of MySQL fields
//for ($i = 0; $i < mysql_num_fields($result); $i++) {
//    echo mysql_field_name($result,$i) . "\t";
//
//}
//print("\n");

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$filename.'.'.$file_ending");
    header("Pragma: no-cache");
    header("Expires: 0");

//end of printing column names
//start while loop to get data
//while($row = mysql_fetch_row($result))
//{
    $schema_insert = "";
    $schema_insert .= '<table border="1">';
//make the column headers what you want in whatever order you want
    $schema_insert .= '<td><u>الكود</u></td>
<td><u>رقم الفاتوره</u></td>
<td><u>الاصناف</u></td>
<td><u>التاريخ </u></td>
<td><u>الاجمالى </u></td>
<td><u>المورد</u></td>
<td><u>طريقه الدفع</u></td>
</tr>';
//loop the query data to the table in same order as the headers
    while ($data = mysqli_fetch_assoc($result)) {
        $sub_sql = "SELECT * FROM " . $prefix . "_order_supply  where inv_id=" . $data['inv_id'] . "  ";
        $sub_result = @mysqli_query($con, $sub_sql);

        $products = '' ;

        $sub_sql = "SELECT * FROM ".$prefix."_receivings  where inv_id=".$data['inv_id']." order by id   $type ";
        $sub_result = @mysqli_query($con,$sub_sql);

        while ($roww = @mysqli_fetch_array($sub_result)) {
            $sub_sql1 = "SELECT item  FROM items  where id=".$roww['item'];
            $sub_result1 = @mysqli_query($con,$sub_sql1);

            if(mysqli_num_rows($sub_result1)>0){
                while($sub_row = @mysqli_fetch_array($sub_result1)){
                    $products.= "(".$roww['Quantity'].") - ".$sub_row['item'] ." <br/> ";
                }
            }
        }
        if($data['supplier']==""){$supplier_name="";}else{
            $result_suppliers = mysqli_query($con,"SELECT id,name FROM ".$prefix."_suppliers WHERE id=".$data['supplier']."");
            if(@mysqli_num_rows($result_suppliers)>0){
                while($row_suppliers = mysqli_fetch_array($result_suppliers))
                {
                    $supplier_name=$row_suppliers['name'];
                }
            }
            }
            if($data['PaymentMethod']==1){$PaymentMethod="نقدى";}
            else if($data['PaymentMethod']==2){$PaymentMethod="اجل";}
            else if($data['PaymentMethod']==3){$PaymentMethod="شيك";}
            else{}
        $schema_insert .= '<tr style="text-align:center;">
                  <td>' . $data[id] . '</td>
                                    <td>' . $data[inv_id] . '</td>
                  <td>' . $products . '</td>
                  <td>' . substr($data['date'], 0, 10) . '</td>
                  <td>' . ($data['Total']-($data['discount'])) . '</td>                 
                  <td>' . $supplier_name. '</td>                 
                  <td>' . $PaymentMethod . "" . '</td>   
                </tr>';
    }
    $schema_insert .= '</table>';
//    $schema_insert = str_replace($sep."$", "", $schema_insert);
//    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
//    $schema_insert .= "\t";

//}
}
header("content-type:application/xls;charset=UTF-8");
//header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
print(trim($schema_insert));
print "\n";
?>