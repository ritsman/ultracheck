<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//================================================

$pono=get_new_pono22($EBH,'central');
$chlno="CO-".$pono;
//echo $pono;




?>
<style>
input#dtd{
    width: 90%;
}

</style>

<script type="text/javascript">
var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='sendGoods' onclick='track(this)'>Challan</a></li>";
    auxul += "<li><a href=\"#\" id='chlnsumm' onclick='track(this)'>Challan Sum</a></li>";
    auxul += "<li><a href=\"#\" id='billing' onclick='track(this)'>Bill</a></li>";
    auxul += "<li><a href=\"#\" id='returnSales' onclick='track(this)'>Return Sales</a></li>";
   
    auxul += "<li><a href=\"#\" id='salesRep' onclick='track(this)'>Print Bill</a></li>";
    auxul += "<li><a href=\"#\" id='salesRepRe' onclick='track(this)'>Credit Note</a></li>";
    auxul += "<li><a href=\"#\" id='viewsales' onclick='track(this)'>Sales Report</a></li>";
    auxul += "<li><a href=\"#\" id='apptrans' onclick='track(this)'>Approve Transfer</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });

    
    var chlno=<?php print json_encode($chlno);?>;
    
    
    
    $(document).ready(function(){
        
        $("#dtd").datepicker({ dateFormat: 'dd/mm/yy' });
        
        $("#chlno").html(chlno);           
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
<div class="container-fluid">
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
    <hr>
    <h4>PACKING LIST OF GOODS DESPATCHED FROM CENTRAL <span id="shopname"/></span></h4>
    <br><div id="counterpcs"></div><br>
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
            <th>FIT</th>
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
    <button type="button" name="updBar" id="updBar" class="btn btn-info">TRANSFER GOODS</button>
    <form id="POForm" class="noshow" action="R_sendGoods.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>
    <script>
        $(document).ready(function(){
            $("#sono2").focus();
        });
        var bcin=[];
        var total_count=0;
        var row="";
        var invtab="Q__stk__CENTRAL";
        console.log("+++++++++");
        console.log(bcin);
        console.log(row);
        console.log("+++++++++");
        var carton_number=1;
        var jk=document.getElementById("sono2");
        jk.addEventListener('keypress', function (e) {
        //alert("K");
        if (e.keyCode === 13) {
            
            $.uniqueSort(bcin);
            var t=$('#sono2').val();
               
                $("#sono2").val('');
                $("#sono2").focus();
                // get the barcode decoded 
                var k=$.inArray(t,bcin);
                //alert(k);
                //console.log(bcin);
                if(k===-1){
                    $.post("fetch_barcode_data_out.php",{data:t,invtab:invtab},function(rt){
                        console.log(rt);
                        
                        var r=JSON.parse(rt);
                        //console.log(r);
                        row="<tr><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td>";
                        row+="<td dirname='direct_id' class='bc' id='"+r.tname+"'>"+r.barcode+"</td><td>"+r.sono2+"</td>";

                        if(r.barcode!==""){
                            row+="<td>"+r.artno+"</td>";
                            var cmaux="";
                                if(r.szcm!=='0'){
                                        cmaux="/"+r.szcm+" CM";
                                }else{
                                    cmaux="";
                                }
                            row+="<td>"+r.cat+"</td><td>"+r.sz+cmaux+"</td>";
                            row+="<td>"+r.inseam+"</td><td>"+r.shade+"</td>";
                            row+="<td>"+r.qty+"</td><td>"+r.pkd+"</td>";
                            row+="<td>"+r.series+"</td><td>"+r.mrp+"</td>";
                            row+="<td>"+r.fit+"</td>";
                            row+="<td><input type='text' class='ctn' title='ctn' value='"+carton_number+"' onchange=\"update_ctn(this)\"/></td>";
                            total_count++;
                            
                        }
                       
                        $("#tabmain tr:eq(0)").after(row);
                        $("td#total_pcs").html(total_count);
                        $("div#counterpcs").html(total_count);
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
    if($("#tabmain tr").length<3){
        alert("NO Barcode Present");
        return false;
    }
    var data=check_and_collect_values("#tabmain")
    var shop=$("#sel_shop").val();
    if(shop=='SELECT'){
        alert("SELECT LOCATION");
        return false;
    }
    var dtd=$("#dtd").val();
    if(dtd==''){
        alert("SELECT DATE");
        return false;
    }else{
        var dtd2=dtd.split("/").reverse().join("-");
    }
    var d={
        'shop':shop,
        'ch_dt':dtd2,
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
        $("#updBar").css("display","none");
    }
});
    </script>