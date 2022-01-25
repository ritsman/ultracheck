<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$outlet=$_POST['holder2'];
$chlno=$_POST['holder1'];
echo $chlno."---".$outlet;
$q="select * from `Q__stk__$outlet` where location like '$chlno%'";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data[0]);
//echo '<hr>';
// get the sold pcs data here---

$q2="select * from `T__salesdata__$outlet` where location like '$chlno%'";
$stm=$DBH->prepare($q2);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data3[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
// var_export($data3);
// echo '<hr>';

$q2="select * from `Q__stk__CENTRAL` where location like '$chlno%'";
$stm=$DBH->prepare($q2);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data2[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data2[0]);
//echo '<hr>';
$head="<div class='pageShow2'><table><tr><th>REFERENCE</th><th>BARCODE</th>";
$head.="<th>CATAGORY</th><th>ARTICLE NO</th><th>SERIES</th><th>COLOR</th>";
$head.="<th>SIZE</th><th>FIT</th><th>PACKED</th><th>MRP</th>";
$head.="<th>CONFIRMED</th><th>UNCONFIRMED</th>";

echo $head;
$total=0;
foreach($data as $d){
    $line="<tr><td>$d[sono2]</td><td>$d[barcode]</td>";
    $line.="<td>$d[cat]</td><td>$d[artno]</td><td>$d[series]</td>";
    $line.="<td>$d[shade]</td><td>$d[sz]</td><td>$d[fit]</td><td>$d[pkd]</td>";
    $line.="<td>$d[mrp]</td>";
    if($d['status']=='CONFM'){
        $line.="<td>$d[qty]</td><td></td>";
    }else{
        $line.="<td></td><td>$d[qty]</td>";
    }
    echo $line;
    $total=$total+intval($d['qty']);
}
// add the sold pcs here

foreach($data3 as $d){
    $qrt=1;
    $line="<tr><td>$d[billno]</td><td>$d[barcode]</td>";
    $line.="<td>$d[cat]</td><td>$d[artno]</td><td>$d[series]</td>";
    $line.="<td>$d[shade]</td><td>$d[sz]</td><td>$d[fit]</td><td>$d[pkd]</td>";
    $line.="<td>$d[mrp]</td>";
    $line.="<td>$qrt</td>";
    echo $line;
    $total=$total+intval($qrt);

}




$cline="<tr><td colspan='9'></td><td>TOTAL</td><td>$total</td>";
echo $cline;
foreach($data2 as $d){
    $line="<tr><td>$d[sono2]</td><td>$d[barcode]</td>";
    $line.="<td>$d[cat]</td><td>$d[artno]</td><td>$d[series]</td>";
    $line.="<td>$d[shade]</td><td>$d[sz]</td><td>$d[fit]</td><td>$d[pkd]</td>";
    $line.="<td>$d[mrp]</td>";
    if($d['status']=='START'){
        $line.="<td>$d[qty]</td><td></td>";
    }else{
        $line.="<td></td><td>$d[qty]</td>";
    }
    echo $line;
    $total=$total+intval($d['qty']);
}

?>
<link rel="stylesheet" href="../style/css-reset.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
<link rel="stylesheet" href="../style/style.css">