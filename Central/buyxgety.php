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
$menseries = get2_gen_series($DBH, 'MEN');
$womenseries = get2_gen_series($DBH, 'WOMEN');

$boyseries = get2_gen_series($DBH, 'BOY');
$girlseries = get2_gen_series($DBH, 'GIRL');

$littleseries = get2_gen_series($DBH, 'LITTLE');
$kidseries = get2_gen_series($DBH, 'KID');
$accseries = get2_gen_series($DBH, 'ACCESSORIES');
$madeups_s = get2_gen_series_os($DBH, 'MADEUPS');

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
        background-color: #ddd;
    }

    .dark {
        background-color: #cdcdcd;
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
    .bar{
        height: 5px;
        background-color: grey;
    }
</style>

<body>
    <div class="row mt-5 d-flex justify-content-center">
        <div class="col-md-12 d-flex justify-content-center"> OFFER TYPE: BUY X GET Y FREE</div>
        <div class="col-md-1"></div>
        <div class="col-md-10 dark d-flex align-items-center fs-6 p-3 justify-content-center">
            <label for="buyx" class="col-md-6 text-right align-items-center">OFFER NAME:</label>
            <input type="text" name="offer_name" id="offer_name" class="form-control col-md-6">
        </div>
        <div class="col-md"></div>
        

    </div>
    <hr/>

    <div id="main-container">
        <div class="container-fluid fw-bold dexa">

            <form action="register_offer.php" method="post" target="_blank" name="schm3" id="schm3">
                <div class="row red fs-6">

                    <div class="col-md-2 dark d-flex align-items-center fs-6">
                        <label for="buyx">OFFER BUY:</label>
                        <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
                    </div>
                    <div class="col-md-2  d-flex align-items-center">
                        <label for="gety">SELECT SERIES:</label>
                        <input type="text" name="inp_series" class="form-control flex-fill inp_series" onchange="select_series(this)">
                    </div>

                    <div class="selected_series d-flex col-md-12"></div>
                    
                </div>

            </form>

        </div>
    </div>

<hr class="bar">
    <div id="main-container-condition">
        <div class="container-fluid fw-bold dexa">

            <form action="register_offer.php" method="post" target="_blank" name="schm3" id="schm3">
                <div class="row red fs-6">

                    <div class="col-md-2 dark d-flex align-items-center fs-6">
                        <label for="buyx">GET FREE:</label>
                        <input type="text" name="buyx" id="buyx" class="form-control flex-fill">
                    </div>
                    <div class="col-md-2  d-flex align-items-center">
                        <label for="gety">SELECT SERIES:</label>
                        <input type="text" name="inp_series" class="form-control flex-fill inp_series" onchange="select_series(this)">
                    </div>

                    <div class="col-md-2  d-flex align-items-center">
                        <label for="gety">DISCOUNT:</label>
                        <input type="text" name="inp_series" class="form-control flex-fill inp_series" onchange="select_series(this)">
                    </div>
                    
                </div>

            </form>

        </div>
    </div>









    <div class="row d-flex justify-content-center">
    <div class="col-md-4 d-flex justify-content-center mt-5">
        <label for="sel_opt">OUTLET:</label>
        <select name="sel_opt22" id="sel_opt22" class="form-select flex-fill outlet" multiple aria-label="multiple-select">
            <option>SELECT</option>
            <option>ALL</option>
            <option>CENTRAL</option>
            <option>VISHNAGAR</option>
            <option>PALSANA</option>
        </select>
</div>
    </div>
    <div class="row d-flex justify-content-center">
    <button type="button" value="clone" id="clone" class="btn btn-info my-2">CLONE</button>
    <button type="button" value="collect" id="collect" class="btn btn-info my-2 mx-2">SAVE</button>
    </div>


</body>




<script>
    // clone the master div for and && offer 
    var dexa = 0;
    $("#clone").click(function() {
        dexa++;
        var cl = $("#main-container").find("div:eq(0)").clone();
        console.log(cl);
        var dexter_div = "<div id='dexter" + dexa + "' class='master_div'></div>";
        var dexter = "#dexter" + dexa;
        
        $("#main-container").append(dexter_div);
        $(dexter).html(cl);
        $(dexter).find("input").val('');
        $(dexter).find("div.selected_series").html('');
        $(dexter).find("input.inp_series").autocomplete({
            source: all_series
        });
        console.log($(".dexa").length);
        var dexter
       
    });
    
    //select series from input and append to the div
    function select_series(ele){
        var v = $(ele).val();
        var item = "<span class='gg'>" + v + "<img src='../img88/cross.png' onclick=\"rrem3(this)\"/></span>";
        $(ele).parent().siblings(".selected_series").append(item);
        $(ele).val('')
                .focus();

    }

    //remove from div and remove from array of selected series
    function rrem3(ele) {

        var s = $(ele).parent().text();
        console.log(s);
        //$(ele).parent().parent().css("background","cyan");
        var div_e=$(ele).parent().parent();
        
        $(div_e).find(ele).parent().remove();
    }
    //save data
    var selected_series=[];
    $("#collect").click(function(){
        var l=$("#main-container").find("div.dexa").length;
        console.log(l);
        
        for(i=0;i<l;i++){
            var series_text='';
            selected_series[i]={};
            $("#main-container").find("div.dexa:eq("+i+") div.selected_series span")
            .each(function(){
                series_text+=$(this).text();
                series_text+=",";
            });
            series_text=series_text.slice(0,-1);
            console.log(series_text);
            console.log("---------");
            selected_series[i].series=series_text;

        }
        console.log(selected_series);
    });
    
</script>