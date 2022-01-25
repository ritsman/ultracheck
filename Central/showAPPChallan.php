<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$desti_outlet=$_POST['holder3'];
$outlet=$_POST['holder2'];
$chlno=$_POST['holder1'];
echo $chlno."---FROM ".$outlet."--TO--".$desti_outlet;
$q="select * from `Q__stk__$outlet` where location like '$chlno%'";
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
//var_export($data[0]);
//echo '<hr>';

$head="<div class='pageShow2'><table id='chktbl'><tr><th>REFERENCE</th><th>BARCODE</th>";
$head.="<th>CATAGORY</th><th>ARTICLE NO</th><th>SERIES</th><th>COLOR</th>";
$head.="<th>SIZE</th><th>FIT</th><th>PACKED</th><th>MRP</th>";
$head.="<th>QTY</th><th>APPROVE<br><input type='checkbox' id='chkall' onclick='chk_all(\"#chktbl\",this)'</th>";

echo $head;
$total=0;
foreach($data as $d){
    $line="<tr><td>$d[sono2]</td><td>$d[barcode]</td>";
    $line.="<td>$d[cat]</td><td>$d[artno]</td><td>$d[series]</td>";
    $line.="<td>$d[shade]</td><td>$d[sz]</td><td>$d[fit]</td><td>$d[pkd]</td>";
    $line.="<td>$d[mrp]</td>";
    $line.="<td>$d[qty]</td>";
    $line.="<td><input type='checkbox' class='chkit' id='$d[id]'/></td>";
    echo $line;
    $total=$total+intval($d['qty']);
}

$cline="<tr><td colspan='9'></td><td>TOTAL</td><td>$total</td>";
echo $cline;

echo "<input type=\"button\" value=\"APPROVE\" id=\"submit\"/>";
echo "<div id='response'></div>";
?>
<head>
<title>APPROVE TRANSFER</title>
</head>
<link rel="stylesheet" href="../style/css-reset.css">
<link rel="stylesheet" href="../bootstrap/bootstrap.css">
<link rel="stylesheet" href="../style/style.css">

<script src="../JQ/jquery-1.12.0.js"></script>
<script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../methods/fun.js"></script>


<script>
var chlno=<?php print json_encode($chlno);?>;
var outlet=<?php print json_encode($outlet);?>;
var desti_outlet=<?php print json_encode($desti_outlet);?>;
    $("#submit").click(function(){
        //alert("c");
        var c=[];
        var napcs=[];
        console.log(outlet,desti_outlet);
        $("#chktbl tr:not(:eq(0),:eq(-1))").each(function(){
            if($(this).find("td:eq(-1) input.chkit").prop("checked")){
                var id=$(this).find("td:eq(-1) input.chkit").attr("id");
                console.log("id: "+id);
                c.push(id);
            }else{
                var id=$(this).find("td:eq(-1) input.chkit").attr("id");
                console.log("id: "+id);
                napcs.push(id);

            }
            
        });
        c=JSON.stringify(c);

        $.post("P_showAPPChallan.php",{c:c,outlet:outlet,desti_outlet:desti_outlet,chlno:chlno,napcs:napcs},function(data){
            console.log(data);
            $("#response").html(data);
        });
        $(this).css("display","none");
    });
</script>