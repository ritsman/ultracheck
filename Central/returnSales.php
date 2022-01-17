<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');
//================================================
$outlet='CENTRAL';
//echo $outlet;
$bill_field=strtolower('central1');
$pono=get_new_pono_rt($EBH,$bill_field);
$bill_prefix=get_bill_prefix_rt($EBH,$bill_field);
$billno="CR1-".$pono;
//echo $pono;



?>
<style>
input#dtd{
    width: 90%;
}
</style>

<script type="text/javascript">
 
    
    var billno=<?php print json_encode($billno);?>;
    
    var outlet="<option>"+<?php print json_encode($outlet);?>+"</option>";
    console.log("OUTLET:"+ outlet)
    
    $(document).ready(function(){
      
        $("#sel_shop").append(outlet);
        //$("#dtd").datepicker({ dateFormat: 'dd/mm/yy' });
        var dt2=tdt();
         $("#bill_dt").append(dt2);
        
        $("#billno").html(billno);           
    });


function load_shop(ele){
    //console.log(series_val);
    var shop=$(ele).val().toUpperCase();
    var t="TO: "+shop;
    $("#shopname").html(t);
    
}

var printok="NO";
</script>
<style>
    #tabmain input[type='text'],#maintab input[type='text']{
        width:90%;
    }
    #sono2{
        width:90%;
    }
    #tabmain{
        font-size: 9px;
    }
    div.divtax{
       display: flex;
       flex-direction: column;
    }
</style>
<div class="container-fluid">
<div class="pageShow2">
<table id="maintab">
        <tr >
            <th>SCAN BARCODE</th>
            <th>
                CREDIT NOTE NO
            </th>
            <th>
                RETURN DATE
            </th>
            <th>
                CUSTOMER
            </th>
            <th>
                CONTACT
            </th>
            <th>GST NO</th>
            <th>REMARKS</th>
            <th>OFFER</th>
            <th>PAYMENT TYPE</th>
        </tr>
        <tr>
            <td class="exclude"><input type="text" name="sono2" id="sono2"  ></td>
            <td id="billno"></td>
            <td id="bill_dt"></td>
            <td><input type="text" name="customer" id="customer" title="customer" ></td>
            <td><input type="text" name="contact" id="contact" title="contact" ></td>
            <td><input type="text" name="gst" id="gst" title="gst" ></td>
            <td><input type="text" name="address" id="address" title="address" ></td>
            <td>
                <select name="sel_shop" id="sel_shop"  title="outlet" class="form-control" onchange="load_shop(this)">
                <option>SELECT</option>
                
                
                
            </select>
            </td>
            
            <td><select name="sel_paytype" id="sel_paytype"  title="paytype" class="form-control" >
                <option>SELECT</option>
                <option>CASH</option>
                <option>CREDIT</option>
                <option>UPI</option>
                <option>CARD PAY</option>
            </td>
            
        </tr>
    </table>
    <hr>
    <h4>RETURN GOODS DETAILS </h4>
    <br><div id="counterpcs"></div><br>
    <table id="tabmain">
        <tr>
            <th>DELETE</th>
            <th>BARCODE</th>
            <th>REFERENCE</th>
            <th>ART NO</th>
            <th>CATAGORY</th>
            <th>SIZE</th>
            <th>INSEAM</th>
            <th>COLOR</th>
            <th>QTY</th>
            <th>PKD</th>
            <th>SERIES</th>
            <th>MRP</th>
            <th>OFFER</th>
            <th>DIS(%)</th>
            <th>DIS(INR)</th>
            <th>SALE PRICE</th>
            <th>TAX(%)</th>
            <th>TAX(INR)</th>
            <th>TOTAL</th>
            
            
        </tr>

        <tr>
            <td colspan="8">
                GRAND TOTAL
            </td>
            <td id="total_pcs" dirname="direct" class="totalpcs"></td>
            <td colspan="5"></td>
            <td id="total_discount" dirname="direct" class="totaldiscount"></td>
            <td id="total_price" dirname="direct" class="totalprice"></td>
            <td></td>
            <td id="total_taxamount" class="totaltaxamount" dirname="direct"></td>
            
            <td id="grand_total" class="grndttl" dirname="direct"></td>
           
        </tr>
        
    </table>
    <br>
    <hr>
    <div class="divtax">
        <table class="d-flex justify-content-end" id="taxdata">
            <tr>
            <td>SPECIAL REMARKS</td>
            <td><input type="text" name="splrmks" id="splrmks" title="splrmks" style="width:90%"></td>
                <td>TAXABLE AMOUT</td>
                <td id="subtotal"></td>
            </tr>
            <tr>
            <td colspan='2'></td>
                <td>SGST</td>
                <td id="sgst" dirname="direct" class="sgst"></td>
            </tr>
            <tr>
            <td colspan='2'></td>
                <td>CGST</td>
                <td id="cgst"  dirname="direct" class="cgst" ></td>
            </tr>
            <tr>
            <td colspan='2'></td>
                <td>IGST</td>
                <td id="igst"  dirname="direct" class="igst" ></td>
            </tr>
            <tr>
            <td colspan='2'></td>
                <td>ROUND OFF</td>
                <td id="rndoff"  dirname="direct" class="rndoff"></td>
            </tr>
            <tr>
            <td colspan='2'></td>
                <td>GRAND TOTAL</td>
                <td id="gttl" dirname="direct" class="gttl"></td>
            </tr>
        </table>
        <hr>
        <p>TOTAL MONEY SAVINGS:<span id="discount_book"></span></p>
    </div>
   
    <div id="response"></div><br><div id="confmpono"></div>
    <button type="button" name="updBar" id="updBar" class="btn btn-info">ACCEPT RETURN</button>
    <button type="button" name="printBill" id="printBill" class="btn btn-info">PRINT</button>
    
    
    <form id="POForm" class="noshow" action="R_returnSales.php" target="if33 " method="post">
        <input type="text" id="holder1" name="holder1" class="noshow"/>
        <input type="text" id="holder2" name="holder2" class="noshow"/>
        <input type="text" id="holder3" name="holder3" class="noshow"/>
      </form>
      <iframe class="noshow" id="if33" name="if33"></iframe>

      <form id="POForm2" class="noshow" action="billprintRT.php" target="_blank" method="post">
        <input type="text" id="holder14" name="holder14" class="noshow"/>
        <input type="text" id="holder24" name="holder24" class="noshow"/>
      </form>
     
    <script>
        $(document).ready(function(){
            $("#sel_shop")[0].selectedIndex=1;
        });
        $(document).ready(function(){
            $("#sono2").focus();
        });
        var bcin=[];
        var total_count=0;
        var invtab="T__salesdata__"+<?php print json_encode($outlet);?>;
        var jk=document.getElementById("sono2");
        var total_discount=0;
        var total_price=0;
        var total_tax=0;
        var grand_total=0;
        var cust_gst=$("#cust_gst").val()==''?'0':'22';
        var tt=cust_gst.substr(0,2);
        var taxtype="";
        
        if(tt=='22'){
            taxtype='S';
        }else{
            taxtype='I';
        }
        
    jk.addEventListener('keypress', function (e) {
        if (e.keyCode === 13) {
            
            $.uniqueSort(bcin);
            var t=$('#sono2').val();
               
                $("#sono2").val('');
                $("#sono2").focus();
                // get the barcode decoded 
                var k=$.inArray(t,bcin);
                //alert(k);
                //console.log(bcin);
                if(k===-1){
                    $.post("../Central/fetch_barcode_data_rt.php",{data:t,invtab:invtab},function(rt){
                        //console.log(rt);
                        //
                        var r=JSON.parse(rt);
                        //console.log(r);
                        var row="<tr><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td>";
                        row+="<td dirname='direct_id' class='barcode' id='"+r.tname+"'>"+r.barcode+"</td><td>"+r.sono2+"</td>";

                        if(r.barcode!==""){
                            row+="<td dirname='direct' class='artno'>"+r.artno+"</td>";
                            var cmaux="";
                                if(r.szcm!=='0'){
                                        cmaux="/"+r.szcm+" CM";
                                }else{
                                    cmaux="";
                                }
                            var mrp=r.mrp;
                            //var disrate=45;
                            var disrate=52.5;
                            
                            var mrpdata=get_mrpdata(mrp,disrate);
                            console.log("MMMMM:");
                            console.log(mrpdata);
                            
                            row+="<td>"+r.cat+"</td><td>"+r.sz+cmaux+"</td>";
                            row+="<td>"+r.inseam+"</td><td>"+r.shade+"</td>";
                            row+="<td>"+r.qty+"</td><td>"+r.pkd+"</td>";
                            row+="<td>"+r.series+"</td><td class='mrp' dirname='direct'>"+r.mrp+"</td>";
                            row+="<td class='offer' dirname='direct'>45</td>";
                            row+="<td class='disrate' dirname='direct'>"+disrate+"</td>";
                            row+="<td class='discount' dirname='direct'>"+mrpdata.discount+"</td>";
                            row+="<td class='saleprice' dirname='direct'>"+mrpdata.price+"</td>";
                            row+="<td class='taxrate' dirname='direct'>"+mrpdata.tax+"</td>";
                            row+="<td class='tax' dirname='direct'>"+mrpdata.taxamount+"</td>";
                            
                            row+="<td class='total' dirname='direct'>"+mrpdata.price_with_tax+"</td>";
                           
                            total_count++;

                            total_discount=total_discount+parseFloat(mrpdata.discount);
                            total_price=total_price+parseFloat(mrpdata.price);
                            total_tax=total_tax+parseFloat(mrpdata.taxamount);
                            grand_total=grand_total+parseFloat(mrpdata.price_with_tax);
                                var cgst=igst=0;
                                
                            if(taxtype=='S'){
                                cgst=(parseFloat(total_tax)/2).toFixed(2);
                                igst=0;

                            }else{
                                cgst=0;
                                igst=parseFloat(total_tax).toFixed(2);
                            }
                            
                            
                        }
                       
                        $("#tabmain tr:eq(-1)").before(row);
                        $("td#total_pcs").html(total_count);
                        $("td#total_discount,#discount_book").html(total_discount.toFixed(2));
                        $("td#total_price,#subtotal").html(total_price.toFixed(2));
                        $("td#total_taxamount").html(total_tax.toFixed(2));
                        $("td#grand_total").html(grand_total.toFixed(2));
                        $("div#counterpcs").html(total_count);
                        $("td#sgst").html(cgst);
                        $("td#cgst").html(cgst);
                        $("td#igst").html(igst);
                       
                        var roff=grand_total-Math.floor(grand_total);
                        //console.log("grandt"+grand_total);
                        //console.log("pricewithtz"+roff);
                            if(roff>=0.5){
                                grand_total=Math.ceil(grand_total);
                                roff=(1-roff).toFixed(2);
                            }else{
                                grand_total=Math.floor(grand_total);
                                roff="-"+roff.toFixed(2);
                            }
                            $("td#rndoff").html(roff);
                            $("td#gttl").html(grand_total);
                        e.preventDefault();
                    });
                }
                bcin.push(t);
                
            
        }

    //console.log(e.keyCode);
    //console.log("---")

}, false);


function remove_row(ele){
    var t=$(ele).parent().next().text();
    var row=$(ele).parent().parent();
    bcin=$.grep(bcin,function(value){
        return value!=t;
    });
    console.log(t);
    $(ele).parent().parent().remove();
    if(t!==''){
        total_count--;
        var del_discount=parseFloat(row.find("td.discount").text());
        var del_saleprice=parseFloat(row.find("td.saleprice").text());
        var del_tax=parseFloat(row.find("td.tax").text());
        var del_total=parseFloat(row.find("td.total").text());
        var del_cgst=parseFloat($("td#sgst").text());
        var del_igst=parseFloat($("td#igst").text());
        
        total_discount=parseFloat($("td#total_discount").text())-del_discount;
        total_price=parseFloat($("td#total_price").text())-del_saleprice;
        total_tax=parseFloat($("td#total_taxamount").text())-del_tax;
        grand_total=parseFloat($("td#grand_total").text())-del_total;
        $("td#total_pcs").html(total_count);
        $("div#counterpcs").html(total_count);

        // tdiscount=tdiscount-del_discount;
        // tprice=tprice-del_saleprice;
        // ttaxamount=ttaxamount-del_tax;
        // tgtotal=tgtotal-del_total;

        var ct=del_cgst==0?total_tax:total_tax/2;

        
        $("td#total_discount").html(total_discount.toFixed(2));
        $("td#total_price").html(total_price.toFixed(2));
        $("td#subtotal").html(total_price.toFixed(2));
        $("td#total_taxamount").html(total_tax.toFixed(2));
        $("td#grand_total").html(grand_total.toFixed(2));
        if(del_cgst==0){
            $("td#igst").html(ct.toFixed(2));
        }else{
            $("td#cgst").html(ct.toFixed(2));
            $("td#sgst").html(ct.toFixed(2));
        }

        var roff=grand_total-Math.floor(grand_total);
        console.log(grand_total,roff);
                            if(roff>=0.5){
                                grand_total=Math.ceil(grand_total);
                                roff=roff.toFixed(2);
                            }else{
                                grand_total=Math.floor(grand_total);
                                roff="-"+roff.toFixed(2);
                            }
                            $("td#rndoff").html(roff);
                            $("td#gttl").html(grand_total);

    }
}

//------collect and save the barcode for inwards
$("#updBar").click(function(){
    var rows=$("#tabmain tr").length;
    //alert(rows);
    if(rows<3){
        alert("NO BARCODE SELECTED! ");
        return false;
    }
    
    
    var dataMain=check_and_collect_values33("#maintab");//33 excludes with class exclude
    var dataBill=check_and_collect_values("#tabmain");
    var dataTax=check_and_collect_values("#taxdata");
    console.log(dataMain);
    console.log(dataBill);
    console.log(dataTax);
    
    
    if((dataMain.goahead=='yes')&&(dataBill.goahead=='yes')&&(dataTax.goahead=='yes')){
        dataMain.totalpcs=$("#total_pcs").text();
        dataMain.totaldiscount=$("#total_discount").text();
        dataMain.subtotal=$("#total_price").text();
        dataMain.totaltaxamount=$("#total_taxamount").text();;
       
        dataMain.ttlbefro=$("#grand_total").text();

        dataMain=JSON.stringify(dataMain);
        dataBill=JSON.stringify(dataBill);
        dataTax=JSON.stringify(dataTax);
        console.log(dataMain);
        console.log(dataBill);
        console.log(dataTax);
        $("#holder1").val(dataMain);
        $("#holder2").val(dataBill);
        $("#holder3").val(dataTax);
        $("#POForm").submit();
        $(this).prop("disabled",true);
    }
});
// go for printing after 2 sec
function printbillnow(printok2){
    console.log("pfun"+printok2);
    if(printok2!=='NO'){
        $("#holder14").val(printok2);
        $("#holder24").val('ORIGINAL FOR CUSTOMER');
        $("#POForm2").submit();
        //newbill.print();
    }
}

// set up printing

$("#printBill").click(function(){
    //window.print();
    //var newbill2=window.open("","newbill","width=500,height=700,status=1,titlebar=1,menubar=1");
   if(printok==='NO'){
       alert("PLS SAVE THE BILL FIRST!");
   }else{
        $("#holder14").val(printok);
        $("#POForm2").submit();
   }
    
   
    
    
    
});


// calculate discount sale tax total

function get_mrpdata(mrp,disrate){
    var data={};
    var tax=0;
    mrp=parseInt(mrp);
    disrate=parseFloat(disrate);
    
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
    
    return data;

}


    </script>