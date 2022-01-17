<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../Central/class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$outlet='CENTRAL';
echo "Palsana-->Reports->>Print Bill::";

// get all billno

$q="select distinct billno from T__salesmain__$outlet";
$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r['billno'];
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
//var_export($data);
//echo '<hr>';
?>
<style type="text/css">
    .pageShow2 table#sup-tab1 td{
        text-align: left

    }
    .pageShow2 table#sup-tab1 input{
        width:80%;

    }
    #sup-btn1{
        width:200px;
    }
    div#sup-no{

        
        position:relative;
        display: inline;
        margin-left: 5px;

    }
</style>
<script type="text/javascript">
var billno=<?php print json_encode($data);?>||0;
    //==============================the aux-nav ul element
    
    $(document).ready(function () {
       
        $("#billno").autocomplete({
            source:billno
        });
    });
    
</script>
<div class="pageShow2">
    <table id="maintab">
        <tr >
            <th>SELECT BILL NO:</th>
            
       
            <th>SELECT BILL TYPE:</th>
            
        </tr>
        <tr>
            <td class="exclude"><input type="text" name="billno" id="billno"  ></td>
            <td><select name="sel_billtype" id="sel_billtype" class="form">
                
                <option>ORIGINAL FOR CUSTOMER</option>
                <option>DUPLICATE</option>
            </select></td>
        </tr>
    </table>
    <hr>
    <form id="POForm2" class="noshow" action="billprint.php" target="_blank" method="post">
        <input type="text" id="holder14" name="holder14" class="noshow"/>
        <input type="text" id="holder24" name="holder24" class="noshow"/>
      </form>
    <button type="button" name="printBill" id="printBill" class="btn btn-info">PRINT</button>
    

</div>
<script>
    // set up printing

$("#printBill").click(function(){
    //window.print();
    //var newbill2=window.open("","newbill","width=500,height=700,status=1,titlebar=1,menubar=1");
    var printok=$("#billno").val();
    var billtype=$("#sel_billtype").val();
   if(printok===''){
       alert("PLS SELECT THE BILL NO!");
       return false;
   }else{
        $("#holder14").val(printok);
        $("#holder24").val(billtype);
        $("#POForm2").submit();
   }
    
   
    
    
    
});
</script>
