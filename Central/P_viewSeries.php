<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$cat=$_POST['cat'];
echo $cat;


$q="select * from `Q__seriesmrp` where catagory='".addslashes($cat)."'";
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

foreach($data as $d){
    $line.="<tr><td>$d[catagory]</td>";
    $line.="<td>$d[series]</td>";
    $line.="<td>$d[mrp]</td>";
    
   
}

?>
<script>
    var line=<?php print json_encode($line);?>||0;
    
    $("#tabmain").append(line);
    
</script>

    <br><br>
    <table id="tabmain">
    
        <tr>
            
            <th>CATAGORY</th>
            <th>SERIES</th>
            <th>MRP</th>
            
            
            
            
        </tr>

       
        
    </table>
    <br>

   