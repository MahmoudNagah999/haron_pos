<?php
include dirname(__FILE__)."/../../includes/inc.php";
require_once('tcpdf_include.php');
$id=Trim(stripslashes($_GET['id']));
$data=get_inv_data($id,1);
$now=date('Y-m-d');
if($data[id]==null){die();}
class MYPDF extends TCPDF {
// Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }
// Colored table
    public function ColoredTable($header,$data) {
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
        foreach($data as $row) {
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
$labelwidth="210";
$labelheight="300";
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
//$pdf->SetTitle($data[name]);
$pdf->SetSubject($data[name]);
$pdf->SetKeywords('etolv.com');
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
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
// Persian and English content
//$htmlpersian = '';
//$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
// set LTR direction for english translation
$pdf->setRTL(false);
$pdf->SetFontSize(14);
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
$pdf->Cell(0, 12, '',0,1,'C');
$total_disc=$data[discount];
$co_name=$get_db_CompanyName;
$inv_date=substr($data[date],0, 10);
$inv_num=$data[inv_id];
$cli_name=get_client_data($data[supplier])[name];
$table.='<tr class="gray"  style="text-align:center;">
<td><u>الصنف</u></td>
<td><u>الكمية</u></td>
<td><u>السعر</u></td>
<td><u>الاجمالى</u></td>
</tr>';
                for ($index = 0; $index < 40; $index++) {
                  //  var_dump($inf[confirmed]);

                }
$result_inv = mysqli_query($con,"SELECT * FROM ".$prefix."_sales where inv_id='".$_GET['id']."'");			
if(@mysqli_num_rows($result_inv)>0){
while($row_inv = mysqli_fetch_array($result_inv))
  {
    $total_qty+=$row_inv[Quantity];
    $inv_user=get_user_data($row_inv[user_id])[name];
     if($Discount_type==2){$item_disc=($row_inv[Price]*($row_inv['Discount']/100));}else{$item_disc=$row_inv['Discount'];}
                $table.='<tr style="text-align:center;">
                  <td>'.Get_model_name($row_inv[item]).'</td>
                  <td>'.$row_inv[Quantity].'</td>
                  <td>'.($row_inv[Price]-$item_disc).'</td>
                  <td>'.$row_inv[Total].'</td>                 
                </tr>';     
  }
}
                                 $table.='<tr>
                  <td>الاجمالى</td>
                  <td style="text-align:center;">'.$total_qty.'</td>
                  <td></td>
                  <td style="text-align:center;">'.($data[Total]).'</td>                 
                </tr>'; 
                                 if($Discount_type==2){$disc=($data[Total]*$data[discount]/100);}else{$disc=$data[discount];}
                                                                  $table.='<tr>
                  <td colspan="3">الخصم</td>
                  <td style="text-align:center;">'.$disc.'</td>                 
                </tr>';
  $table.='<tr>
                  <td colspan="3">الاجمالى بعد الخصم</td>
                  <td style="text-align:center;">'.($data[Total]-$disc).'</td>                 
                </tr>';
  if($db_tax==0 or $db_tax==null){}else{
                                   $table.='<tr>
                  <td colspan="3"> ضريبة '.$db_tax.'%</td>
                  <td style="text-align:center;">'.$data[tax].'</td>                 
                </tr>';
                           $table.='<tr>
                  <td colspan="3">الاجمالى بعد الضريبة</td>
                  <td style="text-align:center;">'. (($data[Total]-$disc)*$data[tax]/100) .'</td>                 
                </tr>';
  }
    if($shipping==1){
        if($data[shipping]<=0 or $data[shipping]==null){}else{
                                   $table.='<tr>
                  <td colspan="3">م.النقل</td>
                  <td style="text-align:center;">'.$data[shipping].'</td>                 
                </tr>'; 
                                                                    $table.='<tr>
                  <td colspan="3">الاجمالى بعد النقل</td>
                  <td style="text-align:center;">'.($data[Total]-$disc+$data[tax]+$data[shipping]).'</td>                 
                </tr>';
    }}
 $table.='<tr>
                  <td  colspan="2">تاريخ الطباعة</td>
                  <td colspan="2" style="text-align:center;">'.date("Y-m-d h:i:s").'</td>
                </tr>';
//echo $table ;

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

			font-size: 14px;
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
    <?php /*
     <table  border="0" style=" font-size:12px; text-align:center;    border-style: none;">
     <tr><td><img src="http://possys.org/apple_club/images/apple_club.png" width="100" /></td></tr>
     </table>
  
    <table  border="0" style=" font-size:12px; text-align:center;    border-style: none;">
   
<tr><td style=" background-color: LightGray; ">$get_db_CompanyName  - $now</td></tr>
</table>
   */
     ?>
        <body>

           
        <table  style="font-size:14px;">
   <tr> 
       <td colspan="2" text-align:right;><u> فاتورة رقم  </u> <u>$inv_num </u> </td>
        <td colspan="1" text-align:left;>$inv_date</td>
           </tr>         
   </table>
            <table  style="font-size:14px;">
   <tr> 
       <td colspan="4">الاسم/$cli_name</td>
           </tr>         
   </table>    
<table class="table" border="1" style="border: 1px solid black;">
$table
</table>

<table border="0"  style="font-size:14px; padding-top:3px;">
          <tr>
          <td  colspan="2">الكاشير</td>
                  <td  colspan="2">$inv_user</td>

                </tr>
                </table>
                
<table border="0"  style="font-size:12px; padding-top:10px;">
          <tr>
          
                 <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_ReturnPolicy </td>

                </tr>
                
                          <tr>
          
                  <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_CustomField1</td>

                </tr>
                                          <tr>
          
                 <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_CustomField2</td>

                </tr>
                                          <tr>
          
                  <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_CustomField3</td>

                </tr>
                                          <tr>
          
                <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_E_mail</td>

                </tr>
                                              <tr>
          
                  <td  colspan="4" style=" font-style: normal; font-size: 14px; font-family: "Times New Roman", Times, serif;">$get_db_Website</td>

                </tr>
                </table>
EOF;
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// set LTR direction for english translation
$pdf->setRTL(false);
ob_end_clean();
$pdf->Output(''.$inv_num.'.pdf', 'I');