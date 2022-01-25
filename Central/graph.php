<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');

//=====================================================
function get_month_sales($DBH,$outlet){
    $q="select sum(grandtotal) as ts  from `T__salesmain__$outlet` where billdate between '2021-03-01' and '2021-03-31'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $data=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage;
    }
    return $data['ts'];
}

$data1['outlet']='PALSANA';
$data1['sales']=get_month_sales($EBH,"PALSANA");
$data2['outlet']='HMT';
$data2['sales']=get_month_sales($EBH,"HMT");
$data3['outlet']='VISHNAGAR';
$data3['sales']=get_month_sales($EBH,"VISHNAGAR");
$data4['outlet']='VATVA';
$data4['sales']=get_month_sales($EBH,"VATVA");
// json_encode($data);
//var_export($data);

//  $data2=[
//     {"outlet":"palsana","sales":"10000"},
//     {"outlet":"vatva","sales":"10000"},
//     {"outlet":"vishnagar","sales":"40000"},
//     {"outlet":"hmt","sales":"58000"},
//     {"outlet":"central","sales":"50000"},
 
//    ];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="d3.min.js"></script>
    <title>Document</title>
</head>
<style>
    svg rect#gg {
       fill: green;
    }
    svg rect#gg2 {
       fill: yellow;
    }
    svg rect#gg3 {
       fill: red;
    }
    .blue{
       fill:steelblue;
    }
    svg text {
       
       font: 12px sans-serif;
       text-anchor: end;
    }
    .hyper{
       color:blue
    }
    .bar{
       fill:steelblue;
    }
    div#container{
       width:900px;
       height:600px;
       background-color: #ddd;
       padding:10px;
    }
    .grid .tick line {
    stroke: #6c9aaa;
    stroke-opacity: 0.2;
}
 </style>
<body>
   <div id="container2">
       <div class="pageShow2">
       <table id="maindata">
           <tr>
               <td>SELECT MONTH</td>
               <td>
                   <select name="sel_month" id="sel_month" class="form-control">
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
           </tr>
       </table>

       </div>
       <h4>MONTHLY SALES COMPARISON</h4>
       
   </div>
   <div id="showdata"></div>
   

   
</body>

<script>

    $("#sel_month").change(function(){
        var mon=$(this).val();
        $("div#showdata").html();
        $("div#showdata").load("P_graph.php",{mon:mon});
        

    });
   </script>
</html>