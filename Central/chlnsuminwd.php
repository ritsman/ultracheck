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

    var chlno=<?php print json_encode($chlno);?>;
    
    
    
    $(document).ready(function(){
        
        $("#dtd").datepicker({ dateFormat: 'dd/mm/yy' });
        $("#dtd2").datepicker({ dateFormat: 'dd/mm/yy' });
        
        $("#chlno").html(chlno);           
    });


function load_shop(ele){
    //console.log(series_val);
    var shop=$(ele).val().toUpperCase();
    //var t="TO: "+shop;
    $("#shopname").html(shop);
    
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
            <th>
                SELECT FRANCHISE
            </th>
            
            <th>
                CHALLAN DATE FROM
            </th>
            <th>
                CHALLAN DATE TO
            </th>
            <th>SHOW DATA</th>
        </tr>
        <tr>
            
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
            
            
            <td><input type="text" name="dtd" id="dtd" title="chl_dt" ></td>
            <td><input type="text" name="dtd2" id="dtd2" title="chl_dt2" ></td>
            <td>
            <button type="button" name="updBar" id="updBar" class="btn btn-info">SHOW</button>
            </td>
        </tr>
    </table>
    <form id="POForm"  class="noshow" action="showChallanInwd.php" target="_blank" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
    </form>


    <hr>
    <h4>CHALLAN LIST OF GOODS DESPATCHED FROM <span id="shopname"></span> TO CENTRAL </h4>
    <br><div id="showdata"></div><br>
    
    <script>
        $("#updBar").click(function(){
            var outlet=$("#sel_shop").val();
            var dt=$("#dtd").val();
            var dtd=dt.split("/").reverse().join("-");
            var dt2=$("#dtd2").val();
            var dtd2=dt2.split("/").reverse().join("-");
            $("#showdata").load("P_chlnsummInwd.php",{outlet:outlet,dtd:dtd,dtd2:dtd2});

        });
    </script>
    