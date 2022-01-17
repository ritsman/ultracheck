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
// get sono2
$q1="select distinct sono2 from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q1);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $sono2[]=$r['sono2'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get catagory
$q2="select distinct cat from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q2);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $cat2[]=$r['cat'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get size
$q3="select distinct sz from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q3);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $sz2[]=$r['sz'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get shade
$q4="select distinct shade from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q4);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $shade2[]=$r['shade'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get pkd
$q5="select distinct pkd from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q5);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $pkd2[]=$r['pkd'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get series
$q6="select distinct series from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q6);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $series2[]=$r['series'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}


// get location
$q7="select distinct location from `Q__stk__CENTRAL`";
$stm=$EBH->prepare($q7);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $location2[]=$r['location'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}


?>
<script src="../multiselect-master/multiselect.min.js"></script>
<link href="../multiselect-master/styles/multiselect.css" rel="stylesheet">

<script type="text/javascript">


var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='salesAnalysis' onclick='track(this)'>Catagory</a></li>";
    auxul += "<li><a href=\"#\" id='series_sum2' onclick='track(this)'>--</a></li>";
    
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });
    
    var sono2=<?php print json_encode($sono2);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    var cat2=<?php print json_encode($cat2);?>;
    var sz2=<?php print json_encode($sz2);?>;
    var shade2=<?php print json_encode($shade2);?>;
    var pkd2=<?php print json_encode($pkd2);?>;
    var series2=<?php print json_encode($series2);?>;
    var location2=<?php print json_encode($location2);?>;
    //console.log(sono);
    var sel_options='';
    $.each(shades,function(i,v){
        sel_options+="<option>"+v+"</option>";
    });
    const MENSWEAR=["MEN'S WEAR","WOMEN'S WEAR","BOY'S WEAR","GIRL'S WEAR","KIDS WEAR","LITTLE","ACCESSORIES"];
    $(document).ready(function(){
        
        $("#sefrminw_dt").datepicker({ dateFormat: 'dd/mm/yy' });
        $("#setoinw_dt").datepicker({ dateFormat: 'dd/mm/yy' });
        
        $("#semaincat").autocomplete({
            source:MENSWEAR
        });
        $("#seartno").autocomplete({
            source:artno
        });
        $("#secat").autocomplete({
            source:cat2
        });

        $("#sesize").autocomplete({
            source:sz2
        });

        $("#secolor").autocomplete({
            source:shade2
        });

        $("#sepkd").autocomplete({
            source:pkd2
        });

        $("#seseries").autocomplete({
            source:series2
        });
        $("#selocation").autocomplete({
            source:location2
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
    #maintab input[type='text']{
        width:90%;
    }
  
</style>
<div class="container-fluid">


<select id='testSelect1' multiple>
  <option value='1'>Item 1</option>
  <option value='2'>Item 2</option>
  <option value='3'>Item 3</option>
  <option value='4'>Item 4</option>
  <option value='5'>Item 5</option>
</select>
<div class="pageShow2">
    <table id="maintab">
        <tr>
            <td>SELECT LOCATION</td>
            <td colspan="3">SEARCH</td>
            <td colspan="2">SHOW</td>
            
            
        </tr>
        <tr>
            <td><select id="sel_loc" class="form-control" title="loc">
                <option>SELECT</option>
                <option>CENTRAL</option>
                <option>PALSANA</option>
                <option>VATVA</option>
                <option>HMT</option>
                <option>VISHNAGAR</option>
            </select></td>
            <td class="exclude" colspan="3"><input type="text" name="sono2" id="sono2" title="sono2" style="width:90%;"></td>
            <td colspan="2">
            <button type="button" name="showinv" id="showinv" class="btn btn-info">SHOW</button>
            </td>
        </tr>
        <tr>
            <td>MAIN CATAGORY</td>
            <td>SUB CATAGORY</td>
            <td>ARTICLE NO</td>
            <td>CATAGORY</td>
            <td>SIZE</td>
            <td>COLOR</td>
        </tr>
        
        <tr>
            <td><input type="text" id="semaincat" title="maincat"/></td>
            <td><input type="text" id="seref" title="sono2"/></td>
            <td><input type="text" id="seartno" title="artno"/></td>
            <td><input type="text" id="secat" title="cat"/></td>
            <td><input type="text" id="sesize" title="sz"/></td>
            <td><input type="text" id="secolor" title="shade"/></td>
            
        </tr>
        <tr>
            <td>PKD</td>
            <td>SERIES</td>
            <td>LOCATION</td>
            <td>FIT</td>
            <td>INWARD DATE FROM</td>
            <td>INWARD DATE TO</td>
        </tr>
        <tr>
           
            <td><input type="text" id="sepkd" title="pkd"/></td>
            <td><input type="text" id="seseries" title="series"/></td>
            <td><input type="text" id="selocation" title="location"/></td>
            <td><input type="text" id="sefit" title="fit"/></td>
            <td><input type="text" id="sefrminw_dt" title="sefrminw_dt"/></td>
            <td><input type="text" id="setoinw_dt" title="setoinw_dt"/></td>
        </tr>
    </table>
    
    <hr>
    <form id="POForm"  class="noshow" action="showSeriesInv.php" target="_blank" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
</form>
   
    
    <div id="showdata">

    </div>
<style>
    .gj{
        /* background:yellow; */
        display:flux;
        justify-content:center;
    }

</style>
    
    
   <script>
   // multiselet

   
       //document.multiselect('#testSelect1');
       $("#testSelect1").multiselect();
  
   //=============================================
       $("#showinv").click(function(){
           //alert("cl");
           //$("#maintab tr td").css("background","red");

            $("#maintab  tr td").each(function(){
                //alert("in");
                var v=$(this).find("input[type='text']").length;
               // alert(v);
                if(v>0){
                    var h=$(this).find("input[type='text']").val();
                    if(h==""){
                        $(this).find("input[type='text']").val(0);
                    }
                    
                }
                
            });
           var data=$("#sel_loc").val();
           console.log(data);
           var search_data=check_and_collect_values33("#maintab");
           console.log(search_data);
           if(search_data.goahead=='yes'){
               search_data=JSON.stringify(search_data);
            var di='<div class="loader"></div>';
            $("div#showdata").html(di);
            $("div#showdata").load("P_showInventory.php",{data:data,search_data:search_data},function(response,status,xhr){
                if(status=='error'){
                    $("#showdata").html("#ERROR in showing data");
                    return false;
                }

               
            });


   

           }
           
       });

     
     


    </script>
    <script src="../multiselect-master/scripts/multiselect.js"></script>
    