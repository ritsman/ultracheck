<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_billing';

$outlet='CENTRAL';
echo $outlet;

$bill_field=strtolower('central1');


//echo $pono;

$dataMain=json_decode($_POST['holder1'],true);
$outlet=$dataMain[1]['outlet'];
unset($dataMain['goahead']);
var_export($dataMain);
echo '<hr>';
$dataBill=json_decode($_POST['holder2'],true);
unset($dataBill['goahead']);
array_pop($dataBill);
var_export($dataBill);
echo '<hr>';
$dataTax=json_decode($_POST['holder3'],true);
unset($dataTax['goahead']);
var_export($dataTax);
echo '<hr>';
// get new billno

$pono=get_new_pono_frn($DBH,$outlet);

$bill_prefix=get_bill_prefix($DBH,$outlet);
$billno=$bill_prefix."-".$pono;
echo $billno."BILLNO";


// set bill date for now
$dtd2=new DateTime();
$billdate=$dtd2->format("Y-m-d");
// function added to get challan data for maintaining transfer data
function get_challan($DBH,$outlet,$barcode){
    $q="select location from `Q__stk__$outlet` where barcode='$barcode'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $location=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $location['location']="NA";
    }
    return $location['location'];
}
$DBH->beginTransaction();

// create main sales table
$q="create table if not exists `T__salesmain__$outlet` (";
$q.=" id int primary key AUTO_INCREMENT not null,";
$q.=" billno varchar(250) not null default '0',";
$q.=" customer varchar(255) not null default '0',";
$q.=" contact varchar(25) not null default '0',";
$q.=" address varchar(255) not null default '0',";
$q.=" gst varchar(255) not null default '0',";
$q.=" outlet varchar(25) not null default '0',";
$q.=" paytype varchar(255) not null default '0',";
$q.=" pcs varchar(25) not null default '0',";

$q.=" billdate DATE not null default '2099-12-01',";

$q.=" sgst varchar(25) not null default '0',";
$q.=" cgst varchar(25) not null default '0',";
$q.=" igst varchar(25) not null default '0',";
$q.=" subtotal varchar(25) not null default '0',";
$q.=" discount varchar(25) not null default '0',";
$q.=" taxtotal varchar(25) not null default '0',";
$q.=" grndttl varchar(25) not null default '0',";
$q.=" roundof varchar(25) not null default '0',";
$q.=" grandtotal varchar(25) not null default '0',";
$q.=" splrmks varchar(255) not null default '0',";

$q.=" unique key (billno))";


$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg.="1@";
}


// create  data sales table
$q2="create table if not exists `T__salesdata__$outlet` (";
$q2.=" id int primary key AUTO_INCREMENT not null,";
$q2.=" billno varchar(250) not null default '0',";
$q2.=" artno varchar(250) not null default '0',";
$q2.=" barcode bigint not null default 0,";
$q2.=" tname varchar(225) not null default '0',";
$q2.=" offer varchar(255) not null default '0',";
$q2.=" mrp varchar(25) not null default '0',";
$q2.=" disrate varchar(25) not null default '0',";
$q2.=" discount varchar(125) not null default '0',";
$q2.=" saleprice varchar(125) not null default '0',";
$q2.=" taxrate varchar(25) not null default '0',";
$q2.=" tax varchar(125) not null default '0',";
$q2.=" total varchar(125) not null default '0',";

$q2.=" sz varchar(125) not null default '0',";
$q2.=" shade varchar(125) not null default '0',";
$q2.=" pkd varchar(125) not null default '0',";
$q2.=" series varchar(125) not null default '0',";
$q2.=" cat varchar(125) not null default '0',";
$q2.=" fit varchar(125) not null default '0',";
$q2.=" location varchar(255) not null default '0',";
$q2.=" billdate DATE not null default '2099-12-01',";


$q2.=" unique key (barcode))";


$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg.="2@";
}


// insert into salesmain
$q3="insert  into `T__salesmain__$outlet` (";
$q3.="`billno` ,`customer` ,`contact`,`address` ,`gst` ,`outlet`,`paytype` ,`pcs` ,`billdate` ,`sgst` ,`cgst` ,`igst` ,`subtotal`, `discount`,`taxtotal`, `grndttl`, `roundof` ,`grandtotal`,`splrmks` ";
$q3.=") values(";
$q3.=" :billno ,:customer ,:contact,:address ,:gst ,:outlet,:paytype ,:pcs ,:billdate ,:sgst ,:cgst ,:igst ,:subtotal,:discount, :taxtotal, :grndttl, :roundof ,:grandtotal,:splrmks ";
$q3.=")";

$stm=$DBH->prepare($q3);
$stm->bindParam(":billno",$billno);
$stm->bindParam(":customer",$dataMain[1]['customer']);
$stm->bindParam(":contact",$dataMain[1]['contact']);
$stm->bindParam(":address",$dataMain[1]['address']);
$stm->bindParam(":gst",$dataMain[1]['gst']);
$stm->bindParam(":outlet",$dataMain[1]['outlet']);
$stm->bindParam(":paytype",$dataMain[1]['paytype']);
$stm->bindParam(":pcs",$dataMain['totalpcs']);
$stm->bindParam(":billdate",$billdate);
$stm->bindParam(":sgst",$dataTax[1]['sgst']);
$stm->bindParam(":cgst",$dataTax[2]['cgst']);
$stm->bindParam(":igst",$dataTax[3]['igst']);
$stm->bindParam(":subtotal",$dataMain['subtotal']);
$stm->bindParam(":discount",$dataMain['totaldiscount']);
$stm->bindParam(":taxtotal",$dataMain['totaltaxamount']);
$stm->bindParam(":grndttl",$dataMain['ttlbefro']);

$stm->bindParam(":roundof",$dataTax[4]['rndoff']);
$stm->bindParam(":grandtotal",$dataTax[5]['gttl']);
$stm->bindParam(":splrmks",$dataTax[0]['splrmks']);

try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo "<br>SALESMAIN".$th->getMessage();
    $msg.="3@";
}

// insert into sales data

foreach($dataBill as $d){
    
    
    $loc=get_challan($DBH,$outlet,$d['barcode']);
    $q4="insert  into `T__salesdata__$outlet` (";
    $q4.="artno,billno,barcode,tname,offer,mrp,disrate,discount,saleprice,taxrate,tax,total,sz,shade,pkd,series,cat,fit,billdate,location)";
    $q4.=" values( ";
    $q4.=":a1,:a,:b,:c,:d,:d1,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n,:o,:p,:q,:q1)";
    // get barcode details

    $g=new Barcode($d['barcode']);
    $h=$g->get_Barcode_data();
    echo '<hr>';
    var_export($h);
    echo '<hr>';
    
    //echo "<br>q4:$q4<br>";
    //var_export($d);
    //echo '<hr>';
    $stm=$DBH->prepare($q4);
    $stm->bindParam(":a1",$d['artno']);
    $stm->bindParam(":a",$billno);
    $stm->bindParam(":b",$d['barcode']);
    $stm->bindParam(":c",$d['id']);
    $stm->bindParam(":d",$d['offer']);
    $stm->bindParam(":d1",$d['mrp']);
    $stm->bindParam(":e",$d['disrate']);
    $stm->bindParam(":f",$d['discount']);
    $stm->bindParam(":g",$d['saleprice']);
    $stm->bindParam(":h",$d['taxrate']);
    $stm->bindParam(":i",$d['tax']);
    $stm->bindParam(":j",$d['total']);

    $stm->bindParam(":k",$h['sz']);
    $stm->bindParam(":l",$h['shade']);
    $stm->bindParam(":m",$h['pkd']);
    $stm->bindParam(":n",$h['series']);
    $stm->bindParam(":o",$h['cat']);
    $stm->bindParam(":p",$h['fit']);
    $stm->bindParam(":q",$billdate);
    $stm->bindParam(":q1",$loc);
    try {
        
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>SALESDATA: ".$th->getMessage();
        $msg.="4@<br>".$th->getMessage();;
    }


    // update the barcode story
    
    $w1="select story ,status from `$d[id]` where barcode='$d[barcode]' ";
    //echo "<br>$w1";
    $stm=$DBH->prepare($w1);
    try {
        $stm->execute();
        $pstory=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
     
     $story="@sold-$billdate";
     $story.=$pstory['story'];
     
     $w="update `$d[id]` set story='$story',status='$billno' where barcode='$d[barcode]'";
     //echo "<br>W:$w";
     $stm=$DBH->prepare($w);
     try {
         
        $stm->execute();
         echo 'done update';
         //$msg.= "<br>".$w;
     } catch (PDOException $th) {
         echo "<br>5".$th->getMessage();
         $msg.="2@";
     }
     // delete fromm inv
     $q4="delete from `Q__stk__$outlet` where barcode='$d[barcode]'";
     
     $stm=$DBH->prepare($q4);
     try {
         
        $stm->execute();
     } catch (PDOException $th) {
         //throw $th;
         echo "<br>6".$th->getMessage();
         $msg.="4@";
     }
}


// update bill no
/*
       **********************up the  new purchase order no
*/
$year= substr($pono,0,2);
$month= substr($pono,2,2);
$pono2= substr($pono,4,4);
      
$qi="insert into B_po_new_gen (`year`,`month`,`$bill_field`)values('$year','$month','$pono2')";
$stm = $DBH->prepare($qi);
try {
    $stm->execute();
    echo '<br>doneponumber insert<br>';
} catch (PDOException $e) {
    echo "<br>6A." . $e->getMessage();
    $msg .= "5@";
}


echo $msg;
$printok="";
echo '<br>';
$kk=strpos($msg,"@");
$msg2="";
if($kk===false){
        $DBH->commit();
        $msg2="<img src=\"../img88/rt.png\"/>";
        $printok=$billno;
        
}else{
        $DBH->rollBack();
        $msg2="##ERROR:DATA NOT CAPTURED";
        $msg2.=$msg;
        $printok="NO";
}
echo $msg2;

?>
<script>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css"/>
</script>
    <script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        var msg=<?php print json_encode($msg2);?>;
        var printok=<?php print json_encode($printok);?>;
        parent.$("#response").html(msg);
        parent.$("#confmpono").html(printok);
        
        parent.printok=printok;
        
    });
   
  </script>


