<?php

include 'tcpdf/tcpdf.php';
header('Content-Type: text/html; charset=UTF-8');
//echo $_REQUEST['html'];die;


$html = "<img width='10' height='10' src='http://www.eds.poliedrosoftware.com/assets/itsolution24/img/logo-favicons/logo_50x50.jpg'>";
$html .= str_replace("ñ", "n", "<section class='receipt-template'>".base64_decode($_REQUEST['html'])."</section>");
//echo $html;die;
pdf($html);

function pdf($html = null, $marginleft = null, $margintop = null, $marginright = null) {
//$html= utf8_decode($html);
//    $html="OOOJHKJHKJH JLH KJH KH KJH";
//    ob_clean();
// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//    $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
//    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margin
//PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT

//    if ($marginleft != null && $margintop != null && $marginright != null)
        $pdf->SetMargins(0, 10, 135);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetFooterMargin(150);

// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------
// set default font subsetting mode
    $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

// set text shadow effect
    $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
// Print text using writeHTMLCell()
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 0, 0, true, '', true);
// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    $pdf->Output('edscoomulpinort.pdf', 'D');
    // $pdf->Output();
//============================================================+
// END OF FILE
//============================================================+
}
?>