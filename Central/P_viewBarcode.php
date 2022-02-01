<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['bar'];

$tname=intval(substr($dataM,1,5))."_stk";
$q="select * from $tname where barcode='$dataM'";
echo $q;
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
}
echo '<hr>';
var_export($data);
echo '<hr>';

$st=explode("@",substr($data['story'],1));
krsort($st);
//var_export($st);
//echo '<hr>';

$line="";
$count=0;
foreach($st as $d){
    $f=explode("-",$d);
    //echo count($f);
    krsort($f);
    //var_export($f);
    $x=max(array_keys($f));
    $y=max(array_keys($f));
    $dt=$f[$x--]."/".$f[$x--]."/".$f[$x--];
    unset($f[$y--]);
    unset($f[$y--]);
    unset($f[$y--]);
    //var_export($f);
    $status=strtoupper(implode("-",$f));
    $pos=strpos($status,"CONF");
    //echo $pos."POS";
    if($pos){
        $loco=$f[1];
    }else{
        $loco=$f[0];
    }
    $q="select location from Q__stk__$loco where barcode='$data[barcode]'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $l=$stm->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    $line.="<tr><td>$data[barcode]</td>";
    $line.="<td>$dt</td>";
    $line.="<td>$status</td>";
    $line.="<td>$l[location]</td>";
    
    $count++;
   
}

?>
<script>
    var line=<?php print json_encode($line);?>||0;
    var count=<?php print $count;?>||0;
    $("#tabmain").append(line);
    
</script>
<h4><?php print json_encode($data['barcode']);?> BARCODE STATUS</h4>
    <br><br>
    <table id="tabmain">
    
        <tr>
            
            <th>BARCODE</th>
            <th>DATE</th>
            <th>STATUS</th>
            <th>LOCATION</th>
            
            
            
        </tr>

       
        
    </table>
    <br>

   