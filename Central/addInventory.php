<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');

// all sales order
$sono=get_sono_list($DBH);

//var_export($sono);
//echo '<hr>';

$shades=get_shade_all($DBH);

$artno=get_articleno($EBH);
//var_export($artno);



?>

<script type="text/javascript">
var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='addInventory' onclick='track(this)'>Fresh</a></li>";
    auxul += "<li><a href=\"#\" id='addTrans' onclick='track(this)'>Transfer Inwards</a></li>";
    auxul += "<li><a href=\"#\" id='chlnsuminwd' onclick='track(this)'>Challan Summary</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });
    
    var sono=<?php print json_encode($sono);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    //console.log(sono);
    var sel_options='';
    $.each(shades,function(i,v){
        sel_options+="<option>"+v+"</option>";
    });
    
    $(document).ready(function(){
        

        $("#artno").autocomplete({
            source:artno
        });

        $("#sel_shade").append(sel_options);
        
    });
    $(document).ready(function(){
               
     var dt2=tdt();
     $("td#dtd2").append(dt2);
    });
/*
* load series options on change of catagory
*/

var series_val={
    'A2':['ANTHAM','BERLIN','CAIRO','DURBAN','EPIC','UBER'],
    'A3':['HOST','INOX','JOR','KEVIN','LUCAS'],
    'A4':['MOON','OPUS','PLUS','QUARK'],
    'A5':['VOLT','WINE','NENO'],
    'A6':['ALEXA','BELLY','CHAMU','DIVA'],
    'A7':['ERA','FURY','GAMMA','HEXA'],
    'A8':['PLAZZO'],
    'A9':['IKIA','JAZZ']
};

function load_series(ele){
    //console.log(series_val);
    var cat=$(ele).val().toString();
    
    var series_options=series_val[cat];
    var opt="<option>SELECT</option>";
    $.each(series_options,function(i,v){
        opt+="<option>"+v+"</option>";
        
    });
    $("#sel_series")
        .empty()
        .append(opt);

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
                CENTRAL LOCATION
            </th>
        </tr>
        <tr>
            <td><input type="text" name="sono2" id="sono2" ></td>
            <td><select name="sel_rack" id="sel_rack" title="sel_rack" class="form-control">
                <option>SELECT</option>
                <option>R1</option>
                <option>R2</option>
                <option>R3</option>
                <option>R4</option>
                <option>R5</option>
                <option>R6</option>
            </select></td>
        </tr>
    </table>
    <hr>
    <h4>FRESH GOODS INWARDS IN CENTRAL WAREHOUSE</h4>
    <div id="counterpcs"></div>
    <br><br>
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
            <th>LOCATION</th>
            <th>FIT</th>
            
            
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
    <button type="button" name="updBar" id="updBar" class="btn btn-info">UPDATE STOCK & LOCATION</button>
    <form id="POForm" class="noshow" action="R_addInventory2.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>
    <script>
        $(document).ready(function(){
            $("#sono2").focus();
        });
        var bcin=[];
        var row="";
        var total_count=0;
        var invtab="Q__stk__CENTRAL";
        console.log("--------");
        console.log(bcin);
        console.log(row);
        console.log("----------");
        var jk=document.getElementById("sono2");
    jk.addEventListener('keypress', function (e) {
        //alert("K");
        if (e.keyCode === 13) {
            $.uniqueSort(bcin);
            var t=$('#sono2').val();
                if(t==''){
                    return false;
                }
               
                $("#sono2").val('');
                $("#sono2").focus();
                // get the barcode decoded 
                var k=$.inArray(t,bcin);
                //alert(k);
                //console.log(bcin);
                if(k===-1){
                    $.post("fetch_barcode_data_in.php",{data:t,invtab:invtab},function(rt){
                        console.log(rt);
                        //return false;
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
                            row+="<td>"+r.location+"</td>";
                            row+="<td>"+r.fit+"</td>";
                            total_count++;
                        }
                       
                        $("#tabmain tr:eq(0)").after(row);
                        $("td#total_pcs").html(total_count);
                        $("div#counterpcs").html(total_count);
                        e.preventDefault();
                    });
                }else{
                    alert("Barcode: "+ t+"Already Present");
                    return false;
                }
                bcin.push(t);
                
            
        }

    //console.log(e.keyCode);
    //console.log("---")

}, false);
console.log("--------");
        console.log(bcin);
        console.log(row);
        console.log("----------");

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
    
    
    //console.log(bcin);
}

//------collect and save the barcode for inwards
$("#updBar").click(function(){
    if($("#tabmain tr").length<3){
        alert("NO Barcode Present");
        return false;
    }
    var data=check_and_collect_values("#tabmain")
    var rack=$("#sel_rack").val();
    if(rack=='SELECT'){
        alert("SELECT LOCATION");
        return false;
    }
    //console.log(rack);
    
    if(data.goahead=='yes'){
        data=JSON.stringify(data);
        console.log(data);
        $("#holder1").val(data);
        $("#holder2").val(rack);
        $("#POForm").submit();
    }
});
    </script>