<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$outlet=$_POST['outlet'];
$series=addslashes($_POST['series']);
// echo $series."--".$outlet;
// return false;
$q="delete from `Q__seriesdiscount` where outlet='$outlet' and series='$series'";
//echo $q;
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
   
  
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
?>