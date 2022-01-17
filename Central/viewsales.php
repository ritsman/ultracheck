<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//==============================================================================
$outlet=$_SESSION['frn'];
if($outlet=='CENTRAL2')$outlet="CENTRAL";
//echo $outlet."OUTLET";
// all sales order
$sono=get_sono_list($DBH);

//var_export($sono);
//echo '<hr>';

$shades=get_shade_all($DBH);

$artno=get_articleno($EBH);
//var_export($artno);

$artno=get_articleno($EBH);
//var_export($artno);
// get sono2
$q1="select distinct sono2 from `Q__stk__$outlet`";
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
$q2="select distinct cat from `Q__stk__$outlet`";
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
$q3="select distinct sz from `Q__stk__$outlet`";
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
$q4="select distinct shade from `Q__stk__$outlet`";
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
$q5="select distinct pkd from `Q__stk__$outlet`";
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
$q6="select distinct series from `Q__stk__$outlet`";
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
$q7="select distinct location from `Q__stk__$outlet`";
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
// get distinct bill type
$q8="select distinct paytype from `T__salesmain__$outlet`";
$stm=$EBH->prepare($q8);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $paytype2[]=$r['paytype'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

//var_export($paytype2);
//echo '<hr>';

?>

<script type="text/javascript">
    var outlet="<option>"+<?php print json_encode(strtoupper($outlet));?>+"</option>";
    var sono=<?php print json_encode($sono);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    //console.log(sono);

    var sono2=<?php print json_encode($sono2);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    var cat2=<?php print json_encode($cat2);?>;
    var sz2=<?php print json_encode($sz2);?>;
    var shade2=<?php print json_encode($shade2);?>;
    var pkd2=<?php print json_encode($pkd2);?>;
    var series2=<?php print json_encode($series2);?>;
    var location2=<?php print json_encode($location2);?>;
    var paytype2=<?php print json_encode($paytype2);?>;
    
    var sel_options='';
    $.each(shades,function(i,v){
        sel_options+="<option>"+v+"</option>";
    });
    
    $(document).ready(function(){
        

        
        $("#sefrminw_dt").datepicker({ dateFormat: 'dd/mm/yy' });
        $("#setoinw_dt").datepicker({ dateFormat: 'dd/mm/yy' });
        
        $("#seref").autocomplete({
            source:sono2
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
        $("#sebilltype").autocomplete({
            source:paytype2
        });
        $("#sel_shade").append(sel_options);
        

        
        //$("#sel_loc").append(outlet);
        
        
    });
    $(document).ready(function(){
               
     var dt2=tdt();
     $("td#dtd2").append(dt2);
     //$("#sel_loc option:eq(1)").prop("selected",true);
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
</style>
<div class="container-fluid">
<div class="pageShow2">
    <table id="maintab">
        <tr>
            <td>SELECT LOCATION</td>
            <td colspan="3">SEARCH</td>
            <td colspan="2">SHOW</td>
            
            
        </tr>
        <tr>
            <td><select id="sel_loc" class="form-control">
                <option>SELECT</option>
                <option>CENTRAL</option>
                <option>PALSANA</option>
                <option>VATVA</option>
                <option>HMT</option>
                <option>VISHNAGAR</option>
                <option>VATVAGIDC</option>
                <option>GITAMANDIR</option>
                <option>KAMREJ</option>
                <option>JAHGIRPURA</option>
                
            </select></td>
            <td class='exclude'colspan="3"><input type="text" name="sono2" id="sono2" title="sono2"></td>
            <td colspan="2">
            <button type="button" name="showinv" id="showinv" class="btn btn-info">SHOW</button>
            </td>
        </tr>
        <tr>
            <td>CONTACT NO</td>
            <td>BILL TYPE</td>
            <td>BILL NO</td>
            <td>ARTICLE NO</td>
            <td>CATAGORY</td>
            <td>SIZE</td>
            
        </tr>
        
        <tr>
            <td><input type="text" id="secont" title="contact"/></td>
            <td><input type="text" id="sebilltype" title="billtype"/></td>
            <td><input type="text" id="seref" title="sono2"/></td>
            <td><input type="text" id="seartno" title="artno"/></td>
            <td><input type="text" id="secat" title="cat"/></td>
            <td><input type="text" id="sesize" title="sz"/></td>
            
            
        </tr>
        <tr>
            <td>COLOR</td>
            <td>PKD</td>
            <td>SERIES</td>
            <td>BILL AMOUNT</td>
            <td>BILL DATE FROM</td>
            <td>BILL DATE TO</td>
        </tr>
        <tr>
            <td><input type="text" id="secolor" title="shade"/></td>
            <td><input type="text" id="sepkd" title="pkd"/></td>
            <td><input type="text" id="seseries" title="series"/></td>
            <td><input type="text" id="sebillamt" title="billamt"/></td>
            <td><input type="text" id="sefrminw_dt" title="sefrminw_dt"/></td>
            <td><input type="text" id="setoinw_dt" title="setoinw_dt"/></td>
        </tr>
        <tr>
            <td>ALL SERIES </td><td><input type="checkbox" id="allseries" title="allseries" onclick="series_summary()"/></td>
        </tr>
    </table>
    </table>
    <hr>
    <div id="showdata">

    </div>
    <style>
    #maintab input[type='text']{
        width:90%;
    }
    .redf{
        color:red;
    }
    </style>
    
   <script>
       $("#showinv").click(function(){
           
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
            $("div#showdata").load("P_viewsales.php",{data:data,search_data:search_data});
           }

          
       });

       function series_summary(){
           var v=$("#allseries").prop("checked");
           //alert(v);
           if(v){
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
          // alert("l");
            var data=$("#sel_loc").val();
            console.log(data);
                var search_data=check_and_collect_values33("#maintab");
            console.log(search_data);
            if(search_data.goahead=='yes'){
                search_data=JSON.stringify(search_data);
            var di='<div class="loader"></div>';
                $("div#showdata").html(di);
                $("div#showdata").load("../Franchise/P2_viewsales.php",{data:data,search_data:search_data});
           }

           }else{
               $("#showdata").html('');
           }

        
       }
    </script>