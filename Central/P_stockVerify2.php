<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$EBH2=new dbconnect();
$EBH=$EBH2->con('ultra');
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//================================================
//var_export($_SESSION);
//echo '<hr>';
$series=$_POST['series'];
//echo $series;

//var_export($dataM);
//echo '<hr>';
$q="select * from `Q__stk__CENTRAL` where series='$series'";

//echo $q;
//return false;
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
//return false;
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
    $line.="<td>$d[location]</td></tr>";
    $count++;
   
}

//$q2="select id,`GITAMANDIR` from `S__stkverify` where id=(select max(id) from `S__stkverify` where gitamandir is not null)";
$q2="select `central` from `S__stkverify` where id=(select max(id) from `S__stkverify` where `central` is not null and series='$series')";
//return false;
//echo $q2;
$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $scn_pcs=$r['central'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
// var_export($scn_pcs);
// echo '<hr>';
// echo json_encode($scn_pcs);
// return false;

?>
<style>
    .red{
        color:red;
    }
</style>
<script>
    var line=<?php print json_encode($line);?>||0;
    var count=<?php print $count;?>||0;
    $("#tabmain tr:eq(-1)").before(line);
    $("#total_pcs").html(count);
</script>
<div class="container-fluid">
    <div class="row red">
        <div id="unfound">

        </div>
    </div>
<div class="pageShow2">
    <div class="row d-flex mb-4 justify-content-center">
        <div class="col-md-6">
        <input type="text" name="sono2" id="sono2" class="mx-5">
        </div>
        <div class="col-md-6" >
            <span id="canned"></span>/ <span id="total_pcs"></span>
        </div>
    
    </div>
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

    



<style>
input#dtd{
    width: 90%;
}


    #tabmain input[type='text']{
        width:90%;
    }
    #sono2{
        width:90%;
    }
</style>

    
    <form id="POForm" class="noshow" action="R_stockVerify.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        <input type="text" id="holder3" name="holder3" class="noshow"/>
      </form>
      <iframe class="noshow1" id="if33" name="if33" style="width:600px"></iframe>
    <script>
        $(document).ready(function(){
            $("#sono2").focus();
        });
        var bcin=[];
        var total_count=0;
        var row="";
        var invtab="Q__stk__CENTRAL";
        var updated_scn_pcs=[];
        var unfound_pcs=[];
        //var scn_pcs=[];
        scn_pcs=JSON.parse(<?php print json_encode($scn_pcs)?>)||[];
        console.log('OOOOOOOOOOO');
        console.log(typeof(scn_pcs[0]));
        
        $(document).ready(function(){
            $("#tabmain tr:not(:eq(0))").each(function(){
                            var b=$(this).find("td:eq(0)").text();
                            var bc=parseInt(b);
                            if($.inArray(bc,scn_pcs)!==-1){
                                $(this).css("background","#e6e600");
                                updated_scn_pcs.push(bc);
                                
                            }
                            
           });
            $("#canned").html(scn_pcs.length+"--"+updated_scn_pcs.length);
        });
        



        console.log("+++++++++");
        console.log(scn_pcs);
        console.log(row);
        console.log("+++++++++");
        var carton_number=1;
        var jk=document.getElementById("sono2");
        jk.addEventListener('keypress', function (e) {
        //alert("K");
        if (e.keyCode === 13) {
            
            $.uniqueSort(scn_pcs);
            var t1=$('#sono2').val();
            var t=parseInt(t1);
                $("#sono2").val('');
                $("#sono2").focus();
                // get the barcode decoded 
                var k=$.inArray(t,scn_pcs);
                //alert(k);
                console.log("PPPPPPPPPPPP");
                console.log(scn_pcs);
                //console.log(bcin);
                if(k===-1){
                    $.post("../Central/fetch_barcode_data_out.php",{data:t,invtab:invtab},function(rt){
                        console.log(rt);
                        
                        var r=JSON.parse(rt);
                        console.log(r);
                        row="<tr><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td>";
                        row+="<td dirname='direct_id' class='bc' id='"+r.tname+"'>"+r.barcode+"</td><td>"+r.sono2+"</td>";
                        if(r.barcode!==""){
                            $("#tabmain tr:not(:eq(0))").each(function(){
                            var b=$(this).find("td:eq(0)").text();
                            var bc=parseInt(b);
                            if(bc==r.barcode){
                                $(this).css("background","#00cc44");
                                scn_pcs.push(bc);
                                updated_scn_pcs.push(bc);
                                $("#canned").html(scn_pcs.length+"--"+updated_scn_pcs.length);
                                // bring this row in front and delete its orignal
                                $("#tabmain tr:eq(1)").before(this);
                            }
                            
                            });
                        }else{
                            unfound_pcs.push(t);
                            $("div#unfound").append(t+' ');
                        }
                        
                        
                       
                        //$("#tabmain tr:eq(0)").after(row);
                        //$("td#total_pcs").html(total_count);
                        //$("div#counterpcs").html(total_count);
                        bcin.push(t)
                        e.preventDefault();
                    });
                }else{
                    alert("Barcode: "+ t+" Already Present");
                    return false;
                }
                
                
            
        }

    //console.log(e.keyCode);
    //console.log("---")

}, false);
console.log("+++++++++");
        console.log(bcin);
        console.log(row);
        console.log("+++++++++");



//------collect and save the barcode for inwards
$("#updBar").click(function(){
    console.log("pressed updbar");
    console.log(scn_pcs);
    console.log(scn_pcs.length)
    var series=$("#series_name").val();
       data=JSON.stringify(scn_pcs);
    //     console.log(data);
      $("#holder1").val(data);
     $("#holder2").val(series);
        $("#POForm").submit();
    //     $("#updBar").css("display","none");
   
});

// reset the collection 
$("#delBar").click(function(){
    //alert("n");
    scn_pcs=[];
    $("#tabmain tr:not(:eq(0))").each(function(){
         $(this).css("background","none");
    });
                                
        
});
    </script>