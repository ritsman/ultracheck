<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
//echo 'R_delBarcode';
$dataM2=json_decode($_POST['bar'],true);

//var_export($dataM2);
//echo '<hr>';

$DBH->beginTransaction();

// insert data into new table
foreach($dataM2 as $kx){
    $tname=intval(substr($kx,1,5))."_stk";
    $dtd2=new DateTime();
    $dtd=$dtd2->format("Y-m-d");
    $story="@del-CENTRAL-$dtd";
    $tb=$ret_data['tname'];
    $w="update `$tname` set story='$story' where barcode='$dataM'";
    $stm=$DBH->prepare($w);
    try {
        
        $stm->execute();
        //echo 'done update';
        //$msg.= "<br>".$w;
    } catch (PDOException $th) {
        $msg.="<br>".$th->getMessage()."<br>".$w;
        $msg.="2@";
    }
    $msg.=$c;

    // delete from the inventory
    $q="delete from `Q__stk__CENTRAL` where barcode='$kx'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $msg.="55@";
    }
    // update the deleted list
    $q2="update `Q__barcode__DELETE` set status='GONEFOREVER' where barcode='$kx'";
    $stm=$DBH->prepare($q2);
    try {
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $msg.="66@";
    }
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
  <script type="text/javascript">
    $(document).ready(function(){
        var msg=<?php print json_encode($msg2);?>;
        
        parent.$("#response").html(msg);
        
        
        
    });
   
  </script>


