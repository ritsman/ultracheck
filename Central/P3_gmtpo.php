<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$name=$_POST['name'];
$q="select sz from `Q__cat_szchart` where name ='".addslashes($name)."'";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    $data=$stm->fetch(PDO::FETCH_ASSOC);
        
    
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$d=json_encode($data);
echo $d;

?>