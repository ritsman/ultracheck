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
$rack=$_POST['holder2'];
$location="CENTRAL";


$qw="create table if not exists `Q__stk__$location` (";
$qw.=" `id` int primary key AUTO_INCREMENT not null,";
$qw.=" `sono2` varchar(255) not null default '0',";
$qw.=" `artno` varchar(255) not null default '0',";
$qw.=" `sz` varchar(255) not null default '0',";
$qw.=" `shade` varchar(255) not null default '0',";
$qw.=" `szcm` varchar(255) not null default '0',";
$qw.=" `pkd` varchar(255) not null default '0',";
$qw.=" `barcode`bigint not null default 0,";
$qw.=" `inseam` varchar(255) not null default '0',";
$qw.=" `cat` varchar(255) not null default '0',";
$qw.=" `series` varchar(255) not null default '0',";
$qw.=" `tname` varchar(255) not null default '0',";
$qw.=" `qty` varchar(255) not null default '0',";
$qw.=" `location` varchar(255) not null default '0',";
$qw.=" `mrp` varchar(255) not null default '0',";
$qw.=" `status` varchar(255) not null default 'START',";
$qw.=" `created` timestamp not null default CURRENT_TIMESTAMP,";
$qw.=" `fit` varchar(255) not null default '0',";
$qw.=" unique key(barcode))";

$stm=$DBH->prepare($qw);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$DBH->beginTransaction();

// insert data into new table
foreach($dataM2 as $kx){
    $dataM=$kx['bc'];
    $tname=$kx['id'];
    // use the class function
    $inventory_table='Q__stk__CENTRAL';
    $b=new BarcodeCheck($dataM,$inventory_table);
    #####################################
    $c=$b->insert_inventory_fresh($rack);
    ##################################
    // update the story of barcode in tname
    $dtd2=new DateTime();
    $dtd=$dtd2->format("Y-m-d");
    $story="@start-CENTRAL-$dtd";
    $tb=$ret_data['tname'];
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


