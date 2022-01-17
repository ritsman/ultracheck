<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['data'];
$search_data=json_decode($_POST['search_data'],true);
unset($search_data['goahead']);

//var_export($search_data);
//echo '<hr>';

//return false;
$location=$_POST['data'];
//var_export($dataM);
//echo '<hr>';
$contact=$search_data[3]['contact'];
$billtype=$search_data[3]['billtype'];
$billno=$search_data[3]['sono2'];
$billamt=$search_data[5]['billamt'];
//echo "BIltype:".$billtype;
$qmain=$contact=='0'?"":" and contact='$contact' ";
$qmain.=$billtype=='0'?"":" and paytype='$billtype' ";
$qmain.=$billno=='0'?"":" and billno ='$billno' ";
$qmain.=$billamt=='0'?"":" and billamt ='$billamt' ";

//echo "qmai:".$qmain;


$q="select * from `T__salesmain__$location` where 1='1'  ";
$q.=$qmain;
//echo $q;
// query for sales return

$qrt="select * from `T__salesmain_rt__$location` where 1='1'  ";
$qrt.=$qmain;
//echo "<br>$qrt<br>";

// generate the salesdata q;uery
$artno=$search_data[3]['artno'];
$cat=addslashes($search_data[3]['cat']);
$sz=$search_data[3]['sz'];
$shade=$search_data[5]['shade'];
$pkd=$search_data[5]['pkd'];
$series=addslashes($search_data[5]['series']);

$qaux=$artno=='0'?"":" and artno='$artno' ";
$qaux.=$cat=='0'?"":" and cat='$cat' ";
$qaux.=$sz=='0'?"":" and sz ='$sz' ";
$qaux.=$shade=='0'?"":" and shade ='$shade' ";
$qaux.=$pkd=='0'?"":" and pkd='$pkd' ";
$qaux.=$series=='0'?"":" and series='$series' ";

$frmdt=$search_data[5]['sefrminw_dt'];
$todt=$search_data[5]['setoinw_dt'];
if($frmdt!='0'&&$todt!='0'){
    $qdt=" and (billdate between '$frmdt' and '$todt')";
}else{
    $qdt="";
}


$q2="select * from `T__salesdata__$location` where 1='1'  ";
$q2.=$qaux;
//echo $q2;
if($qmain!=""&&$qaux==""){
    call_from_main($q,$qdt,$DBH,$qrt);
}else if($qmain==""&&$qaux!=""){
    call_from_data($q2,$qdt,$DBH);
}else if($qmain!=""&&$qaux!=""){
    call_from_main_data($DBH,$q,$q2,$qdt);
}else if($qmain==""&&$qaux==""){
    call_from_main($q,$qdt,$DBH,$qrt);
}

function call_from_main($q,$qdt,$DBH,$qrt=''){
    // for the sales
    //echo $q.$qdt;
    $fq=$q.$qdt;
    $stm=$DBH->prepare($fq);
    try {
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
    // for the sales return
    //echo $qrt.$qdt;
    $fq2=$qrt.$qdt;
    //echo $fq2;
    $stm=$DBH->prepare($fq2);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $dataRT[]=$r;
        }
    } catch (PDOException $th) {
        //throw $th;
        echo "RT:".$th->getMessage();
    }
    //var_export($dataRT);
    //echo '<hr>';
    echo "<table><tr><td>BILL NO(MAIN)</td>";
    echo "<td>BILL DATE</td>";
    echo "<td>CUSTOMER</td>";
    echo "<td>CONTACT</td>";
    echo "<td>PAYMENT MODE</td>";
    echo "<td>REMARKS</td>";
    echo "<td>QTY</td>";
    echo "<td>SGST</td>";
    echo "<td>CGST</td>";
    echo "<td>IGST</td>";
    
    
   
    echo "<td>SELL PRICE</td>";
    echo "<td>DISCOUNT</td>";
    echo "<td>TAX</td>";
    echo "<td>TOTAL</td>";
    $t_pcs=0;
    $cgst=$sgst=$igst=0;
    $subtotal=$discount=$taxtotal=$grandtotal=0;;
    foreach($data as $d){
        $line="<tr><td>$d[billno]</td>";
        $line.="<td>$d[billdate]</td>";
        $line.="<td>$d[customer]</td>";
        $line.="<td>$d[contact]</td>";
        $line.="<td>$d[paytype]</td>";
        $line.="<td>$d[splrmks]</td>";
        $line.="<td>$d[pcs]</td>";
        
        $line.="<td>$d[sgst]</td>";
        $line.="<td>$d[cgst]</td>";
        $line.="<td>$d[igst]</td>";
        $line.="<td>$d[subtotal]</td>";
        $line.="<td>$d[discount]</td>";
        $line.="<td>$d[taxtotal]</td>";
        $line.="<td>$d[grandtotal]</td>";
        

        echo $line;
        $t_pcs=$t_pcs+intval($d['pcs']);
        $cgst=$cgst+intval($d['cgst']);
        $sgst=$sgst+intval($d['sgst']);
        $igst=$igst+intval($d['igst']);
        $subtotal=$subtotal+floatval($d['subtotal']);
        $discount=$discount+floatval($d['discount']);
        $taxtotal=$taxtotal+floatval($d['taxtotal']);
        $grandtotal=$grandtotal+floatval($d['grandtotal']);
    }
    foreach($dataRT as $d){
        $line="<tr class='redf'><td>$d[billno]</td>";
        $line.="<td>$d[billdate]</td>";
        $line.="<td>$d[customer]</td>";
        $line.="<td>$d[contact]</td>";
        $line.="<td>$d[paytype]</td>";
        $line.="<td>$d[splrmks]</td>";
        $line.="<td>$d[pcs]</td>";
        
        $line.="<td>$d[sgst]</td>";
        $line.="<td>$d[cgst]</td>";
        $line.="<td>$d[igst]</td>";
        $line.="<td>$d[subtotal]</td>";
        $line.="<td>$d[discount]</td>";
        $line.="<td>$d[taxtotal]</td>";
        $line.="<td>$d[grandtotal]</td>";
        

        echo $line;
        $t_pcs2=$t_pcs2+intval($d['pcs']);
        $cgst2=$cgst2+intval($d['cgst']);
        $sgst2=$sgst2+intval($d['sgst']);
        $igst2=$igst2+intval($d['igst']);
        $subtotal2=$subtotal2+floatval($d['subtotal']);
        $discount2=$discount2+floatval($d['discount']);
        $taxtotal2=$taxtotal2+floatval($d['taxtotal']);
        $grandtotal2=$grandtotal2+floatval($d['grandtotal']);
    }
    echo "<tr><td colspan='6'>TOTAL</td><td>".intval($t_pcs-$t_pcs2)."</td>";
    echo "<td>".floatval($sgst-$sgst2)."</td><td>".floatval($cgst-$cgst2)."</td><td>".floatval($igst-$igst2)."</td>";
    echo "<td>".floatval($subtotal-$subtotal2)."</td>";
    echo "<td>".floatval($discount-$discount2)."</td>";
    echo "<td>".floatval($taxtotal-$taxtotal2)."</td>";
    echo "<td>".floatval($grandtotal-$grandtotal2)."</td>";
}
function call_from_data($q,$qdt,$DBH){
    //echo $q.$qdt;
    $fq=$q.$qdt;
    
    $stm=$DBH->prepare($fq);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r;
        }
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    echo "<table><tr><td>BILL NO(DATA)</td>";
    echo "<td>BILL DATE</td>";
    echo "<td>ARTICLE NO</td>";
    echo "<td>BARCODE</td>";
    echo "<td>CATAGORY</td>";
    echo "<td>SERIES</td>";
    echo "<td>SIZE</td>";
    echo "<td>COLOR</td>";
    echo "<td>PKD</td>";
    echo "<td>FIT</td>";
    echo "<td>MRP</td>";
   
    echo "<td>SELL PRICE</td>";
    echo "<td>TAX</td>";
    echo "<td>TOTAL</td>";
    $count=$sales_total=$tax_total=$t_total=0;
    foreach($data as $d){
        $line="<tr><td>$d[billno]</td>";
        $line.="<td>$d[billdate]</td>";
        $line.="<td>$d[artno]</td>";
        $line.="<td>$d[barcode]</td>";
        $line.="<td>$d[cat]</td>";
        $line.="<td>$d[series]</td>";
        $line.="<td>$d[sz]</td>";
        $line.="<td>$d[shade]</td>";
        $line.="<td>$d[pkd]</td>";
        $line.="<td>$d[fit]</td>";
        $line.="<td>$d[mrp]</td>";
        $line.="<td>$d[saleprice]</td>";
        $line.="<td>$d[tax]</td>";
        $line.="<td>$d[total]</td>";
        echo $line;
        $count++;
        $sales_total=$sales_total+floatval($d['saleprice']);
        $tax_total=$tax_total+floatval($d['tax']);
        $t_total=$t_total+floatval($d['total']);

    }
    echo "<tr><td colspan='10'>TOTAL</td><td>$count</td><td>$sales_total</td><td>$tax_total</td><td>$t_total</td></tr>";

}
function call_from_main_data($DBH,$q1,$q2,$qdt){
   
    
    //echo $q1.$qdt."<br>";
    //echo $q2.$qdt;
    $fq=trim($q1.$qdt);
    
    
    $stm=$DBH->prepare($fq);
    try {
        //echo 'do:'.$fq;
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
    foreach($data as $d){
        $frq=$q2." and billno='$d[billno]'";
        //echo $frq;
        $stm=$DBH->prepare($frq);
        try {
            $stm->execute();
            while($r=$stm->fetch(PDO::FETCH_ASSOC)){
                $res_data[]=$r;
            }
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        }
        echo "<table><tr><td>BILL NO(MAINDATA)</td>";
        echo "<td>BILL DATE</td>";
        echo "<td>ARTICLE NO</td>";
        echo "<td>BARCODE</td>";
        echo "<td>CATAGORY</td>";
        echo "<td>SERIES</td>";
        echo "<td>SIZE</td>";
        echo "<td>COLOR</td>";
        echo "<td>PKD</td>";
        echo "<td>FIT</td>";
        echo "<td>MRP</td>";
    
        echo "<td>SELL PRICE</td>";
        echo "<td>TAX</td>";
        echo "<td>TOTAL</td>";
    foreach($res_data as $d){
        $line="<tr><td>$d[billno]</td>";
        $line.="<td>$d[billdate]</td>";
        $line.="<td>$d[artno]</td>";
        $line.="<td>$d[barcode]</td>";
        $line.="<td>$d[cat]</td>";
        $line.="<td>$d[series]</td>";
        $line.="<td>$d[sz]</td>";
        $line.="<td>$d[shade]</td>";
        $line.="<td>$d[pkd]</td>";
        $line.="<td>$d[fit]</td>";
        $line.="<td>$d[mrp]</td>";
        $line.="<td>$d[saleprice]</td>";
        $line.="<td>$d[tax]</td>";
        $line.="<td>$d[total]</td>";
        echo $line;

    }

    }


}
return false;
// make search query
$sq="";
foreach($search_data[3] as $key=>$val){
    if($val!=='0'){
        $sq.="  and `$key` ='".addslashes($val)."' ";
    }
        
    
    
}

//$sq=substr($sq,0,-1);

//echo "<br>1.".$sq;
foreach($search_data[5] as $key=>$val){
    if($val!=='0'&&$key!=='sefrminw_dt'&&$key!=='setoinw_dt'){
        $sq.="  and `$key` ='$val' ";
    }
    
}
//$sq=rtrim($sq,",");
//echo "<br>1.".$sq;
if($search_data[5]['sefrminw_dt']!=='0'&&$search_data[5]['setoinw_dt']!=='0'){
    $sq.=" and (created between '".$search_data[5]['sefrminw_dt']." 00:00:00' and '".$search_data[5]['setoinw_dt']." 23:59:59')";
}
//echo "<br>$sq";
$q.=$sq;
echo "<br>$q";
//return false;

$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
}
//var_export($data);
//echo '<hr>';
$line="";
$count=0;
foreach($data as $d){
    $line.="<tr><td>$d[barcode]</td>";
    $line.="<td>$d[sono2]</td>";
    $line.="<td>$d[artno]</td>";
    $line.="<td>$d[cat]</td>";
    $line.="<td>$d[sz]/$d[szcm] CM</td>";
    $line.="<td>$d[inseam]</td>";
    $line.="<td>$d[shade]</td>";
    $line.="<td>$d[qty]</td>";
    $line.="<td>$d[pkd]</td>";
    $line.="<td>$d[series]</td>";
    $line.="<td>$d[mrp]</td>";
    $line.="<td>$d[location]</td>";
    $line.="<td>$d[created]</td></tr>";
    $count++;
   
}

?>
<script>
    var line=<?php print json_encode($line);?>||0;
    var count=<?php print $count;?>||0;
    $("#tabmain tr:eq(-1)").before(line);
    $("#total_pcs").html(count);
</script>
<h4>CURRENT INVENTORY IN <?php print $location;?> WAREHOUSE</h4>
<h5>TOTAL PCS:<?php print $count;?></h5>
    <br><br>
    <table id="tabmain">
    <!-- <tr>
            
            <th><input type="text" id="sebarcode" placeholder="
            BARCODE"/></th>
            <th><input type="text" id="seref" placeholder="
            REFERENCE"/></th>
            <th><input type="text" id="seartno" placeholder="
            ARTNO"/></th>
            <th><input type="text" id="secat" placeholder="
            CATAGORY"/></th>
            <th><input type="text" id="sesz" placeholder="
            SIZE"/></th>
            <th></th>
            <th><input type="text" id="secolor" placeholder="
            COLOR"/></th>
            <th></th>
            <th><input type="text" id="sepkd" placeholder="
            PKD"/></th>
            <th><input type="text" id="seseries" placeholder="
            SERIES"/></th>
            <th><input type="text" id="semrp" placeholder="
            MRP"/></th>
            <th><input type="text" id="selocation" placeholder="
            LOCATION"/></th>
            
            
        </tr> -->
        <tr>
            
            <th>BARCODE</th>
            <th>REFERENCE</th>
            <th>ART NO</th>
            <th>CATAGORY</th>
            <th>SIZE</th>
            <th>INSEAM</th>
            <th>COLOR</th>
            <th>QTY</th>
            <th>PKD</th>
            <th>SERIES</th>
            <th>MRP</th>
            <th>LOCATION</th>
            <th>INWARD DATE</th>
            
            
        </tr>

        <tr>
            <td colspan="7">
                TOTAL PCS INWARDS
            </td>
            <td id="total_pcs"></td>
        </tr>
        
    </table>
    <br>

    <script>
        $(document).ready(function(){
            $("#sono2").on("keyup", function() {
                var ttl=0;
                var value = $(this).val().toLowerCase();
                //console.log(value);
                $("#tabmain tr:not(:eq(0))").filter(function() {
                   
                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1);
                   
                });
            });
        });
    </script>