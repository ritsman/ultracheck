<?php
session_start();
require_once('../tcpdf/tcpdf.php');
include '../inc/dbclass.inc.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con("ultra");
$usr=$_SESSION['usr'];
//=================================================================================================


//$a=array(110,50);
$a=array(50,110);
//echo $_POST['holder'];
$data=json_decode($_POST['holder2'],true);
// print_r($data);
// echo '<hr>';
// return false;

//++++++=========================================================================================
// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new TCPDF("P", "mm", $a, true, 'UTF-8', false);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(0, 0, 0);
// ---------------------------------------------------------
$r='10000220987654';
$r2='0410041500';
$r3='0410041600';
$r4='0410041700';
$r5='0410041800';


// set font
$pdf->SetFont('helvetica', '', 6);

// add a page
$pdf->AddPage();


$pdf->SetFont('helvetica', '', 6);

// define barcode style
$style = array(
    'position' => '',
    'align' => '',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => 'R',
    'border' => false,
    
    'hpadding' => 'auto',
    'vpadding' =>'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' =>false,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);


//$cc=['01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21'];
//print_r($cc2);
$count=count($data);
$i=1;
foreach($data as $d){
    
    $p=explode("/",$d['sz']);
    

        //set the font
        $pdf->SetFontSize(24);
        $pdf->Text(26,10,$p[0],'','',true,'','','','','','','','','');//33,10

        $pdf->RoundedRect(5,20,38,55,'2','1111','D');

        $pdf->SetFont('','B',9,'','false');

        $pdf->Text(15,22,$d['series'],'','',true,'','','','','','','','','');
        $pro="PRODUCT";
        $catagory=$d['cat'];
        
        $pro2="FIT TYPE";
        $fit=$d['fit'];
        $pro3="SIZE";
        $size=$d['sz'];
        
        $inseam=$d['inseam']=='0'?'':$d['inseam'];
        $pro4=$inseam==''?'':"INSEAM";
        $pro5="COLOR";
        $color=$d['color'];
        $pro6="QTY";
        $qty="1N";
        $pro7="PKD";
        $pkd=$d['pkd'];
        $pro8="Art No.";
        $artno=$d['artno'];

        $mrp=$d['mrp'];
        $line="(Inclusive of All Taxes)";

        $pdf->SetFont('','B',6,'','false');
        $pdf->Text(5,30,$pro,'','',true,'','','','','','','','','');
        $pdf->Text(20,30,$catagory,'','',true,'','','','','','','','','');

        $pdf->Text(5,33,$pro2,'','',true,'','','','','','','','','');
        $pdf->Text(20,33,$fit,'','',true,'','','','','','','','','');


        $pdf->Text(5,36,$pro3,'','',true,'','','','','','','','','');
        $pdf->Text(20,36,$size,'','',true,'','','','','','','','','');

        $pdf->Text(5,39,$pro4,'','',true,'','','','','','','','','');
        $pdf->Text(20,39,$inseam,'','',true,'','','','','','','','','');

        $pdf->Text(5,42,$pro5,'','',true,'','','','','','','','','');
        $pdf->Text(20,42,$color,'','',true,'','','','','','','','','');

        $pdf->Text(5,45,$pro6,'','',true,'','','','','','','','','');
        $pdf->Text(20,45,$qty,'','',true,'','','','','','','','','');

        $pdf->Text(5,49,$pro7,'','',true,'','','','','','','','','');
        $pdf->Text(20,49,$pkd,'','',true,'','','','','','','','','');

        $pdf->Text(5,53,$pro8,'','',true,'','','','','','','','','');
        $pdf->Text(20,53,$artno,'','',true,'','','','','','','','','');
        
        $pdf->SetFont('','B',10,'','false');

        $pdf->Text(10,58,'MRP :','','',true,'','','','','','','','','');
        $pdf->Text(20,58,"INR $mrp/-",'','',true,'','','','','','','','','');

        $pdf->SetFont('','',8,'','false');

        $pdf->Text(7,63,$line,'','',true,'','','','','','','','','');
        $pdf->SetFont('','',10,'','false');

        $pdf->write1DBarcode($d['barcode'], 'C128',4, 75, 38, 8, 0.4, $style, 'N');
        $pdf->Text(10,82,$d['barcode'],'','',true,'','','','','','','','','');
       if($i<$count){
        $pdf->AddPage();
       }
        $i++;
     
}
   
  




// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('BARCODE.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
