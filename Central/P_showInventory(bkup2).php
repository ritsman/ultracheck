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


$location=$_POST['data'];
//var_export($dataM);
//echo '<hr>';
if($location=='CENTRAL'){
    $q="select * from `Q__stk__$location` where 1='1' ";   
    $wq="select * from `Q__stk__$location` where 1='1' ";  
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
        $sq.="  and `$key` ='$val' ";
    }
    
}
//$sq=rtrim($sq,",");
//echo "<br>1.".$sq;
if($search_data[5]['sefrminw_dt']!=='0'&&$search_data[5]['setoinw_dt']!=='0'){
    $sq.=" and (created between '".$search_data[5]['sefrminw_dt']." 00:00:00' and '".$search_data[5]['setoinw_dt']." 23:59:59')";
}
//echo "<br>$sq";
if($location=='CENTRAL'&&$sq==''){
    $q.=$sq." limit 0,100";
    //$q.=$sq;
    //$q.=$sq;
}else{
    //$q.=$sq;
    $q.=$sq." limit 0,100";
}


//echo "<br>$q";
//return false;

$stm=$DBH->prepare($q);
try {
    
    $stm->execute();
    $fullcount=$stm->rowCount();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $data[]=$r;
    }
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

$ttl_no_pages=ceil($stm->rowCount()%100);
echo $ttl_no_pages;

//var_export($data);
//echo '<hr>';
// get total count of pcs
$stm=$DBH->prepare($wq);
try {
    $stm->execute();
    $fullcount2=$stm->rowCount();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

if($location=='CENTRAL'&&$sq==''){
    $show_count=$fullcount2;
}else{
    $show_count=$fullcount;
}
$count=0;
foreach($data as $d){
    $line="<tr><td>$d[barcode]</td>";
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
    echo $sct;
    
}

?>
<link rel="stylesheet" href="../external/css/bootstrap.css">
<script src="../external/js/jquery-3.5.1.js"></script>
<script src="../external/js/bootstrap.js"></script>
<script src="../twbs/jquery.twbsPagination.js" type="text/javascript"></script>
<script>
    var line=<?php print json_encode($line);?>||0;
    //console.log(line);
    var count=<?php print $count;?>||0;
    var fullcount=<?php print $show_count;?>||0;
    $("#tabmain tr:eq(0)").after(line);
    var ty=count+"/"+fullcount;
    $("#total_pcs").html(fullcount);
    
</script>
<h4>CURRENT INVENTORY IN <?php print $location;?> WAREHOUSE</h4>
<div class="container">
      <nav aria-label="Page navigation">
          <ul class="pagination gj" id="pagination"></ul>
      </nav>
  </div>
<h5>TOTAL PCS: <?php print $show_count;?></h5>
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
            $("#sono2").on("keyup", function() {
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
            totalPages: 35,
            visiblePages: 10,
            onPageClick: function (event, page) {
                console.info(page + ' (from options)');
                $("#showdata2").html(page);
            }
        }).on('page', function (event, page) {
            console.info(page + ' (from event listening)');
        });
    });
</script>
    