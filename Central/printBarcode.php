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
var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='printBarcode' onclick='track(this)'>New</a></li>";
    auxul += "<li><a href=\"#\" id='viewBarcode' onclick='track(this)'>View</a></li>";
    auxul += "<li><a href=\"#\" id='delBarcode' onclick='track(this)'>Destroy</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
    });
    var loc=window.location.pathname
    
    console.log((loc.substring(1,loc.indexOf(('/'),1))).toUpperCase());
    var sono=<?php print json_encode($sono);?>;
    var shades=<?php print json_encode($shades);?>;
    var artno=<?php print json_encode($artno);?>;
    //console.log(sono);
    var sel_options='';
    $.each(shades,function(i,v){
        sel_options+="<option>"+v+"</option>";
    });
    
    $(document).ready(function(){
        $("#sono2").autocomplete({
            source:sono
        });

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
    'A1':['FLY'],
    'A2':['ANTHAM','BERLIN','CAIRO','DURBAN','EPIC','UBER'],
    'A3':['HOST','INOX','JOR','KEVIN','LUCAS'],
    'A4':['MOON','OPUS','PLUS','QUARK'],
    'A5':['VOLT','WINE','NENO'],//mens
    'A6':['ALEXA','BELLY','CHAMU','DIVA','UBER F'],
    'A7':['ERA','FURRY','GAMA','HEXA'],
    'A8':['PLAZZO'],
    'A9':['IKIA','JAZZ'],
    'A10':['REMO'],
    'A11':['SIGMA'],
    'B1':['TRACK'],
    'B2':['ZOOM'],
    'B3':['LOWER','WOMEN\'S LEGGING','K-JEGGINGS'],
    'B4':['KENVA','RIVA','MEVA','NOVA'],
    'B5':['ORRA','PEARL','QUEEN'],
    'B6':['SKY'],
    //womens
    'C1':['MOON JUNIOR','OPUS JUNIOR','PLUS JUNIOR','QUARK JUNIOR'],
    'C2':['ANTHAM JUNIOR','BERLIN JUNIOR','CAIRO JUNIOR','DURBAN JUNIOR','EPIC JUNIOR','UBER JUNIOR'],
    'C3':['HOST JUNIOR','INOX JUNIOR','JOR JUNIOR','KEVIN JUNIOR','LUCAS JUNIOR'],
    'C4':['VOLT JUNIOR','WINE JUNIOR','NENO JUNIOR'],//boys
    'D1':['KENVA JUNIOR','RIVA JUNIOR','MEVA JUNIOR','NOVA JUNIOR'],
    'D2':['ALEXA JUNIOR','BELLY JUNIOR','CHAMU JUNIOR','DIVA JUNIOR'],
    'D3':['IKIA JUNIOR','JAZZ JUNIOR'],
    'D4':['ERA JUNIOR','FURRY JUNIOR'],//girls
    'D5':['GAMA JUNIOR'],//girls
    'E1':['KENVA KIDS','RIVA KIDS','MEVA KIDS','NOVA KIDS'],
    'E2':['ALEXA KIDS','BELLY KIDS','CHAMU KIDS','DIVA KIDS'],
    'E3':['GAMA KIDS'],
    'E4':['IKIA KIDS','JAZZ KIDS'],
    'E5':['ERA KIDS','FURRY KIDS'],//little
    'F1':['MOON KIDS','OPUS KIDS','PLUS KIDS','QUARK KIDS'],
    'F2':['ANTHAM KIDS','BERLIN KIDS','CAIRO KIDS','DURBAN KIDS','EPIC KIDS','UBER KIDS'],
    'F3':['JOR KIDS'],
    'F4':['VOLT KIDS','WINE KIDS'],//kids
    'G1':['APRON','BAGS'],//accessory
    'H1':['ARTISAN','AZURE','SANTORINI','TINSEL','PRISTINE','MAJESTIC','EPIC','TUSSAH','TWILIGHT'],// made-ups
    'H2':['ARTISAN','AZURE','SANTORINI','TINSEL','PRISTINE','MAJESTIC','EPIC','TUSSAH','TWILIGHT'],// made-ups
    'H3':['ARTISAN','AZURE','SANTORINI','TINSEL','PRISTINE','MAJESTIC','EPIC','TUSSAH','TWILIGHT']// made-ups
    
};

// catagory series values
var cat_series_val={};
cat_series_val['M']={
    'A1':["MEN'S JACKET"],
    'A2':["MEN'S JEANS"],
    'A3':["MEN'S SHIRT"],
    'A4':["MEN'S T-SHIRT"],
    'A5':["MEN'S SHORTS"],
    'B1':["MEN'S TRACK"],
    'B2':["MEN'S BOXER"],
    'A10':["MEN'S CASUAL"],
    'A11':["MEN'S FORMAL"]
   
};
cat_series_val['W']={
    'A6':["WOMEN'S JEANS"],
    'A7':["WOMEN'S KURTI"],
    'A8':["WOMEN'S PLAZO"],
    'A9':["WOMEN'S SHORTS"],
    'B3':["WOMEN'S LOWER"],
    'B4':["WOMEN'S T-SHIRT"],
    'B5':["WOMEN'S SHIRT"],
    'B6':["WOMEN'S JACKET"],

    
   
};
cat_series_val['B']={
    'C1':["BOY'S T-SHIRT"],
    'C2':["BOY'S JEANS"],
    'C3':["BOY'S SHIRT"],
    'C4':["BOY'S SHORTS"],
    
   
};
cat_series_val['G']={
    'D1':["GIRL'S T-SHIRT"],
    'D2':["GIRL'S JEANS"],
    'D3':["GIRL'S SHORTS"],
    'D4':["GIRL'S FROCK"],
    'D5':["GIRL'S SKIRT"],
    
        
    
   
};
cat_series_val['L']={
    'E1':["LITTLE T-SHIRT"],
    'E2':["LITTLE JEANS"],
    'E3':["LITTLE SKIRT"],
    'E4':["LITTLE SHORTS"],
    'E5':["LITTLE FROCK"],
    
    
   
};
cat_series_val['K']={
    'F1':["KIDS T-SHIRT"],
    'F2':["KIDS JEANS"],
    'F3':["KIDS SHIRT"],
    'F4':["KIDS SHORTS"],
    
    
    
   
};
cat_series_val['A']={
    'G1':["ACCESSORIES"],
   
    
    
    
   
};
cat_series_val['D']={
    'H1':["QUEEN BED SHEET"],
    'H2':["KING SIZE SHEET"],
    'H3':["SINGLE BED SHEET"],
   
    
    
    
   
};





// load cat after gender
function load_cat(ele){
    //console.log(series_val);
    var gender=$(ele).val().toString();
   
    var series_options=cat_series_val[gender];
    var opt="<option>SELECT</option>";
    $.each(series_options,function(i,v){
        opt+="<option value='"+i+"'>"+v+"</option>";
        
    });
    $("#sel_cat")
        .empty()
        .append(opt);

}




// load series after cat
function load_series(ele){
    //console.log(series_val);
    var cat=$(ele).val().toString();
    console.log(cat);
    var series_options=series_val[cat];
    console.log(series_options);
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
    <table id="tabmain">
        <tr>
            <th>SELECT SALES ORDER NO</th>
            <th>SELECT ARTICLE NO</th>
            <th>SELECT SIZE</th>
            <th>SIZE/CM</th>
            <th>SELECT INSEAM</th>
            <th>MAKE NEW ARTICLE NO</th>
            
        </tr>
        <tr>
            <td><input type="text" name="sono2" id="sono2" title="sono2"></td>
            <td><input type="text" name="artno" id="artno" title="artno"></td>
            <td>
                <select class="form-control" id="sel_szinch" title="sz" onchange="set_cm_value(this)">
                    <option>SELECT</option>
                    <option>REGULAR</option>
                    <option>.</option>
                    <option>0</option>
                    <option>22</option>
                    <option>24</option>
                    <option>26</option>
                    <option>28</option>
                    <option>30</option>
                    <option>32</option>
                    <option>34</option>
                    <option>36</option>
                    <option>38</option>
                    <option>40</option>
                    <option>42</option>
                    <option>44</option>
                    <option>46</option>
                    <option>48</option>
                    <option>XS</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                    <option>XXL</option>
                    <option>3XL</option>
                    <option>2-3Y</option>
                    <option>3-4Y</option>
                    <option>4-5Y</option>
                    <option>5-6Y</option>
                    <option>6-7Y</option>
                    <option>7-8Y</option>
                    <option>8-9Y</option>
                    <option>9-10Y</option>
                    <option>10-11Y</option>
                    <option>11-12Y</option>
                    <option>12-13Y</option>
                    <option>13-14Y</option>
                    <option>14-15Y</option>
                    <option>15-16Y</option>
                    <option>16-17Y</option>
                    <option>2.2MX2.74M</option>
                    <option>6-12M</option>
                    <option>12-18M</option>
                    <option>18-24M</option>
                </select>
            </td>
            <td>
                <select class="form-control" title="szcm" id="sel_szcm">
                    <option>SELECT</option>
                    
                    <option>0</option>
                    <option>56</option>
                    <option>61</option>
                    <option>66</option>
                    <option>71</option>
                    <option>76</option>
                    <option>81</option>
                    <option>86</option>
                    <option>91</option>
                    <option>96</option>
                    <option>101</option>
                    <option>106</option>
                    <option>111</option>
                    <option>116</option>
                    <option>121</option>
                    <option>34</option>
                    <option>36</option>
                    <option>38</option>
                    <option>40</option>
                    <option>42</option>
                    <option>44</option>
                    <option>46</option>
                    <option>48</option>
                    <option>33</option>
                    <option>35</option>
                    <option>38</option>
                    <option>40</option>
                    <option>43</option>
                    <option>45</option>
                    <option>48</option>
                </select>
            </td>
            <td>
            <input type="text" name="inseam" id="inseam" title="inseam">

            </td>
            <td>
                    <button type="button" name="makeart" id="makeart" class="btn btn-info">NEW ART NO</button>
                </td>
            <tr>
                <th>SELECT COLOR</th>
                <th>PKD </th>
                <th>PKD MONTH</th>
                <th>SELECT NO OF BARCODES</th>
                <th colspan="2">PRINT BARCODE</th>

            </tr>
            <tr>

            
                <td>
                <select class="form-control" title="shade" id="sel_shade">
                        <option>SELECT</option>
                        
                        
                    </select>
                </td>

            <td>
                <select class="form-control" title="pkd">
                    <option>SELECT</option>
                    <option>2019</option>
                    <option>2020</option>
                    <option>2021</option>
                    
                </select>
            </td>
            <td>
                <select class="form-control" title="pkdmonth">
                    <option>SELECT</option>
                    <option>JAN</option>
                    <option>FEB</option>
                    <option>MAR</option>
                    <option>APR</option>
                    <option>MAY</option>
                    <option>JUN</option>
                    <option>JUL</option>
                    <option>AUG</option>
                    <option>SEP</option>
                    <option>OCT</option>
                    <option>NOV</option>
                    <option>DEC</option>
                </select>
            </td>
            <td>
                    <input type="text" name="copies" id="copies" title="copies">
                </td>

                
                <td colspan="2">
                    <button type="button" name="getBar" id="get_bar" class="btn btn-primary">GENERATE BARCODE</button>
                </td>

            </tr>
            

        </tr>
    </table>
    <hr>
    <div class="noshow" id="artshow">
    <p>MAKE ARTICLE NUMBER</p><p id="artnewno"></p>
    <table id="maintab">
        <tr>
            <th>BRAND</th>
            <th>GENDER</th>
            <th>CATAGORY</th>
            <th>SERIES</th>
            
            
        
        </tr>
        <tr>
            <td>
                <select class="form-control" title="brand">
                    <option>SELECT</option>
                    <option>FLIVEZ</option>
                    <option>MADOO</option>
                </select>
            </td>

            <td>
                <select class="form-control" title="gender" onchange="load_cat(this)" id="sel_gender">
                    <option>SELECT</option>
                    <option>M</option>
                    <option>W</option>
                    <option>B</option>
                    <option>G</option>
                    <option>L</option>
                    <option>K</option>
                    <option>A</option>
                    <option>D</option>
                </select>
            </td>

            <td>
                <select class="form-control" title="catagory" onchange="load_series(this)" id="sel_cat">
                    <option>SELECT</option>
                    <option value="A2">MEN'S JEANS</option>
                    <option value="A3">MEN'S SHIRT</option>
                    <option value="A4">MEN'S T-SHIRT</option>
                    <option value="A5">MEN'S SHORTS</option>
                    <option value="A1">MEN'S JACKET</option>
                    <option value="B1">MEN'S TRACK</option>
                    <option value="B2">MEN'S BOXER</option>
                    <option value="A6">WOMEN'S JEANS</option>
                    <option value="A7">WOMEN'S KURTI</option>
                    <option value="A8">WOMEN'S PLAZO</option>
                    <option value="A9">WOMEN'S SHORTS</option>
                    <option value="B3">WOMEN'S LOWER</option>
                    <option value="B4">WOMEN'S T-SHIRT</option>
                    <option value="B5">WOMEN'S SHIRT</option>
                    <option value="C1">BOY'S T-SHIRT</option>
                    <option value="C2">BOY'S JEANS</option>
                    <option value="C3">BOY'S SHIRT</option>
                    <option value="C4">BOY'S SHORTS</option>
                    <option value="D1">GIRL'S T-SHIRT</option>
                    <option value="D2">GIRL'S JEANS</option>
                    <option value="E1">LITTLE T-SHIRT</option>
                    <option value="E2">LITTLE JEANS</option>
                    <option value="E3">LITTLE SKIRT</option>
                    <option value="E4">LITTLE SHORTS</option>
                    <option value="E4">LITTLE FROCK</option>
                    <option value="F1">KIDS T-SHIRT</option>
                    <option value="G1">ACCESSORIES</option>
                    <option value="F1">MADE UPS</option>
                </select>
            </td>

            <td>
                <select class="form-control" title="series" id="sel_series">
                    <option>SELECT</option>
                    
                </select>
            </td>

            
        
        </tr>
        <tr>

            
        
            <th>FABRIC</th>
            <th>WASH</th>
            <th>FIT</th>
            <th>SO</th>
            
            
        </tr>
            
        <tr>
        <td>
                <select class="form-control" title="fab">
                    <option>SELECT</option>
                    <option>A-COTTON KNIT</option>
                    <option>B-POLY KNIT</option>
                    <option>C-3/1 RING</option>
                    <option>D-3/1 OE</option>
                    <option>E-3/1 POLY</option>
                    <option>F-SATIN</option>
                    <option>G-3/1 SATIN</option>
                    <option>H-DOBBY</option>
                    <option>I-2/1</option>
                    <option>J-SHIRTING PRINT</option>
                    <option>K-SHIRTING PLAIN</option>
                    <option>L-SHIRTING CHECKS</option>
                    <option>M-RIGID</option>
                    <option>N-CORDUROY</option>
                </select>
            </td>
            <td>
                <select class="form-control" title="wash">
                    <option>SELECT</option>
                    <option>1-RAW ONLY</option>
                    <option>2-RAW RESIN</option>
                    <option>3-RAW RESIN 3D</option>
                    <option>4-RAW TOWEL</option>
                    <option>5-RAW TINT</option>
                    <option>6-RAW + MANUAL DRY PROCESS</option>
                    <option>7-RAW RESIN+ MANUAL DRY PROCESS</option>
                    <option>8-RAW RESIN 3D + MANUAL DRY PROCESS</option>
                    <option>9-RAW TOWEL + MANUAL DRY PROCESS</option>
                    <option>10-RAW TINT+ MANUAL DRY PROCESS</option>
                    <option>11-RAW + LASER DRY PROCESS</option>
                    <option>12-RAW RESIN+ LASER DRY PROCESS</option>
                    <option>13-RAW RESIN 3D + LASER DRY PROCESS</option>
                    <option>14-RAW TOWEL +LASERL DRY PROCESS</option>
                    <option>15-RAW TINT+ LASER DRY PROCESS</option>
                    <option>16-ENZYME ONLY</option>
                    <option>17-ENZYME + MANUAL DRY PROCESS</option>
                    <option>18-ENZYME + LASER DRY PROCESS</option>
                    <option>19-ENZYME + TINT + LASER DRY PROCESS</option>
                    <option>20-ENZYME + TINT + MANUAL DRY PROCESS</option>
                    <option>21-ENZYME + TOWEL + LASER DRY PROCESS</option>
                    <option>22-ENZYME + TOWEL + MANUAL DRY PROCESS</option>
                    <option>23-ENZYME + BLEACH WASH ONLY</option>
                    <option>24-ENZYME + BLEACH + MANUAL DRY PROCESS</option>
                    <option>25-ENZYME + BLEACH + LASER DRY PROCESS</option>
                    <option>26-ENZYME + BLEACH +TOWEL + LASER DRY PROCESS</option>
                    <option>27-ENZYME + BLEACH +TOWEL + MANUAL DRY PROCESS</option>
                    <option>28-ENZYME + BLEACH +TINT + TOWEL + LASER DRY PROCESS</option>
                    <option>29-ENZYME + BLEACH +TINT + TOWEL + MANUAL DRY PROCESS</option>
                    <option>30-BLEACH WASH ONLY</option>
                    <option>31-BLEACH + MANUAL DRY PROCESS</option>
                    <option>32-BLEACH + LASER DRY PROCESS</option>
                    <option>33-BLEACH + TOWEL + LASER DRY PROCESS</option>
                    <option>34-BLEACH + TOWEL + MANUAL DRY PROCESS</option>
                    <option>35-BLEACH + TINT + LASER DRY PROCESS</option>
                    <option>36-BLEACH + TINT + MANUAL DRY PROCESS</option>
                    <option>37-OD-BLACK</option>
                    <option>38-OD-KHAKI</option>
                    <option>39-ENZYME +TINT + TOWEL + MANUAL DRY PROCESS</option>
                    <option>40-ENZYME +TINT + TOWEL + LASER DRY PROCESS</option>
                    <option>41-ENXYME + BLEACH +TINT + TOWEL + MANUAL DRY PROCESS</option>
                    <option>42-ENXYME + BLEACH +TINT + TOWEL + LASER DRY PROCESS</option>
                    <option>43-RAW + TOWEL +TINT + MANUAL DRY PROCESS</option>
                    <option>44-RAW + TOWEL +TINT + LASER DRY PROCESS</option>
                    <option>45-RAW + RESIN +TINT + MANUAL DRY PROCESS</option>
                    <option>46-OD GRAY</option>
                    <option>47-OD PISTA GREEN</option>
                    <option>48-OD RAMA</option>
                    <option>49-OD GREEN</option>
                    <option>50-OD BROWN</option>
                    <option>51-SOFTENER</option>
                    <option>52-OD MILITARY OLIVE + DRY PROCESS</option>
                   
                </select>
            </td>

            <td>
            <select class="form-control" title="fit">
                    <option>SELECT</option>
                    <option>SLIM</option>
                    <option>COMFORT</option>
                    <option>REGULAR</option>
                    
                </select>
            </td>
            <td>
                <input type="text" name="month" id="month" title="sono" >
            </td>

            

            

        </tr>
                    
    </table>
    <br>
    <button type="button" name="makeart2" id="makeart2" class="btn btn-info">SAVE ART NO</button>
    <hr>
    </div>
    
    <div id="barshow" class="noshow">
        <table id="bartab">
        
            <tr>
                <td>SELECT <input type="checkbox" id="masterchk" checked/>
                </td>
                <td>BARCODE</td>
                <td>ART NO</td>
                <td>CATAGORY</td>
                <td>SIZE</td>
                <td>INSEAM</td>
                <td>COLOR</td>
                <td>QTY</td>
                <td>PKD</td>
                <td>SERIES</td>
                <td>MRP</td>
                <td>FIT</td>
            </tr>
        
        </table>
        <br><br>
        <button type="button" name="prntBar" id="prntBar" class="btn btn-info">PRINT BARCODE</button>
        <button type="button" name="prntBar2" id="prntBar2" class="btn btn-info">PRINT STICKER</button>
    </div>
    
</div>
</div>
<form id="POForm" class="noshow" action="printbarcodepdf.php" target="_blank" method="post">
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        
      </form>
      <form id="POForm2" class="noshow" action="printbarcodepdfOS2.php" target="_blank" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>
<script>
    // select all or none

    $("#masterchk").click(function(){
        //alert("cl");
        var k=$(this).prop("checked");
        $("#bartab tr:not(:eq(0))").each(function(){
            $(this).find("td:eq(0) input.chkprnt").prop("checked",k);
        });
    });

    // decode SUBcatagory from this array
    
    men_cat={
    'A':"MEN'S JEANS",
    'B':"MEN'S JEANS",
    'C':"MEN'S JEANS",
    'D':"MEN'S JEANS",
    'E':"MEN'S JEANS",
    'F':"MEN'S JACKET",
    'U':"MEN'S JEANS",
    'H':"MEN'S SHIRT",
    'I':"MEN'S SHIRT",
    'J':"MEN'S SHIRT",
    'K':"MEN'S SHIRT",
    'L':"MEN'S SHIRT",
    'M':"MEN'S T-SHIRT",
    'O':"MEN'S T-SHIRT",
    'P':"MEN'S T-SHIRT",
    'Q':"MEN'S T-SHIRT",
    'V':"MEN'S SHORTS",
    'W':"MEN'S SHORTS",
    'N':"MEN'S SHORTS",
    'T':"MEN'S TRACK",
    'Z':"MEN'S BOXER",
    'S':"MEN'S FORMAL",
    'R':"MEN'S CASUAL"
   
    };
    women_cat={
    'A':"WOMEN'S JEANS",
    'B':"WOMEN'S JEANS",
    'C':"WOMEN'S JEANS",
    'D':"WOMEN'S JEANS",
    'U':"WOMEN'S JEANS",
    'E':"WOMEN'S KURTI",
    'F':"WOMEN'S KURTI",
    'G':"WOMEN'S KURTI",
    'H':"WOMEN'S KURTI",
    'P':"WOMEN'S PLAZO",
    'I':"WOMEN'S SHORTS",
    'J':"WOMEN'S SHORTS",
    'L':"WOMEN'S LOWER",
    'K':"WOMEN'S T-SHIRT",
    'R':"WOMEN'S T-SHIRT",
    'M':"WOMEN'S T-SHIRT",
    'N':"WOMEN'S T-SHIRT",
    'O':"WOMEN'S SHIRT",
    'P':"WOMEN'S SHIRT",
    'Q':"WOMEN'S SHIRT",
    'S':"WOMEN'S JACKET",
    'W':"WOMEN'S LOWER"
    

};

    boys_cat={
        'M':"BOY'S T-SHIRT",
        'O':"BOY'S T-SHIRT",
        'P':"BOY'S T-SHIRT",
        'Q':"BOY'S T-SHIRT",
        'A':"MEN'S JEANS",
        'B':"BOY'S JEANS",
        'C':"BOY'S JEANS",
        'D':"BOY'S JEANS",
        'E':"BOY'S JEANS",
        'J':"BOY'S SHIRT",
        'V':"BOY'S SHORTS",
        'W':"BOY'S SHORTS",
        'N':"BOY'S SHORTS"
    };
    girls_cat={
        'K':"GIRL'S T-SHIRT",
        'R':"GIRL'S T-SHIRT",
        'M':"GIRL'S T-SHIRT",
        'N':"GIRL'S T-SHIRT",
        'A':"GIRL'S JEANS",
        'B':"GIRL'S JEANS",
        'C':"GIRL'S JEANS",
        'D':"GIRL'S JEANS",
        'I':"GIRL'S SHORTS",
        'E':"GIRL'S FROCK",
        'G':"GIRL'S SKIRT",
        'J':"GIRL'S SHORTS",
        'F':"GIRL'S FROCK"
    };
    little_cat={
        'K':"LITTLE T-SHIRT",
        'R':"LITTLE T-SHIRT",
        'M':"LITTLE T-SHIRT",
        'N':"LITTLE T-SHIRT",
        'A':"LITTLE JEANS",
        'B':"LITTLE JEANS",
        'C':"LITTLE JEANS",
        'D':"LITTLE JEANS",
        'G':"LITTLE SKIRT",
        'I':"LITTLE SHORTS",
        'E':"LITTLE FROCK",
        'F':"LITTLE FROCK"
    };
    kids_cat={
        'M':"KIDS T-SHIRT",
        'O':"KIDS T-SHIRT",
        'P':"KIDS T-SHIRT",
        'Q':"KIDS T-SHIRT",
        'A':"KIDS JEANS",
        'B':"KIDS JEANS",
        'C':"KIDS JEANS",
        'D':"KIDS JEANS",
        'E':"KIDS JEANS",
        'J':"KIDS SHIRT",
        'V':"KIDS SHORTS",
        'W':"KIDS SHORTS",
        'N':"KIDS SHORTS",
        'T':"KIDS TRACK",
        
    }

    acc_cat={
        'A':'APRON',
        'B':"DENIM BAGS"
    }
    madeups_cat={
        'D':'DOUBLE BED SHEET',
        'S':'SINGLE BED SHEET',
        'K':'KINGSIZE BED SHEET'
    }
    // show the div for making new article no

    $("#makeart").click(function(){
        $("div#artshow").toggleClass("noshow");
       if($("div#artshow").hasClass("noshow")){
           
        $(this).html("NEW ART NO");
       }else{
        $(this).html("HIDE");
       }
        
       
    });
    $("#makeart2").click(function(){
        //alert("c");
        var data=check_and_collect_values("#maintab");
        console.log(data);
        // return false;
        if(data.goahead=='yes'){
            data=JSON.stringify(data);
            $.post("P_artno.php",{data:data},function(ret_data){
                console.log(artno);
                console.log(ret_data);
                //return false;
                $("input#artno").val(ret_data);
                var d='<div class="alert alert-info" role="alert">'+ret_data+"</div>";
                //alert(ret_data);
                var ret_data2=ret_data.replace(/(\r\n|\n|\r)/gm,"");
                    artno.push(ret_data2);
                    console.log("AAAAAAAAAA");
                    console.log(artno);
                $("p#artnewno").html(d);
            });
        }
    });

    //generate new barcodes
    $("#get_bar").click(function(){
        $("div#barshow").removeClass("noshow");
        if(!$("div#artshow").hasClass("noshow")){
            
            $("div#artshow").addClass("noshow");
        }



        var article=$("#artno").val();
        var ind=$.inArray(article,artno);
        //alert(ind);
        if(ind==-1){
            alert("Article No not found!")
            return false;
        }else{
           // alert("gin");
           var data=check_and_collect_values("#tabmain");
           console.log(data);
           if(data.goahead=='yes'){
               data=JSON.stringify(data);
               $.post("getbarcode.php",{data:data},function(r){
                   console.log(r);
                   
                   var rt=JSON.parse(r);
                   $.each(rt,function(i,v){
                       console.log(i);
                       console.log("_____");
                       console.log(v);
                       var row="<tr><td><input type='checkbox' checked class='chkprnt'/> </td><td>"+i+"</td><td>"+v.artno+"</td>";
                       var cat='';
                       if(v.artno[1]==='M'){
                           cat=men_cat[v.artno[2]];
                       }else if(v.artno[1]==='W'){
                        cat=women_cat[v.artno[2]];
                       }else if(v.artno[1]==='B'){
                           cat=boys_cat[v.artno[2]];
                       }else if(v.artno[1]==='G'){
                           cat=girls_cat[v.artno[2]];
                       }else if(v.artno[1]==='L'){
                           cat=little_cat[v.artno[2]];
                       }else if(v.artno[1]==='K'){
                           cat=kids_cat[v.artno[2]];
                       }else if(v.artno[1]==='A'){
                           cat=acc_cat[v.artno[2]];
                       }else if(v.artno[1]==='D'){
                           cat=acc_cat[v.artno[2]];
                       }
                       var cmaux="";
                       if(v.szcm!=='0'){
                            cmaux="/"+v.szcm+" CM";
                       }else{
                           cmaux="";
                       }
                        

                       row+="<td>"+cat+"</td><td>"+v.sz+cmaux+"</td><td>"+v.inseam+"</td><td>"+v.color+"</td>";
                       row+="<td>"+v.qty+"</td><td>"+v.pkd+"</td><td>"+v.series+"</td><td>"+v.mrp+"</td><td>"+v.fit+"</td>";
                       
                       $("#bartab").append(row);
                   });
               });
                
           }
          
        }

    });

    $("#prntBar").click(function(){
        //alert("select");
        var data={};
        $("#bartab tr:not(:eq(0))").each(function(i){
            if($(this).find("td:eq(0) input.chkprnt").prop("checked")==true){
                console.log("PPP");
                data[i]={};
                data[i]['barcode']=$(this).find("td:eq(1)").text();
                data[i]['artno']=$(this).find("td:eq(2)").text();
                data[i]['cat']=$(this).find("td:eq(3)").text();
                data[i]['sz']=$(this).find("td:eq(4)").text();
                data[i]['inseam']=$(this).find("td:eq(5)").text();
                data[i]['color']=$(this).find("td:eq(6)").text();
                data[i]['qty']=$(this).find("td:eq(7)").text();
                data[i]['pkd']=$(this).find("td:eq(8)").text();
                data[i]['series']=$(this).find("td:eq(9)").text();
                data[i]['mrp']=$(this).find("td:eq(10)").text();
                data[i]['fit']=$(this).find("td:eq(11)").text();
            }
        });
        console.log(data);
        data=JSON.stringify(data);
        $("#holder2").val(data);
        $("#POForm").submit();

    });

// print sticker with logo
$("#prntBar2").click(function(){
        //alert("select");
        var data={};
        $("#bartab tr:not(:eq(0))").each(function(i){
            if($(this).find("td:eq(0) input.chkprnt").prop("checked")==true){
                console.log("PPP");
                data[i]={};
                data[i]['barcode']=$(this).find("td:eq(1)").text();
                data[i]['artno']=$(this).find("td:eq(2)").text();
                data[i]['cat']=$(this).find("td:eq(3)").text();
                data[i]['sz']=$(this).find("td:eq(4)").text();
                data[i]['inseam']=$(this).find("td:eq(5)").text();
                data[i]['color']=$(this).find("td:eq(6)").text();
                data[i]['qty']=$(this).find("td:eq(7)").text();
                data[i]['pkd']=$(this).find("td:eq(8)").text();
                data[i]['series']=$(this).find("td:eq(9)").text();
                data[i]['mrp']=$(this).find("td:eq(10)").text();
                data[i]['fit']=$(this).find("td:eq(11)").text();
            }
        });
        console.log(data);
        data=JSON.stringify(data);
        $("#holder1").val(data);
        $("#POForm2").submit();

    });






    var sz_in_inch={
                    'REGULAR':0,
                    0:0,
                    22:56,
                    24:61,
                    26:66,
                    28:71,
                    30:76,
                    32:81,
                    34:86,
                    36:91,
                    38:96,
                    40:101,
                    42:106,
                    44:111,
                    48:116,
                    'XS':34,
                    'S':36,
                    'M':38,
                    'L':40,
                    'XL':42,
                    'XXL':44,
                    '3XL':46,
                    '14-15Y':0,
                    '2-3Y':0,
                    '3-4Y':33,
                    '4-5Y':0,
                    '5-6Y':35,
                    '6-7Y':0,
                    '7-8Y':38,
                    '8-9Y':0,
                    '9-10Y':40,
                    '10-11Y':0,
                    '12-13Y':43,
                    '14-15Y':45,
                    '16-17Y':48,
                    '6-12M':0,
                    '12-18M':0,
                    '18-24M':0,

                    
                    
                   
                };

    function set_cm_value(ele){
        var szinch=$(ele).val();
        var szcm=sz_in_inch[szinch];
        //console.log(szcm,szinch);
        $("#sel_szcm").val(szcm);//
    }
</script>
