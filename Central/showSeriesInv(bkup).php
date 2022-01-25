<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$location=$_GET['location'];
//$series=$_POST['holder1'];
$series=$_GET['series'];
echo $series."---".$location;

$q="select distinct artno from `Q__stk__$location` where series = '$series'";
//echo $q;
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $artno[]=$r['artno'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo "<br>1.".$th->getMessage();
}
//var_export($artno);
//echo '<hr>';
$q2="select distinct sz from `Q__stk__$location` where series = '$series' order by sz";
//echo $q2;
$stm=$DBH->prepare($q2);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $sizes[]=$r['sz'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo "<br>2.".$th->getMessage();
}
//var_export($sizes);
//echo '<hr>';

$head="<div class='pageShow2'><table><tr><th>ARTNO</th>";
foreach($sizes as $s){
    $head.="<th>$s</th>";

}
$head.="</tr>";
echo $head;
function get_shade($artno,$DBH){
    $data=[];
    $q="select distinct shade from `Q__artno__sz` where artno='$artno'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r['shade'];
        }
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $data;
}
function get_sz_total($sz_array,$location,$i,$artno,$DBH,$series,$shade){
    $q="select sum(qty) as tp from `Q__stk__$location` where artno='$artno' and series='$series' and shade='$shade' and sz='".$sz_array[$i]."'";
    //echo "<br>$q";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $ds=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }

    $line="<td>".intval($ds['tp'])."</td>";
    echo $line;
    $i++;
    if($i<count($sz_array)){
        get_sz_total($sz_array,$location,$i,$artno,$DBH,$series,$shade);
    }

}
function get_sz_pcs($location,$artno_array,$DBH,$counter,$counter2,$series,$sizes){
    $line="<tr><td>".$artno_array[$counter]."</td>";
    echo $line;
    // shades of this artno
    $shade=get_shade($artno_array[$counter],$DBH);
    foreach($shade as $s){
        $line="<td>$s</td>";
        echo $line;
        get_sz_total($sizes,$location,$counter2,$artno_array[$counter],$DBH,$series,$s);
    }
    
   
    //$q2="select * from `Q__stk__$location` where  and artno='".$artno_array[$counter]."'";
    //echo "<br>$q2";
    // $stm=$DBH->prepare($q2);
    // try {
    //     $stm->execute();
    //     while($r=$stm->fetch(PDO::FETCH_ASSOC)){
    //         $data2[]=$r;
    //     }
    // } catch (PDOException $th) {
    //     //throw $th;
    //     echo $th->getMessage();
    // }
    $counter++;
    if($counter<count($artno_array)){
        get_sz_pcs($location,$artno_array,$DBH,$counter,$counter2,$series,$sizes);
    }

}

get_sz_pcs($location,$artno,$DBH,0,0,$series,$sizes);


//var_export($data2[0]);
//echo '<hr>';



?>
<link rel="stylesheet" href="../style/css-reset.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
<link rel="stylesheet" href="../style/style.css">