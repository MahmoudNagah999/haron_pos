<?php
include dirname(__FILE__)."/../../includes/inc.php";

$safe_id=$_GET['safe_id'];
$orderby=$_GET['orderby'];
$type=$_GET['type'];
$sqlCon='';
if ($orderby==null or  $orderby==''){    $orderby = 'id';}
if ($type==null or  $type==''){    $type = 'Desc';}
if ($safe_id!=null and $safe_id!=''){
    $sqlCon.=' and  safe_id = '.$safe_id.'   ';
}
//MySQL Database Name
$filename = 'treasury';         //File Name
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
//create MySQL connection
  $sql = "SELECT * FROM ".$prefix."_treasury  where  id!= '' $sqlCon order by $orderby $type";

$result = @mysqli_query($con,$sql);
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
$schema_insert.= '<table border="1">';
//make the column headers what you want in whatever order you want
$schema_insert.= '<td><u>الكود</u></td>
<td><u>الخزينه</u></td>
<td><u>العمليه</u></td>
<td><u>المبلغ</u></td>
<td><u>التاريح</u></td>
<td><u>تفاصيل</u></td>
</tr>';
//loop the query data to the table in same order as the headers
while($row = @mysqli_fetch_array($result))
{
    #################
    $issingle=$i/2;
    $dot = strstr($issingle, '.');
    if($dot==""){
        $class="background_color_FFF";
    }else{$class='background_color_D5EFF0';}
    if($row['type']==1){$ex_type="$Withdrawal_lang";}
    else if($row['type']==2){$ex_type="$Deposit_lang";}
    else if($row['type']==3){$ex_type="$Purchases_cash_lang";}
    else if($row['type']==4){$ex_type="$Cash_sales_lang";}
    else if($row['type']==5){$ex_type="$Expenses_lang";}
    else if($row['type']==6){$ex_type="$Payment_suppliers_lang";}
    else if($row['type']==7){$ex_type="$Collection_customers";}
    else if($row['type']==8){$ex_type="$Sales_returns_lang";}
    else if($row['type']==9){$ex_type="$Returns_Purchases_lang";}
    else if($row['type']==50){$ex_type="$commission_lang";}
    else{}



    $schema_insert.= ' <tr class="'.$class.'">
        <td class="text-center">'.$row['id'].'</td>
        <td class="text-center">'.get_safe_data($row['safe_id'])[name].'</td>
        <td class="text-center">'.$ex_type.'</td>
        <td class="text-center">'.$row['Amount'].'</td>
        <td class="text-center">'.substr($row['date'], 0, 10).'</td>
        <td class="text-center">'.$row['notes'].'</td>
        </tr>';

    $i++; }
$schema_insert.= '</table>';

//    $schema_insert = str_replace($sep."$", "", $schema_insert);
//    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
//    $schema_insert .= "\t";

//}
header("content-type:application/xls;charset=UTF-8");
//header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
print(trim($schema_insert));
print "\n";
?>