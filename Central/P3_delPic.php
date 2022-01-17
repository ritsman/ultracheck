<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');


$artno=$_POST['artno'];
$shade=$_POST['shade'];
//var_export($artno);
// get all the images;;
$q="delete from `Q__artno__pic` where artno='$artno' and shade='$shade'";
//echo $q;

$stm=$EBH->prepare($q);
try {
    
    $stm->execute();
    if($stm->rowCount()>0){
        $msg="<img src=\"../img88/rt.png\"/>";
    }else{
        $msg="#ERROR: NO PIC FOUND TO DELETE";
    }
    
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg="#ERROR: PIC NOT DELETED";
}
$d=json_encode($data);
echo $d;


?>
