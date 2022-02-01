<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_offer';

// username and passwd
$userpass=$_POST['holder2'];
$u=explode("&&&",$userpass);
$user=$u[0];
$passwd=$u[1];

$dataMain=json_decode($_POST['holder1'],true);// file permissions for central

var_export($dataMain);
echo '<hr>';
$q_central="";
foreach($dataMain as $ar_data){
    foreach($ar_data as $filename=>$d){
        //echo $filename."--".$d;
        //echo '<hr>';
        $data_central[$filename]=$d;
        $q_central.="('$user','central','$filename','$d'),";
    }
}
$q_central=substr($q_central,0,-1);
echo $q_central;
var_export($data_central);
echo '<hr>';

$qw ="create table if not exists `Q__file_permission`  (";
$qw.=" `id` int primary key AUTO_INCREMENT not null,";
$qw.=" `username` varchar(255) not null default '0',";
$qw.=" `module` varchar(255) not null default '0',";
$qw.=" `filename` varchar(255) not null default '0',";
$qw.=" `permit` varchar(255) not null default '0',";
$qw.=" unique key(username,module,filename));";


echo $qw;
echo '<hr>';
$stm=$DBH->prepare($qw);
try {
    
    $stm->execute();
    echo 'table created';
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}



$DBH->beginTransaction();


$q="replace into `Q__file_permission` (`username`,`module`,`filename`,`permit`)";
$q.="values";
$q.=$q_central;
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


