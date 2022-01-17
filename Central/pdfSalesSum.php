<?php
session_start();
require_once('../tcpdf/tcpdf.php');
include '../inc/dbclass.inc.php';
$DBH2 = new dbconnect();
$DBH = $DBH2->con('ultra');
$EBH2 = new dbconnect();
$EBH = $DBH2->con('ultrainv');
//=================================================================================================

//get data

$date = isset($_POST['holder2'])?$_POST['holder2']:date("Y-m-d");
$pre_date = isset($_POST['holder1'])?$_POST['holder1']:date("Y-m-d");;
// echo $pre_date;
// echo $date;
// return false;
function get_sale_pcs($DBH, $outlet, $frmdt, $todt)
{

    $q = "select sum(pcs) as pc2 from `T__salesmain__$outlet` where billdate between '$frmdt' and '$todt'";
    //echo $q;
    $stm = $DBH->prepare($q);
    try {
        $stm->execute();
        $pcs = $stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        //echo $th->getMessage();
        $pcs['pc2'] = 0;
    }
    // echo $pcs['pc2'];
    return intval($pcs['pc2']);
}
// get return pcs
function get_sale_rt_pcs($DBH, $outlet, $frmdt, $todt)
{

    $q = "select sum(pcs) as pc2 from `T__salesmain_rt__$outlet` where billdate between '$frmdt' and '$todt'";
    //echo $q;
    $stm = $DBH->prepare($q);
    try {
        $stm->execute();
        $pcs = $stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        //echo $th->getMessage();
        $pcs['pc2'] = 0;
    }
    // echo $pcs['pc2'];
    return intval($pcs['pc2']);
}

// get sales
function get_sale_rs($DBH, $outlet, $paytype, $frmdt, $todt)
{
    if ($paytype == 'GT') {
        $q = "select sum(grandtotal) as pc2 from `T__salesmain__$outlet` where billdate between '$frmdt' and '$todt'";
    } else if ($paytype == 'RT') {
        $q = "select sum(grandtotal) as pc2 from `T__salesmain_rt__$outlet` where billdate between '$frmdt' and '$todt'";
    } else {
        $q = "select sum(grandtotal) as pc2 from `T__salesmain__$outlet` where paytype='$paytype' and billdate between '$frmdt' and '$todt'";
    }

    //echo $q;
    $stm = $DBH->prepare($q);
    try {
        $stm->execute();
        $pcs = $stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        //echo $th->getMessage();
        $pcs['pc2'] = 0;
    }
    // echo $pcs['pc2'];
    return intval($pcs['pc2']);
}


$total_pcs['PALSANA'] = get_sale_pcs($EBH, 'PALSANA', $pre_date, $date);
$total_pcs['VATVA'] = get_sale_pcs($EBH, 'VATVA', $pre_date, $date);
$total_pcs['VISHNAGAR'] = get_sale_pcs($EBH, 'VISHNAGAR', $pre_date, $date);
$total_pcs['HMT'] = get_sale_pcs($EBH, 'HMT', $pre_date, $date);
$total_pcs['GITAMANDIR'] = get_sale_pcs($EBH, 'GITAMANDIR', $pre_date, $date);
$total_pcs['VATVAGIDC'] = get_sale_pcs($EBH, 'VATVAGIDC', $pre_date, $date);
$total_pcs['KAMREJ'] = get_sale_pcs($EBH, 'KAMREJ', $pre_date, $date);
$total_pcs['JAHGIRPURA'] = get_sale_pcs($EBH, 'JAHGIRPURA', $pre_date, $date);

$total_rt_pcs['PALSANA'] = get_sale_rt_pcs($EBH, 'PALSANA', $pre_date, $date);
$total_rt_pcs['VATVA'] = get_sale_rt_pcs($EBH, 'VATVA', $pre_date, $date);
$total_rt_pcs['VISHNAGAR'] = get_sale_rt_pcs($EBH, 'VISHNAGAR', $pre_date, $date);
$total_rt_pcs['HMT'] = get_sale_rt_pcs($EBH, 'HMT', $pre_date, $date);
$total_rt_pcs['GITAMANDIR'] = get_sale_rt_pcs($EBH, 'GITAMANDIR', $pre_date, $date);
$total_rt_pcs['VATVAGIDC'] = get_sale_rt_pcs($EBH, 'VATVAGIDC', $pre_date, $date);
$total_rt_pcs['KAMREJ'] = get_sale_rt_pcs($EBH, 'KAMREJ', $pre_date, $date);
$total_rt_pcs['JAHGIRPURA'] = get_sale_rt_pcs($EBH, 'JAHGIRPURA', $pre_date, $date);


$total_rs['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'CASH', $pre_date, $date);
$total_rs['VATVA'] = get_sale_rs($EBH, 'VATVA', 'CASH', $pre_date, $date);
$total_rs['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'CASH', $pre_date, $date);
$total_rs['HMT'] = get_sale_rs($EBH, 'HMT', 'CASH', $pre_date, $date);
$total_rs['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'CASH', $pre_date, $date);
$total_rs['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'CASH', $pre_date, $date);
$total_rs['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'CASH', $pre_date, $date);
$total_rs['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'CASH', $pre_date, $date);

$total_rs_upi['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'UPI', $pre_date, $date);
$total_rs_upi['VATVA'] = get_sale_rs($EBH, 'VATVA', 'UPI', $pre_date, $date);
$total_rs_upi['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'UPI', $pre_date, $date);
$total_rs_upi['HMT'] = get_sale_rs($EBH, 'HMT', 'UPI', $pre_date, $date);
$total_rs_upi['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'UPI', $pre_date, $date);
$total_rs_upi['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'UPI', $pre_date, $date);
$total_rs_upi['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'UPI', $pre_date, $date);
$total_rs_upi['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'UPI', $pre_date, $date); //


$total_rs_card['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'CARD PAY', $pre_date, $date);
$total_rs_card['VATVA'] = get_sale_rs($EBH, 'VATVA', 'CARD PAY', $pre_date, $date);
$total_rs_card['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'CARD PAY', $pre_date, $date);
$total_rs_card['HMT'] = get_sale_rs($EBH, 'HMT', 'CARD PAY', $pre_date, $date);
$total_rs_card['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'CARD PAY', $pre_date, $date);
$total_rs_card['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'CARD PAY', $pre_date, $date);
$total_rs_card['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'CARD PAY', $pre_date, $date);
$total_rs_card['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'CARD PAY', $pre_date, $date);

$total_rs_cdt['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'CREDIT', $pre_date, $date);
$total_rs_cdt['VATVA'] = get_sale_rs($EBH, 'VATVA', 'CREDIT', $pre_date, $date);
$total_rs_cdt['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'CREDIT', $pre_date, $date);
$total_rs_cdt['HMT'] = get_sale_rs($EBH, 'HMT', 'CREDIT', $pre_date, $date);
$total_rs_cdt['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'CREDIT', $pre_date, $date);
$total_rs_cdt['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'CREDIT', $pre_date, $date);
$total_rs_cdt['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'CREDIT', $pre_date, $date);
$total_rs_cdt['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'CREDIT', $pre_date, $date);

$total_rs_multi['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['VATVA'] = get_sale_rs($EBH, 'VATVA', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['HMT'] = get_sale_rs($EBH, 'HMT', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'MULTIPLE', $pre_date, $date);
$total_rs_multi['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'MULTIPLE', $pre_date, $date);

$total_rs_gndttl['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'GT', $pre_date, $date);
$total_rs_gndttl['VATVA'] = get_sale_rs($EBH, 'VATVA', 'GT', $pre_date, $date);
$total_rs_gndttl['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'GT', $pre_date, $date);
$total_rs_gndttl['HMT'] = get_sale_rs($EBH, 'HMT', 'GT', $pre_date, $date);
$total_rs_gndttl['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'GT', $pre_date, $date);
$total_rs_gndttl['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'GT', $pre_date, $date);
$total_rs_gndttl['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'GT', $pre_date, $date);
$total_rs_gndttl['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'GT', $pre_date, $date);

$total_rs_gndttl_rt['PALSANA'] = get_sale_rs($EBH, 'PALSANA', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['VATVA'] = get_sale_rs($EBH, 'VATVA', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['VISHNAGAR'] = get_sale_rs($EBH, 'VISHNAGAR', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['HMT'] = get_sale_rs($EBH, 'HMT', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['GITAMANDIR'] = get_sale_rs($EBH, 'GITAMANDIR', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['VATVAGIDC'] = get_sale_rs($EBH, 'VATVAGIDC', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['KAMREJ'] = get_sale_rs($EBH, 'KAMREJ', 'RT', $pre_date, $date);
$total_rs_gndttl_rt['JAHGIRPURA'] = get_sale_rs($EBH, 'JAHGIRPURA', 'RT', $pre_date, $date);


//++++++=========================================================================================
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(4, 0, 0);




// add a page
$pdf->AddPage();


// set font
$pdf->SetFont('times', 'BU', 10);
// $style3 = array('width' => 1, 'cap' => 'round', 'join' => 'miter', 'dash' => '2,10', 'color' => array(255, 0, 0));
// $style4 = array('L' => 0,
//                 'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
//                 'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
//                 'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));



// $pdf->Text(10, 4, 'Rectangle examples');
// $pdf->Rect(100, 10, 40, 20, 'DF', $style4, array(220, 220, 200));
// $pdf->Rect(145, 10, 40, 20, 'D', array('all' => $style3));
//Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='',
// $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
$pdf->Cell(0, 0, 'ULTRADENIM RETAIL SUMMARY', 0, 1, 'C', 0, '', 0);
$pdf->Cell(0, 26, "FROM $pre_date  TO $date", 0, 1, 'C', 0, '', 0);
//$pdf->Cell(0, 30, 'TEST CELL STRETCH: force spacing', 1, 1, 'C', 0, '', 4);
//$pdf->Ln(1);

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='',
// $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(19, 0, 'OUTLET', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(13, 0, 'PCS',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(15, 0, 'RETURN PCS',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'TOTAL PCS', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'CASH SALES',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'UPI SALES',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'CARD SALES',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, 'EXCHANGE',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, 'MULTIPLE SALES', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'GROSS TOTAL',  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'RETURN SALES', 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, 'NET SALES', 0, 'C', 0, 1, '', '', true);
// ---------------------------------------------------------horizontal lines
$pdf->Line(4, 30, 208, 30);
$pdf->Line(4, 38, 208, 38);
//----------------------------------------------------------vertical lines
$pdf->Line(4, 30, 4, 85);
$pdf->Line(23, 30, 23, 85);
$pdf->Line(36, 30, 36, 85);
$pdf->Line(51, 30, 51, 85);
$pdf->Line(68, 30, 68, 85);
$pdf->Line(85, 30, 85, 85);
$pdf->Line(102, 30, 102, 85);
$pdf->Line(119, 30, 119, 85);
$pdf->Line(138, 30, 138, 85);
$pdf->Line(157, 30, 157, 85);
$pdf->Line(174, 30, 174, 85);
$pdf->Line(191, 30, 191, 85);
$pdf->Line(208, 30, 208, 85);
//---------------------------------------------------
$pdf->Line(4, 80, 208, 80);
$pdf->Line(4, 85, 208, 85);

$TOTALPCS=$total_pcs['PALSANA']+$total_pcs['VATVA']+$total_pcs['VISHNAGAR']+$total_pcs['HMT']+$total_pcs['GITAMANDIR']+$total_pcs['VATVAGIDC']+$total_pcs['KAMREJ']+$total_pcs['JAHGIRPURA'];

$TOTAL_RT_PCS=$total_rt_pcs['PALSANA']+$total_rt_pcs['VATVA']+$total_rt_pcs['VISHNAGAR']+$total_rt_pcs['HMT']+$total_rt_pcs['GITAMANDIR']+$total_rt_pcs['VATVAGIDC']+$total_rt_pcs['KAMREJ']+$total_rt_pcs['JAHGIRPURA'];

$NETPCS=$TOTALPCS-$TOTAL_RT_PCS;
$CASH_SALES=$total_rs['PALSANA']+$total_rs['VATVA']+$total_rs['VISHNAGAR']+$total_rs['HMT']+$total_rs['GITAMANDIR']+$total_rs['VATVAGIDC']+$total_rs['KAMREJ']+$total_rs['JAHGIRPURA'];
$UPI_SALES=$total_rs_upi['PALSANA']+$total_rs_upi['VATVA']+$total_rs_upi['VISHNAGAR']+$total_rs_upi['HMT']+$total_rs_upi['GITAMANDIR']+$total_rs_upi['VATVAGIDC']+$total_rs_upi['KAMREJ']+$total_rs_upi['JAHGIRPURA'];
$CARD_SALES=$total_rs_card['PALSANA']+$total_rs_card['VATVA']+$total_rs_card['VISHNAGAR']+$total_rs_card['HMT']+$total_rs_card['GITAMANDIR']+$total_rs_card['VATVAGIDC']+$total_rs_card['KAMREJ']+$total_rs_card['JAHGIRPURA'];
$CREDIT_SALES=$total_rs_cdt['PALSANA']+$total_rs_cdt['VATVA']+$total_rs_cdt['VISHNAGAR']+$total_rs_cdt['HMT']+$total_rs_cdt['GITAMANDIR']+$total_rs_cdt['VATVAGIDC']+$total_rs_cdt['KAMREJ']+$total_rs_cdt['JAHGIRPURA'];
$MULTI_SALES=$total_rs_multi['PALSANA']+$total_rs_multi['VATVA']+$total_rs_multi['VISHNAGAR']+$total_rs_multi['HMT']+$total_rs_multi['GITAMANDIR']+$total_rs_multi['VATVAGIDC']+$total_rs_multi['KAMREJ']+$total_rs_multi['JAHGIRPURA'];
$GRAND=$total_rs_gndttl['PALSANA']+$total_rs_gndttl['VATVA']+$total_rs_gndttl['VISHNAGAR']+$total_rs_gndttl['HMT']+$total_rs_gndttl['GITAMANDIR']+$total_rs_gndttl['VATVAGIDC']+$total_rs_gndttl['KAMREJ']+$total_rs_gndttl['JAHGIRPURA'];

$GRAND_RT=$total_rs_gndttl_rt['PALSANA']+$total_rs_gndttl_rt['VATVA']+$total_rs_gndttl_rt['VISHNAGAR']+$total_rs_gndttl_rt['HMT']+$total_rs_gndttl_rt['GITAMANDIR']+$total_rs_gndttl_rt['VATVAGIDC']+$total_rs_gndttl_rt['KAMREJ']+$total_rs_gndttl_rt['JAHGIRPURA'];

$NET_GRAND=$GRAND-$GRAND_RT;

$pdf->SetFont('helvetica', '', 7);
$pdf->MultiCell(19, 0, 'PALSANA', 0, 'C', 0, 0, 4, 39, true);
$pdf->MultiCell(13, 0, $total_pcs['PALSANA'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['PALSANA']-$total_rt_pcs['PALSANA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['PALSANA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['PALSANA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['PALSANA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['PALSANA']-$total_rs_gndttl_rt['PALSANA'], 0, 'C', 0, 0, '', '', true);


$pdf->MultiCell(19, 0, 'VATVA', 0, 'C', 0, 0, 4, 45, true);
$pdf->MultiCell(13, 0, $total_pcs['VATVA'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['VATVA']-$total_rt_pcs['VATVA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['VATVA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VATVA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['VATVA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VATVA']-$total_rs_gndttl_rt['VATVA'], 0, 'C', 0, 0, '', '', true);


$pdf->MultiCell(19, 0, 'VISHNAGAR', 0, 'C', 0, 0, 4, 50, true);
$pdf->MultiCell(13, 0, $total_pcs['VISHNAGAR'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['VISHNAGAR']-$total_rt_pcs['VISHNAGAR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['VISHNAGAR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VISHNAGAR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['VISHNAGAR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VISHNAGAR']-$total_rs_gndttl_rt['VISHNAGAR'], 0, 'C', 0, 0, '', '', true);


$pdf->MultiCell(19, 0, 'HMT', 0, 'C', 0, 0, 4, 55, true);
$pdf->MultiCell(13, 0, $total_pcs['HMT'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['HMT']-$total_rt_pcs['HMT'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['HMT'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['HMT'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['HMT'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['HMT']-$total_rs_gndttl_rt['HMT'], 0, 'C', 0, 0, '', '', true);

$pdf->MultiCell(19, 0, 'GITAMANDIR', 0, 'C', 0, 0, 4, 60, true);
$pdf->MultiCell(13, 0, $total_pcs['GITAMANDIR'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['GITAMANDIR']-$total_rt_pcs['GITAMANDIR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['GITAMANDIR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['GITAMANDIR'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['GITAMANDIR'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['GITAMANDIR']-$total_rs_gndttl_rt['GITAMANDIR'], 0, 'C', 0, 0, '', '', true);

$pdf->MultiCell(19, 0, 'VATVAGIDC', 0, 'C', 0, 0, 4, 65, true);
$pdf->MultiCell(13, 0, $total_pcs['VATVAGIDC'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['VATVAGIDC']-$total_rt_pcs['VATVAGIDC'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['VATVAGIDC'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VATVAGIDC'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['VATVAGIDC'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['VATVAGIDC']-$total_rs_gndttl_rt['VATVAGIDC'], 0, 'C', 0, 0, '', '', true);

$pdf->MultiCell(19, 0, 'KAMREJ', 0, 'C', 0, 0, 4, 70, true);
$pdf->MultiCell(13, 0, $total_pcs['KAMREJ'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['KAMREJ']-$total_rt_pcs['KAMREJ'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['KAMREJ'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['KAMREJ'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['KAMREJ'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['KAMREJ']-$total_rs_gndttl_rt['KAMREJ'], 0, 'C', 0, 0, '', '', true);

$pdf->MultiCell(19, 0, 'JAHGIRPURA', 0, 'C', 0, 0, 4, 75, true);
$pdf->MultiCell(13, 0, $total_pcs['JAHGIRPURA'],  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $total_rt_pcs['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_pcs['JAHGIRPURA']-$total_rt_pcs['JAHGIRPURA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_upi['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_card['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_cdt['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $total_rs_multi['JAHGIRPURA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['JAHGIRPURA'],  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl_rt['JAHGIRPURA'], 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $total_rs_gndttl['JAHGIRPURA']-$total_rs_gndttl_rt['JAHGIRPURA'], 0, 'C', 0, 0, '', '', true);


$pdf->SetFont('times', 'B', 10);

$pdf->MultiCell(19, 0, 'RETAIL', 0, 'C', 0, 0, 4, 80, true);
$pdf->MultiCell(13, 0, $TOTALPCS,  0, 'C', 0, 0,'','', true);
$pdf->MultiCell(15, 0, $TOTAL_RT_PCS,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $NETPCS, 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $CASH_SALES,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $UPI_SALES,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $CARD_SALES,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $CREDIT_SALES,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(19, 0, $MULTI_SALES, 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $GRAND,  0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $GRAND_RT, 0, 'C', 0, 0, '', '', true);
$pdf->MultiCell(17, 0, $NET_GRAND, 0, 'C', 0, 0, '', '', true);
//Close and output PDF document
$pdf->Output('SALES-SUMMARY.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>