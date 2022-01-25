<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$chlno=$_POST['chlno'];

$location=$_POST['location'];
//echo $chlno."--".$location;
//return false;
$q="select * from `Q__stk__$location` where location like '$chlno%' and status='START'";
//echo $q;
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
    $ct=explode('@',$d['location']);
    $c=$ct[1];
    $line.="<tr id='$d[barcode]'><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td>";
    $line.="<td class='$d[barcode]'  dirname='direct'></td>";
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
    $line.="<td>$c</td></tr>";
    $count++;
    $ret_data['barcode'][$d['barcode']]=[$count];
   
}
$ret_data['count']=$count;
$ret_data['line']=$line;
echo json_encode($ret_data);
?>
