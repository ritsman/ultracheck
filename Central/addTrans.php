<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//================================================
$outlet=strtoupper($_SESSION['frn']);
$pono=get_new_pono22($EBH,'central');
$chlno="CO-".$pono;
//echo $pono;

$q="select pono,pcs from `Q__challan_main` where too='$outlet'";
//echo $q;
$stm=$EBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $chl_all[]=$r['pono'];
        $pcs_all[]=$r['pcs'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}



?>
<style>
input#dtd{
    width: 90%;
}
</style>

<script type="text/javascript">
    var outlet=<?php print json_encode($outlet);?>;
    var chlno=<?php print json_encode($chlno);?>;
    var series_options=<?php print json_encode($chl_all);?>||0;
    console.log(series_options);
    var pcsall=<?php print json_encode($pcs_all);?>||0;
    
    console.log(pcsall);
    


    $(document).ready(function(){
        var opt="<option>SELECT</option>";
        $.each(series_options,function(i,v){
            opt+="<option>"+v+"</option>";
            
        });
        $("#sel_series")
            .empty()
            .append(opt);


    });
   function load_bc(ele,usr){
       var chlno=$(ele).val();
       //var usr="PALSANA";
       //var usr=outlet;
       $("#shopname").html(chlno);
       $.post("P_addTrans.php",{chlno:chlno,location:usr},function(data){
            console.log(data);
            //return false;
            data=JSON.parse(data);
            //console.log(data);
            $("#tabmain tr:not(:eq(0),:eq(-1))").remove();
            $("#tabmain tr:eq(0)").after(data.line);
            $("td#total_pcs").html(data.count);
            
            $("#counterpcs").html(data.count);
            load_bc_data();
           
       });
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
<div class="container-fluid">
<div class="pageShow2">
    <table id="maintab">
        <tr >
            <th>SCAN BARCODE</th>
            
            
        
            <th>
                SELECT INWARD CHALLAN
            </th>
            
        </tr>
        <tr>
            <td><input type="text" name="sono2" id="sono2" ></td>
            <td><select name="sel_series" id="sel_series" title="sel_series" class="form-control" onchange="load_bc(this,outlet)" >
                <option>SELECT</option>
               
                
            </select></td>
            
        </tr>
    </table>
    <hr>
    <h4>CONFIRM LIST OF GOODS RECIEVED FROM CENTRAL VIA CHALLAN NO: <span id="shopname"/></span></h4>
    <br><div><span id="scanpcs"></span>/<span id="counterpcs"></span></div><br><div id="showcase"></div>
    <table id="tabmain">
        <tr>
            <th>DELETE</th>
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
            <th>CARTON</th>
            
            
        </tr>

        <tr>
            <td colspan="8">
                TOTAL PCS INWARDS
            </td>
            <td id="total_pcs"></td>
        </tr>
        
    </table>
    <br>
    <div id="response"></div><br>
    <button type="button" name="updBar" id="updBar" class="btn btn-info">SAVE & UPDATE STOCK</button>
    <form id="POForm" class="noshow" action="R_addTrans.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>
    <script>
        $(document).ready(function(){
            $("#sono2").focus();
        });
        var bcin={};
        var total_count=0;
        var ttotalpcs=parseInt($("#counterpcs").text());
        function load_bc_data(){
            bcin={};
            // get the list of all barcodes
            $("#tabmain tr:not(:eq(0),:eq(-1))").each(function(i,v){
            var bc=$(this).find("td:eq(1)").attr("class");
            i++;
            bcin[bc]=i;
            });
            //console.log("bc_dtata______");
            //console.log(bcin);
            var showdata="[";
            var showcount=0;
            $.each(bcin,function(i,v){
                //console.log(i,v);
                var short_barcode=i.substring(i,6);
                showdata+=short_barcode+", ";
                showcount++;
                if(showcount%20==0){
                    showdata+="<br>";
                }
            });
            showdata+="]";
            repeat_bc=[];
            total_count=0;
            $("#scanpcs").html(0);
            $("#showcase").html(showdata);
        }
        


var repeat_bc=[];
var jk=document.getElementById('sono2');
    jk.addEventListener('keypress', function (e) {
        //console.log(repeat_bc);
        if (e.keyCode === 13) {
           
            var t=$('#sono2').val();
               
                $("#sono2").val('');
                $("#sono2").focus();
                var k=$.inArray(t,repeat_bc);
                //alert(k);
                if(k===-1){
                    if(t in bcin){
                    //alert("yes");
                    //alert(bcin[t]);
                    //$("#tabmain tr:eq("+bcin[t]+")").find("td:eq(1)").html(t);
                    var cell="tr#"+t+" td:eq(1) ";
                    //console.log("CELL");
                    //console.log(cell);
                    $("#tabmain").find(cell).html(t);
                    total_count++
                    $("#scanpcs").html(total_count);
                    repeat_bc.push(t);

                    // now remove the scanned barcode from showing from the part list;;
                    //console.log("here");
                    //console.log(t);
                    delete bcin[t];
                    var showdata="[";
                    var showcount=0;
                    $.each(bcin,function(i,v){
                    //console.log(i,v);
                    
                    var short_barcode=i.substring(i,6);
                    showdata+=short_barcode+", ";
                    showcount++;
                    if(showcount%20==0){
                        showdata+="<br>";
                    }
                    });
                        showdata+="]";
                        //repeat_bc=[];
                        //total_count=0;
                       
                        $("#showcase").html(showdata);


                    }else{
                        var noline="<tr><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td><td dirname='direct'></td><td>BARCODE: "+t+" NOT IN LIST</td>";
                        $("#tabmain tr:eq(0)").after(noline);
                    }
                
                }else{
                    alert("Barcode: "+ t+"Already Present");
                    return false;
                }
                // get the barcode decoded 
                
                    
                
                
                
            
        }

    //console.log(e.keyCode);
    //console.log("---")

}, false);


function remove_row(ele){
    var t=$(ele).parent().next().text();
    bcin=$.grep(bcin,function(value){
        return value!=t;
    });
    //console.log("b:"+t);
    $(ele).parent().parent().remove();
    
    if((t!=="EMPTY CELL VALUE!")&&(t!=='')){
        //console.log("C:"+t);
        total_count--;
        $("td#total_pcs").html(total_count);
        $("#scanpcs").html(total_count);
    }
}

//------collect and save the barcode for inwards
$("#updBar").click(function(){
    
    if($("#tabmain tr").length<3){
        alert("NO Barcode Present");
        return false;
    }
    var data=check_and_collect_values("#tabmain");
    
    var chlno=$("#sel_series").val();
    if(chlno=='SELECT'){
        alert("SELECT LOCATION");
        return false;
    }
    
    var d={
        'chlno':chlno,
        
        'total_count':total_count
    };
    var d1=JSON.stringify(d);
    //console.log(rack);
    
    if(data.goahead=='yes'){
        data=JSON.stringify(data);
        console.log(data);
        $("#holder1").val(data);
        $("#holder2").val(d1);
        $("#POForm").submit();
        $(this).css("display","none");
    }
});
    </script>