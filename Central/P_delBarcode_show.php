<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['data'];

$location=$_POST['data'];
//var_export($dataM);
//echo '<hr>';

    $q="select * from `Q__barcode__DELETE` where location='DELETED' and status=\"START\"";

//echo $q;
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
}
//var_export($data);
//echo '<hr>';
$line="";
$count=0;
foreach($data as $d){
    $line.="<tr><td><input type='checkbox' class='delbar' title='delbar' checked/></td>";
    $line.="<td dirname='direct' class='bc'>$d[barcode]</td>";
    $line.="<td>$d[sono2]</td>";
    $line.="<td>$d[artno]</td>";
    $line.="<td>$d[cat]</td>";
    $line.="<td>$d[sz]/$d[szcm] CM</td>";
    $line.="<td>$d[inseam]</td>";
    $line.="<td>$d[shade]</td>";
    $line.="<td>$d[qty]</td>";
    $line.="<td>$d[pkd]</td>";
    $line.="<td>$d[series]</td>";
    $line.="<td>$d[mrp]</td>";
    $line.="<td>$d[location]</td></tr>";
    //$line.="<td>$d[created]</td></tr>";
    $count++;
   
}

?>
<script>
    var line=<?php print json_encode($line);?>||0;
    var count=<?php print $count;?>||0;
    $("#tabmain tr:not(:eq(-1),:eq(0))").remove();
    $("#tabmain tr:eq(-1)").before(line);
    $("#total_pcs").html(count);
</script>
