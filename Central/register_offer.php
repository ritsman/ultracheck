<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
//echo 'register offer';
$buy=$_POST['buyx'];
$get=$_POST['gety'];
echo "buy$buy;get$get";
$outlet=explode(',',$_POST['hidme2']);
var_export($outlet);
$q="insert into Q__offer_buy(`name`,`outlet`,`buyx`,`gety`,`status`) values ";
foreach($outlet as $frn){
    if($frn!=='ALL'){
        $subq.="('buyxgety','$frn','$buy','$get','on'),";
    }
    
}
$subq=substr($subq,0,-1);
echo $subq;
$q.=$subq;
echo '<br>';
echo $q;

$stm=$DBH->prepare($q);
try {
    $stm->execute();
    echo "<img src='../img88/rt.png'/>";
} catch (PDOException $th) {
    //throw $th;
    echo '<br>';
    echo $th->getMessage();
}


?>