<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$cat=$_POST['cat'];
$q="select distinct artno,catagory from `Q__artno` where series ='".addslashes($cat)."'";
//echo $q;
//return false;
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data['artno'][]=$r['artno'];
        $data['cat'][]=$r['catagory'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// foreach($data2 as $key=>$artno){
//     $q="select catagory from `Q__artno` where artno ='".$artno."'";
//     //echo $q;
//     //return false;
//     $stm=$DBH->prepare($q);
//     try {
//         $stm->execute();
//         $r=$stm->fetch(PDO::FETCH_ASSOC);
//         $data['cat'][]=$r['catagory'];
//         $data['artno'][]=$artno;
        
//     } catch (PDOException $th) {
//         //throw $th;
//         echo $th->getMessage();
//     }

// }
$d=json_encode($data);
echo $d;

?>