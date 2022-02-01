<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_offer';



$dataMain=json_decode($_POST['holder1'],true);
$outlet=$dataMain[0]['outlet'];
unset($dataMain['goahead']);
var_export($dataMain);
echo '<hr>';
$data=json_decode($_POST['holder2'],true);
unset($data['goahead']);
$series=$data[1]['series'];
$discount=$data[1]['disrate'];
var_export($data);
echo '<hr>';


$DBH->beginTransaction();
$q="insert into `Q__seriesdiscount` (`outlet`,`series`,`discount`)";
$q.="values('$outlet','$series','$discount')";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    $msg="4";
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
    $msg.="@4";
}

echo $msg;

echo '<br>';
$kk=strpos($msg,"@");
$msg2="";
if($kk===false){
        $DBH->commit();
        $msg2="<img src=\"../img88/rt.png\"/>";
        $printok=$billno;
        
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


