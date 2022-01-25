<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultra');
//========================================================================
$q="select distinct artno from `Q__artno__sz` ";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $artdata[]=$r['artno'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
// get series
function get_gen_series($DBH,$gen){
    $q="select distinct series from `Q__seriesmrp` where catagory like '$gen%'" ;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['series'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
}
//----------------------------------------------------------------
function get_gen_series_os($DBH,$gen){
    // get catagory
    
      $q="select distinct series from `Q__os__madeups` where cat='MADEUPS'" ;
      echo $q;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['series'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
    }
//=========================================================================
// get cataogry
function get_gen_cat($DBH,$gen){
    // get catagory
    
      $q="select distinct catagory from `Q__seriesmrp` where catagory like '$gen%'" ;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['catagory'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
    }

//========================================================================
function get_gen_cat_os($DBH,$gen){
    // get catagory
    
      $q="select distinct subcat from `Q__os__madeups` where cat='MADEUPS'" ;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['subcat'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
    }

    $menseries=get_gen_series($DBH,'MEN');
    $womenseries=get_gen_series($DBH,'WOMEN');
    
    $boyseries=get_gen_series($DBH,'BOY');
    $girlseries=get_gen_series($DBH,'GIRL');
    
    $littleseries=get_gen_series($DBH,'LITTLE');
    $kidseries=get_gen_series($DBH,'KID');
    $accseries=get_gen_series($DBH,'ACCESSORIES');
    $madeups_s=get_gen_series_os($DBH,'MADEUPS');

    // var_export($menseries);
    // echo '<hr>';
    $mencat=get_gen_cat($DBH,'MEN');
    $womencat=get_gen_cat($DBH,'WOMEN');
    
    $boycat=get_gen_cat($DBH,'BOY');
    $girlcat=get_gen_cat($DBH,'GIRL');
    
    $littlecat=get_gen_cat($DBH,'LITTLE');
    $kidcat=get_gen_cat($DBH,'KID');
    $acccat=get_gen_cat($DBH,'ACCESSORIES');
    $madeups=get_gen_cat_os($DBH,'MADEUPS');
    

?>
<script>
    var artdata=<?php print json_encode($artdata);?>;

    var menseries=<?php print json_encode($menseries);?>;
    //console.log(menseries);
    var womenseries=<?php print json_encode($womenseries);?>;

    var boyseries=<?php print json_encode($boyseries);?>;
    var girlseries=<?php print json_encode($girlseries);?>;

    var littleseries=<?php print json_encode($littleseries);?>;
    var kidseries=<?php print json_encode($kidseries);?>;
    var accseries=<?php print json_encode($accseries);?>;
    var madeups_s=<?php print json_encode($madeups_s);?>;

    var mencat=<?php print json_encode($mencat);?>;
    var womencat=<?php print json_encode($womencat);?>;

    var boycat=<?php print json_encode($boycat);?>;
    var girlcat=<?php print json_encode($girlcat);?>;

    var littlecat=<?php print json_encode($littlecat);?>;
    var kidcat=<?php print json_encode($kidcat);?>;
    var acccat=<?php print json_encode($acccat);?>;
    var madeups=<?php print json_encode($madeups);?>;
    //console.log(madeups);

    $("#inp_frmdt").datepicker({ dateFormat: 'dd/mm/yy' });
     $("#inp_todt").datepicker({ dateFormat: 'dd/mm/yy' });

     $(document).ready(function(){
         $("input#inp_artno").autocomplete({
             source:artdata
         });
     });
// get subcat auto complete

function get_subcat(mc){
  switch(mc){
    case "MENS":
    return mencat;
    break;

    case "WOMENS":
    return womencat;
    break;

    case "BOYS":
    return boycat;
    break;

    case "GIRLS":
    return girlcat;
    break;

    case "LITTLE":
    return littlecat;
    break;

    case "KIDS":
    return kidcat;
    break;

    case "ACCESSORIES":
    return acccat;
    break;
    case "MADEUPS":
    return madeups;
    break;
    default:
    return 0;
  }
}
// get series
function get_series(mc){
  switch(mc){
    case "MENS":
    return menseries;
    break;

    case "WOMENS":
    return womenseries;
    break;

    case "BOYS":
    return boyseries;
    break;

    case "GIRLS":
    return girlseries;
    break;

    case "LITTLE":
    return littleseries;
    break;

    case "KIDS":
    return kidseries;
    break;

    case "ACCESSORIES":
    return accseries;
    break;
    case "MADEUPS":
    return madeups_s;
    break;
    default:
    return 0;
  }
}
</script>
    


    <!-- <div class="container-fluid"> -->
        <div class="pageShow2 container-fluid">
            <!-- first row -->
            <div class="row first_row">
                <div class="col-md-2">SELECT ARTICLE NO: </div>
                <div class="col-md-4">
                <input name="inp_artno" id="inp_artno"  class="form-control">
                </div>
               
            
                <hr> 
                <div class="col-md-2">SELECT MAIN CATAGORY: </div>
                <div class="col-md-4">
                    <select name="sel_cat" id="sel_cat"  class="form-control">
                        <option >SELECT</option>
                        <option >MENS</option>
                        <option >WOMENS</option>
                        <option >BOYS</option>
                        <option >LITTLE</option>
                        <option >KIDS</option>
                        <option >GIRLS</option>
                        <option >ACCESSORIES</option>
                        <option >MADEUPS</option>
                    </select>
                </div>
           
               
               
            </div>
            <!-- first2 row -->
            <div class="row first_row">
                
               
            
                <hr> 
           
                <div class="col-md-2">SELECT SUB CATAGORY: </div>
                <div class="col-md-4">
                    <input name="inp_subcat" id="inp_subcat"  class="form-control">
                        
                </div>
                <div class="col-md-2">SELECT SERIES: </div>
                <div class="col-md-4">
                    <input name="inp_series" id="inp_series"  class="form-control">
                        
                </div>
                
                <div id="selected_subcat" class="col-md-6"></div>
                
                <div id="selected_series" class="col-md-6"></div>
               
            </div>
            <!-- end of first2 row && begin 2nd row -->
           
            <div class="row second_row">
                <div class="fx col-md-6">
                    <div id="inp_holder" >
                        <input type="text" id="artno" placeholder="Select Artno"/>
                        <span onclick="show_options()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                        </span>
                    </div>
                    <div id="options_holder" class="noshow">
                        <ul id="options">
                    
                        <li onclick="chg_sel(this)">SELECT ALL</li>
                        <!-- <li onclick="chg_sel(this)">LAGER23</li>
                        <li onclick="chg_sel(this)">LIRGE2</li>
                        <li onclick="chg_sel(this)">LARGF3</li>
                        <li onclick="chg_sel(this)">BEGROOM</li>
                        <li onclick="chg_sel(this)">LARGE5</li>
                        <li onclick="chg_sel(this)">LARGE6</li>
                        <li onclick="chg_sel(this)">LARGE7</li>
                        <li onclick="chg_sel(this)">LARGE8</li>
                        <li onclick="chg_sel(this)">LARGE9</li> -->
                        

                    
                    
                    </ul>
                    </div>
                </div>
                <div id="selected_artno" class="col-md-6"></div>
            <!-- end of 2nd row && begin 3rd row-->
           
            
               
                
            </div>
           
            <div class="row third_row">
                <div class="col-md-1">DATE FROM: </div>
                <div class="col-md-2">
                    <input name="inp_frmdt" id="inp_frmdt"  class="form-control">
                        
                </div>
                
                
                <div class="col-md-1">DATE TO: </div>
                <div class="col-md-2">
                    <input name="inp_todt" id="inp_todt"  class="form-control">
                        
                </div>
               



                <div class="col-md-2">SELECT OUTLET: </div>
                <div class="fx col-md-4">
                    <div id="outlet_holder" >
                        <input type="text" id="outlet" placeholder="Select Outlet"/>
                        <span onclick="show_outlet()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                        </span>
                    </div>
                    <div id="outlet_choice" class="noshow">
                        <ul id="options2">
                    
                        <li onclick="outlet_sel(this)">SELECT ALL</li>
                        <li onclick="outlet_sel(this)">CENTRAL</li>
                        <li onclick="outlet_sel(this)">PALSANA</li>
                        <li onclick="outlet_sel(this)">VATVA</li>
                        <li onclick="outlet_sel(this)">HMT</li>
                        <li onclick="outlet_sel(this)">VISHNAGAR</li>
                        <li onclick="outlet_sel(this)">VATVAGIDC</li>
                        <li onclick="outlet_sel(this)">GITAMANDIR</li>
                        <li onclick="outlet_sel(this)">KAMREJ</li>
                        <li onclick="outlet_sel(this)">JAHGIRPURA</li>
                        
                        

                    
                    
                    </ul>
                    </div>
                    </div>
                    <hr>
                    <div class="col-md-1">MIN STOCK: </div>
                <div class="col-md-2">
                    <input name="inp_minstk" id="inp_minstk"  type="number"class="form-control">
                        
                </div>
                
                
                <div class="col-md-1">MAX STOCK: </div>
                <div class="col-md-2">
                    <input name="inp_maxstk" id="inp_maxstk" type="number"  class="form-control">
                        
                </div>
                <hr>
                
                <div class="col-md-6"></div>
                <div class="col-md-3">SALES REPORT ONLY: </div>
                <br><br><br><br>
                <div class="col-md-3  d-flex start">
                
                    <input name="chk_sales" id="chk_sales" type="checkbox" style="margin-left:-120px;">
                        
                </div>
               
            
            </div>
            <div class="row fourth_row" >
                <div class="col-md-12" id="fsx3">
                    <input type="button" value="ON SCREEN" id="onscreen" class="btn btn-primary"/>
                    <input type="button" value="EXCEL" id="onexp" class="btn btn-danger"/>
                </div>
            
            </div>
            <hr>
            <div id="showdata">
                show data here//
            </div>
            
            
           
            
            
        </div>
    <!-- </div> -->


<style>

div#fsx3{
    display:flex;
    justify-content:flex-end;
    /* padding:5px; */
    align-items:center;
    background:#FFFFFF;
}
ul#options{
    margin:0;
    text-align:left;
    padding-left:8px;
}
ul#options li,ul#options2 li{
    cursor:pointer;
}
ul#options li:hover{
    background:steelblue;
    color:#FFFFFF;
}
div#inp_holder{
    text-align:left;
    
}
#artno{
    width:70%;
    text-align:left;
    margin:0;
}
div#options_holder{
    width:70%;
    min-height:150px;;
    max-height:150px;
    background:#FFFFFF;
    border-radius:2px;
    overflow-y:scroll;
    overflow-x:hidden;
    border:1px solid #cdcdcd;
    margin-top:2px;
}
div#outlet_choice{
    width:70%;
    min-height:150px;;
    max-height:150px;
    background:#FFFFFF;
    border-radius:2px;
    overflow-y:scroll;
    overflow-x:hidden;
    border:1px solid #cdcdcd;
    margin-top:2px;
    text-align:left;
    padding-left:3px;
}
span.gg{
    
    padding:2px;
    border:1px solid #ddd;
    margin:1px;
    display:flex;
    align-items:center;
    justify-content:center;
}
    span.gg img{
        width:12px;
        height:12px;
        margin:3px;
    }
    span.gg2{
    
    padding:2px;
    border:1px solid #ddd;
    margin:1px;
    
}
    span.gg2 img{
        width:12px;
        height:12px;
        margin:3px;
    }
    #sel_cat{
        width:70%;
    }
    .lineup{
        margin-top:5px;
        background: #FFFFFF;
    }
    .fx{
        /* background:steelblue; */
        display:flex;
        flex-direction:column;
        width:100%;
        
    }
    .hlight{
        background:steelblue;
        color:#FFFFFF;
    }
    div#selected_artno{
        height:auto;
        max-height:200px;
        overflow-y:scroll;
        overflow-x:hide;
        text-align:left;
        border:1px solid #cdcdcd;
        /* background:yellow; */
        display:flex;
        flex-wrap:wrap;
    }
    .first_row{
        background:#ffffff;;
        display:flex;
        align-items:center;
        margin-bottom:10px;
        padding:10px;
    }
    .second_row{
        background:#ffffff;
        
        margin-bottom:10px;
        padding:10px;
    }
    .third_row{
        background:#ffffff;
        margin-top:10px;
        margin-bottom:10px;
        padding:10px;
    }
    
    .C1{
        background:#F2F2F2;
    }
    .red{
        background-color: red;
    }
    .minom{
        color:red;
        background-color: yellow;
    }
    .maxom{
        color:green;
        background-color: lightblue;
    }
    #inp_frmdt,#inp_todt{
        z-index: 500;
    }
    div#showdata{
        /* background-color:cyan; */
        max-width:99%;
        max-height:900px;
        overflow-x:scroll;
        overflow-y:scroll;
    }
</style>
<script>
artno_reverse={
  "MEN'S JACKET":"A2",
  "MEN'S JEANS":'A2',
  "MEN'S SHIRT":'A3',
  "MEN'S T-SHIRT":'A4',
  "MEN'S SHORTS":'A5',
  "MEN'S TRACK":'B1',
  "MEN'S BOXER":'B2',
  "MEN'S CASUAL":'A10',
  "MEN'S FORMAL":'A11',

  "WOMEN'S JEANS":'A6',
  "WOMEN'S KURTI":'A7',
  "WOMEN'S PLAZO":'A8',
  "WOMEN'S SHORTS":'A9',
  "WOMEN'S LOWER":'B3',
  "WOMEN'S T-SHIRT":'B4',
  "WOMEN'S SHIRT":'B5',
  "WOMEN'S JACKET":'B6',

  "BOY'S T-SHIRT":'C1',
  "BOY'S JEANS":'C2',
  "BOY'S SHIRT":'C3',
  "BOY'S SHORTS":'C4',

  "GIRL'S T-SHIRT":'D1',
  "GIRL'S JEANS":'D2',
  "GIRL'S SHORTS":'D3',
  "GIRL'S FROCK":'D4',
  "GIRL'S SKIRT":'D5',

  "LITTLE T-SHIRT":'E1',
  "LITTLE JEANS":'E2',
  "LITTLE SKIRT":'E3',
  "LITTLE SHORTS":'E4',
  "LITTLE FROCK":'E5',

  "KIDS T-SHIRT":'F1',
  "KIDS JEANS":'F2',
  "KIDS SHIRT":'F3',
  "KIDS SHORTS":'F4',
  "QUEEN BED SHEET":'Q',
  "KING BED SHEET":'K',
    "SINGLE BED SHEET":'S',
    "TOWEL":'T',
    "NAPKIN":'N',
    "HANDKERCHIEF":'H'
    
};
// get list of artno from seris
function get_artno3(subcat){
    console.log("U PASS THIS 4D...:");
    console.log(subcat);
  // get and load artno list with this catagory
  $.post("P4_gmtpo.php",{cat:subcat},function(data){
    var d=JSON.parse(data);
    
    console.log("D4____:");
    console.log(d);
    var liaddon="";
    $(d.artno).each(function(i,v){
        //console.log(i,"--",v);
        liaddon+="<li title='"+d.cat[0]+"'onclick=\"chg_sel(this)\">"+v+"</li>";
    });
$("ul#options").append(liaddon);

  });
}

// get list of artno from catagory

function get_artno2(subcat){
console.log("U PASS THIS(get_artno2)...:");
  console.log(subcat);
  // get and load artno list with this catagory
  $.post("P_gmtpo.php",{cat:artno_reverse[subcat.toUpperCase()]},function(data){
    var d=JSON.parse(data);
    var subcat2=artno_reverse[subcat.toUpperCase()];
    console.log("D____:");
    console.log(d);
    var liaddon="";
    $(d).each(function(i,v){
        liaddon+="<li title='"+subcat2+"'onclick=\"chg_sel(this)\">"+v+"</li>";
    });
$("ul#options").append(liaddon);

  });
}
// load option while typing in artno field
$("#artno").keyup(function(){
    $("div#options_holder").removeClass("noshow");
    var v=$(this).val().toUpperCase();
    console.log(v);
    if(v!==''){
        
        $("ul#options li:not(:eq(0))").each(function(){
            if($(this).text().indexOf(v)>-1){
                //alert('yes');
                $(this).css("display","block");

            }else{
                //alert("no");
                $(this).css("display","none");
            }
        });
    }else{
        
        $("ul#options li:not(:eq(0))").each(function(){
            $(this).css("display","block");
        });

    }
    
});
var sel_outlet=[];
function outlet_sel(ele){
    var eq=-1;
    eq=$(ele).index();
    //console.log("eq:"+eq);


    $(ele).toggleClass("hlight");
    var val=$(ele).text();
    var cl=$(ele).hasClass("hlight");
    //console.log(cl);
    
    var it=$.inArray(val,sel_outlet);
    if(cl==true&&it==-1&&eq!=0){
        //alert("cl=J");
        sel_outlet.push(val);
       
        
    }else if(cl==false&&it>-1&&eq!=0){
        //alert("cl=N");
        sel_outlet.splice(it,1);
        
        // function to select all
    }else if(cl==true&&it==-1&&eq==0){
        //alert("cl=M");
        sel_outlet=[];
        
        $(ele).parent().find("li:not(li.hlight)").addClass("hlight");
        $(ele).siblings().each(function(i,v){
            
            var val2=$(this).text();
            var eq2=$(this).index();
            sel_outlet.push(val2);
            
            
        });

    }else if(cl==false&&it==-1&&eq==0){
         
        $(ele).parent().find("li").removeClass("hlight");
        sel_outlet=[];
        

    }
    
    console.log(sel_outlet);
   
    
   

}
    

var selected_artno=[];

var sel_artno=[];
var direct_artno=[];
var direct_cat=[];
//direct input for artno
$("#inp_artno").change(function(){
    //alert("k");
    var v=$(this).val();
    
   
    $.post("P2_salesAnalysis.php",{artno:v},function(data){
        console.log("P2_salesAnalysis");
        console.log(data);
        mata=JSON.parse(data);
        var cls_code=mata['code'];
        var cat=mata['cat'];
        
        direct_artno.push({clas:cls_code,art:v});
        direct_cat.push(cat);
        var item="<span class='gg'>"+v+"<img src='../img88/cross.png' onclick=\"rrem3(this)\"/></span>";
        $("div#selected_artno").append(item);
        console.log("frm P2analys")
        console.log(direct_artno);
        console.log(direct_cat);
    });
   
});
function chg_sel(ele){
    //alert("cl=y");
    var eq=-1;
    eq=$(ele).index();
    //console.log("eq:"+eq);


    $(ele).toggleClass("hlight");
    var val=$(ele).text();
    var cl=$(ele).hasClass("hlight");
    //console.log(cl);
    var clas=$(ele).attr("title");
    //var clas=clas2[0];
    var it=$.inArray(val,selected_artno);
    if(cl==true&&it==-1&&eq!=0){
        //alert("cl=J");
        selected_artno.push(val);
       
        sel_artno.push({clas:clas,art:val});
       
        var item="<span class='gg'>"+val+"<img src='../img88/cross.png' onclick=\"rrem2(this,"+eq+")\"/></span>";
        $("div#selected_artno").append(item);

   
        
    }else if(cl==false&&it>-1&&eq!=0){
        //alert("cl=N");
        selected_artno.splice(it,1);
        sel_artno.splice(it,1);
        $("div#selected_artno").find("span:contains('"+val+"')").css("color","red");
        $("div#selected_artno").find("span:contains('"+val+"')").remove();
        //rrem2(ele,eq);
        // function to select all
    }else if(cl==true&&it==-1&&eq==0){
        //alert("cl=M");
        selected_artno=[];
        sel_artno=[];
        $('div#selected_artno').html('');
        $(ele).parent().find("li:not(li.hlight)").addClass("hlight");
        $(ele).siblings().each(function(i,v){
            var clas=$(this).attr("title");
            var val2=$(this).text();
            var eq2=$(this).index();
            selected_artno.push(val2);
            sel_artno.push({clas:clas,art:val2});
            var item="<span class='gg'>"+val2+"<img src='../img88/cross.png' onclick=\"rrem2(this,"+eq2+")\"/></span>";
            $("div#selected_artno").append(item);
        });

    }else if(cl==false&&it==-1&&eq==0){
         
        $(ele).parent().find("li").removeClass("hlight");
        selected_artno=[];
        sel_artno=[];
        $('div#selected_artno').html('');

    }
    
    console.log(selected_artno);
    console.log(sel_artno);
    
    
}
function show_options(){
    //alert("h");
    $("div#options_holder").toggle("noshow")
}
function show_outlet(){
    //alert("h");
    $("div#outlet_choice").toggle("noshow")
}
//var main_cat=[];
// choose and put main catagory
$("#sel_cat3").change(function(e){
    var main_cat=$(this).val();
    // var m="<h3>"+main_cat+"</h3>";
    // $("div#main_cat").html(m);
    
});
$("#sel_cat").change(function(){
  var mc=$(this).val();
  var subcat=get_subcat(mc);
  var series=get_series(mc);
  //console.log(subcat);
  $("#inp_subcat").autocomplete({
    source:subcat
  });
  $("#inp_series").autocomplete({
    source:series
  });
  selected=[];

});
//load sub catagory options
var selected=[];
$("#inp_subcat").change(function(e){
    var it=$(e.target).val();
    console.log(it);
    var k=$.inArray(it,selected);
    //alert(k);
    if(k==-1){
        //alert("yes");
        selected.push(it);
    }
    
    console.log(selected);
    console.log(selected.length);
    $("div#selected_subcat").html('');
    $(selected).each(function(i,v){
        var item="<span class='gg2'>"+v+"<img src='../img88/cross.png' onclick=\"rrem(this,"+i+")\"/></span>";
        $("div#selected_subcat").append(item);
        

    });
    get_artno2(it);// add all the article numbers of this subcat in the dropdown list of select all
    $(this).val('');
    
});

// $("#inp_series").change(function(){
//     alert("mac");
//     var k=90;
//     console.log("it");
//     console.log(k);
// });




// load series options
var selected_s=[];
$("#inp_series").change(function(){
    var it=$("#inp_series").val();
    console.log("it");
    console.log(it);
    //alert(it);
    //return false;
    var k=$.inArray(it,selected_s);
    //alert(k);
    if(k==-1){
        //alert("yes");
        selected_s.push(it);
    }
    
    console.log(selected_s);
    console.log(selected_s.length);
    $("div#selected_series").html('');
    $(selected_s).each(function(i,v){
        var item="<span class='gg2'>"+v+"<img src='../img88/cross.png' onclick=\"rrem(this,"+i+")\"/></span>";
        $("div#selected_series").append(item);
        //get_artno3(it);

    });
    get_artno3(it);
    $(this).val('');
    
});
// ====================================================delete from selection
function rrem(ele,index){
    //alert(ele.val());
    //$(ele).parent().css("background","red");
    //console.log($(ele).parent().text());
    $(ele).parent().remove();
    var vl=$(ele).parent().text();
   //var c=$("#sel_cat").find("option:contains('MENS')").css('color','green');
    //var c=$("#sel_cat").find("option:eq("+index+")").css("color","red");
    var c=$("#sel_cat").find("option:eq("+index+")").prop('selected',false);
    console.log(index);
    var del=$("#sel_cat").find("option:eq("+index+")").val();
    console.log(del);
    //delete selected[index];
    selected.splice(index,1);
    console.log(selected);
}
function rrem2(ele,index){
    
    $(ele).parent().remove();
    var vl=$(ele).parent().text();
   //var c=$("#sel_cat").find("option:contains('MENS')").css('color','green');
    //var c=$("#sel_cat").find("option:eq("+index+")").css("color","red");
    var c=$("ul#options").find("li:eq("+index+")");
    c.removeClass("hlight");
    console.log(index);
    var it=$.inArray(vl,selected_artno);
    selected_artno.splice(it,1);
    sel_artno.splice(it,1);
    //console.log(selected_artno);
    //console.log(sel_artno);
    
}
function rrem3(ele){
    
    $(ele).parent().remove();
    var vl=$(ele).parent().text();
   //var c=$("#sel_cat").find("option:contains('MENS')").css('color','green');
    //var c=$("#sel_cat").find("option:eq("+index+")").css("color","red");
    ;
    var index =direct_artno.map(function(e) { return e.art; }).indexOf(vl);
    direct_artno.splice(index,1);
    
    var index2 = sel_artno.map(function(e) { return e.art; }).indexOf(vl);
    sel_artno.splice(index2,1);
    // console.log("after delte");
    // console.log(vl);
    // console.log(index,index2);
    // console.log(direct_artno);
    // console.log(sel_artno);
    
}
// get playing with data

$("#onscreen").click(function(){
    // merge the data coming from direct input field
    console.log(sel_artno);
    $(direct_artno).each(function(i,v){
        console.log("direct");
        console.log(v)
        // var k=indexOf(v,sel_artno);
        // alert(k);
        var index = sel_artno.map(function(e) { return e.art; }).indexOf(v.art);
        //alert(index);
        if(index==-1){
            sel_artno.push(v);
        }
        
    });
    var frmdt=$("#inp_frmdt").val().split("/").reverse().join("-");
    var todt=$("#inp_todt").val().split("/").reverse().join("-");

    var minstk=$("#inp_minstk").val();
    var maxstk=$("#inp_maxstk").val();
    var salesrep=$("#chk_sales").prop("checked")?1:0;
    console.log("final values here_______");
    console.log(minstk,maxstk,salesrep);
   
    var cat=JSON.stringify(selected);
    var artno=JSON.stringify(sel_artno);
    console.log("PPPPPPP");
    console.log(cat,artno);
    var outlet=JSON.stringify(sel_outlet);
    var di='<div class="loader"></div>';
    $("div#showdata").html(di);
    $("#showdata").load("P_salesAnalysis.php",
        {artno:artno,cat:cat,frmdt:frmdt,todt:todt,outlet:outlet,minstk:minstk,maxstk:maxstk,sales:salesrep});
});
</script>
