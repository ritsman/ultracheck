<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=json_decode($_POST['data'],true);
unset($dataM['goahead']);

// var_export($dataM);
// echo '<hr>';



foreach($dataM as $data2){
    foreach($data2 as $k=>$v){
        $data[$k]=$v;
    }
}
// var_export($data);
// echo '<hr>';
$q="select * from `Q__artno__sz` where sono2='$data[sono2]'";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data1[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// var_export($data1);
// echo '<hr>';

foreach($data1 as $d){
    $pkm=strtoupper($d['pkdmonth']).substr($d['pkd'],2);
    $q="select * from `Q__os__madeups` where pono='$d[sono2]' and artno='$d[artno]' and sz='$d[sz]'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $final_data[$d['id']]=$stm->fetch(PDO::FETCH_ASSOC);
        $final_data[$d['id']]['pkm']=$pkm;//
    } catch (\Throwable $th) {
        //throw $th;
    }
}
// echo '<hr>';
// var_export($final_data);
// echo '<hr>';
//var_export($data);
//echo '<hr>';
echo json_encode($final_data);

?>