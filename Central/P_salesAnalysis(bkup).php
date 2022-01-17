<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
// list of functions
function get_op_stk($DBH,$outlet,$artno,$shade,$sz,$frmdt){
    $q="select sum(qty) as pcs from `Q__stk__$outlet` where artno='$artno' and shade='$shade' ";
    $q.=" and sz='$sz' and created < '$frmdt' ";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $qty=$stm->fetch(PDO::FETCH_ASSOC);
        }else{
            $qty['pcs']=0;
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $qty['pcs']=0;
    }
    return intval($qty['pcs'])==0?null:intval($qty['pcs']);
}

// get recd stock
function get_rcd_stk($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt){
    $q="select sum(qty) as pcs from `Q__stk__$outlet` where artno='$artno' and shade='$shade' ";
    $q.=" and sz='$sz' and (created between '$frmdt' and '$todt')";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $qty=$stm->fetch(PDO::FETCH_ASSOC);
        }else{
            $qty['pcs']=0;
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $qty['pcs']=0;
    }
    return intval($qty['pcs'])==0?null:intval($qty['pcs']);
}
// get closing stock

function get_cls_stk($DBH,$outlet,$artno,$shade,$sz,$todt){
    $q="select sum(qty) as pcs from `Q__stk__$outlet` where artno='$artno' and shade='$shade' ";
    $q.=" and sz='$sz' and created > '$todt' ";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $qty=$stm->fetch(PDO::FETCH_ASSOC);
        }else{
            $qty['pcs']=0;
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $qty['pcs']=0;
    }
    return intval($qty['pcs'])==0?null:intval($qty['pcs']);
}
// get sold stock

function get_sold_stk($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt){
    $q="select count(barcode) as pcs from `T__salesdata__$outlet` where artno='$artno' and shade='$shade' ";
    $q.=" and sz='$sz' and (billdate between '$frmdt' and '$todt')";
    //echo $q;
    //echo $q."<br>";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $qty=$stm->fetch(PDO::FETCH_ASSOC);
        }else{
            $qty['pcs']=0;
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $qty['pcs']=0;
    }
    return intval($qty['pcs'])==0?null:intval($qty['pcs']);
}




$cat=json_decode($_POST['cat'],true);
$artnoary=json_decode($_POST['artno'],true);
$frmdt=$_POST['frmdt'];
$todt=$_POST['todt'];
$outlet_ary=json_decode($_POST['outlet'],true);
// var_export($outlet_ary);
// echo '<hr>';
// get the head line
foreach($outlet_ary as $out){
    $hline.="<th colspan='4'>$out</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";
}
// echo $frmdt ."--".$todt;
// var_export($cat);
// echo '<hr>';
// var_export($artnoary);
// echo '<hr>';
$cat_reverse=[
    "A2"=>"MEN'S JACKET",
    'A2'=>"MEN'S JEANS",
    'A3'=>"MEN'S SHIRT",
    'A4'=>"MEN'S T-SHIRT",
    'A5'=>"MEN'S SHORTS",
    'B1'=>"MEN'S TRACK",
    'B2'=>"MEN'S BOXER",
    'A10'=>"MEN'S CASUAL",
    'A11'=>"MEN'S FORMAL",
  
    'A6'=>"WOMEN'S JEANS",
    'A7'=>"WOMEN'S KURTI",
    'A8'=>"WOMEN'S PLAZO",
    'A9'=>"WOMEN'S SHORTS",
    'B3'=>"WOMEN'S LOWER",
    'B4'=>"WOMEN'S T-SHIRT",
    'B5'=>"WOMEN'S SHIRT",
    'B6'=>"WOMEN'S JACKET",
  
    'C1'=>"BOY'S T-SHIRT",
    'C2'=>"BOY'S JEANS",
    'C3'=>"BOY'S SHIRT",
    'C4'=>"BOY'S SHORTS",
  
    'D1'=>"GIRL'S T-SHIRT",
    'D2'=>"GIRL'S JEANS",
    'D3'=>"GIRL'S SHORTS",
    'D4'=>"GIRL'S FROCK",
    'D5'=>"GIRL'S SKIRT",
  
    'E1'=>"LITTLE T-SHIRT",
    'E2'=>"LITTLE JEANS",
    'E3'=>"LITTLE SKIRT",
    'E4'=>"LITTLE SHORTS",
    'E5'=>"LITTLE FROCK",
  
    'F1'=>"KIDS T-SHIRT",
    'F2'=>"KIDS JEANS",
    'F3'=>"KIDS SHIRT",
    'F4'=>"KIDS SHORTS"
      
];
echo "<table><tr><th colspan='4'>".$hline;
echo "<tr><th>CATAGORY</th><th>ARTICLE NO</th><th>SHADE</th>";
echo "<th>SIZE</th>".$h2line;
foreach($artnoary as $ary){
    $cat=$cat_reverse[$ary['clas']];
    // get shades
    $r=get_artno_shades_n_sz($DBH,$ary['art']);
    // var_export($r);
    // echo '<hr>';
    foreach($r['shade'] as $shary){
        foreach($r['sz'] as $sz){
            $line="<tr><td>$cat</td><td>$ary[art]</td><td>$shary</td><td>$sz</td>";
            $auxline="";
            foreach($outlet_ary as $outlet){
                
                $op_stk[$outlet]=get_op_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt);
                $rcd_stk[$outlet]=get_rcd_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                $sold_stk[$outlet]=get_sold_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                $cls_stk[$outlet]=get_cls_stk($DBH,$outlet,$ary['art'],$shary,$sz,$todt);
                $auxline.="<td class='C1'>$op_stk[$outlet]</td><td>$rcd_stk[$outlet]</td>";
                $auxline.="<td class='C1'>$sold_stk[$outlet]</td>";
                $closing_stk=$op_stk[$outlet]+$rcd_stk[$outlet]-$sold_stk[$outlet]+$cls_stk[$outlet];
                $auxline.="<td>$closing_stk</td>";
                
            }
            $line.=$auxline;
            echo $line;
            // return false;
            
            
            
        }
        

       
    }
    
}




?>