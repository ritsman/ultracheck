<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
// $EBH2=new dbconnect();
// $EBH=$DBH2->con('ultrainv');
//================================================================

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
        $("input#series_name").autocomplete({
            source: all_series
        });
    });
</script>
<div class="container">
    <div class="row mt-5 d-flex justify-content-center">
        
        <div class="col-md-12 dark d-flex align-items-center fs-6 p-3 justify-content-center">
            <label for="buyx" class="col-md-3 text-right align-items-center">SELECT SERIES:</label>
            <input type="text" name="series_name" id="series_name" class="form-control col-md-7">
        </div>

        <div class="col-md-12 d-flex justify-content-center">
            <button class="btn btn-info mx-3" id="updBar">SAVE</button>
        
            <button class="btn btn-info mx-3" id="delBar">RESET</button>
        </div>
        
        

    </div>
    <hr/>
    <div class="container">
        <div id="load_data">

        </div>
    </div>
</div>
<script>
    $("#series_name").change(function(){
        var series=$(this).val();
        if(series==""){
            return false;
        }
        var di='<div class="loader"></div>';
        $("div#load_data").html(di);
        $("#load_data").load("P_stockVerify2.php",{series:series});
    });
</script>