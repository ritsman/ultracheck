<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultra');
//==============================================================================
$newpono=get_new_pono22($DBH,'gmtpo');
$pono="GPO/".$newpono;
// name of sz charts
$q6a = "select distinct name  from Q__cat_szchart";
$suppa = [];


try {

   $stm = $DBH->prepare($q6a);
   $stm->execute();
   if ($stm->rowCount() > 0) {
       while ($result2 = $stm->fetch(PDO::FETCH_ASSOC)) {
           $suppa[] = $result2['name'];
       }
       //echo "<hr/>";
       //print_r($supp);
   } else {
       $suppa = null;
   }
} catch (PDOException $e) {
   echo $e->getMessage();
   $suppa = null;
}

$shade_master=get_shade_all($EBH);
//var_export($suppa);
//echo '<hr>';
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
$mencat=get_gen_cat($DBH,'MEN');
$womencat=get_gen_cat($DBH,'WOMEN');

$boycat=get_gen_cat($DBH,'BOY');
$girlcat=get_gen_cat($DBH,'GIRL');

$littlecat=get_gen_cat($DBH,'LITTLE');
$kidcat=get_gen_cat($DBH,'KID');


?>
<!DOCTYPE html>
<head><title>::New Sales Order::</title>

<script src="../methods/fun.js"></script>

</head>
  <script type="text/javascript">
  var pono=<?php print json_encode($pono);?>;
  console.log(pono);
  var auxul = "<ul id='aux-ul'><li><a href=\"#\" class=\"bkch\" id='gmtPo' onclick='track(this)'>New</a></li>";
    auxul += "<li><a href=\"#\" id='series_sum' onclick='track(this)'>View</a></li>";
    auxul += "<li><a href=\"#\" id='series_sum' onclick='track(this)'>Delete</a></li>";
    auxul += "</ul>";
    $(document).ready(function () {
        $("#auxnav").html(auxul);
        $("td.pono").html(pono);
    });

    $(document).ready(function(){
     $("#shdt").datepicker({ dateFormat: 'dd/mm/yy' });
     $("#dtd").datepicker({ dateFormat: 'dd/mm/yy' });
     var dt2=tdt();
     
     $("td#dtd2").append(dt2);
  });  
 
        
     
      var suppa={};
      suppa=<?php print json_encode($suppa);?>;
      var mencat=<?php print json_encode($mencat);?>;
      var womencat=<?php print json_encode($womencat);?>;

      var boycat=<?php print json_encode($boycat);?>;
      var girlcat=<?php print json_encode($girlcat);?>;

      var littlecat=<?php print json_encode($littlecat);?>;
      var kidcat=<?php print json_encode($kidcat);?>;

      var shade_master=<?php print json_encode($shade_master);?>;
      var cust_master=<?php print json_encode(get_customer_list($EBH));?>;
      
     
 //====================================================get array maincat
 var maincat=["MEN","WOMEN","BOYS","GIRLS","LITTLE","KIDS","ACCESSORIES"];
 var szchart=[];
 var ratio=[];
 var hsn=0;
$("#maincat").autocomplete({
  source:maincat
});
$("#szchart").autocomplete({
  source:suppa
});

$("#shade").autocomplete({
  source:shade_master
});
$("#supp").autocomplete({
  source:cust_master
});

artno_reverse={
  "MEN'S JACKET":"A2",
  "MEN'S JEANS":'A2',
  "MEN'S SHIRT":'A3',
  "MEN'S T-SHIRT":'A4',
  "MEN'S SHORTS":'A5',
  "MEN'S TRACK":'B1',
  "MEN'S BOXER":'B2',

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

  "LITTLE T-SHIRT":'E1',
  "LITTLE JEANS":'E2',
  "LITTLE SKIRT":'E3',
  "LITTLE SHORTS":'E4',
  "LITTLE FROCK":'E5',

  "KIDS T-SHIRT":'F1',
  "KIDS JEANS":'F2',
  "KIDS SHIRT":'F3',
  "KIDS SHORTS":'F4',
    
};

// function to return subcat according to main cat;;
// catagory series values

function get_subcat(mc){
  switch(mc){
    case "MEN":
    return mencat;
    break;

    case "WOMEN":
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
    default:
    return 0;
  }
}
function get_artno(subcat){
  console.log(subcat);
  // get and load artno list with this catagory
  $.post("P_gmtpo.php",{cat:artno_reverse[subcat]},function(data){
    var d=JSON.parse(data);
    $("#artno").autocomplete({
      source:d
    });

    // get the name from size-chart for this catagory
    $.post("P2_gmtpo.php",{cat:subcat},function(data2){
      console.log(data2);
      var k=JSON.parse(data2);
      $("#szchart").val(k['name']);
      $("#ratio").val(k['ratio']);
      szchart=k['sz'];
      ratio=k['ratio'];
      hsn=k['hsn'];

    });
  });
  return artno_reverse[subcat];
}

$("#maincat").change(function(){
  var mc=$(this).val();
  var subcat=get_subcat(mc);
  $("#subcat").autocomplete({
    source:subcat
  });

});

$("#subcat").change(function(){
  var mc=$(this).val();
  var artno=get_artno(mc);
  console.log(artno);
  

});


$(document).ready(function(){
  var w=$("table#ad-main").width();
  $("table#po-tab1").width(w);
  $("table#maintab").width(w)
  $("table#po-det44").width(w)
});

// get all the calculation in place

function calculate(){
  //alert("clicked calci");
  var subtotal=0;
  var total_qty=0;
  var net_amt=0;
  // get rate * qty =amt
  $("table#maintab tr:not(:eq(0))").each(function(){
    var rate=parseFloat($(this).find("td.trate input").val());
    var qty=parseInt($(this).find("td.tqty input").val());
    var amt=rate*qty;
    subtotal+=amt;
    total_qty+=qty;
    $(this).find("td.tamt").text(amt.toFixed(2));
  });
  $("td#tqty").text(total_qty);
  $("#subtotal").val(subtotal);

  var discount=parseFloat($("input#dis").val());
  //var discount_value=subtotal-subtotal*discount*0.01;
  var discount_value=subtotal*discount*0.01;

  net_amt=subtotal-discount_value;
  $("input#discount_value").val(discount_value.toFixed(2));

  var frt=parseFloat($("input#frt").val());

  //net_amt=net_amt+frt;
  $("input#frt_value").val(frt.toFixed(2));

  var sgst=parseFloat($("#sgst").val());

  sgst_tax=net_amt*sgst*0.01;
  $("input#sgst_value").val(sgst_tax.toFixed(2));

  var cgst=parseFloat($("#cgst").val());

  cgst_tax=net_amt*cgst*0.01;
  $("input#cgst_value").val(cgst_tax.toFixed(2));

  var igst=parseFloat($("#igst").val());

  igst_tax=net_amt*igst*0.01;
  $("input#igst_value").val(igst_tax.toFixed(2));

  var oths=parseFloat($("#oths").val());

  $("input#oths_value").val(oths.toFixed(2));


  net_amt=net_amt+frt+sgst_tax+cgst_tax+igst_tax+oths;

  $("td#netd").text(net_amt.toFixed(2));


}

// add the size-qty distribution

$("#addbtn").click(function(){
  var go=check_and_collect_values("#ad-main");
  console.log(go);
  if(go.goahead=='yes'){
    var ttlqty=parseInt($("#ttlqty").val());
  var szchartname=$("#szchart").val();
  
  ratio=$("#ratio").val();
   // get the name from size-chart for this catagory
   $.post("P3_gmtpo.php",{name:szchartname},function(data2){
      console.log(data2);
      var k=JSON.parse(data2);
      
      
      szchart=k['sz'];
      
      console.log("____________");
      console.log(szchart);
      var sk=szchart.split(",");
      console.log(sk.length);
      console.log(sk);
      console.log(sk[1]);
      console.log(ratio)
      var rt=ratio.split(",");
      var rt_total=0;
      $(rt).each(function(i,v){
        console.log(i,v);
        rt_total+=parseFloat(v);
      });
  
    var row="";
    for(var i=0;i<sk.length;i++){
      var rate=parseFloat($("#rate").val());
      var row="<tr><td><img src='../img88/cross.png' onclick=\"del_row(this)\"/></td>";
      row+="<td>"+hsn+"</td>";
      row+="<td>"+$("#subcat").val()+"</td>";
      row+="<td>"+$("#artno").val()+"</td>";
      row+="<td>"+$("#shade").val()+"</td>";
      row+="<td>"+sk[i]+"</td>";
      var val=(rt[i]/rt_total)*ttlqty;
      val=Math.ceil(val);
      console.log(rt[i],rt_total,val);
      var amt=(val*rate).toFixed(2);
      row+="<td class='trate'><input type='text' value='"+rate+"' onchange='calculate()'/></td>";
      row+="<td class='tqty'><input type='text' value='"+val+"' onchange='calculate()'/></td>";   
      row+="<td class='tamt'>"+amt+"</td></tr>";    
      //console.log(row);
      $("#maintab tbody").append(row);
    }
     
      

    });
  
      
  }
  calculate();

});
function del_row(ele){
  $(ele).parent().parent().remove();
}

  </script>
 <style type="text/css">
  
  #supp,#purInp{
    
    width: 200px;
  }
  .pageShow2 .dt22 {
    /*background: blue;*/
    width: 120px;
  }

 
    div.po-select1{
      /*background: red;*/
      position: relative;
      width:100%;
      height: auto;
      left:0;
      /* max-height: 300px; */
      overflow: auto;
      margin-top: 15px;
    }

    
  
  table#ad-main{
      
    width:90%;  
  }
  table#ad-main input[type='text']{
      width:90%;
  }
  table#ad-main tr td.td_itemname{
      width:70%;
      
  }
  table.PO1{
    position: relative;
    margin-bottom: 10px;
    width: 50%;
  }
  .trm .tnc{
    background: #ddd;
    width: 300px;
  }
  #cat{
    border: 0;
    height: 35px;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 95%;
    width:120px;
  }
  #pobtnSub{
    width:200px;
    border-radius:2px;
    color: #fff;
    border: 0;
    background: #0066ff;
  }
  tr.subT{
    font-weight: bold;
  }
  #newRef{
    border-radius:0;
    
  }
  table.trm tr td{
    text-align: left;
  }
  table.trm tr td input[type="text"]{
    width:97%;
  }
  div#item_holder{
    min-height:300px;
    /* background:#fff; */
    
  }
  table#maintab{
    background:#FFF;
  }

 

 
 </style>    
  
<div class="pageShow2">
  
 
    <table id="po-tab1">
      <tr>
          <td><div class="sup">Supplier:</td><td><input type="text" id="supp" title="supp"/></div></td>
          <td>Date:</td><td id="dtd2" dirname="direct" class="dtd"></td>
      </tr>
      <tr>
        <td><div class="pono">PO No:</td><td class='pono' dirname='direct'><div id="poNo"></div></td>
        <td>Expected Delivery Date:</td><td><input type="text" id="shdt" title="shdt"/></td>
      </tr>
      <tr>
        <td><div class="pur-so">Reference:</td>
        <td colspan='2' style="text-align:left"><input type="text" id="purInp" style="width:80%"/></td>
        
      </tr>
    </table>
  
  
  <hr>
            
   
    
        
    <div class="container noshow">
    <table class="trims" id="ad-main" >
        <tr>
            <td>Main Catagory</td>
            <td>Sub Catagory</td>
            <td>Article No</td><td>Color</td><td>Size-Chart</td>
            <td>Ratio</td><td>Rate</td><td>Total Qty</td>

        </tr>
        <tr>
            <td><input type="text" id="maincat" title="maincat"/></td>
            <td><input type="text" id="subcat" title="subcat"/></td>
            <td><input type="text" id="artno" title="artno"/></td>
            <td><input type="text" id="shade" title="shade"/></td>
            <td><input type="text" id="szchart" title="szchart"/></td>
            <td><input type="text" id="ratio" title="ratio"/></td>
            <td><input type="text" id="rate" title="rate"/></td>
            <td><input type="text" id="ttlqty" title="ttlqty"/></td>
            <td><input type="button" id="addbtn" value="ADD" class="btn btn-primary" title="nov"/></td>

        </tr>
</table>
</div>

<div class="container noshow" id="item_holder">
      <table class="trims" id="maintab">
        <thead>
        <tr>
          <th></th>
            <th>HSN</th>
            <th>CATAGORY</th>
            <th>ARTICLE NO</th><th>COLOR</th><th>SIZE</th>
            <th>RATE</th><th>QTY</th><th>AMOUNT</th>
        </tr>
        </thead>
        <tbody>
         

        </tbody>
        
      
        
  </table>
    </div>
  <div class="container">
  <h3 class="display-5">Import File</h3>
            <form id="fab-xl" name="fab-xl" action="R_gmtPoPL.php" method="post" target="_blank" enctype="multipart/form-data">
              <table class="table table-striped">
                  <tr>
                      <td>Choose file to import:</td>
                      <td><input type="file" name="fabFile" id="fabFile" /></td>
                      <td class="noshow"><input type="text" name="sono" id="sono" /></td>
                      <td class="noshow"><input type="text" id="holderMain2" name="holderMain2" /></td>
                      
                                  
                  </tr>
                  
              </table>
                
              <input type="text" class="noshow" id="holderImpno" name="holderImpno"/>
              <input type="button" value="Upload File" id="fabBtn" class="btn btn-primary"/>
            </form>
  </div>
  <hr>
  <br/>
       
    <div id="po-select">
      <form id="podetail">
      <table class="PO1" border="1" id="po-det44">
        <tr id="ttq1">
          <td>Description</td><td>Total Qty</td><td>Total Amt</td>
        </tr>
        <tr>
            <td>Subtotal</td><td id="tqty" class="tqty" dirname='direct'></td>
            <td><input type="text" class='rchng' value="0" id="subtotal" title="subtotal" onchange="calculate()"/></td>
        </tr>
          
        <tr>
            <td>Discount(%)</td>
            <td><input type="text" id='dis' title='discount' value='0' onchange="calculate()"/></td>
            <td><input type="text" class='rchng' value="0" id="discount_value" title="discount_value" onchange="calculate()"/></td>
        </tr>
        <tr>
            <td>Freight(INR)</td>
            <td><input type="text" value="0" id="frt" title="frt" onchange="calculate()"/></td>
            <td><input type="text"  class='rchng' value="0" id="frt_value" title="frt_value" onchange="calculate()"/></td>
        </tr>
        
        
        <tr>
            <td>SGST(%)</td>
            <td><input type="text" value="0" id="sgst" title="sgst" onchange="calculate()"/></td>
            <td><input type="text"  class='rchng' value="0" id="sgst_value" title="sgst_value" onchange="calculate()"/></td>
        </tr>
        <tr>
            <td>CGST(%)</td>
            <td><input type="text" value="0"id="cgst" title="cgst" onchange="calculate()"/></td>
            <td><input type="text"  class='rchng' value="0" id="cgst_value" title="cgst_value" onchange="calculate()"/></td>
        </tr>
        <tr>
            <td>IGST(%)</td>
            <td><input type="text" value="0"id="igst" title="igst" onchange="calculate()"/></td>
            <td><input type="text" class='rchng'  value="0" id="igst_value" title="igst_value" onchange="calculate()"/></td>
        </tr>
        <tr>
            <td>Others(INR)</td>
            <td><input type="text" value='0' id="oths" title="oths" onchange="calculate()"/></td>
            <td><input type="text"  class='rchng' value="0" id="oths_value" title="oths_value" onchange="calculate()"/></td>
        </tr>
        <tr>
        <td>NET Amount(INR)</td><td></td><td id="netd" class="netamount" dirname='direct'></td>
        
        
      </tr>
      </table>
      
      </form>
    
      </table>
      
      </form>
  </div>
      
      <input type="button" value="Calculate" id="calci"/>
      
     
      <h3>Terms and Conditions</h3>
      <table class="trm" border="1" id="tabterms">
        <tr class="rowdii stop">
          <td><input type="text" class="tnc" title="tnc"/></td>
        </tr>
        <tr></tr>
      </table>
      <input type="button" value="Add" id="addNew" onclick="cloneRow3()"/>
      <input type="button" value="Delete" id="delNew" onclick="removeRow3(3)"/>
       <form id="POForm" class="noshow" action="R_genpo.php" target="if33" method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        <input type="text" id="holder3" name="holder3" class="noshow"/>
        <input type="text" id="holder4" name="holder4" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>
    
      <br><br>
    <input type="button" value="SUBMIT DATA" id="submit"/>
    <div id="response"></div>
    </div>   
    <script type="text/javascript">

    // upload button
    $("#fabBtn").click(function(){
        // var pomain=check_and_collect_values("#maintab");
        
        // console.log(pomain);
        // if(pomain.goahead=='yes'){
        // var sortno=$("#sortno").val();
        // $("#sono").val(sortno);
        // pomain=JSON.stringify(pomain);
        // $("#holderMain2").val(pomain);
        $("#fab-xl").submit();
        //}
        //$(this).hide();

    });
        $("#submit").click(function(){
            //alert('t');
            $("#pobtn").click();
            var goahead=check_and_collect_values22("table#ad-main");
            console.log(goahead);
            console.log(goahead.goahead);
            var data1=JSON.stringify(goahead);
            console.log("dta.....");
            console.log(data1);
            
            //poMain
            var goahead2=check_and_collect_values22("table#po-tab1");
            console.log(goahead2);
            console.log(goahead2.goahead);
            goahead2.ttqty=$("td#tqty").text();
            goahead2.netamt=$("td#netd").text();
            goahead2.subtotal=$("td#tamt").text();
            goahead2.shdt=$("input#shdt").val();
            var data2=JSON.stringify(goahead2);
            console.log("dta.....");
            console.log(data2);
            //#poXtra
            var goahead3=check_and_collect_values22("table#po-det44");
            console.log(goahead3);
            console.log(goahead3.goahead);
            var data3=JSON.stringify(goahead3);
            console.log("dta.....");
            console.log(data3);
            //#poterms
            var goahead4=check_and_collect_values22("table#tabterms");
            console.log(goahead4);
            console.log(goahead4.goahead);
            var data4=JSON.stringify(goahead4);
            console.log("dta.....");
            console.log(data4);
            if((goahead.goahead=='yes')&&(goahead2.goahead=='yes')&&(goahead3.goahead=='yes')&&(goahead4.goahead=='yes'))
            {
                //alert("going forward");
                $("#holder1").val(data1);
                $("#holder2").val(data2);
                $("#holder3").val(data3);
                $("#holder4").val(data4);
                $("#POForm").submit();
                $(this).prop("disabled",true);
                //$(".pageShow2").css("background","#cdcdcd");
                $(".pageShow2 input").prop("disabled",true);
                $(".pageShow2 select").prop("disabled",true);
                
                
            }
            
        });
    
    
    
    </script>

