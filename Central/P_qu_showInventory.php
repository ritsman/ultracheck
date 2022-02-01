<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$query=$_POST['query'];
$page=$_POST['page'];
$page--;
$fullcount=$_POST['fullcount'];
$ttlpages=$_POST['tp'];
$records=$_POST['records'];;
$offset=$page*$records;
if($offset>$fullcount){
    $offset=(($page-1)*$records)+($page*$records-$fullcount);
}
//echo $query."---".$page;
$wq=$query." limit $offset,$records";

$stm2=$DBH->prepare($wq);
try {
    $stm2->execute();
    while($r=$stm2->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $wq."1<br>";
    echo $th->getMessage();
}


$count=0;
$line="";
foreach($data as $d){
    //var_export($d);
    //echo '<hr>';
    $line.="<tr>";//<td>$d[id]</td>";
    $line.="<td>$d[barcode]</td>";
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
    $line.="<td>$d[location]</td>";
    $line.="<td>$d[fit]</td>";
    $line.="<td>$d[created]</td></tr>";
    $count++;
    $k = json_encode($line);
    $sct = <<<sct
    <script>
        
   //console.log($k);
    $(document).ready(function(){
        $("table#tabmain tr:eq(-1)").before($k);
    });
    </script>
sct;
    //echo $sct;
    
}

?>
<link rel="stylesheet" href="../external/css/bootstrap.css">
<script src="../external/js/jquery-3.5.1.js"></script>
<script src="../external/js/bootstrap.js"></script>
<script src="../twbs/jquery.twbsPagination.js" type="text/javascript"></script>
<script>
    var line=<?php print json_encode($line);?>||0;
    //console.log(line);
   $("#tabmain").find("tr:gt(0)").remove();
    $("#tabmain tr:eq(0)").after(line);
   
</script>
<!-- <p><?php //print $wq;?></p> -->
<p>SHOWING <?php print $page+1;?>OF <?php print $ttlpages;?></p>
<p>SHOWING <?php print intval($page)*intval($records)."-".intval($page+1)*intval($records);?> OF <?php print $fullcount;?></p>
    <table id="tabmain">
   
   <tr>
       
       <th>BARCODE</th>
       <th>REFERENCE</th>
       <th>ART NO</th>
       <th>CATAGORY</th>
       <th>SIZE</th>
       <th>INSEAM</th>
       <th>COLOR</th>
       <th>QTY</th>
       <th>PKD</th>
       <th>SERIES</th>
       <th>MRP</th>
       <th>LOCATION</th>
       <th>FIT</th>
       <th>INWARD DATE</th>
       
       
   </tr>

   <tr>
       <td colspan="7">
           TOTAL PCS INWARDS
       </td>
       <td id="total_pcs"></td>
   </tr>
   
</table>
    </div>
    
    <br>

    
    