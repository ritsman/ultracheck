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
    $wq="select * from `Q__stk__$location` where 1='1' ";  
}else{
    $q="select * from `Q__stk__$location` where status='CONFM' ";
    $wq="select * from `Q__stk__$location` where status='CONFM' ";
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

// get total count of pcs
$stm=$DBH->prepare($wq);
try {
    $stm->execute();
    $fullcount=$stm->rowCount();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//echo "<br>$sq";
if($location=='CENTRAL'&&$sq==''){
    $q.=$sq." limit 500,2000";
}else{
    $q.=$sq;
}


//echo "<br>$q";
//return false;
$fullcount2=0;
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    $fullcount2=$stm->rowCount();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data);
//echo '<hr>';

$count=0;
foreach($data as $d){
    $line.="<tr><td>$d[id]</td><td>$d[barcode]</td>";
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
echo json_encode($line);
?>
