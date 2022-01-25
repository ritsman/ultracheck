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
    .hide{
        display: none!important;
    }
</style>
<div class="container-fluid">
<div class="pageShow2">
    <table id="maintab">
        <tr>
            <th>SELECT LOCATION</th>
            <th>SEARCH</th>
            <th>SHOW</th>
            
            
        </tr>
        <tr>
            <td><select id="sel_loc" class="form-control">
                <option>SELECT</option>
                <option>CENTRAL</option>
            </select></td>
            <td><input type="text" name="sono2" id="sono2" title="sono2"></td>
            <td>
            <button type="button" name="showinv" id="showinv" class="btn btn-info">SHOW</button>
            </td>
        </tr>
    </table>
    <hr>
    <div id="showdata">
    <nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">1</a></li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item"><a class="page-link" href="#">Next</a></li>
  </ul>
</nav>
   <script>
       $("#showinv").click(function(){
           var data=$("#sel_loc").val();
           console.log(data);
           $("div#showdata").load("P_showInventory.php",{data:data});
       });

       
    </script>