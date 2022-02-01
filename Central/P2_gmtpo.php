<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$cat=$_POST['cat'];
$q="select name,sz,ratio from `Q__cat_szchart` where cat ='".addslashes($cat)."'";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    //echo $stm->rowCount();
    if($stm->rowCount()>0){
        $data1=$stm->fetch(PDO::FETCH_ASSOC);
    }else{
        $data1=[0];
    }
   
        
    
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    echo "<br>$q<br>";
    $data1="NOTHING";
}
// get hsn code
$q2="select hsn from `Q__hsn` where cat='".addslashes($cat)."'";
$stm=$DBH->prepare($q2);
try {
    $stm->execute();
    //echo $stm->rowCount();
    if($stm->rowCount()>0){
        $data2=$stm->fetch(PDO::FETCH_ASSOC);
    }else{
        $data2=[0];
    }
    
        
    
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    echo "<br>$q2<br>";
    $data2="NOTHING2";
}
//var_export($data1);
//var_export($data2);
$data=array_merge($data1,$data2);
//var_export($data);
$d=json_encode($data);
echo $d;

?>