<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$cat=$_POST['cat'];
$series=$_POST['series'];
//echo $series."__cat".$cat;

//========================================================================
$catagory=[];
$q1a="select distinct subcat from `Q__os__madeups`";
$stm=$DBH->prepare($q1a);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $catagory[]=$r['subcat'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($catagory);
//echo '<hr>';
// $t=in_array($cat,$catagory);
// echo $t."_T";
if(in_array($cat,$catagory)){
    $q="select mrp from `Q__os__madeups` where series='$series' and subcat='$cat'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        
        $stm->execute();
    $r=$stm->fetch(PDO::FETCH_ASSOC);
    
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }

}else{
    $q="select mrp from `Q__seriesmrp` where series='".addslashes($series)."'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        
        $stm->execute();
       $r=$stm->fetch(PDO::FETCH_ASSOC);
      
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
}




//var_export($data);
//echo '<hr>';
echo $r['mrp'];
?>