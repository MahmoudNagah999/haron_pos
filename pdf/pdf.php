<?php
error_reporting(0);

require '../Arabic.php';
$Arabic = new I18N_Arabic('CharsetD');
$Arabic->setInputCharset('utf-8');
if (isset($_GET['charset'])) {
    $Arabic->setOutputCharset($_GET['charset']);
}
$charset = $Arabic->getOutputCharset();
/*
// include autoloader
require_once 'dompdf/autoload.inc.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;
// instantiate and use the dompdf class
$dompdf = new Dompdf();
$url="http://localhost/aaa/course_details_print.php?id=18";
##################################
require_once 'SimpleHtmlDom/simple_html_dom.php';
$website = file_get_html($url);
// You might need to tweak the selector based on the website you are scanning
// Example: some websites don't set the rel attribute
// others might use less instead of css
//
// Some other options:
// link[href] - Any link with a href attribute (might get favicons and other resources but should catch all the css files)
// link[href="*.css*"] - Might miss files that aren't .css extension but return valid css (e.g.: .less, .php, etc)
// link[type="text/css"] - Might miss stylesheets without this attribute set
foreach ($website->find('link[rel="stylesheet"]') as $stylesheet)
{
$stylesheet_url= "http://localhost/aaa/".$stylesheet->href;
$stylesheets_url.= file_get_html($stylesheet_url);
}
###################################
//$url=file_get_contents($url);
//$url_con.="<style>";
//$url_con.=$stylesheets_url;
//$url_con.="</style>";
//$url_con.=' '.$website;
$url_con="<h1>ãÑÍÈÇð Hello</h1>";
//echo $url_con;
//$text = $Arabic->convert($url_con);
$text=mb_convert_encoding($url_con, 'HTML-ENTITIES', 'UTF-8');
$dompdf->loadHtml($text);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();
// Output the generated PDF to Browser
$dompdf->stream();
 * */
//============================================================+
// File name   : example_018.php
// Begin       : 2008-03-06
// Last Update : 2013-05-14
//
// Description : Example 018 for TCPDF class
//               RTL document with Persian language
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: RTL document with Persian language
 * @author Nicola Asuni
 * @since 2008-03-06
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 018', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

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

// add a page
$pdf->AddPage();

// Persian and English content
$htmlpersian = '';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

$pdf->SetFontSize(10);

// print newline
$pdf->Ln();

// Persian and English content
$htmlpersiantranslation = '';
$pdf->WriteHTML($htmlpersiantranslation, true, 0, true, 0);

// Restore RTL direction
$pdf->setRTL(true);

// set font
$pdf->SetFont('aefurat', '', 18);

// print newline
$pdf->Ln();

// Arabic and English content
$pdf->Cell(0, 12, '',0,1,'C');
$htmlcontent = 'ãÑÍÈÇð';
$pdf->WriteHTML($htmlcontent, true, 0, true, 0);

// set LTR direction for english translation
$pdf->setRTL(false);

// print newline
$pdf->Ln();

$pdf->SetFont('aealarabiya', '', 18);

// Arabic and English content
$htmlcontent2 = $Arabic->convert("ãÑÍÈÇð");
$pdf->WriteHTML($htmlcontent2, true, 0, true, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_018.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+