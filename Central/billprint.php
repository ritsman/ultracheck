<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
//include '../Central/class_barcode.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
    //echo 'PRINT NEW BILL:-';
$outlet='CENTRAL';
$billno=$_POST['holder14'];
$billtype=isset($_POST['holder24'])?$_POST['holder24']:"ORIGINAL FOR CUSTOMER";
//echo $billno.":---:".$billtype;
$shop_mobile="";
$shop_email="";
//echo $outlet;
switch($outlet){
    case 'PALSANA': case 'palsana':
        $shop_mobile='+919825248574';
        $shop_email='mk2@ultralifestyle.in';
        $outlet_add="PALSANA -SURAT-394315";
        break;
    case 'VATVA': case 'vatva':
        $shop_mobile='+919023727575';
        $shop_email='ultralifestyleoutlet@gmail.com';
        $outlet_add="VATVA-AHMEDABAD-382445";
        break;

    case 'HMT': case 'hmt':
        $shop_mobile='+917575805155';
        $shop_email='ultralifestyleoutlethmt@gmail.com';
        $outlet_add="MOTIPURA-HIMMATNAGAR-383001";
        break;
    case 'KAMREJ': case 'kamrej':
        $shop_mobile='+917069832023';
        $shop_email='ultralifestyleoutletkam@gmail.com';
        $outlet_add="Survey No 103B At Navagam,";
        $outlet_add.="Kamrej Cross Road,Surat-394185";
        break;
    default:
        $shop_mobile='+919426890832';
        $shop_email='mk2@ultralifestyle.in';
        $outlet_add = "PALSANA -SURAT-394315";
        break;
}








$q="select * from T__salesmain__$outlet where billno='$billno'";
$stm=$DBH->prepare($q);
try {
    //code...
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $dataMain=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

//var_export($dataMain);
//echo '<hr>';

$q="select * from T__salesdata__$outlet where billno='$billno'";
$stm=$DBH->prepare($q);
try {
    //code...
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

//var_export($data);
//echo '<hr>';
// get hsn

function get_hsn($DBH,$cat){
    $hsn=0;
    $q="select hsn from `Q__hsn` where cat='".addslashes($cat)."'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $hsn2=$stm->fetch(PDO::FETCH_ASSOC);
        $hsn=$hsn2['hsn'];
    } catch (PDOException $th) {
        //throw $th;
        $hsn="NA";
        echo $th->getMessage();
    }
    return $hsn;
}
$line="";
$count=1;
foreach($data as $d){
    $cat2=new Barcode($d['barcode']);
    $cat=$cat2->get_cat();
    $hsn=get_hsn($DBH,$cat);
    $line.="<tr><td class='sntd'>$count</td><td>$cat<br>$d[artno]<br>$d[barcode]<br>HSN:$hsn</td><td>1</td>";
    $line.="<td>$d[mrp]</td><td>$d[disrate]%</td><td>$d[saleprice]</td>";
    //$line.="<td>$d[tax]</td><td>$d[total]</td></tr>";
    $line.="<td>$d[total]</td></tr>";
    $count++;
}

?>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css">
    
    <script src="../methods/fun.js"></script>
    <script src="../methods/base-fun.js"></script>
    
    <script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.structure.css">
<div id="pageHolder">
<style>
    @media print ,screen{

    
    @page{
        width:77mm;
        height:3274mm;
    }
    body{
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        
    }
    div#pageHolder{
        max-width:77mm;
        font-size: 0.3cm;
        overflow: hidden;
    }
    div#header{
        text-align: center;
        font-size: 3mm;
        font-weight: bold;
        
    }
    div#billdetails table tr td,div#billheader table tr td{
        font-size: 2.2mm;
        font-weight: bold;

    }
    div#billdetails table tr#tott td{
        border-top:1px solid black;
        border-bottom:1px solid black;
        text-align:left;
    }
    .sntd{
        max-width: 4mm
    }
    p.tt{
        margin: 0;;
        font-size: 2mm;
        font-weight: bold;
        margin-bottom:5px;
    }
    p.tt2{
        margin: 0;;
        font-size: 2.5mm;
        font-weight: bolder;
        margin-bottom:5px;
    }
    p.tt3{
        margin: 0;;
        font-size: 2.5mm;
        font-weight: bolder;
    }
    table#billtab{
        border:1px solid black;
    }
    }
</style>
<script>
    var line=<?php print json_encode($line);?>||0;
    var billdate=<?php print json_encode($dataMain['billdate']);?>;
    //console.log(billdate);
    var billdate2=billdate.split("-").reverse().join("/");
    //console.log(billdate2,billdate);
    //console.log(line);
    $(document).ready(function(){
        //alert("S");
        $("tr#first").after(line);
        $("td#bill_dt").html(billdate2);
    });
    
</script>

    <div id="header">
    <img src="../img88/ultralogo.jpeg" alt="companylogo" style="width:2.5cm;height:2.5cm;margin:0">
        
        
        <p>ULTRADENIM LIFESTYLE PVT LTD</p>
        <p><?php print $outlet_add;?></p>
        <p>MOBILE:<?php print $shop_mobile;?><br> EMAIL:<?php print $shop_email;?></p>
        <p>GST:24AACCV6051F2ZJ</p>
        ***************************************
        <h4><?php print $billtype;?></h4>
        ***************************************
        <h3>TAX INVOICE</h3>
    </div>
    <hr/>
    <div id="billheader">
        <table>
            <tr>
                <td>BILL NO:</td>
                <td id="billno"><?php print $dataMain['billno'];?></td>
                <td>DATE:</td>
                <td id="bill_dt"></td>
            </tr>
            <tr>
                <td>NAME:</td>
                <td id="cust_name"><?php print strtoupper($dataMain['customer']);?></td>
                <td>MOBILE:</td>
                <td id="cust_mobile"><?php print $dataMain['contact'];?></td>
            </tr>
            <tr>
                <td>ADDRESS:</td>
                <td id="cust_add" colspan="4"><?php print $dataMain['address'];?></td>
                
            </tr>
            <tr>
            <td>GSTIN:</td>
            <td id="cust_gst">
            <?php print $dataMain['gst'];?>
            </td>
            </tr>
        </table>
        <hr>
        <div id="billdetails">
            <table>
                <tr id="first">
                    <td class="sntd">Sr</td>
                    <td>DESCRIPTION</td>
                    <td>QTY</td>
                    <td>MRP</td>
                    <td>DISC</td>
                    <td>PRICE</td>
                   
                    <td>TOTAL</td>
                </tr>
                
                <tr id="tott">
                    <td></td>
                    <td>TOTAL</td>
                    <td><?php print $dataMain['pcs'];?></td>
                    <td></td><td></td>
                    <td><?php print $dataMain['subtotal'];?></td>
                    <td><?php print $dataMain['grndttl'];?></td>
                    
                   
                </tr>
            </table>
            **********************************
            <table id="billtab">
                <tr>
                    <td colspan="3">Taxable Amt</td>
                    <td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td>
                    <td></td><td></td><td></td><td></td>
                    <td></td><td></td><td><td></td><td></td>
                        <td><?php print $dataMain['subtotal'];?></td>
                </tr>
                <tr>
                    <td colspan="20">SGST</td>
                    <td><?php print $dataMain['sgst'];?></td>
                </tr>
                <tr>
                    <td colspan="20">CGST</td>
                    <td><?php print $dataMain['cgst'];?></td>
                </tr>
                <tr>
                    <td colspan="20">IGST</td>
                    <td><?php print $dataMain['igst'];?></td>
                </tr>
                <tr>
                    <td colspan="20">Total Tax</td>
                    <td><?php print $dataMain['taxtotal'];?></td>
                </tr>
                <tr>
                    <td colspan="20">ROUND OFF</td>
                    <td><?php print $dataMain['roundof'];?></td>
                </tr>
                <tr>
                    <td colspan="20">
                        GRAND TOTAL
                    </td>
                    <td><?php print $dataMain['grandtotal'];?></td>
                </tr>
            </table>
            <p class="tt">PRICES INCLUSIVE OF ALL TAXES</p>
            <p class="tt">TOTAL NO OF ITEMS <?php print $dataMain['pcs'];?></p>
            <p class="tt">NET BILL AMOUNT <?php print $dataMain['grandtotal'];?></p>
            <p class="tt2">TOTAL SAVING ON THIS PURCHASE:<?php print $dataMain['discount'];?></p>

            <p class="tt3">PAYMENT TYPE: <?php print $dataMain['paytype'];?></p>
            <p class="tt3">REMARKS: <?php print $dataMain['splrmks'];?></p>
            
            <p class="tt3">------------------------------------------------------------------</p>

            <p class="tt">THANK YOU FOR SHOPPING</p>
            <p class="tt">HAVE A NICE DAY :)</p>
            <p class="tt">Terms and Conditions:</p>
            <p class="tt">1):In any case, No Return and No Refund </p>
            <p class="tt">2):Fix Rate & No Guarantee</p>

            <p class="tt">3):Exchange will be acceptable within 3 Days of Billing only</p>
            <p class="tt">4):Decision of the company shall be final & binding.</p>
            <p class="tt">5):Subject to Surat Jurisdiction only.</p>
            <p class="tt">This is a computer-generated invoice, hence<br>
                no signature required.
            </p>

        </div>
    </div>
    

    
    
</div>
<br><br>
<button type="button" name="printBill" id="printBill" class="btn btn-info" onclick="myfun()">PRINT</button>

<script>
    
    function myfun(){
        var newbill2=window.open("","newbill","width=500,height=700,status=1,titlebar=1,menubar=1");
        var wt=document.getElementById("pageHolder").innerHTML;
        newbill2.document.write(wt);
        newbill2.print();
        newbill2.close();
        
    }
</script>
