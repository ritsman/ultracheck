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
$self_outlet="CENTRAL";
//echo $self_outlet;
$pono=get_new_pono22($DBH,'central');
$chlno="CO-".$pono;
//echo $pono;


$bill_field=strtolower($self_outlet);
$pono=get_new_challan($DBH,$bill_field);
$bill_prefix=get_bill_prefix($DBH,$bill_field);
$chlno=$bill_prefix."O-".$pono;
//echo $pono;

//var_export($dataM);
//echo '<hr>';
$q="select * from `Q__stk__$self_outlet` where status='START' ";

echo $q;

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
// get previous scan result;;;
//select * from `S__stkverify` where  palsana is not null and id=(select max(id)) 
$q2="select `$self_outlet` from `S__stkverify` where `$self_outlet` is not null and id=(select max(id)) ";
//echo $q2;
$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $scn_pcs=$r["$self_outlet"];
    }
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
}
//var_export($scn_pcs);
//echo '<hr>'
//echo json_encode($scn_pcs);
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
    <table id="maintab">
        <tr >
            <th>SCAN BARCODE</th>
            
            
        
            <th>
                SELECT FRANCHISE
            </th>
            <th>
                CHALLAN NO
            </th>
            <th>
                CHALLAN DATE
            </th>
        </tr>
        <tr>
            <td><input type="text" name="sono2" id="sono2" ></td>
            <td><select name="sel_shop" id="sel_shop" title="sel_shop" class="form-control" onchange="load_shop(this)">
                <option>SELECT</option>
                <option>PALSANA</option>
                <option>VATVA</option>
                <option>HMT</option>
                <option>VISHNAGAR</option>
                <option>VATVAGIDC</option>
                <option>GITAMANDIR</option>
                <option>KAMREJ</option>
                <option>JAHGIRPURA</option>
                
            </select></td>
            <td id="chlno"></td>
            
            <td><input type="text" name="dtd" id="dtd" title="chl_dt" ></td>
            </td>
        </tr>
    
    </table>
    <div id="response"></div><br>
    <button type="button" name="updBar" id="updBar" class="btn btn-info">SAVE LIST</button>
    <button type="button" name="delBar" id="delBar" class="btn btn-info">RESET</button>
    <button type="button" name="expBar" id="expBar" class="btn btn-info">EXPORT</button>
<br><br>
<h4>CURRENT INVENTORY IN <?php print $self_location;?> OUTLET</h4>

    <nav aria-label="Page navigation">
        <ul class="pagination" id="pagination"></ul>
    </nav>

    <br><h5>TOTAL PCS: <span id="canned"></span>/<?php print $count;?></h5>
    <br>
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

</style>

<script type="text/javascript">

    
    var chlno=<?php print json_encode($chlno);?>;
    var self_outlet=<?php print json_encode($self_outlet);?>;
    
    
    $(document).ready(function(){
        
        $("#dtd").datepicker({ dateFormat: 'dd/mm/yy' });
        
        $("#chlno").html(chlno); 
        // remove the self_shop so that goood ar not send to itself accidently
        console.log(self_outlet);
        //$("#sel_shop").children("option:contains(\""+self_outlet+"\")").remove();  option[text="B"]' 
       
        $("#sel_shop option").each(function(){
            var g=$(this).val();
            //console.log(g);
            if(g==self_outlet){
                $(this).remove();
            }
        });
       
        //$("#sel_shop").find("option").text('PALSANA').remove();
    });


function load_shop(ele){
    //console.log(series_val);
    var shop=$(ele).val().toUpperCase();
    var t="TO: "+shop;
    $("#shopname").html(t);
    
}


</script>
<style>
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
        var invtab="Q__stk__"+self_outlet;
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

function remove_row(ele){
    var t=$(ele).parent().next().text();
    bcin=$.grep(bcin,function(value){
        return value!=t;
    });
    console.log(t);
    $(ele).parent().parent().remove();
    if(t!==''){
        total_count--;
        $("td#total_pcs").html(total_count);
        $("div#counterpcs").html(total_count);
    }
}
// update carton no
function update_ctn(ele){
    carton_number=$(ele).val();
    //console.log(carton_number);
    return carton_number;
}

//------collect and save the barcode for inwards
$("#updBar").click(function(){
    console.log("pressed updbar");
    console.log(scn_pcs);
    console.log(scn_pcs.length)
    
       data=JSON.stringify(scn_pcs);
    //     console.log(data);
      $("#holder1").val(data);
     $("#holder2").val(self_outlet);
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