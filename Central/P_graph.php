<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultra');
$EBH2=new dbconnect();
$EBH=$DBH2->con('ultrainv');

//=====================================================
$mon=$_POST['mon'];
function get_period($mon){
    switch($mon){
        case "JAN":
            return "between '2021-01-01' and '2021-01-31'";
        break;
        case "FEB":
            return "between '2021-02-01' and '2021-02-28'";
        break;
        case "MAR":
            return "between '2021-03-01' and '2021-03-31'";
        break;
        case "APR":
            return "between '2021-04-01' and '2021-04-30'";
        break;
        case "MAY":
            return "between '2021-05-01' and '2021-05-31'";
        break;
        case "JUN":
            return "between '2021-06-01' and '2021-06-30'";
        break;
        case "JUL":
            return "between '2021-07-01' and '2021-07-31'";
        break;
        case "AUG":
            return "between '2021-08-01' and '2021-08-31'";
        break;
        case "SEP":
            return "between '2021-09-01' and '2021-09-30'";
        break;
        case "OCT":
            return "between '2021-10-01' and '2021-10-31'";
        break;
        case "NOV":
            return "between '2021-11-01' and '2021-11-30'";
        break;
        case "DEC":
            return "between '2021-12-01' and '2021-12-31'";
        break;
        default:
        return 'INKNOWN';
    }

}
$period=get_period($mon);
function get_month_sales($DBH,$outlet,$period){
    $q="select sum(grandtotal) as ts  from `T__salesmain__$outlet` where billdate $period";
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
$data1['sales']=get_month_sales($EBH,"PALSANA",$period);
$data2['outlet']='HMT';
$data2['sales']=get_month_sales($EBH,"HMT",$period);
$data3['outlet']='VISHNAGAR';
$data3['sales']=get_month_sales($EBH,"VISHNAGAR",$period);
$data4['outlet']='VATVA';
$data4['sales']=get_month_sales($EBH,"VATVA",$period);
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
   <div id="container">
       
   
</body>

<script>

   $("#container").html('');
    var data1=<?php print json_encode($data1);?>;
    var data2=<?php print json_encode($data2);?>;
    var data3=<?php print json_encode($data3);?>;
    var data4=<?php print json_encode($data4);?>;
    var data=[data1,data2,data3,data4];
    console.log(data);
    console.log("==============");


  var dataN=[
   {"outlet":"palsana","sales":"10000"},
   {"outlet":"vatva","sales":"10000"},
   {"outlet":"vishnagar","sales":"40000"},
   {"outlet":"hmt","sales":"58000"},
   {"outlet":"central","sales":"50000"},

  ];

    const width=500;
    const height=500;
    const margin = {'top': 20, 'right': 20, 'bottom': 100, 'left': 100};
    const graphWidth = width - margin.left - margin.right;
    const graphHeight = height - margin.top - margin.bottom;

    const svg=d3.select("#container")
                .append("svg")
                .attr("width",width)
                .attr("height",height);

    const graph=svg.append("g")
                    .attr("width",graphWidth)
                    .attr("height",graphHeight)
                    .attr("transform",`translate(${margin.left},${margin.top})`);

    const gx_axis=graph.append("g")
                        .attr("transform",`translate(0,${graphHeight})`);
    const gy_axis=graph.append("g");

    var minsales=d3.min(data.map(function(d){return d.sales}));
    var maxsales=d3.max(data.map(function(d){return d.sales}));
    console.log(maxsales);
    var upp=parseInt(maxsales)+parseInt(minsales);
    console.log(upp);
    

    var xScale=d3.scaleBand()
            .domain(data.map(function(d){return d.outlet}))
            .range([0,graphWidth])
            .padding(0.4);

    var yScale=d3.scaleLinear()
                    .domain([upp,0])
                    .range([0,graphHeight]);

    const xAxis=d3.axisBottom(xScale);
    const yAxis=d3.axisLeft(yScale);

    gx_axis.call(xAxis);
    gy_axis.call(yAxis);

    const rects=graph.selectAll("rect")
                        .data(data)
                        .enter()
                        .append("rect")
                        .attr("transform",`translate(15,0)`)
                        .attr("width",20)
                        .attr("class","blue")
                        .attr("height",function(d){return graphHeight-yScale(d.sales)})
                        .attr("x",function(d){return xScale(d.outlet)})
                        .attr("y",function(d){return yScale(d.sales)});


   
                  
   graph.append("g")
         .data([data])
         //.enter()
         .append("line")
         
         .attr("x1",xScale(0))
         .attr("y1",function(d){
            console.log(d);
            return yScale(maxsales)})
         .attr("x2",width)
         .attr("y2",function(d){return yScale(maxsales)})
         .attr("stroke","red");

   graph.append('g')
    .attr('class', 'grid')
    .call(d3.axisLeft()
        .scale(yScale)
        .tickSize(-width, 0, 0)
        .tickFormat(''));

  

  
</script>
</html>