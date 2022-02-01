<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$outlet=$_POST['outlet'];
//echo $series;
function get_mrp($DBH,$series){
    $q="select mrp from `Q__seriesmrp` where series='".addslashes($series)."'";
    //echo $q;
    
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $r=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $r['mrp'];
   
}
function get_mrp_os($DBH,$series){
    $q="select mrp from `Q__os__madeups` where series='".addslashes($series)."'";
    //echo $q;
    
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $r=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $r['mrp'];
   
}
// select distinct series from madeups to get mrp from q--os--madeups
$qw="select distinct series from `Q__os__madeups`";
$stm=$DBH->prepare($qw);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $catagory[]=$r['series'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($catagory);
//echo '<hr>';

$q="select * from `Q__seriesdiscount` where outlet='$outlet'";
//echo $q;
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
//var_export($data);
//echo '<hr>';
$s=<<<EOC
<table><tr><th></th><th>OUTLET</th><th>SERIES</th><th>MRP</th><th>DISCOUNT</th></tr>


EOC;
echo $s;
foreach($data as $d){
    if(in_array($d['series'],$catagory)){
        $mrp=get_mrp_os($DBH,$d['series']);
    }else{
        $mrp=get_mrp($DBH,$d['series']);
    }
    
    $line="<tr><td><img src=\"../img88/cross.png\" class='deloffer' onclick=\"del_ser_dis(this)\"/></td>";
    $line.="<td class='out'>$d[outlet]</td><td class='ser'>$d[series]</td><td>$mrp</td><td>$d[discount]</td>";
    echo $line;
}


?>
<script>
    function del_ser_dis(ele){
        alert("del");
        var outlet=$(ele).parent().siblings("td.out").text();
        var series=$(ele).parent().siblings("td.ser").text();
       
        $.post("del_P2_offer.php",{outlet:outlet,series:series},function(data){
            console.log(data);
            var s="<span style=\"color:red\">DELETED</span>";
            $(ele).parent().html(s);
        });
    }
</script>