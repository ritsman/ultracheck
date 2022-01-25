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
                SEE STORY
            </th>
        </tr>
        <tr>
            <td><input type="text" name="sono2" id="sono2" ></td>
            <td><button type="button" name="barstory" id="barstory" class="btn btn-info">STORY</button></td>
        </tr>
    </table>
    <hr>
    
    
    
    <br>
    <div id="showdata"></div><br>

    <script>
        $("#barstory").click(function (){
            var bar=$("#sono2").val();
            $("#showdata").load("P_viewBarcode.php",{bar:bar});


        });
    </script>
    
   