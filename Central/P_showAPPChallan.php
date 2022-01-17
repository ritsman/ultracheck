<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
//echo 'R_addInventory';
$dataM2=json_decode($_POST['c'],true);
$napcs=json_decode($_POST['napcs'],true);
//var_export($dataM2);
//echo '<hr>';

$location=$_POST['desti_outlet'];
$location_from=$_POST['outlet'];
$chlno=$_POST['chlno'];
//echo $location."--".$location_from."--".$chlno;




$DBH->beginTransaction();

// insert data into new table
foreach($dataM2 as $kx){
    $q="select * from `Q__stk__$location_from` where id=$kx";
    //echo "<br>1".$q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $ba=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>1.".$th->getMessage();
    }

    $dataM=$ba['barcode'];
    // insert into location
    $inventory_table="Q__stk__$location";
    $b=new BarcodeCheck($dataM,$inventory_table);
    $c=$b->insert_inventory_fresh($chlno);

    // update the story of barcode in tname
    $dtd2=new DateTime();
    $dtd=$dtd2->format("Y-m-d");
    $story="@sent-$location-$dtd";
    $tname=intval(substr($dataM,1,5))."_stk";

    $w1="select story from `$tname` where barcode='$dataM' ";
    $stm=$DBH->prepare($w1);
    try {
        $stm->execute();
        $pstory=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    $story.=$pstory['story'];

    $w="update `$tname` set story='$story' where barcode='$dataM'";
    $stm=$DBH->prepare($w);
    try {
        
        $stm->execute();
        echo 'done update';
        //$msg.= "<br>".$w;
    } catch (PDOException $th) {
        $msg.="<br>".$th->getMessage()."<br>".$w;
        $msg.="2@";
    }
    $msg.=$c;
    // delete from location_from
    //update the status and location of sending warehouse
    $w4="delete from `Q__stk__$location_from` where id='$kx'";
    //echo $w4;
    $stm=$DBH->prepare($w4);
    try {
        
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }

}

// restate the status of pcs not selected to transfer to their original stauta

foreach($napcs as $n){
    $q="update Q__stk__$location_from set status='CONFM' where id='$n'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
}


// update challan main set business as done
$q6="update `Q__challan_main` set fromm ='$location_from' where pono='$chlno'";

$stm=$DBH->prepare($q6);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg.-"6@";
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
        $msg2="##ERROR:DATA NOT CAPTURED";
        $msg2.=$msg;
}
echo $msg2;

?>
<script>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css"/>
</script>
    <script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
  
   
 

