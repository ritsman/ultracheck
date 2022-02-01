<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_billing';


$q="select distinct billno from `T__salesdata_rt__PALSANA`";
$stm=$DBH->prepare($q);
$stm->execute();
while($r=$stm->fetch(PDO::FETCH_ASSOC)){
    $data[]=$r['billno'];
}

//var_export($data);
//echo '<hr>';
foreach($data as $billno){
    $q="select billdate from T__salesmain_rt__PALSANA where billno='$billno'";
    $stm=$DBH->prepare($q);
    $stm->execute();
    $dt=$stm->fetch(PDO::FETCH_ASSOC);
    $res[$billno]=$dt['billdate'];
}
//var_export($res);
//echo '<hr>';

foreach($res as $billno=>$billdt){
    $q="update T__salesdata_rt__PALSANA set billdate='$billdt' where billno='$billno'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        echo "done $billno--$billdt<br>";
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
}
?>