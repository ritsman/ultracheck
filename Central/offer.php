<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//========================================================================
$catagory=[];
$q1="select distinct catagory from `Q__seriesmrp`";
$stm=$EBH->prepare($q1);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $catagory[]=$r['catagory'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($catagory);
//echo '<hr>';
//========================================================================
$q1a="select distinct subcat from `Q__os__madeups`";
$stm=$EBH->prepare($q1a);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $catagory[]=$r['subcat'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($catagory);
//echo '<hr>';
//========================================================================
$series=[];
$q="select distinct series from  `Q__seriesmrp`";
$stm=$EBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $series[]=$r['series'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($series);
//echo '<hr>';
//==========================================================================
$qa="select distinct series from  `Q__os__madeups`";
$stm=$EBH->prepare($qa);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $series[]=$r['series'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($series);//[date]
//echo '<hr>';


?>

<script type="text/javascript">

var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='offer' onclick='track(this)'>New</a></li>";
    auxul += "<li><a href=\"#\" id='viewSeries' onclick='track(this)'>Series</a></li>";
    auxul += "<li><a href=\"#\" id='delBarcode' onclick='track(this)'>Destroy</a></li>";
    auxul += "<li><a href=\"#\" id='buyxgety' onclick='track(this)'>BUY X Get Y</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });
    
    var series=<?php print json_encode($series);?>;
    var catagory=<?php print json_encode($catagory);?>;
    
    
    $(document).ready(function(){
        $("#series").autocomplete({
            source:series
        });
        $("#catagory").autocomplete({
            source:catagory
        });

       
    });
    $(document).ready(function(){
               
     var dt2=tdt();
     $("td#dtd2").append(dt2);
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
    #tabmain input[type='number']{
        width:85%;
    }
</style>
<div class="container-fluid">
<br><br>
<div class="pageShow2">
<h3>SET MRP && DISCOUNT ON SERIES</h3>
<table id="maintab">
    <tr>
        <th>SELECT OULET</th>
        <td>
        <select class="form-control" id="sel_outlet" title="outlet">
                    <option>SELECT</option>
                    <option>CENTRAL</option>
                    <option>PALSANA</option>
                    <option>HMT</option>
                    <option>VATVA</option>
                    <option>VISHNAGAR</option>
                    <option>VATVAGIDC</option>
                    <option>GITAMANDIR</option>
                    <option>KAMREJ</option>
                    <option>JAHGIRPURA</option>
                    
        </select>
        </td>
        <th>
            CHANGE DEFAULT DISCOUNT
        </th>
        <td>
        <input type="text" name="dfltdis" id="dfltdis" title="dfltdis"  ></td>
        </td>
    </tr>
</table> 
<hr>
<table id="tabmain">
        <tr>
        <th>
            <img src="../img88/plus.png" alt="plus" onclick="add_offer(this)">
        </th>
           
            <th>SELECT CATAGORY</th>
            <th>SELECT SERIES</th>
            <th>MRP</th>
            <th>DISCOUNT ON MRP %</th>
            <th>DISCOUNT(INR)</th>
            <th>SALE PRICE</th>
            <th>TAX(%)</th>
            <th>TAX(INR)</th>
            <th>TOTAL</th>
            <th>SAVE</th>
            
            
        </tr>
        <tr>
        <td>
            <img src="../img88/cross.png" alt="plus" onclick="del_offer(this)">
        </td>
            <td class="cat22"><input type="text" name="catagory" id="catagory" title="catagory"></td>
            <td><input type="text" name="series" id="series" title="series" onchange="get_mrp(this)"></td>
            
            
            <td class="m2rp">
            <input type="text" name="mrp" id="mrp" title="mrp">

            </td>
            <td><input type="text" name="disrate" id="disrate" title="disrate" onchange="get_mrpdata(this)"></td>
            <td id="discount" dirname="direct" class="discount"></td>
            <td id="saleprice" dirname="direct" class="saleprice"></td>
            <td id="taxrate" dirname="direct" class="taxrate"></td>
            <td id="taxvalue" dirname="direct" class="taxvalue"></td>
            <td id="total" dirname="direct" class="total"></td>
            <td>
                    <button type="button" name="makeart" id="makeart" class="btn btn-info">SAVE </button>
            </td>
            
        </tr>
    </table>
    <hr>
    <div id="response"></div>
    <div id="showdata"></div>
    <form id="POForm" class="noshow" action="R_offer.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>

    <script>
    // load the mrp
    function get_mrp(ele){
        var series=$(ele).val();
        var cat=$(ele).parent().siblings("td.cat22").find("input#catagory").val();
        $.post("P_offer.php",{series:series,cat:cat},function(mrp){
            $(ele).parent().siblings("td.m2rp").find("input#mrp").val(mrp);
        });
    }
    // load the discount values
    function get_mrpdata(ele){
        var data={};
        var tax=0;
        var mrp=parseFloat($(ele).parent().siblings("td.m2rp").find("input#mrp").val());
        //mrp=parseInt($("#mrp").val());
        var disrate=parseFloat($(ele).val());
        
        console.log(mrp,disrate);
        var discount=(mrp*disrate*0.01);
        console.log(discount);
        var price_with_tax=(mrp-discount);
        if(price_with_tax<1050){
            tax=5;
        }else{
            tax=12;
        }
    
        var price=(price_with_tax*100)/(100+tax);
        var tax_amount=price*tax*0.01;
        console.log(price,price_with_tax,tax_amount);

        data.discount=discount.toFixed(2);
        data.tax=tax;
        data.taxamount=tax_amount.toFixed(2);
        data.price=price.toFixed(2);
        data.price_with_tax=price_with_tax.toFixed(2);
        $(ele).parent().siblings("td#discount").text(data.discount);
        $(ele).parent().siblings("td#saleprice").text(data.price);
        $(ele).parent().siblings("td#taxrate").text(data.tax);
        $(ele).parent().siblings("td#taxvalue").text(data.taxamount);
        $(ele).parent().siblings("td#total").text(data.price_with_tax);
        
    return data;

}
// save the data

$("#makeart").click(function(){
    var datamain=check_and_collect_values("#maintab");
    var data=check_and_collect_values("#tabmain");
    console.log(datamain);
    console.log(data);
    if((datamain.goahead=='yes')&&(data.goahead=='yes')){
        datamain=JSON.stringify(datamain);
        data=JSON.stringify(data);
        $("#holder1").val(datamain);
        $("#holder2").val(data);
        
        $("#POForm").submit();
        $(this).prop("disabled",true);
    }
});

// load series data
$("#sel_outlet").change(function(){
    
    var outlet=$(this).val();
    $("#showdata").load("P2_offer.php",{outlet:outlet});
    $.post("P3_offer.php",{outlet:outlet},function(data){
        $("#dfltdis").val(data);
    });
});
    </script>