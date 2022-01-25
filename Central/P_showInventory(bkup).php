<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['data'];
$search_data=json_decode($_POST['search_data'],true);
unset($search_data['goahead']);

//var_export($search_data);
//echo '<hr>';


$location=$_POST['data'];
//var_export($dataM);
//echo '<hr>';
if($location=='CENTRAL'){
    $q="select * from `Q__stk__$location` where 1='1' ";    
}else{
    $q="select * from `Q__stk__$location` where status='CONFM' ";
}
//echo $q;


// make search query
$sq="";
foreach($search_data[3] as $key=>$val){
    if($val!=='0'){
        $sq.="  and `$key` ='".addslashes($val)."' ";
    }
        
    
    
}

//$sq=substr($sq,0,-1);

//echo "<br>1.".$sq;
foreach($search_data[5] as $key=>$val){
    if($val!=='0'&&$key!=='sefrminw_dt'&&$key!=='setoinw_dt'){
        $sq.="  and `$key` ='$val' ";
    }
    
}
//$sq=rtrim($sq,",");
//echo "<br>1.".$sq;
if($search_data[5]['sefrminw_dt']!=='0'&&$search_data[5]['setoinw_dt']!=='0'){
    $sq.=" and (created between '".$search_data[5]['sefrminw_dt']." 00:00:00' and '".$search_data[5]['setoinw_dt']." 23:59:59')";
}
//echo "<br>$sq";
$q.=$sq;
//echo "<br>$q";


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

$line="";
$count=0;
foreach($data as $d){
    $line.="<tr><td>$d[barcode]</td>";
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
   
}

?>
<script>
    // var line=<?php print json_encode($line);?>||0;
    // var count=<?php print $count;?>||0;
    // $("#tabmain tr:eq(-1)").before(line);
    // $("#total_pcs").html(count);
    
</script>
<h4>CURRENT INVENTORY IN <?php print $location;?> WAREHOUSE</h4>
<h5>TOTAL PCS:<?php print $count;?></h5>
    <br><br>
    <table id="tabmain">
    <!-- <tr>
            
            <th><input type="text" id="sebarcode" placeholder="
            BARCODE"/></th>
            <th><input type="text" id="seref" placeholder="
            REFERENCE"/></th>
            <th><input type="text" id="seartno" placeholder="
            ARTNO"/></th>
            <th><input type="text" id="secat" placeholder="
            CATAGORY"/></th>
            <th><input type="text" id="sesz" placeholder="
            SIZE"/></th>
            <th></th>
            <th><input type="text" id="secolor" placeholder="
            COLOR"/></th>
            <th></th>
            <th><input type="text" id="sepkd" placeholder="
            PKD"/></th>
            <th><input type="text" id="seseries" placeholder="
            SERIES"/></th>
            <th><input type="text" id="semrp" placeholder="
            MRP"/></th>
            <th><input type="text" id="selocation" placeholder="
            LOCATION"/></th>
            
            
        </tr> -->
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
    <br>

    <script>
        // $(document).ready(function(){
        //     $("#sono2").on("keyup", function() {
        //         var ttl=0;
        //         var value = $(this).val().toLowerCase();
        //         //console.log(value);
        //         $("#tabmain tr:not(:eq(0))").filter(function() {
                   
        //             $(this).toggle(
        //                 $(this).text().toLowerCase().indexOf(value) > -1);
                   
        //         });
        //     });
        // });
    </script>