<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_addInventory';
$dataM2=json_decode($_POST['holder1'],true);
unset($dataM2['goahead']);
var_export($dataM2);
echo '<hr>';
$rack=json_decode($_POST['holder2'],true);
var_export($rack);
echo '<hr>';

$q="select * from `Q__challan_main` where pono='$rack[chlno]'";
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    $chlndata=$stm->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $th) {
    //throw $th;
    echo "<br>3".$th->getMessage();
}

var_export($chlndata);
echo '<hr>';

$inv_fromm="Q__stk__$chlndata[fromm]";
$inv_too="Q__stk__$chlndata[too]";
echo $inv_too."-------";

$DBH->beginTransaction();

foreach($dataM2 as $d){
    $bc=array_values($d);
// update reciever

    $q1="update `$inv_too` set status='CONFM' where barcode='$bc[0]'";
    echo "<br>$q1<br>";
    $stm=$DBH->prepare($q1);
    try {
        
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>4".$th->getMessage();
        $msg.="8@";
    }
     // update the story of barcode in tname
    $tname=intval(substr($bc[0],1,5))."_stk";
    $w1="select story from `$tname` where barcode='$bc[0]' ";
    $stm=$DBH->prepare($w1);
    try {
        $stm->execute();
        $pstory=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
     $dtd2=new DateTime();
     $dtd=$dtd2->format("Y-m-d");
     $story="@conf-$chlndata[too]-$dtd";
     $story=$pstory['story'];
     
     $w="update `$tname` set story='$story',status='$rack[chlno]' where barcode='$bc[0]'";
     $stm=$DBH->prepare($w);
     try {
         
         $stm->execute();
         echo 'done update';
         //$msg.= "<br>".$w;
     } catch (PDOException $th) {
         echo "<br>5".$th->getMessage()."<br>".$w;
         $msg.="2@";
     }
     // delete fromm inv
     $q4="delete from `$inv_fromm` where barcode='$bc[0]'";
     echo "<br>".$q4;
     $stm=$DBH->prepare($q4);
     try {
         
        $stm->execute();
     } catch (PDOException $th) {
         //throw $th;
         echo "<br>6".$th->getMessage();
         $msg.="4@";
     }
}

// update chllan table
// get balance pcs
//$balpcs22=$chlndata['balpcs']=='AB'?
$newbal=intval($chlndata['balpcs'])-intval($rack['total_count']);
echo "$rack[total_count]===$chlndata[pcs]--$chlndata[balpcs]<br>";
//$newbal=$balpcs-$rack['total_count'];
echo "NEWBAL:".$newbal;
if($newbal==0){
    $f=$chlndata['too']."-C";
}else{
    $f=$chlndata['too'];
}

    
    $q="update `Q__challan_main` set too='$f',balpcs='$newbal' where pono='$rack[chlno]'";
    echo $q;
    $stm=$DBH->prepare($q);
    try {
        
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $msg.="6@";
    }





echo $msg;
echo '<br>';
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
  <script type="text/javascript">
    $(document).ready(function(){
        var msg=<?php print json_encode($msg2);?>;
        
        parent.$("#response").html(msg);
        
        
        
    });
   
  </script>


