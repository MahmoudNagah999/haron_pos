<?php
include dirname(__FILE__)."/../../includes/inc.php";
require_once('tcpdf_include.php');
$ids=Trim(stripslashes($_GET['ids']));
$now=date('Y-m-d');

$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$notes=stripslashes($_GET['notes']);
$inv=stripslashes($_GET['inv']);
$store_from_id=stripslashes($_GET['store_from_id']);
$store_to_id=stripslashes($_GET['store_to_id']);

$alldata=get_stores_change_inv_data_by_id($ids,$from , $to,$notes,$store_from_id,$store_to_id);

if(count($alldata) == 0 or (count($alldata)>0 and $alldata[0][id]== null)){die();}
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
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetPrintFooter(true);
$pdf->SetPrintHeader(true);
//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('etolv.com');
//$pdf->SetTitle('sdkjahdkj');

$pdf->SetSubject('Order Supply');
$pdf->SetKeywords('etolv.com');
// set default header data
$pdf->SetHeaderData('', '100', 'التاريخ : ' . $now, '');

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', 'I', 6));
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
//    $pdf->SetAutoPageBreak(FALSE);
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
//$pdf->SetMargins(0, 0, 0, true);

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

if (count($alldata) > 250){
    $table.='<div id="printTpMy"> ';
}
$table .= '       <table  cellspacing="0" cellpadding="0" align="center"  dir="rtl"  id="tableee" width="100%" class="table" border="1" style=" border: 1px solid black;">      
';
$table .= '<tr nobr="true" class="gray"  style="text-align:center;">
<td width="5%"><u>الكود</u></td>
<td width="25%"><u>الاصناف</u></td>
<td width="8%"><u>التاريخ</u></td>
<td  width="15%"><u>ملاحظات</u></td>
<td  width="10%"><u>من مخزن</u></td>
<td  width="10%"><u>الى مخزن</u></td>
</tr>';
foreach ($alldata as $data) {

    $sub_sql = "SELECT ".$prefix."_stores_change.Quantity , items.item FROM ".$prefix."_stores_change Join items on items.id =".$prefix."_stores_change.item  where ".$prefix."_stores_change.inv_id=".$data['inv_id']." order by items.item $type ";
    $sub_result = @mysqli_query($con,$sub_sql);

    $products = '' ;


    if(mysqli_num_rows($sub_result)>0){
        while($sub_row = @mysqli_fetch_array($sub_result)){
            $products.= "(".$sub_row['Quantity'].") - ".$sub_row['item'] ." <br/> ";
        }
    }
    $table .= '<tr nobr="true">
                  <td>' . $data[id] . '</td>
                  <td>' . $products . '</td>
                  <td>' . substr($data['date'], 0, 10) . '</td>
                  <td>' . $data[notes] . '</td>                 
                  <td>' . get_store_data($data['store_from_id'])[name] . "" . '</td>                 
                  <td>' . get_store_data($data['store_to_id'])[name] . "" . '</td>                 
                </tr>';
}
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
                printWindow.document.write('<html><head><title></title>');
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
        td,th { page-break-inside: avoid; }

    </style>
  
        <body>
$table
     
EOF;
//    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
    $pdf->writeHTML($htmlcontent, true, false, false, false, '');
// set LTR direction for english translation
    $pdf->setRTL(false);


    ob_end_clean();

    $pdf->Output('order_supplier_print.pdf', 'I');
}