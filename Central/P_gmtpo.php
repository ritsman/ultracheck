<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$cat=$_POST['cat'];
$q="select distinct artno from `Q__artno` where catagory ='".addslashes($cat)."'";
//echo $q;
//return false;
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r['artno'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$d=json_encode($data);
echo $d;

?>