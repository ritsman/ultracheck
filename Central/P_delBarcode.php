<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['bar'];

$tname=intval(substr($dataM,1,5))."_stk";
$DBH->beginTransaction();
$q="delete from $tname where barcode='$dataM'";
//echo $q;
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
    $msg.='1@';
}
//delete from central warehouse;

$q2="delete from `Q__stk__CENTRAL` where barcode='$dataM'";
$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
    
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
    $msg.='2@';
}

//echo $msg;
//echo '<br>';
$kk=strpos($msg,"@");
$msg2="";
if($kk===false){
        $DBH->commit();
        $msg2="<img src=\"../img88/rt.png\"/>";
        
}else{
               $DBH->rollBack();
        $msg2="##ERROR: BARCODE NOT DESTROYED";
        $msg2.=$msg;
}
echo $msg2;


?>
