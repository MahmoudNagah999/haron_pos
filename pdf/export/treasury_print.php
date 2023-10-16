<?php
include dirname(__FILE__)."/../../includes/inc.php";
require_once('tcpdf_include.php');
$ids=Trim(stripslashes($_GET['ids']));
$safe_id=Trim(stripslashes($_GET['safe_id']));
$now=date('Y-m-d');

$alldata=get_treasury_data($ids,$safe_id);
//var_dump($alldata);
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
$labelwidth="200";
$labelheight="160";
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
$pdf->SetSubject('Treasury Print');
$pdf->SetKeywords('etolv.com');
// set default header data
$pdf->SetHeaderData('', '70', 'التاريخ : ' . $now, '');

// set header and footer fonts
$pdf->setHeaderFont(Array('aealarabiya', 'I', 6));
// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(30, 10, 5);
$now=date('Y-m-d');

$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
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

    $table=' ';
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
// print newline
//$pdf->Ln();
// Arabic and English content
    $pdf->Cell(0, 12, '', 0, 1, 'C');



    $table .= '       <table class="table" border="2" >      
';
    $table .= '<tr><th><u>الكود</u></th>
<th><u>الخزينه</u></th>
<th><u>العمليه</u></th>
<th><u>المبلغ</u></th>
<th><u>التاريح</u></th>
<th><u>تفاصيل</u></th>
</tr>';

foreach ($alldata as $data) {

    if ($data['type'] == 1) {
        $ex_type = "$Withdrawal_lang";
    } else if ($data['type'] == 2) {
        $ex_type = "$Deposit_lang";
    } else if ($data['type'] == 3) {
        $ex_type = "$Purchases_cash_lang";
    } else if ($data['type'] == 4) {
        $ex_type = "$Cash_sales_lang";
    } else if ($data['type'] == 5) {
        $ex_type = "$Expenses_lang";
    } else if ($data['type'] == 6) {
        $ex_type = "$Payment_suppliers_lang";
    } else if ($data['type'] == 7) {
        $ex_type = "$Collection_customers";
    } else if ($data['type'] == 8) {
        $ex_type = "$Sales_returns_lang";
    } else if ($data['type'] == 9) {
        $ex_type = "$Returns_Purchases_lang";
    } else if ($data['type'] == 50) {
        $ex_type = "$commission_lang";
    } else {
    }

    $table .= '<tr style="text-align:center;">
                  <td>' . $data[id] . '</td>
                  <td>' . get_safe_data($data['safe_id'])[name] . '</td>
                  <td>' . $ex_type . '</td>
                  <td>' . $data[Amount] . '</td>
                  <td>' . substr($data['date'], 0, 10) . '</td>
                  <td>' . $data[notes] . '</td>                 
                </tr>';
}
    $table .= '</table>
<div></div>';


###########################
    $htmlcontent = <<<EOF
<!-- CSS STYLE -->
<style type="text/css">
        u {
    text-decoration: underline;
        text-align:center;
        font-size: 10px;
}
.gray{
    	background-color:LightGray;
}
        .table {

			font-size: 12px;
			min-width: 90%;
			border: 1px;
		
        
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
</body>
EOF;
    $pdf->WriteHTML($htmlcontent, true, 0, true, 0);
// set LTR direction for english translation
    $pdf->setRTL(false);

//}
ob_end_clean();

$pdf->Output('order_supplier_print.pdf', 'I');