<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$outlet=$_POST['outlet'];
$q="select discount from `Q__series_defaultdiscount` where outlet='$outlet'";
$stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $r=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    echo $r['discount'];
   


?>