<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

// username and passwd
$user=$_POST['usr'];


$q="select * from `Q__file_permission` where `username`='$user'";

$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg.="@4";
}
$d=json_encode($data);

echo $d;

?>
