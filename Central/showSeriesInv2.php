<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$location=$_GET['location'];
//$series=$_POST['holder1'];
$series=$_GET['series'];
echo $series."---".$location."--RESERVED";
echo "<br>SHOW IMAGE: <input type='checkbox' id='showimg'/>";

$q="select distinct artno from `Q__stk__$location` where series = '$series' and location like 'CO%'";
//echo $q;
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $artno[]=$r['artno'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo "<br>1.".$th->getMessage();
}
//var_export($artno);
//echo '<hr>';
$q2="select distinct sz from `Q__stk__$location` where series = '$series' order by sz";
//echo $q2;
$stm=$DBH->prepare($q2);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $sizes[]=$r['sz'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo "<br>2.".$th->getMessage();
}
//var_export($sizes);
//echo '<hr>';

$head="<div class='pageShow2'><table><tr><th>ARTNO</th><th>COLOR</th><th>IMAGE</th>";
foreach($sizes as $s){
    $head.="<th>$s</th>";

}
$head.="</tr>";
echo $head;

function get_shade22($artno,$DBH){
    $data=[];
    $q="select distinct shade from `Q__artno__sz` where artno='$artno'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r['shade'];
        }
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $data;
}
// get reciver and sender of challan frm location
function get_recv_loc($DBH,$challan){
    $q="select fromm,too from Q__challan_main where pono='$challan'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $recv=$stm->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $rcv['fromm']='';
        $rcv['too']='';
    }
    return $recv;
}
function get_sz_total($sz_array,$location,$i,$artno,$DBH,$series,$shade){
    $q="select sum(qty) as tp,location from `Q__stk__$location` where artno='$artno' and series='$series' and shade='$shade' and sz='".$sz_array[$i]."' and location like 'CO%' group by location";
    //echo "<br>$q";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $ds=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }

    $line="<td>".intval($ds['tp'])."</td>";
    if($ds['location']){
        $rcv=get_recv_loc($DBH,$ds['location']);
        $line2="<td>$ds[location]<br>($rcv[fromm]--$rcv[too])</td>";
    }
    
    echo $line;
    $i++;
    if($i<count($sz_array)){
        get_sz_total($sz_array,$location,$i,$artno,$DBH,$series,$shade);
    }
    echo $line2;

}

//
function get_sz_pcs($location,$artno_array,$DBH,$counter,$counter2,$series,$sizes,$img){
    
    echo isset($line);
    // shades of this artno
    $shade=get_shade22($artno_array[$counter],$DBH);
    foreach($shade as $s){
        
        $line="<tr><td>".$artno_array[$counter]."</td>";
        $line.="<td>$s</td>";
        if($img==1){
            $pic=get_image($artno_array[$counter],$s,$DBH);
            $line.="<td><a href=\"$pic\" target='_blank'><img src='".$pic."' class='img-thumbnail imgsz'/></a></td>";
        }else{
            $line.="<td></td>";
        }
        
        echo $line;
        get_sz_total($sizes,$location,$counter2,$artno_array[$counter],$DBH,$series,$s);
    }
    
    $counter++;
    if($counter<count($artno_array)){
        get_sz_pcs($location,$artno_array,$DBH,$counter,$counter2,$series,$sizes,$img);
    }

}
// get the image name
function get_image($artno,$shade,$DBH){
    $q="select picname from `Q__artno__pic` where artno='$artno' and shade='$shade'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $picname=$stm->fetch(PDO::FETCH_ASSOC);
        }else{
            $picname['picname']="../artno/default.jpg";
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $picname['picname'];
}

//get_sz_pcs($location,$artno,$DBH,0,0,$series,$sizes,$img);

?>
<head>
<title>ARTNO-STOCK</title>
</head>
<link rel="stylesheet" href="../style/css-reset.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
<link rel="stylesheet" href="../style/style.css">
<script src="../JQ/jquery-1.12.0.js"></script>
<script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<style type="text/css">
.imgsz{
    /* border:2px solid red; */
    width:150px;
    height:150px;
}


</style>
<div id="showdata">
    
</div>
<script>
    var loc=<?php print json_encode($location);?>;
    var series=<?php print json_encode($series);?>;
    $("#showimg").click(function(){
        var cl=$(this).prop("checked");
        //alert(cl);
        if(cl){
            $("div#showdata").load("P_showSeriesInv2.php",{img:1,loc:loc,series:series});
        }else{
            $("div#showdata").load("P_showSeriesInv2.php",{img:0,loc:loc,series:series});
        }
    });

    $(document).ready(function(){
        $("#showdata").load("P_showSeriesInv2.php",{img:0,loc:loc,series:series});
    });
</script>