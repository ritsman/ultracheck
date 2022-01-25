<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$upart=$_FILES['upart'];
var_export($upart);
echo '<hr>';
$artno=$_POST['artno'];
$shade=$_POST['shade'];

echo $artno."---".$shade;
echo $msg;

echo '<br>';

$DBH->beginTransaction();

// create table for upload picture
$q2=" CREATE TABLE if not exists `Q__artno__pic` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `artno` varchar(255) NOT NULL DEFAULT '0',
    `shade` varchar(255) NOT NULL DEFAULT '0',
    `picname` varchar(255) NOT NULL DEFAULT '0',
    UNIQUE(artno,shade)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

  $stm=$DBH->prepare($q2);
  try {
      $stm->execute();
  } catch (PDOException $th) {
      //throw $th;
      echo $th->getMessage();
      $msg.="4@";
  }




$upload_directory="../artno";
if($upart['error']!==0){
    $msg.="UPLOAD FAILED@";
    return false;
}else{
    $destination=$upload_directory."/".$upart['name'];
    if( move_uploaded_file($upart['tmp_name'],$destination)){
        echo 'go';
        echo addslashes($destination);
        $q="insert into Q__artno__pic (`artno`,`shade`,`picname`) values('$artno','$shade','$destination')";
        $stm=$DBH->prepare($q);
        try {
            
            $stm->execute();
        } catch (PDOException $th) {
            //throw $th;\
            echo $th->getMessage();
            $msg.="2@<br>".$th->getMessage();
        }
    }else{
        echo 'failed';
        $msg.="3@";
    }
   
    
}

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
        $printok="NO";
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
        var destination=<?php print json_encode($destination);?>;
        
        parent.$("#response").html(msg);
        parent.artpic=destination;
        parent.$("#artpic").html("<img src='"+destination+"' class='img-thumbnail'/>");
        
        
    });
   
  </script>
