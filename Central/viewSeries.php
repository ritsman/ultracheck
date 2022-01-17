<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//==================================================
$q="select distinct catagory from `Q__seriesmrp` order by catagory";
$stm=$EBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $cat[]=$r['catagory'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($cat);
//echo '<hr>';

?>

<script type="text/javascript">
var cat=<?php print json_encode($cat);?>||0;
var opt="";
$.each(cat,function(i,v){
    opt+="<option>"+v+"</option>";
});
$(document).ready(function(){
    $("#sel_cat").append(opt);
});

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
            <th>SELECT CATAGORY</th>
            
            
        
            <th>
                SERIES
            </th>
            
        </tr>
        <tr>
            <td><select name="sel_cat" id="sel_cat" class="form-control">
            <option>SELECT</option>
            
            </select></td>
            <td><button type="button" name="barstory" id="barstory" class="btn btn-info">SHOW</button></td>
        </tr>
    </table>
    <hr>
    
    
    
    <br>
    <div id="showdata"></div><br>

    <script>
        $("#barstory").click(function (){
            var cat=$("#sel_cat").val();
            $("#showdata").load("P_viewSeries.php",{cat:cat});


        });
    </script>
    
   