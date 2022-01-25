<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_stockVerify';
$dataM2=json_decode($_POST['holder1'],true);
$data=$_POST['holder1'];
$data2=json_encode($dataM2);
var_export($dataM2);
echo '<hr>';
var_export($data);
echo '<hr>';
var_export($data2);
echo '<hr>';
$self_outlet="CENTRAL";

echo $self_outlet.": outlet";
// return false;
$bill_field=strtolower($self_outlet);
echo $bill_field.": billfield";
$pono=get_new_challan($DBH,$bill_field);

$bill_prefix=get_bill_prefix($DBH,$bill_field);
$chlno=$bill_prefix."O-".$pono;
echo $chlno.": pono";
// return false;

$qw="create table if not exists `S__stkverify` (";
$qw.=" `id` int primary key AUTO_INCREMENT not null,";
$qw.=" `palsana` text  null ,";
$qw.=" `vishnagar` text null ,";
$qw.=" `vatvagidc` text null ,";
$qw.=" `gitamandir` text null ,";
$qw.=" `jahgirpura` text null ,";
$qw.=" `kamrej` text null,";
$qw.=" `hmt` text null ,";
$qw.=" `created` timestamp not null default CURRENT_TIMESTAMP)";



$stm=$DBH->prepare($qw);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}


$DBH->beginTransaction();

// insert data into new table

    $dtd2=new DateTime();
    $dtd=$dtd2->format("Y-m-d");



$q="insert into `S__stkverify`(`$self_outlet`) values('$data')";
echo $q;
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    echo 'done';
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
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


