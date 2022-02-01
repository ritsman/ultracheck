<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$outlet=$_POST['outlet'];
$dtd=isset($_POST['dtd'])?$_POST['dtd']:"";
$dtd2=isset($_POST['dtd2'])?$_POST['dtd2']:"";
//echo "O:$outlet--D:$dtd";

if($dtd==""){

    $q="select * from `Q__challan_main` where  (fromm='$outlet' or fromm='$outlet-UC') and too='CENTRAL'";
}else{
    $q="select * from `Q__challan_main` where  (fromm='$outlet' or fromm='$outlet-C') and too='CENTRAL' and (chdt between '$dtd' and '$dtd2')";

}
//echo $q;

$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data);
//echo '<hr>';

$line_head="<table><tr><th>CHALLAN NO</th><th>CHALLAN DATE</th><th>FROM</th>";
$line_head.="<th>TO</th><th>CONFIRMED PCS</th><th>BAL PCS</th></tr>";
echo $line_head;
//return false;
$tpc=0;
foreach($data as $d){
    $line="<tr><td>$d[pono]</td>";
    $line.="<td>$d[chdt]</td>";
    $line.="<td>$d[fromm]</td>";
    $line.="<td>$d[too]</td>";
    $line.="<td><a href='#' id='$d[pono]' onclick=\"open_chln(this)\">$d[pcs]</a></td>";
    $line.="<td>$d[balpcs]</td>";
    $tpcs=$tpcs+intval($d['balpcs']);
    $tpcs2=$tpcs2+intval($d['pcs']);
    
   echo $line;
}
$bottom_line="<tr><td colspan='4'>TOTAL PCS</td><td>$tpcs2</td><td>$tpcs</td>";
echo $bottom_line;
?>
<style>

.modal
{
    overflow: hidden;
}
.modal-dialog{
    margin-right: 0;
    margin-left: 0;
}
.modeless{
    top:10%;
    left:50%;
    bottom:auto;
    right:auto;
    margin-left:-300px;
}

</style>


<script>
var outlet=<?php print json_encode($outlet);?>;
function open_chln(ele){
    var id=$(ele).attr("id");
    console.log(id,outlet);
    $("#holder1").val(id);
    $("#holder2").val(outlet);
    $("#POForm").submit();
}
$("#subit").click(function(){
    $("#holder1").val("PPP");
    $("#holder2").val("RRR");
    $("#POForm").submit();
});
</script>
