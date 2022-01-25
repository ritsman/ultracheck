<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
// get total pcs stock in location
function get_pcs($location,$series,$DBH){
    $invtable="Q__stk__$location";
    $q="";
    switch($location){
        case "RESERVE":
            $q="select sum(qty) as tpcs from `Q__stk__CENTRAL` where series='".addslashes($series)."' and location like 'CO-%'";
        break;
        case "CENTRAL":
            $q="select sum(qty) as tpcs from `$invtable` where series='".addslashes($series)."' and location not like 'CO-%'";
        break;
        default:
        $q="select sum(qty) as tpcs from `$invtable` where series='".addslashes($series)."' ";
        break;
    }
   
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $qty=$stm->fetch(PDO::FETCH_ASSOC);
        $qty2=intval($qty['tpcs']);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $qty2=0;
    }
    
    return $qty2;
}
// show table
$headline="<div class='pageShow2'><table><tr>";
$headline.="<th>SERIES</th><th>RESERVED</th><th>CENTRAL</th><th>PALSANA</th><th>VATVA</th>";
$headline.="<th>HIMMATNAGAR</th><th>VISHNAGAR</th><th>GITAMANDIR</th>";
$headline.="<th>VATVAGIDC</th><th>KAMREJ</th><th>JAHGIRPURA</th><th>SERIES TOTAL</th>";
echo $headline;

// get started with series
$q="select distinct series from `Q__seriesmrp`";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r['series'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data);
//echo '<hr>';
$central_total=0;
$vatva_total=0;
$reserve_total=0;
$palsana_total=0;
$hmt_total=0;
$vishnagar_total=0;

$gitamandir_total=0;
$vatvagidc_total=0;
$kamrej_total=0;
$jahgirpura_total=0;

foreach($data as $d){
    $row_total=0;
    $line="<tr><td>$d</td>";
    echo $line;
    $central=get_pcs('RESERVE',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv2.php?series=$d&location=CENTRAL\" >$central</a></td>";
    $reserve_total=$reserve_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('CENTRAL',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=CENTRAL\" >$central</a></td>";
    $central_total=$central_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('PALSANA',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=PALSANA\" >$central</a></td>";
    $palsana_total=$palsana_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('VATVA',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=VATVA\" >$central</a></td>";
    $vatva_total=$vatva_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('HMT',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=HMT\" >$central</a></td>";
    $hmt_total=$hmt_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('VISHNAGAR',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=VISHNAGAR\" >$central</a></td>";
    $vishnagar_total=$vishnagar_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('GITAMANDIR',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=GITAMANDIR\" >$central</a></td>";
    $gitamandir_total=$gitamandir_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('VATVAGIDC',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=VATVAGIDC\" >$central</a></td>";
    $vatvagidc_total=$vatvagidc_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('KAMREJ',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=KAMREJ\" >$central</a></td>";
    $kamrej_total=$kamrej_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    $central=get_pcs('JAHGIRPURA',$d,$DBH);
    $line="<td><a target='_blank' href=\"showSeriesInv.php?series=$d&location=JAHGIRPURA\" >$central</a></td>";
    $jahgirpura_total=$jahgirpura_total+$central;
    $row_total=$row_total+$central;
    echo $line;
    echo "<td>$row_total</td>";
}
$bottom_line="<tr><td>TOTAL</td><td>$reserve_total</td><td>$central_total</td><td>$palsana_total</td>";
$bottom_line.="<td>$vatva_total</td><td>$hmt_total</td><td>$vishnagar_total</td>";
$bottom_line.="<td>$gitamandir_total</td><td>$vatvagidc_total</td><td>$kamrej_total</td>";
$bottom_line.="<td>$jahgirpura_total</td>";
echo $bottom_line;

?>

<script>
    function open_art(ele){
        //alert("ll");
        var series=$(ele).attr("id");
        var location=$(ele).attr("class");
        console.log(series+"--"+location);
        $("#holder1").val(series);
        $("#holder2").val(location);
        $("#POForm2").submit();
    }
</script>