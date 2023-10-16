<?php
include dirname(__FILE__)."/../../includes/inc.php";
require_once('tcpdf_include.php');
$ids=Trim(stripslashes($_GET['ids']));
$now=date('Y-m-d');

$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);

$alldata=get_order_supply_inv_data_by_id($ids);
if(count((array)$alldata) == 0 or (count((array)$alldata)>0 and $alldata[0][id]== null)){die();}
class MYPDF extends TCPDF {
// Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $alldata = array();
        foreach($lines as $line) {
            $alldata[] = explode(';', chop($line));
        }
        return $alldata;
    }
// Colored table
    public function ColoredTable($header,$alldata) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 35, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
      //  $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($alldata as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
         //   $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

######################
$labelwidth="300";
$labelheight="240";
//$labelwidth="210";
//$labelheight="300";
$custom_layout = array($labelwidth, $labelheight);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintFooter(false);
$pdf->SetPrintHeader(false);
//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('etolv.com');
//$pdf->SetTitle($alldata[name]);
$pdf->SetSubject('Order Supply');
$pdf->SetKeywords('etolv.com');
// set default header data
$pdf->SetHeaderData('', '100', 'التاريخ : ' . $now, '');

// set header and footer fonts
$pdf->setHeaderFont(Array('helvetica', 'I', 6));
// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(30, 10, 5);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
foreach ($alldata as $data) {
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language dependent data:
$lg = Array();
$lg['a_meta_charset'] = 'UTF-8';
$lg['a_meta_dir'] = 'rtl';
$lg['a_meta_language'] = 'ar';
$lg['w_page'] = 'page';
// set some language-dependent strings (optional)
$pdf->setLanguageArray($lg);
// ---------------------------------------------------------
// set font
$pdf->SetFont('dejavusans', '', 12);
//$pdf->SetMargins(3, -4, 1, true);
    // add a page
    $pdf->AddPage();
    $table='  <br/>';
// Persian and English content
//$htmlpersian = '';
//$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
// set LTR direction for english translation
    $pdf->setRTL(false);
    $pdf->SetFontSize(10);
// print newline
//$pdf->Ln();
// Persian and English content
//$htmlpersiantranslation = '';
//$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);
// Restore RTL direction
    $pdf->setRTL(true);
// set font
    $pdf->SetFont('dejavusans', '', 18);
// print newline
//$pdf->Ln();
// Arabic and English content
    $pdf->Cell(0, 14, '', 0, 1, 'C');
  $branchName = $data['branch_name'];
  $branch_logo = (!empty($data['branch_logo']))? $data['branch_logo'] : 'no_image.jpg' ;
//    $pdf->Image('../../images/'.$branch_logo, 170, 3, 25, 18);
    $table.='
<img src="../../images/'.$branch_logo.'" style="width: 180px;text-align: center" alt="">
<div  class="form-control" style=" font-size: 12px; background-color: aliceblue ; text-align: center ; border-radius: 20px">
بوليصه شحن : '.$data['inv_id'].' - '.$branchName.'
</div>
';
  
    $table.='<br/>';
    $table.='<table width="95%" class="table" border="1" style="  border: 1px solid black;">
<tr>
<td>كود  </td>
<td>'.$data['id'].'</td>
<td>اسم العميل</td>
<td colspan="2">'.$data['client'].'</td>
<td>'.get_region_data($data['region_id'])[name].'</td>
</tr>
<tr>
<td>الفرع</td>
<td colspan="2">'.   $data['branch_name'].'</td>
<td>تعديل</td>
<td colspan="2">'.   $data['edit_user'].'</td>
</tr>
<tr>
<td>تاريخ التحرير</td>
<td>'.$data['date'].'</td>
<td colspan="4" rowspan="2">العنوان : '.$data['address'].' </td>
</tr>
<tr>
<td>
تاريخ التسليم
</td>

<td>

</td>
</tr>
<tr>
<td>تليفون</td>
<td colspan="2">'.$data['mobile1'].'</td>
<td>محمول</td>
<td colspan="2">'.$data['mobile2'].'</td>
</tr>
<tr>
<td>ملاحظات</td>
<td colspan="5">'.$data['notes'].'</td>
</tr>
</table>
    
    
    
    
    
    
    
    
    
    
    
    
    ';


   // $sub_sql = "SELECT " . $prefix . "_order_supply.Price , " . $prefix . "_order_supply.Quantity , items.item FROM " . $prefix . "_order_supply Join items on items.id =" . $prefix . "_order_supply.item  where " . $prefix . "_order_supply.inv_id=" . $data['inv_id'] . " order by items.item Asc";
   // $sub_result = @mysqli_query($con, $sub_sql);



    $table.='<table width="95%"  class="table" border="1" style=" border: 1px solid black;">
<tr>
<th width="80%">اسم المنتج</th>
<th width="20%">السعر</th>

</tr>
';
    $products = '' ;

    $sub_sql = "SELECT * FROM ".$prefix."_order_supply  where inv_id=".$data['inv_id']."  ";
    $sub_result = @mysqli_query($con,$sub_sql);

    while ($roww = @mysqli_fetch_array($sub_result)) {
        if($roww['item_status'] == 'offers'){
            $sub_sql1 = "SELECT name  FROM ".$prefix."_offers_inv  where id=".$roww['item'];
            $sub_result1 = @mysqli_query($con,$sub_sql1);
            if(mysqli_num_rows($sub_result1)>0) {
                while ($sub_row1 = @mysqli_fetch_array($sub_result1)) {
                    $products.= "(".$roww['Quantity'].") - ".$sub_row1['name'] ." <br/> ";
                }
            }
        }
        else{
            $sub_sql1 = "SELECT item  FROM items  where id=".$roww['item'];
            $sub_result1 = @mysqli_query($con,$sub_sql1);

            if(mysqli_num_rows($sub_result1)>0){
                while($sub_row = @mysqli_fetch_array($sub_result1)){
                    $products.= "(".$roww['Quantity'].") - ".$sub_row['item'] ." <br/> ";
                }
            }
        }
    }
        $table.='
<tr>
<td >'.$products.'</td>
<td>'.$data['Total'].'</td>

</tr>


';
       $total = $data['Total'] +$data['shipping']-$data['discount'];
//    }

    $table.='

<tr>
<td > الاجمالى + م.النقل  ( '.$data['shipping'].')  - الخصم ('.$data['discount'].') </td>
<td>'.$total.'</td>

</tr>

</table>';
    $table .='<br/>
                <br/>
                <table width="95%"  class="table" border="1" style=" border: 1px solid black;">
                
                <tr>
                <td>اسم السكرتير</td>
                <td style="text-align:center;" >'.$data['user_id'].'</td>
                <td style="text-align:center;" >ميعاد التسليم</td>
                <td colspan="2">من :</td>
                <td colspan="2"> الى : </td>
              
</tr>
<tr>

<td> امضاء العميل</td>
<td colspan="3"></td>
<td> امضاء المندوب</td>
<td colspan="2"></td>
</tr>
</table>';
###########################
    $htmlcontent = <<<EOF
<!-- CSS STYLE -->
<style type="text/css">
        u {
    text-decoration: underline;
        text-align:center;
        font-weight: bold;
        font-size: 14px;
}
.gray{
    	background-color:LightGray;
}
        .table {

			font-size: 12px;
			min-width: 100%;
			border: 0px;
		
        
                            }

        .row {
            display: table-row;
        }

        .column {

            vertical-align: top;
        }
    </style>
     <table  border="0" style=" font-size:9px; text-align:center;    border-style: none;">
     <tr><td></td></tr>
     </table>
    <table  border="0" style=" font-size:12px; text-align:center;    border-style: none;">
   
<tr ><td style=" background-color: LightGray; ">$get_db_CompanyName - $branchName -$now </td></tr>
</table>
     <body>
     
     
     
     
     <table>
     <tr>
     <td ><div style="padding-right: 50px;">$table</div></td>
     <td ><div style="padding-left: 50px;">$table</div></td>
</tr>
     </table>
</div>

                
EOF;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// set LTR direction for english translation
    $pdf->setRTL(false);

}
ob_end_clean();

$pdf->Output('order_supplier_print.pdf', 'I');