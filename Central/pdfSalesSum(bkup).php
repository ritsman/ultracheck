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

$date = $_POST['holder2'];
$pre_date = $_POST['holder1'];
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


?>
<style>
    input#dtd {
        width: 90%;
    }
    table#data-table{
        text-align: right;
    }
</style>
<script src="../methods/gopf.js"></script>
    <script src="../methods/fun.js"></script>
    <script src="../methods/base-fun.js"></script>
<script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript">
    var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='salesSum' onclick='track(this)'>Summary</a></li>";
    auxul += "<li><a href=\"#\" id='qaccess' onclick='track(this)'>Card</a></li>";

    auxul += "</ul>";
    $(document).ready(function() {
        $("#auxnav").html(auxul);
    });
    var dt2 = <?php print json_encode($date); ?>;
    var dt = dt2.split("-").reverse().join("/");
    var dt21 = <?php print json_encode($pre_date); ?>;
    var dt1 = dt21.split("-").reverse().join("/");
    $(document).ready(function() {
        $("#frmdt").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $("#todt").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        var tdy = tdt();
        console.log(tdy);
       
            $(this).find("span#to22dt").text(dt);
            $(this).find("span#frm22dt").text(dt1);
       

    });

    var total_pcs = <?php print json_encode($total_pcs); ?>;
    var total_rt_pcs = <?php print json_encode($total_rt_pcs); ?>;
    var total_rs = <?php print json_encode($total_rs); ?>;
    var total_rs_upi = <?php print json_encode($total_rs_upi); ?>;
    var total_rs_card = <?php print json_encode($total_rs_card); ?>;
    var total_rs_cdt = <?php print json_encode($total_rs_cdt); ?>;
    var total_rs_multi = <?php print json_encode($total_rs_multi); ?>;
    var total_rs_gndttl = <?php print json_encode($total_rs_gndttl); ?>;
    var total_rs_gndttl_rt = <?php print json_encode($total_rs_gndttl_rt); ?>;
    console.log(total_pcs);

    var res_ttl=[];
    res_ttl['PCS']=[];
    var pcs=0;
    var pcs_rt=0;
    var cash=upi=card=cdt=multi=gndttl=gndttl_rt=0;

    $(document).ready(function() {
        $("#data-table tbody tr:not(:eq(-1))").each(function() {
            var cls = $(this).attr("class");
            $(this).find("td.totalpcs").text(total_pcs[cls]);
            $(this).find("td.totalpcsrt").text(total_rt_pcs[cls]);
            var net_pcs = total_pcs[cls] - total_rt_pcs[cls];
            $(this).find("td.netpcs").text(net_pcs);
            $(this).find("td.cashsale").text(total_rs[cls]);
            $(this).find("td.upisale").text(total_rs_upi[cls]);
            $(this).find("td.cardsale").text(total_rs_card[cls]);
            $(this).find("td.cdtsale").text(total_rs_cdt[cls]);
            $(this).find("td.multiplesale").text(total_rs_multi[cls]);
            $(this).find("td.gndttl").text(total_rs_gndttl[cls]);
            $(this).find("td.gndttlrt").text(total_rs_gndttl_rt[cls]);
            var net_ttl = total_rs_gndttl[cls] - total_rs_gndttl_rt[cls];
            $(this).find("td.nettl").text(net_ttl);
            
            pcs=pcs+parseInt(total_pcs[cls]);
            console.log(pcs,total_pcs[cls]);
            pcs_rt=pcs_rt+parseInt(total_rt_pcs[cls]);

            cash=cash+parseInt(total_rs[cls]);
            upi=upi+parseInt(total_rs_upi[cls]);
            card=card+parseInt(total_rs_card[cls]);
            cdt=cdt+parseInt(total_rs_cdt[cls]);
            multi=multi+parseInt(total_rs_multi[cls]);
            gndttl=gndttl+parseInt(total_rs_gndttl[cls]);
            gndttl_rt=gndttl_rt+parseInt(total_rs_gndttl_rt[cls]);
            
        });

        //update the total
        $("td#totalpcs").text(pcs);
        $("td#totalpcsrt").text(pcs_rt);
        var net_pcs2=pcs-pcs_rt;
        $("td#netpcs").text(net_pcs2);
        $("td#cashsale").text(cash);
        $("td#upisale").text(upi);
        $("td#cardsale").text(card);
        $("td#cdtsale").text(cdt);
        $("td#multiplesale").text(multi);
        $("td#gndttl").text(gndttl);
        $("td#gndttlrt").text(gndttl_rt);
        var net_ttl2 = gndttl - gndttl_rt;
        $("td#nettl").text(net_ttl2);


        $("tr.UDLS").css("font-weight","700")
                    .css("font-size","110%")
                    .css("color","#0000ff");

    });
    console.log("PPPPPPPPPPPP");
    console.log(pcs);
</script>



    <div class="container-fluid">
        <div class="row justify-content-center">
            <h3 >Date From:<span id="frm22dt"></span> 
            --Date To:<span id="to22dt"></span></h3>
            <table class="table table-striped" id="data-table">
                <thead class="thead-dark">
                    <tr>
                        <th>OUTLET</th>
                        
                        <th>PCS</th>
                        <th>RETURN PCS</th>
                        <th>TOTAL PCS</th>
                        <th>CASH SALES</th>
                        <th>UPI SALES</th>
                        <th>CARD SALES</th>
                        <th>AGAINST EXCHANGE</th>
                        <th>MULTIPLE SALES</th>
                        <th>GROSS TOTAL</th>
                        <th>RETURN SALES</th>
                        <th>NET SALES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="PALSANA">
                        <td>PALSANA</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="VATVA">
                        <td>VATVA</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="HMT">
                        <td>HIMMATNAGAR</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="VISHNAGAR">
                        <td>VISHNAGAR</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="GITAMANDIR">
                        <td>GITAMANDIR</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="VATVAGIDC">
                        <td>VATVAGIDC</td>
                       
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="KAMREJ">
                        <td>KAMREJ</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale">
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>
                    <tr class="JAHGIRPURA">
                        <td>JAHGIRPURA</td>
                        
                        <td class="totalpcs"></td>
                        <td class="totalpcsrt"></td>
                        <td class="netpcs"></td>
                        <td class="cashsale"></td>
                        <td class="upisale"></td>
                        <td class="cardsale"></td>
                        <td class="cdtsale"></td>
                        <td class="multiplesale"></td>
                        <td class="gndttl"></td>
                        <td class="gndttlrt"></td>
                        <td class="nettl"></td>
                    </tr>

                    <tr class="UDLS">
                        <td>RETAIL</td>
                        
                        <td id="totalpcs"></td>
                        <td id="totalpcsrt"></td>
                        <td id="netpcs"></td>
                        <td id="cashsale"></td>
                        <td id="upisale"></td>
                        <td id="cardsale"></td>
                        <td id="cdtsale"></td>
                        <td id="multiplesale"></td>
                        <td id="gndttl"></td>
                        <td id="gndttlrt"></td>
                        <td id="nettl"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>


<?php
return false;
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
?>