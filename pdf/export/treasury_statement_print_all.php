<?php
include dirname(__FILE__)."/../../includes/inc.php";
require_once('tcpdf_include.php');
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));

$safe_id=$_GET['safe_id'];
if ($safe_id > 0 ){

}else{
    echo'<div style="text-align:center; background-color:#E18C80; border-radius:5px;">
							<span style="float:left; padding-left:20px;"><img src="images/close.png" style="border:0px;" /></span>
							'.$must_choose_safe.'
							</div>';
    die();
}
$safe_name = " ( " . get_safe_data($_GET['safe_id'])[name] .  " ) "  ;
if($safe_id==""){}else{
    $quy.=" ".$prefix."_treasury.safe_id='$safe_id' and ";
}
$notes=$_GET['notes'];
if($notes==""){}else{
    $quy.=" ".$prefix."_sales_inv.notes like '%$notes%' and ";
}
if ($notes!=null and $notes!='') {
    $sql = "SELECT ".$prefix."_treasury.* FROM ".$prefix."_treasury join ".$prefix."_sales_inv on ".$prefix."_sales_inv.inv_id = ".$prefix."_treasury.inv_id where $quy  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'  ";

}else{
    $sql = "SELECT ".$prefix."_treasury.* FROM ".$prefix."_treasury where $quy  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'  ";

}
$result = @mysqli_query($con,$sql);
$now=date('Y-m-d');
//die();
//$alldata = @mysqli_fetch_array($result);
if($result->num_rows == 0 ){die();}
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

    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo.jpg';
        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'I', 4);
        // Title
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }


// Colored table
    public function ColoredTable($header,$alldata) {

        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.5);
//        $this->SetFont('', 'B');
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
$labelwidth="210";
$labelheight="297" ;
//$labelwidth="210";
//$labelheight="300";
$custom_layout = array($labelwidth, $labelheight);
$pdf = new TCPDF('L', PDF_UNIT, $custom_layout, true, 'UTF-8', false);

//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintFooter(true);
$pdf->SetPrintHeader(true);
//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('etolv.com');
//$pdf->SetTitle($alldata[name]);
$pdf->SetSubject('Order Supply');
$pdf->SetKeywords('etolv.com');
// set default header data
$pdf->SetHeaderData('', '100', 'التاريخ : ' . $now  . '  -  '. $safe_name, '');

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', 'I', 6));
// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(30, 10, 5);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 10);
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
//$pdf->SetFont('dejavusans', '', 9);
//$pdf->SetMargins(3, -4, 1, true);

// add a page
$pdf->AddPage();

//    $table = '  <br/>';
// Persian and English content
//$htmlpersian = '';
//$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
// set LTR direction for english translation
$pdf->setRTL(false);
$pdf->SetFontSize(8);
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
$pdf->Cell(0, 12, '', 0, 1, 'C');

if ($result->num_rows > 250){
    $table.='<div class="float" id="printTpMy"> ';
}
$table .= '       <table nobr="true"  id="tableee" width="100%" class="print-friendly table" dir="rtl" border="1" style=" border: 1px solid black;">      
';
$table .= '<tr  nobr="true" class="gray"  style="text-align:center;">
  <th  class="text-center">الحركه</th>

  
  <th  class="text-center">نوع العملية</th>
  
  
  <th  class="text-center">التاريخ</th>
  
  
  <th  class="text-center">اسم الجهه</th>
  <th   class="text-center">بيان</th>
  <th   class="text-center">ملاحظات</th>

  <th  class="text-center">وارد</th>
  <th  class="text-center">منصرف</th>
  <th  class="text-center">الرصيد</th>

</tr>';
$i=0;
$balance = 0 ;
while($row = @mysqli_fetch_array($result))
{
    $balance+=$row['Amount'];
    if($row['type']==1){$ex_type="$Withdrawal_lang";}
    else if($row['type']==2){$ex_type="$Deposit_lang";}
    else if($row['type']==3){$ex_type="$Purchases_cash_lang";}
    else if($row['type']==4){$ex_type="$Cash_sales_lang";}
    else if($row['type']==5){$ex_type="$Expenses_lang";}
    else if($row['type']==6){$ex_type="$Payment_suppliers_lang";}
    else if($row['type']==7){$ex_type="$Collection_customers";}
    else if($row['type']==8){$ex_type="$Sales_returns_lang";}
    else if($row['type']==9){$ex_type="$Returns_Purchases_lang";}
    else{}
    $noteArray = explode(' ',$row['notes']);
    if ($row['type']=="5"){
        $expenses_id=$row['expenses_id'];
        $nameVal=get_expenses_set_data($expenses_id) ["name"];
        $name='مصروف  \ '.$nameVal;

    } elseif ($row['type']=="3"){
        $supplier_id=$row['client_supp_name'];
        $name='مورد  \ '.get_supplier_data($supplier_id)[name];
    }elseif ($row['type']=="4"){
        $client_id=$row['client_supp_name'];
        if ($client_id == 0){
            $name='فاتوره  \ '.$row[inv_id];

        }else{
            $name='عميل  \ '.get_client_data($client_id)[name];
        }
    }elseif ($row['type']=="6"){
        $name='مورد  \ '.get_supplier_data($noteArray[count($noteArray) - 1])[name];
    }elseif ($row['type']=="7"){
        $client_id=substr($noteArray[count($noteArray) - 1],12);
        $name='عميل  \ '.get_client_data($client_id)[name];
    }elseif ($row['type']=="8"){
        $inv_id=substr($noteArray[count($noteArray) - 1],1);
        $name='فاتوره  \ '.$inv_id;
    }else{
        $name ='';
    }



    $table .=' <tr nobr="true" class="'.$class.'">
        <td>'.$row['id'].'</td>
        <td>'.$ex_type.'</td>
        <td>'.substr($row['date'], 0, 10).'</td>
        <td>'.$name.'</td>
        <td>'.get_inv_data($row['inv_id'],1)[notes].'</td>
        <td>'.$row['notes'].'</td>

        <td>';
             if ($row['Amount'] >= 0){
            $table .= $row['Amount'];
        }
            $table .= '</td>';
    $table .= '<td>';
            if ($row['Amount'] <= 0){
            $table .= $row['Amount'];
            }
            $table .= '</td>';
    $table .= ' <td>'.$balance.'</td>
    </tr>';

     $i++;
}


        $table .= '<tr> <thead  style="background-color:#CCC;">
    <th colspan="6" class="text-center">'.$the_total_lang.'</th>
<th class="text-center">';

if ($notes!=null and $notes!='') {
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury join ".$prefix."_sales_inv on ".$prefix."_sales_inv.inv_id = ".$prefix."_treasury.inv_id  where $quy ".$prefix."_treasury.Amount > 0 and  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}else{
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury where $quy ".$prefix."_treasury.Amount > 0 and  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}    $result_get = mysqli_query($con,$totalSql);
    while($row_get = mysqli_fetch_array($result_get))
    {
        $total=($row_get['Amount']);
    }

    $table .=  $total;
    $table .= '</th>
<th class="text-center">';

if ($notes!=null and $notes!='') {
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury join ".$prefix."_sales_inv on ".$prefix."_sales_inv.inv_id = ".$prefix."_treasury.inv_id  where $quy ".$prefix."_treasury.Amount < 0 and  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}else{
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury where $quy ".$prefix."_treasury.Amount < 0 and  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}    $result_get = mysqli_query($con,$totalSql);
    while($row_get = mysqli_fetch_array($result_get))
    {
        $total=($row_get['Amount']);
    }

    $table .=  $total;
    $table .= '</th>
<th class="text-center">';

if ($notes!=null and $notes!='') {
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury join ".$prefix."_sales_inv on ".$prefix."_sales_inv.inv_id = ".$prefix."_treasury.inv_id  where $quy  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}else{
    $totalSql="SELECT Sum(".$prefix."_treasury.Amount) as Amount FROM ".$prefix."_treasury where $quy  left(".$prefix."_treasury.date,10) BETWEEN '".$from."' AND '".$to."'";

}    $result_get = mysqli_query($con,$totalSql);
    while($row_get = mysqli_fetch_array($result_get))
    {
        $total=($row_get['Amount']);
    }

    $table .=  $total;
    $table .= '</th>
</thead></tr>';

$table .= '</table>
<div></div>';

if (count($alldata) > 250) {
 $table.='</div>' ;
}
if (count($alldata) > 250) {

##################################################
//    echo '<script src="./../../js/jquery.min.js"></script>
//';
    echo '<style type="text/css">
        u {
    text-decoration: underline;
        text-align:center;
        font-size: 9px;
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

    @media print{
        .noprint{
            display:none;
        }
    }
</style> ';
    echo '
<button class="noprint btn btn-info" onclick="window.print();" id="print" >Print</button>
';
    echo $table;
    echo "
      <script type='text/javascript'>
      
    $(document).on('click','#print', function() {
 var divContents = $('#printTpMy').html();//div which have to print
                var printWindow = window.open('', '', 'height=700,width=900');
                printWindow.document.write('<html><head><style>' +
                 'table{   border-collapse:collapse;}' +
                 'tr td{page-break-inside: avoid; white-space: nowrap;}' +
                  'table.print-friendly tr td, table.print-friendly tr th {page-break-inside: avoid;}</style><title></title>');
                printWindow.document.write('</head><body onload=\"window.print()\">');
                printWindow.document.write(divContents);
                printWindow.document.write('</body></html>');
                printWindow.document.close();

                printWindow.onload=function(){
//                printWindow.focus();
                printWindow.print();
//                printWindow.close();
                }
        });
    </script>
";
}else {
###########################
    $htmlcontent = <<<EOF
<!-- CSS STYLE -->
<style type="text/css">
        u {
    text-decoration: underline;
        text-align:center;
        font-size: 9px;
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

        <body>

$table
     
EOF;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// set LTR direction for english translation
    $pdf->setRTL(false);


    ob_end_clean();

    $pdf->Output('order_supplier_print.pdf', 'I');
}