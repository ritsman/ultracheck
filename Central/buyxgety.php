<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2 = new dbconnect();
$DBH = $DBH2->con('ultrainv');
$EBH2 = new dbconnect();
$EBH = $DBH2->con('ultra');
//========================================================================

//echo 'offer Buy X get Y Free';//
$menseries = get_gen_series($DBH, 'MEN');
$womenseries = get_gen_series($DBH, 'WOMEN');

$boyseries = get_gen_series($DBH, 'BOY');
$girlseries = get_gen_series($DBH, 'GIRL');

$littleseries = get_gen_series($DBH, 'LITTLE');
$kidseries = get_gen_series($DBH, 'KID');
$accseries = get_gen_series($DBH, 'ACCESSORIES');
$madeups_s = get_gen_series_os($DBH, 'MADEUPS');

// var_export($madeups_s);
// echo '<hr>';

$all_series = array_merge($menseries, $womenseries, $boyseries, $girlseries, $littleseries, $kidseries, $accseries, $madeups_s);
// var_export($all_series);
// echo '<hr>';


?>
<script>
    var all_series = <?php print json_encode($all_series); ?>;
    console.log(all_series);

    $(document).ready(function() {
        $("input.inp_series").autocomplete({
            source: all_series
        });
    });
</script>

<style>
    .dexa {
        width: 98%;
        margin-left: auto;
        margin-right: auto;
        margin-top: 2%;
        font-size: 0.8em;
    }

    .red {
        background-color: red;
    }

    .yellow {
        background-color: yellow;
    }

    .green {
        background-color: green;
    }

    span.gg {

        padding: 2px;
        border: 1px solid #ddd;
        margin: 1px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    span.gg img {
        width: 12px;
        height: 12px;
        margin: 3px;
    }
</style>

<body>
    <div class="row">
        <div class="col"> OFFER NAME: BUY X GET Y FREE</div>
        <div class="col">OFFER CODE: BUYXGETY</div>

    </div>

    <div id="main-container">
        <div class="container-fluid fw-bold dexa">

            <form action="register_offer.php" method="post" target="_blank" name="schm3" id="schm3">
                <div class="row red fs-6">

                    <div class="col-md-2 yellow d-flex align-items-center fs-6">
                        <label for="buyx">OFFER BUY:</label>
                        <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
                    </div>
                    <div class="col-md-2 green d-flex align-items-center">
                        <label for="gety">SELECT SERIES:</label>
                        <input type="text" name="inp_series" class="form-control flex-fill inp_series" onchange="solve(this,sel_series)">
                    </div>

                <div class="selected_series d-flex col-md-8"></div>
                <div class="col">
                    <hr />
                </div>
                </div>

            </form>

        </div>
    </div>


</body>

<button type="button" value="clone" id="clone">CLONE</button>
<div class="col-md-4 yellow d-flex align-items-center">
    <label for="sel_opt">OUTLET:</label>
    <select name="sel_opt22" id="sel_opt22" class="form-select flex-fill outlet" multiple aria-label="multiple-select">
        <option>SELECT</option>
        <option>ALL</option>
        <option>CENTRAL</option>
        <option>VISHNAGAR</option>
        <option>PALSANA</option>
    </select>
</div>
<input type="hidden" name="hidme2" id="hidme2" value="this is real" class="hidme">
<div class="col-md-3 green d-flex align-items-center">
    <button class="btn btn-primary mx-1 flex-fill subform" id="schm_buy3" title="schm3" onclick="sub_form(this)" type="button">APPLY</button>
    <button class="btn btn-primary mx-1 flex-fill">REMOVE</button>
    <span class="response"></span>
</div>
<script>
    var dexa = 0;
    $("#clone").click(function() {
        dexa++;
        var cl = $("#main-container").find("div:eq(0)").clone();
        console.log(cl);
        var dexter_div = "<div id='dexter" + dexa + "' class='master_div'></div>";
        var dexter = "#dexter" + dexa;
        
        $("#main-container").append(dexter_div);
        $(dexter).html(cl);
        $(dexter).find("input.inp_series").autocomplete({
            source: all_series
        });
        console.log($(".dexa").length);
        var dexter
       
    });
    //collect the series value in the div
    var sel_series = {};

    //direct input for artno
    $(".inp_series2").change(function() {
        //alert("k");
        var hj=$(this).parents(".dexa").attr("id");
        console.log(hj);
        // $(hj).css("background","black");
        // var v = $(this).val();
        // var dexter2="l";
        // sel_series.dexter2={};
        // sel_series['l']=v;

        // //sel_series.push(v);
        // var item = "<span class='gg'>" + v + "<img src='../img88/cross.png' onclick=\"rrem3(this)\"/></span>";
        // $(this).parent().siblings(".selected_series").append(item);
        // console.log(sel_series);


    });

    function solve(ele,sel_series){
        var hj=$(ele).parents(".master_div").attr("id");
        console.log(hj);
        //sel_series[hj]=[];
        sel_series[hj].push($(ele).val());
        console.log(sel_series);
    }

    //remove from div and remove from array of selected series
    function rrem3(ele) {

        var s = $(ele).parent().text();
        console.log(s);
        $(ele).parent().parent().css("background","cyan");
        var div_e=$(ele).parent().parent();
        var index = sel_series.indexOf(s);
        console.log(index);
        sel_series.splice(index, 1);
        console.log(sel_series);
        $(div_e).find(ele).parent().remove();
    }
</script>