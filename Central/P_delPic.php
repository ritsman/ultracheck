<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');


$artno=$_POST['artno'];
//var_export($artno);
// get all the images;;
$q="select shade from `Q__artno__pic` where artno='$artno'";
//echo $q;

$stm=$EBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$d=json_encode($data);
echo $d;


?>
