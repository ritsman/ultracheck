<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2 = new dbconnect();
$DBH = $DBH2->con('ultra');
$EBH2 = new dbconnect();
$EBH = $DBH2->con('ultrainv');

// all purchase order
$sono = get_gpo_list($EBH);

//var_export($sono);
//echo '<hr>';

$shades = get_shade_all($DBH);

$artno = get_articleno($EBH);
//var_export($artno);



?>

<script type="text/javascript">
    var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='printBarcodeOS' onclick='track(this)'>New</a></li>";
    auxul += "<li><a href=\"#\" id='viewBarcode' onclick='track(this)'>View</a></li>";
    auxul += "<li><a href=\"#\" id='delBarcode' onclick='track(this)'>Destroy</a></li>";
    auxul += "</ul>";
    $(document).ready(function() {
        $("#auxnav").html(auxul);
    });

    var sono = <?php print json_encode($sono); ?>;
    var shades = <?php print json_encode($shades); ?>;
    var artno = <?php print json_encode($artno); ?>;
    //console.log(sono);
    var sel_options = '';
    $.each(shades, function(i, v) {
        sel_options += "<option>" + v + "</option>";
    });

    $(document).ready(function() {
        $("#sono2").autocomplete({
            source: sono
        });

        $("#artno").autocomplete({
            source: artno
        });

        $("#sel_shade").append(sel_options);

    });
    $(document).ready(function() {

        var dt2 = tdt();
        $("td#dtd2").append(dt2);
    });
    /*
     * load series options on change of catagory
     */

    var series_val = {
        'A1': ['FLY'],
        'A2': ['ANTHAM', 'BERLIN', 'CAIRO', 'DURBAN', 'EPIC', 'UBER'],
        'A3': ['HOST', 'INOX', 'JOR', 'KEVIN', 'LUCAS'],
        'A4': ['MOON', 'OPUS', 'PLUS', 'QUARK'],
        'A5': ['VOLT', 'WINE', 'NENO'], //mens
        'A6': ['ALEXA', 'BELLY', 'CHAMU', 'DIVA', 'UBER F'],
        'A7': ['ERA', 'FURRY', 'GAMA', 'HEXA'],
        'A8': ['PLAZZO'],
        'A9': ['IKIA', 'JAZZ'],
        'B1': ['TRACK'],
        'B2': ['ZOOM'],
        'B3': ['LOWER'],
        'B4': ['KENVA', 'RIVA', 'MEVA', 'NOVA'],
        'B5': ['ORRA', 'PEARL', 'QUEEN'],
        'B6': ['SKY'], //womens
        'C1': ['MOON JUNIOR', 'OPUS JUNIOR', 'PLUS JUNIOR', 'QUARK JUNIOR'],
        'C2': ['ANTHAM JUNIOR', 'BERLIN JUNIOR', 'CAIRO JUNIOR', 'DURBAN JUNIOR', 'EPIC JUNIOR', 'UBER JUNIOR'],
        'C3': ['HOST JUNIOR', 'INOX JUNIOR', 'JOR JUNIOR', 'KEVIN JUNIOR', 'LUCAS JUNIOR'],
        'C4': ['VOLT JUNIOR', 'WINE JUNIOR', 'NENO JUNIOR'], //boys
        'D1': ['KENVA JUNIOR', 'RIVA JUNIOR', 'MEVA JUNIOR', 'NOVA JUNIOR'],
        'D2': ['ALEXA JUNIOR', 'BELLY JUNIOR', 'CHAMU JUNIOR', 'DIVA JUNIOR'],
        'D3': ['IKIA JUNIOR'],
        'D4': ['ERA JUNIOR'], //girls
        'E1': ['KENVA KIDS', 'RIVA KIDS', 'MEVA KIDS', 'NOVA KIDS'],
        'E2': ['ALEXA KIDS', 'BELLY KIDS', 'CHAMU KIDS', 'DIVA KIDS'],
        'E3': ['GAMA KIDS'],
        'E4': ['IKIA KIDS', 'JAZZ KIDS'],
        'E5': ['ERA KIDS'], //little
        'F1': ['MOON KIDS', 'OPUS KIDS', 'PLUS KIDS', 'QUARK KIDS'],
        'F2': ['ANTHAM KIDS', 'BERLIN KIDS', 'CAIRO KIDS', 'DURBAN KIDS', 'EPIC KIDS', 'UBER KIDS'],
        'F3': ['JOR KIDS'],
        'F4': ['VOLT KIDS', 'WINE KIDS'], //kids
        'G1': ['APRON', 'BAGS'], //accessory
        'H1': ['ARTISAN', 'AZURE', 'SANTORINI', 'TINSEL', 'PRISTINE', 'MAJESTIC', 'EPIC', 'TUSSAH', 'TWILIGHT'], // made-ups
        'H2': ['ARTISAN', 'AZURE', 'SANTORINI', 'TINSEL', 'PRISTINE', 'MAJESTIC', 'EPIC', 'TUSSAH', 'TWILIGHT'], // made-ups
        'H3': ['ARTISAN', 'AZURE', 'SANTORINI', 'TINSEL', 'PRISTINE', 'MAJESTIC', 'EPIC', 'TUSSAH', 'TWILIGHT'] // made-ups

    };

    // catagory series values
    var cat_series_val = {};
    cat_series_val['M'] = {
        'A1': ["MEN'S JACKET"],
        'A2': ["MEN'S JEANS"],
        'A3': ["MEN'S SHIRT"],
        'A4': ["MEN'S T-SHIRT"],
        'A5': ["MEN'S SHORTS"],
        'B1': ["MEN'S TRACK"],
        'B2': ["MEN'S BOXER"]

    };
    cat_series_val['W'] = {
        'A6': ["WOMEN'S JEANS"],
        'A7': ["WOMEN'S KURTI"],
        'A8': ["WOMEN'S PLAZO"],
        'A9': ["WOMEN'S SHORTS"],
        'B3': ["WOMEN'S LOWER"],
        'B4': ["WOMEN'S T-SHIRT"],
        'B5': ["WOMEN'S SHIRT"],
        'B6': ["WOMEN'S JACKET"],


    };
    cat_series_val['B'] = {
        'C1': ["BOY'S T-SHIRT"],
        'C2': ["BOY'S JEANS"],
        'C3': ["BOY'S SHIRT"],
        'C4': ["BOY'S SHORTS"],


    };
    cat_series_val['G'] = {
        'D1': ["GIRL'S T-SHIRT"],
        'D2': ["GIRL'S JEANS"],
        'D3': ["GIRL'S SHORTS"],
        'D4': ["GIRL'S FROCK"],



    };
    cat_series_val['L'] = {
        'E1': ["LITTLE T-SHIRT"],
        'E2': ["LITTLE JEANS"],
        'E3': ["LITTLE SKIRT"],
        'E4': ["LITTLE SHORTS"],
        'E5': ["LITTLE FROCK"],



    };
    cat_series_val['K'] = {
        'F1': ["KIDS T-SHIRT"],
        'F2': ["KIDS JEANS"],
        'F3': ["KIDS SHIRT"],
        'F4': ["KIDS SHORTS"],




    };
    cat_series_val['A'] = {
        'G1': ["ACCESSORIES"],





    };
    cat_series_val['D'] = {
        'H1': ["QUEEN BED SHEET"],
        'H2': ["KING BED SHEET"],
        'H3': ["SINGLE BED SHEET"],





    };





    // load cat after gender
    function load_cat(ele) {
        //console.log(series_val);
        var gender = $(ele).val().toString();

        var series_options = cat_series_val[gender];
        var opt = "<option>SELECT</option>";
        $.each(series_options, function(i, v) {
            opt += "<option value='" + i + "'>" + v + "</option>";

        });
        $("#sel_cat")
            .empty()
            .append(opt);

    }




    // load series after cat
    function load_series(ele) {
        //console.log(series_val);
        var cat = $(ele).val().toString();
        console.log(cat);
        var series_options = series_val[cat];
        console.log(series_options);
        var opt = "<option>SELECT</option>";
        $.each(series_options, function(i, v) {
            opt += "<option>" + v + "</option>";

        });
        $("#sel_series")
            .empty()
            .append(opt);

    }
</script>
<style>
    #tabmain input[type='text'] {
        width: 90%;
    }
</style>
<div class="container-fluid">
    <div class="pageShow2">
        <table id="tabmain">
            <tr>
                <th>SELECT PURCHASE ORDER NO</th>
                <th>SELECT ARTICLE NO</th>

                <th>MAKE NEW ARTICLE NO</th>

            </tr>
            <tr>
                <td><input type="text" name="sono2" id="sono2" title="sono2"></td>
                <td><input type="text" name="artno" id="artno" title="artno"></td>


                <td colspan="2">
                    <button type="button" name="getBar" id="get_bar" class="btn btn-primary">GENERATE BARCODE</button>
                </td>

            </tr>


            </tr>
        </table>
        <hr>

        <br>

        <hr>
    </div>

    <div id="barshow" class="noshow">
        <table id="bartab" class="table table-striped">

            <tr>
                
                <td>GPO</td>
                <td>ART NO</td>
                <td>CATAGORY</td>
                <td>SIZE</td>
                <td>PILLOW</td>
                
                <td>QTY</td>
                <td>PKD</td>
                <td>SERIES</td>
                <td>MRP</td>
                
            </tr>

        </table>
        <br><br>
        
    </div>

</div>
</div>
<form id="POForm" class="noshow" action="printbarcodepdfOS.php" target="_blank" method="post">
    <input type="text" id="holder1" name="holder1" class="noshow" />

</form>
<iframe class="noshow" id="if33" name="if33"></iframe>
<script>
    // select all or none

    $("#masterchk").click(function() {
        //alert("cl");
        var k = $(this).prop("checked");
        $("#bartab tr:not(:eq(0))").each(function() {
            $(this).find("td:eq(0) input.chkprnt").prop("checked", k);
        });
    });

    // decode SUBcatagory from this array

    men_cat = {
        'A': "MEN'S JEANS",
        'B': "MEN'S JEANS",
        'C': "MEN'S JEANS",
        'D': "MEN'S JEANS",
        'E': "MEN'S JEANS",
        'F': "MEN'S JACKET",
        'U': "MEN'S JEANS",
        'H': "MEN'S SHIRT",
        'I': "MEN'S SHIRT",
        'J': "MEN'S SHIRT",
        'K': "MEN'S SHIRT",
        'L': "MEN'S SHIRT",
        'M': "MEN'S T-SHIRT",
        'O': "MEN'S T-SHIRT",
        'P': "MEN'S T-SHIRT",
        'Q': "MEN'S T-SHIRT",
        'V': "MEN'S SHORTS",
        'W': "MEN'S SHORTS",
        'N': "MEN'S SHORTS",
        'T': "MEN'S TRACK",
        'Z': "MEN'S BOXER"

    };
    women_cat = {
        'A': "WOMEN'S JEANS",
        'B': "WOMEN'S JEANS",
        'C': "WOMEN'S JEANS",
        'D': "WOMEN'S JEANS",
        'U': "WOMEN'S JEANS",
        'E': "WOMEN'S KURTI",
        'F': "WOMEN'S KURTI",
        'G': "WOMEN'S KURTI",
        'H': "WOMEN'S KURTI",
        'P': "WOMEN'S PLAZO",
        'I': "WOMEN'S SHORTS",
        'J': "WOMEN'S SHORTS",
        'L': "WOMEN'S LOWER",
        'K': "WOMEN'S T-SHIRT",
        'R': "WOMEN'S T-SHIRT",
        'M': "WOMEN'S T-SHIRT",
        'N': "WOMEN'S T-SHIRT",
        'O': "WOMEN'S SHIRT",
        'P': "WOMEN'S SHIRT",
        'Q': "WOMEN'S SHIRT",
        'S': "WOMEN'S JACKET"


    };

    boys_cat = {
        'M': "BOY'S T-SHIRT",
        'O': "BOY'S T-SHIRT",
        'P': "BOY'S T-SHIRT",
        'Q': "BOY'S T-SHIRT",
        'A': "MEN'S JEANS",
        'B': "BOY'S JEANS",
        'C': "BOY'S JEANS",
        'D': "BOY'S JEANS",
        'E': "BOY'S JEANS",
        'J': "BOY'S SHIRT",
        'V': "BOY'S SHORTS",
        'W': "BOY'S SHORTS",
        'N': "BOY'S SHORTS"
    };
    girls_cat = {
        'K': "GIRL'S T-SHIRT",
        'R': "GIRL'S T-SHIRT",
        'M': "GIRL'S T-SHIRT",
        'N': "GIRL'S T-SHIRT",
        'A': "GIRL'S JEANS",
        'B': "GIRL'S JEANS",
        'C': "GIRL'S JEANS",
        'D': "GIRL'S JEANS",
        'I': "GIRL'S SHORTS",
        'E': "GIRL'S FROCK"
    };
    little_cat = {
        'K': "LITTLE T-SHIRT",
        'R': "LITTLE T-SHIRT",
        'M': "LITTLE T-SHIRT",
        'N': "LITTLE T-SHIRT",
        'A': "LITTLE JEANS",
        'B': "LITTLE JEANS",
        'C': "LITTLE JEANS",
        'D': "LITTLE JEANS",
        'G': "LITTLE SKIRT",
        'I': "LITTLE SHORTS",
        'E': "LITTLE FROCK"
    };
    kids_cat = {
        'M': "KIDS T-SHIRT",
        'O': "KIDS T-SHIRT",
        'P': "KIDS T-SHIRT",
        'Q': "KIDS T-SHIRT",
        'A': "KIDS JEANS",
        'B': "KIDS JEANS",
        'C': "KIDS JEANS",
        'D': "KIDS JEANS",
        'E': "KIDS JEANS",
        'J': "KIDS SHIRT",
        'V': "KIDS SHORTS",
        'W': "KIDS SHORTS",
        'N': "KIDS SHORTS",
        'T': "KIDS TRACK",

    }

    acc_cat = {
        'A': 'APRON',
        'B': "DENIM BAGS"
    }
    madeups_cat = {
        'Q': 'QUEEN BED SHEET',
        'S': 'SINGLE BED SHEET',
        'K': 'KING BED SHEET',
        'T':'TOWEL',
        'N':'NAPKIN'
    }



    //generate new barcodes
    $("#get_bar").click(function() {
        $("div#barshow").removeClass("noshow");

        $("table#bartab tr:not(:eq(0))").remove();

        var article = $("#artno").val();

        // alert("gin");
        var data = check_and_collect_values("#tabmain");
        console.log(data);
        if (data.goahead == 'yes') {
            data = JSON.stringify(data);
            $.post("getbarcodeOS.php", {
                data: data
            }, function(r) {
                console.log(r);//

                var rt = JSON.parse(r);
                $.each(rt, function(i, v) {
                    console.log(i);
                    console.log("_____");
                    console.log(v);
                    var row = "<tr><td class='"+i+"'>" + v.pono + "</td><td class='"+v.id+"'>" + v.artno + "</td>";
                    row += "<td>" + v.subcat + "</td><td>" + v.sz + "</td><td>" + v.pillow + "</td>" ;
                    row += "<td>" + v.qty + "</td><td>" + v.pkm + "</td><td>" + v.series + "</td><td>" + v.mrp + "</td>" ;
                    row +="<td><button type=\"button\" name=\"prntBar\" id=\"prntBar\" class=\"btn btn-info\" onclick=\"print_Bar(this)\">PDF</button></td>";
                    $("#bartab").append(row);
                });
            });

        }



    });

    $("#prntBar").click(function() {
        //alert("select");
        var data = {};
        $("#bartab tr:not(:eq(0))").each(function(i) {
            if ($(this).find("td:eq(0) input.chkprnt").prop("checked") == true) {
                console.log("PPP");
                data[i] = {};
                data[i]['tname'] = $(this).find("td:eq(0)").attr('class');
                data[i]['pono'] = $(this).find("td:eq(0)").text();
                data[i]['artno'] = $(this).find("td:eq(1)").text();
                data[i]['madeupid'] = $(this).find("td:eq(1)").attr('class');
                data[i]['cat'] = $(this).find("td:eq(2)").text();
                data[i]['sz'] = $(this).find("td:eq(3)").text();
                data[i]['pillow'] = $(this).find("td:eq(4)").text();
                
                data[i]['qty'] = $(this).find("td:eq(5)").text();
                data[i]['pkd'] = $(this).find("td:eq(6)").text();
                data[i]['series'] = $(this).find("td:eq(7)").text();
                data[i]['mrp'] = $(this).find("td:eq(8)").text();
                
            }
        });
        console.log(data);
        data = JSON.stringify(data);
        $("#holder1").val(data);
        $("#POForm").submit();

    });

    function print_Bar(ele){
        var row=$(ele).parent().parent();
        var data={};
        //$(ele).parent().parent().css("background","green");
                data['tname'] = $(row).find("td:eq(0)").attr('class');
                data['pono'] = $(row).find("td:eq(0)").text();
                data['artno'] = $(row).find("td:eq(1)").text();
                data['madeupid'] = $(row).find("td:eq(1)").attr('class');
                data['cat'] = $(row).find("td:eq(2)").text();
                data['sz'] = $(row).find("td:eq(3)").text();
                data['pillow'] = $(row).find("td:eq(4)").text();
                
                data['qty'] = $(row).find("td:eq(5)").text();
                data['pkd'] = $(row).find("td:eq(6)").text();
                data['series'] = $(row).find("td:eq(7)").text();
                data['mrp'] = $(row).find("td:eq(8)").text();
                
                console.log(data);
        data = JSON.stringify(data);
        $("#holder1").val(data);
        $("#POForm").submit();
    }



    var sz_in_inch = {
        'REGULAR': 0,
        0: 0,
        22: 56,
        24: 61,
        26: 66,
        28: 71,
        30: 76,
        32: 81,
        34: 86,
        36: 91,
        38: 96,
        40: 101,
        42: 106,
        44: 111,
        48: 116,
        'XS': 34,
        'S': 36,
        'M': 38,
        'L': 40,
        'XL': 42,
        'XXL': 44,
        '3XL': 46,
        '14-15Y': 0,
        '2-3Y': 0,
        '3-4Y': 33,
        '4-5Y': 0,
        '5-6Y': 35,
        '6-7Y': 0,
        '7-8Y': 38,
        '8-9Y': 0,
        '9-10Y': 40,
        '10-11Y': 0,
        '12-13Y': 43,
        '14-15Y': 45,
        '16-17Y': 48




    };

    function set_cm_value(ele) {
        var szinch = $(ele).val();
        var szcm = sz_in_inch[szinch];
        //console.log(szcm,szinch);
        $("#sel_szcm").val(szcm); //
    }
</script>