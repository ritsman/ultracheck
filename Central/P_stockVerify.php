<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['data'];
$search_data=json_decode($_POST['search_data'],true);
unset($search_data['goahead']);

//var_export($search_data);
//echo '<hr>';

$records=100;// rows per page
$location=$_POST['data'];
//var_export($dataM);
//echo '<hr>';
if($location=='CENTRAL'){
    $q="select * from `Q__stk__$location` where 1='1' and status='START'";   
    $wq="select * from `Q__stk__$location` where 1='1' and status='START' ";  
}else{
    $q="select * from `Q__stk__$location` where status='CONFM' ";
    $wq="select * from `Q__stk__$location` where status='CONFM' ";
}
//echo $q;


// make search query
$sq="";
foreach($search_data[3] as $key=>$val){
    if($val!=='0'){
        $sq.="  and `$key` ='".addslashes($val)."' ";
    }
        
    
    
}

//$sq=substr($sq,0,-1);

//echo "<br>1.".$sq;
foreach($search_data[5] as $key=>$val){
    if($val!=='0'&&$key!=='sefrminw_dt'&&$key!=='setoinw_dt'){
        $sq.="  and `$key` ='".addslashes($val)."' ";
    }
    
}
//$sq=rtrim($sq,",");
//echo "<br>1.".$sq;
if($search_data[5]['sefrminw_dt']!=='0'&&$search_data[5]['setoinw_dt']!=='0'){
    $sq.=" and (created between '".$search_data[5]['sefrminw_dt']." 00:00:00' and '".$search_data[5]['setoinw_dt']." 23:59:59')";
}
//echo "<br>$sq";
$q.=$sq;
$wq.=$sq." limit 0,$records";

//echo "<br>$wq";
//return false;

$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    $fullcount=$stm->rowCount();
    
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$fullcount=$stm->rowCount();
$ttl_no_pages=ceil($stm->rowCount()/$records);
//echo $ttl_no_pages;

//var_export($data);
//echo '<hr>';
// get total count of pcs
$stm2=$DBH->prepare($wq);
try {
    $stm2->execute();
    while($r=$stm2->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}


$count=0;
//var_export($data);
//echo '<hr>';
$line="";
foreach($data as $d){
    $line.="<tr><td>$d[barcode]</td>";
    $line.="<td>$d[sono2]</td>";
    $line.="<td>$d[artno]</td>";
    $line.="<td>$d[cat]</td>";
    $line.="<td>$d[sz]/$d[szcm] CM</td>";
    $line.="<td>$d[inseam]</td>";
    $line.="<td>$d[shade]</td>";
    $line.="<td>$d[qty]</td>";
    $line.="<td>$d[pkd]</td>";
    $line.="<td>$d[series]</td>";
    $line.="<td>$d[mrp]</td>";
    $line.="<td>$d[location]</td>";
    $line.="<td>$d[fit]</td>";
    $line.="<td>$d[created]</td></tr>";
    $count++;
    $k = json_encode($line);
    $sct = <<<sct
    <script>
        
   //console.log($k);
    $(document).ready(function(){
        $("table#tabmain tr:eq(-1)").before($k);
    });
    </script>
sct;
    //echo $sct;
    
}
//----------------------------------------------------
// get previous scan result;;;
//select * from `S__stkverify` where  palsana is not null and id=(select max(id)) 
$self_outlet='CENTRAL';
$q2="select `$self_outlet` from `S__stkverify` where `$self_outlet` is not null and id=(select max(id)) ";
//echo $q2;
$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $scn_pcs=$r["$self_outlet"];
    }
} catch (PDOException $th) {
    //throw $th;
    $th->getMessage();
}
?>
<link rel="stylesheet" href="../external/css/bootstrap.css">
<script src="../external/js/jquery-3.5.1.js"></script>
<script src="../external/js/bootstrap.js"></script>
<script src="../twbs/jquery.twbsPagination.js" type="text/javascript"></script>
<script>
    var line=<?php print json_encode($line);?>||0;
    //console.log(line);
    var records=<?php print json_encode($records);?>;
    var ttl_no_pages=<?php print json_encode($ttl_no_pages);?>;
    var query=<?php print json_encode($q);?>||0;
    console.log(ttl_no_pages+"-------");
    //var count=<?php print $count;?>||0;
    var fullcount=<?php print $fullcount;?>||0;
    $("#tabmain tr:eq(0)").after(line);
    //var ty=count+"/"+fullcount;
    //$("#total_pcs").html(fullcount);
    
</script>

<h4>CURRENT INVENTORY IN <?php print $location;?> WAREHOUSE</h4>
<div class="container">
      <nav aria-label="Page navigation">
          <ul class="pagination gj" id="pagination"></ul>
      </nav>
  </div>
<h5>TOTAL PCS: <?php print $fullcount;?>
<br>
TOTAL PAGES: <?php print $ttl_no_pages;?>
</h5>
    <br><br>

    <div id="showpagecount">
    <table id="tabmain">
   
   <tr>
       
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
       <th>LOCATION</th>
       <th>FIT</th>
       <th>INWARD DATE</th>
       
       
   </tr>

   <tr>
       <td colspan="7">
           TOTAL PCS INWARDS
       </td>
       <td id="total_pcs"></td>
   </tr>
   
</table>
    </div>
    
    <br>

    <script>
        $(document).ready(function(){
            $("#sono22").on("keyup", function() {
                var ttl=0;
                var value = $(this).val().toLowerCase();
                //console.log(value);
                $("#tabmain tr:not(:eq(0))").filter(function() {
                   
                    $(this).toggle(
                        $(this).text().toLowerCase().indexOf(value) > -1);
                   
                });
            });

 


        });


    </script>
    <script type="text/javascript">
    
    $(function () {
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: ttl_no_pages,
            visiblePages: 10,
            
            onPageClick: function (event, page) {
                //console.info(page + ' (from options)');
                $("#showpagecount").load("P_qu_showInventory.php",{query:query,page:page,fullcount:fullcount,tp:ttl_no_pages,records:records});
                
            }
        }).on('page', function (event, page) {
            //console.info(page + ' (from event listening)');

            
        });
    });

// for stock verification
        var bcin=[];
        var total_count=0;
        var row="";
        var invtab="Q__stk__CENTRAL";
        var updated_scn_pcs=[];
        var unfound_pcs=[];
        //var scn_pcs=[];
        scn_pcs=JSON.parse(<?php print json_encode($scn_pcs)?>)||[];
        console.log('OOOOOOOOOOO');
        console.log(typeof(scn_pcs[0]));
        
        $(document).ready(function(){
            $("#tabmain tbody tr:not(:eq(0))").each(function(ind,val){
                            var b=$(this).find("td:eq(0)").text();
                            var bc=parseInt(b);
                            if($.inArray(bc,scn_pcs)!==-1){
                                //alert("here");
                                $("#tabmain").find("tr:eq("+(ind+1)+")").css("background","#e6e600");
                                
                                updated_scn_pcs.push(bc);
                                
                            }
                            
           });
            $("#canned").html(scn_pcs.length+"--"+updated_scn_pcs.length);
        });
        



        console.log("+++++++++");
        console.log(scn_pcs);
        console.log(row);
        console.log("+++++++++");
        var carton_number=1;
        var jk=document.getElementById("sono22");
        jk.addEventListener('keypress', function (e) {
        //alert("K");
        if (e.keyCode === 13) {
            
            $.uniqueSort(scn_pcs);
            var t1=$("#sono22").val();
            var t=parseInt(t1);
                $("#sono22").val('');
                $("#sono22").focus();
                // get the barcode decoded 
                var k=$.inArray(t,scn_pcs);
                //alert(k);
                console.log("PPPPPPPPPPPP");
                console.log(scn_pcs);
                //console.log(bcin);
                if(k===-1){
                    $.post("../Central/fetch_barcode_data_out.php",{data:t,invtab:invtab},function(rt){
                        console.log(rt);
                        
                        var r=JSON.parse(rt);
                        console.log(r);
                        row="<tr><td><img src='../img88/cross.png' onclick=\"remove_row(this)\"/></td>";
                        row+="<td dirname='direct_id' class='bc' id='"+r.tname+"'>"+r.barcode+"</td><td>"+r.sono2+"</td>";
                        if(r.barcode!==""){
                            $("#tabmain tr:not(:eq(0))").each(function(){
                            var b=$(this).find("td:eq(0)").text();
                            var bc=parseInt(b);
                            if(bc==r.barcode){
                                $(this).css("background","#00cc44");
                                scn_pcs.push(bc);
                                updated_scn_pcs.push(bc);
                                $("#canned").html(scn_pcs.length+"--"+updated_scn_pcs.length);
                            }
                            
                            });
                        }else{
                            unfound_pcs.push(t);
                            $("div#unfound").append(t+' ');
                        }
                        
                        
                       
                        //$("#tabmain tr:eq(0)").after(row);
                        //$("td#total_pcs").html(total_count);
                        //$("div#counterpcs").html(total_count);
                        bcin.push(t)
                        e.preventDefault();
                    });
                }else{
                    alert("Barcode: "+ t+" Already Present");
                    return false;
                }
                
                
            
        }

    //console.log(e.keyCode);
    //console.log("---")

}, false);
console.log("+++++++++");
        console.log(bcin);
        console.log(row);
        console.log("+++++++++");



//------collect and save the barcode for inwards
$("#updBar").click(function(){
    console.log("pressed updbar");
    console.log(scn_pcs);
    console.log(scn_pcs.length)
    var self_outlet="CENTRAL";
       data=JSON.stringify(scn_pcs);
    //     console.log(data);
      $("#holder1").val(data);
     $("#holder2").val(self_outlet);
        $("#POForm").submit();
    //     $("#updBar").css("display","none");
   
});

// reset the collection 
$("#delBar").click(function(){
    //alert("n");
    scn_pcs=[];
    $("#tabmain tr:not(:eq(0))").each(function(){
         $(this).css("background","none");
    });
                                
        
});
</script>
    