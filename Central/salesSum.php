<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2 = new dbconnect();
$DBH = $DBH2->con('ultra');
$EBH2 = new dbconnect();
$EBH = $DBH2->con('ultrainv');
//================================================
$date = date('Y-m-d');
$pre_date = date('Y-m-d', strtotime("-1days"));
//echo $pre_date;
//echo $date;
$clearance= $_SESSION['al'];
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

    table#data-table {
        text-align: right;
    }
</style>

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
    var clearance=<?php print $clearance;?>;
    console.log(clearance);
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

    var res_ttl = [];
    res_ttl['PCS'] = [];
    var pcs = 0;
    var pcs_rt = 0;
    var cash = upi = card = cdt = multi = gndttl = gndttl_rt = 0;

    $(document).ready(function() {
        $("#data-table tbody tr:not(:eq(-1))").each(function() {
            var cls = $(this).attr("class");
            $(this).find("td.totalpcs").text(total_pcs[cls]);
            $(this).find("td.totalpcsrt").text(total_rt_pcs[cls]);
            var net_pcs = total_pcs[cls] - total_rt_pcs[cls];
            $(this).find("td.netpcs").text(net_pcs);
            if(clearance==5){
                $(this).find("td.cashsale").text(total_rs[cls]);
                $(this).find("td.upisale").text(total_rs_upi[cls]);
                $(this).find("td.cardsale").text(total_rs_card[cls]);
                $(this).find("td.cdtsale").text(total_rs_cdt[cls]);
                $(this).find("td.multiplesale").text(total_rs_multi[cls]);
                $(this).find("td.gndttl").text(total_rs_gndttl[cls]);
                $(this).find("td.gndttlrt").text(total_rs_gndttl_rt[cls]);
                var net_ttl = total_rs_gndttl[cls] - total_rs_gndttl_rt[cls];
                $(this).find("td.nettl").text(net_ttl);
            }
           

            pcs = pcs + parseInt(total_pcs[cls]);
            console.log(pcs, total_pcs[cls]);
            pcs_rt = pcs_rt + parseInt(total_rt_pcs[cls]);

            cash = cash + parseInt(total_rs[cls]);
            upi = upi + parseInt(total_rs_upi[cls]);
            card = card + parseInt(total_rs_card[cls]);
            cdt = cdt + parseInt(total_rs_cdt[cls]);
            multi = multi + parseInt(total_rs_multi[cls]);
            gndttl = gndttl + parseInt(total_rs_gndttl[cls]);
            gndttl_rt = gndttl_rt + parseInt(total_rs_gndttl_rt[cls]);

        });

        //update the total
        $("td#totalpcs").text(pcs);
        $("td#totalpcsrt").text(pcs_rt);
        var net_pcs2 = pcs - pcs_rt;
        $("td#netpcs").text(net_pcs2);
        if(clearance==5){
            $("td#cashsale").text(cash);
            $("td#upisale").text(upi);
            $("td#cardsale").text(card);
            $("td#cdtsale").text(cdt);
            $("td#multiplesale").text(multi);
            $("td#gndttl").text(gndttl);
            $("td#gndttlrt").text(gndttl_rt);
            var net_ttl2 = gndttl - gndttl_rt;
            $("td#nettl").text(net_ttl2);
        }
        


        $("tr.UDLS").css("font-weight", "700")
            .css("font-size", "110%")
            .css("color", "#0000ff");

    });
    console.log("PPPPPPPPPPPP");
    console.log(pcs);
</script>

<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <th><label for="fromdt">FROM DATE</label></th>
                <th><input type="text" id="frmdt" class="form-control"></th>
                <th><label for="todt">TO DATE</label></th>
                <th><input type="text" id="todt" class="form-control"></th>
                <th>
                    <button class="btn btn-info" id="getDetails">ONSCREEN</button>
                
                    <button class="btn btn-info" id="getpdf" style="margin-left:10px">PDF
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-pdf" viewBox="0 0 16 16">
                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z" />
                            <path d="M4.603 12.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.701 19.701 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.187-.012.395-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.065.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.716 5.716 0 0 1-.911-.95 11.642 11.642 0 0 0-1.997.406 11.311 11.311 0 0 1-1.021 1.51c-.29.35-.608.655-.926.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.27.27 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.647 12.647 0 0 1 1.01-.193 11.666 11.666 0 0 1-.51-.858 20.741 20.741 0 0 1-.5 1.05zm2.446.45c.15.162.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.881 3.881 0 0 0-.612-.053zM8.078 5.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                        </svg>
                    </button>
                </th>


            </thead>

        </table>


    </div>
</div>
<form id="POForm" class="noshow" action="pdfSalesSum.php" target="_blank" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        
</form>
<div id="showdata">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <h3>Date From:<span id="frm22dt"></span>
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

</div>

<script>

    //onscreen data
    $("#getDetails").click(function() {
        //alert("l");
        var frmdt = $("#frmdt").val();
        var todt = $("#todt").val();
        console.log(frmdt, todt);
        if (frmdt == '' || todt == '') {
            console.log("here");
            return false;
        }
        dt1 = frmdt.split("/").reverse().join("-");
        dt2 = todt.split("/").reverse().join("-");
        diff = dt2 >= dt1;
        if (diff == false) {
            msg = "<p class='errMsg'>Check Date Value</p>";
            if ($("#frmdt").parent().find('p').hasClass('errMsg')) {
                return false;
            } else {
                $("#frmdt").parent().append(msg);
            }

        } else {
            $("#showdata").load("P_salesSum.php", {
                fmdt: dt1,
                tdt: dt2
            });
            $("#frmdt").parent().find("p.errMsg").remove();
            console.log(dt1, dt2)
        }

    });

    //onpdf data
    $("#getpdf").click(function() {
        if(clearance!=5){
            alert("CONTACT ADMIN!!");
            return false;
        }
        //alert("l");
        var frmdt = $("#frmdt").val();
        var todt = $("#todt").val();
        console.log(frmdt, todt);
        if (frmdt == '' || todt == '') {
            console.log("here");
            return false;
        }
        dt1 = frmdt.split("/").reverse().join("-");
        dt2 = todt.split("/").reverse().join("-");
        diff = dt2 >= dt1;
        if (diff == false) {
            msg = "<p class='errMsg'>Check Date Value</p>";
            if ($("#frmdt").parent().find('p').hasClass('errMsg')) {
                return false;
            } else {
                $("#frmdt").parent().append(msg);
            }

        } else {
            $("#holder1").val(dt1);
            $("#holder2").val(dt2);
            $("#POForm").submit();
             
            $("#frmdt").parent().find("p.errMsg").remove();
            console.log(dt1, dt2)
        }

    });
</script>