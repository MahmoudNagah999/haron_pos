<?php
include dirname(__FILE__)."/../../includes/inc.php";

$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$dateSqlCon = "";
if ($from !='' and $to!=''){
    $from=stripslashes(date('Y-m-d',strtotime($from)));
    $to=stripslashes(date('Y-m-d',strtotime($to)));
    $dateSqlCon .="and left(date,10) BETWEEN '".$from."' AND '".$to."'";
}elseif ($from =='' and $to!=''){
    $to=stripslashes(date('Y-m-d',strtotime($to)));
    $dateSqlCon .="and left(date,10)  <=  '".$to."'";
}elseif ($from !='' and $to==''){
    $from=stripslashes(date('Y-m-d',strtotime($from)));
    $dateSqlCon .="and left(date,10)  >=  '".$from."'";
}else{
    if (!isset($_GET['from']) and !isset($_GET['from']) )
    {
        $dateSqlCon .="and left(date,10) BETWEEN '".date("d/m/Y")."' AND '".date("d/m/Y")."'";
    }}
$mobile1=stripslashes($_GET['mobile1']);
$mobile2=stripslashes($_GET['mobile2']);
$status_array = array();
foreach ($_GET['status'] as $one_status){
    if ($one_status!=''){
        $status_array []= $one_status;
    }
}
if (count($status_array) > 0){

    $status=implode(',',$status_array);
}
else{
    $status = '' ;
}
$inv=stripslashes($_GET['inv']);
$branch = array();
$branch=implode(',',$_GET['branch_id']); 
$UerID=stripslashes($_GET['UerID']);
if($inv=="" or $inv==null){}else{$add_sql.="inv_id='$inv' and ";}
if($user_branch_id && $user_branch_id > 0){$add_sql.="branch_id IN ($user_branch_id) and ";}
else{
    if($branch=="" or $branch==null){}else{$add_sql.="branch_id IN ($branch) and ";}
}


if ($_GET['region_id']!="null" and $_GET['region_id']!=null and $_GET['region_id']!=''){
//    $regions=explode(',',stripslashes($_GET['region_id']));

    $i =0 ;
    foreach ($_GET['region_id'] as $region){
        if($region=="" or $region==null){}else{
            $region_childs = get_region_childs($region);
            $region_childs=implode(',',$region_childs);
            if ($i == 0){
                $add_sql.=" ( ";
                $add_sql.="    region_id IN ($region_childs )  ";
            }else{
                $add_sql.="  or   region_id IN ($region_childs )  ";
            }
        }
        $i++;
    }
    $add_sql.="   ) and   ";

}
$alpha_joins = join("','",$_GET['Alpha']);
//die($add_sql )  ;
//$region_childs = get_region_childs($region);
//$region_childs=implode(',',$region_childs);
//if($region=="" or $region==null){}else{$add_sql.="    region_id IN ($region_childs ) and ";}
if($UerID=="" or $UerID==null){}else{$add_sql_UerID="user_id='$UerID' and ";}
$add_sql_doc = '' ;
if($mobile1=="" or $mobile1==null){}else{$add_sql_doc.=" mobile1 like '%$mobile1%' and ";}
if($mobile2=="" or $mobile2==null){}else{$add_sql_doc.=" mobile2 like '%$mobile2%' and ";}



if($status=="" or $status==null){}else{$add_sql_doc.="status IN ($status) and ";}
 if($_GET['Alpha']=="" or $_GET['Alpha']==null){}else{ $add_sql_doc.=" alpha IN ('".$alpha_joins."') and ";}
//MySQL Database Name
$filename = 'order_supply';         //File Name
/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
//create MySQL connection
  //SELECT * FROM cairo_order_supply_inv where type in('1','2') and left(date,10) BETWEEN '2021-03-21' AND '2021-04-21' order by id ASC LIMIT 0, 100
  //SELECT * FROM cairo_order_supply_inv where type in('1','2') and left(date,10) BETWEEN '2021-03-21' AND '2021-04-21' order by id asc
  $sql = "SELECT * FROM ".$prefix."_order_supply_inv where $add_sql $add_sql_UerID $add_sql_doc type in('1','2') $dateSqlCon order by id ASC";
 $result = @mysqli_query($con,$sql);
$num=mysqli_num_rows($result);
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

  //  header("Content-Type: application/xls");
  //  header("Content-Disposition: attachment; filename=$filename.'.'.$file_ending");
  //  header("Pragma: no-cache");
  //  header("Expires: 0");

//end of printing column names
//start while loop to get data
//while($row = mysql_fetch_row($result))
//{
    $schema_insert = "";
    $schema_insert .= '<table border="1">';
//make the column headers what you want in whatever order you want
    $schema_insert .= '<td><u>الكود</u></td>
<td><u>العنوان</u></td>
<td><u>الفرع</u></td>
<td><u>محمول1 </u></td>
<td><u>محمول2 </u></td>
<td><u>الاصناف</u></td>
<td><u>رقم التوريد</u></td>
<td><u>التاريخ</u></td>
<td><u>الاجمالى</u></td>
<td><u>م.النقل</u></td>
<td><u>العميل</u></td>
<td><u>الحاله</u></td>
<td><u>وقت التعديل</u></td>
<td><u>تعديل بواسطة</u></td>
<td><u> بواسطة</u></td>
<td><u> Alpha</u></td
</tr>';
//loop the query data to the table in same order as the headers
    while ($data = mysqli_fetch_assoc($result)) {
        $sub_sql = "SELECT * FROM " . $prefix . "_order_supply  where inv_id=" . $data['inv_id'] . "  ";
        $sub_result = @mysqli_query($con, $sub_sql);

        $products = '';

        while ($roww = @mysqli_fetch_array($sub_result)) {


            if ($roww['item_status'] == 'offers') {


                $sub_sql1 = "SELECT name  FROM " . $prefix . "_offers_inv  where id=" . $roww['item'];

                $sub_result1 = @mysqli_query($con, $sub_sql1);
                if (mysqli_num_rows($sub_result1) > 0) {
                    while ($sub_row1 = @mysqli_fetch_array($sub_result1)) {
                        $products .= "(" . $roww['Quantity'] . ") - " . $sub_row1['name'] . " <br/> ";

                    }
                }
            } else {

                $sub_sql1 = "SELECT item  FROM items  where id=" . $roww['item'];
                $sub_result1 = @mysqli_query($con, $sub_sql1);

                if (mysqli_num_rows($sub_result1) > 0) {
                    while ($sub_row = @mysqli_fetch_array($sub_result1)) {
                        $products .= "(" . $roww['Quantity'] . ") - " . $sub_row['item'] . " <br/> ";
                    }
                }
            }
        }

        $schema_insert .= '<tr style="text-align:center;">
                  <td>' . $data[id] . '</td>
                  <td>' . $data[address] . '</td>
                  <td>' . get_branch_data($data['branch_id'])[name] . '</td>
                  <td>' . $data['mobile1'] . '</td>
                  <td>' . $data['mobile2'].' </td>
                  <td>' . $products . '</td>
                  <td>' . $data[inv_id] . '</td>
                  <td>' . substr($data['date'], 0, 10) . '</td>
                  <td>' . $data[Total] . '</td>                 
                  <td>' . $data[shipping] . '</td>                 
                  <td>' . $data[client] . '</td>                 
                  <td>' . get_order_supply_status_data($data['status'])[name] . "" . '</td>   
                   <td>' . $data[updated_at] . '</td>                 
        
                  <td>' . get_user_data($data['edit_user'])[name] . "" . '</td>   
                  <td>' . get_user_data($data['user_id'])[name] . "" . '</td>
                  <td>' . $data[alpha] . '</td>
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
print chr(255) . chr(254) . mb_convert_encoding($schema_insert, 'UTF-16LE', 'UTF-8');
print "\n";
?>