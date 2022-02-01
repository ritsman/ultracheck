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




$cat=json_decode($_POST['cat'],true);
$artnoary=json_decode($_POST['artno'],true);
$frmdt=$_POST['frmdt'];
$todt=$_POST['todt'];
$outlet_ary=json_decode($_POST['outlet'],true);
//var_export($outlet_ary);
// echo '<hr>';
// get the head line
// foreach($outlet_ary as $out){
//     $hline.="<th colspan='4'>$out</th>";
//     $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";
// }
// echo $frmdt ."--".$todt;
// var_export($cat);
// echo '<hr>';
if(in_array('CENTRAL',$outlet_ary)){
    $hline.="<th colspan='4'>CENTRAL</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";

}
if(in_array('PALSANA',$outlet_ary)){
    $hline.="<th colspan='4'>PALSANA</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";

}
if(in_array('VATVA',$outlet_ary)){
    $hline.="<th colspan='4'>VATVA</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";

}
if(in_array('HMT',$outlet_ary)){
    $hline.="<th colspan='4'>HMT</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";

}
if(in_array('VISHNAGAR',$outlet_ary)){
    $hline.="<th colspan='4'>VISHNAGAR</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>CLS STK</th>";

}
//var_export($artnoary[0]['art']);
//echo '<hr>';
$cat_reverse=[
    "A2"=>"MEN'S JACKET",
    'A2'=>"MEN'S JEANS",
    'A3'=>"MEN'S SHIRT",
    'A4'=>"MEN'S T-SHIRT",
    'A5'=>"MEN'S SHORTS",
    'B1'=>"MEN'S TRACK",
    'B2'=>"MEN'S BOXER",
  
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



$maincount= count($artnoary);

function display_line($DBH,$artno,$outlet_ary,$frmdt,$todt,$cat_reverse,$clas){
    $q="select * from `Q__artno__sz` where artno='".$artno."'";
    //echo $q."<br>";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $rc=$stm->rowCount();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
        //echo $artno."---$rc";
        for($j=0;$j<$rc;$j++){
            $q2="select shade,sz from `Q__artno__sz` where artno='".$artno."' order by shade,sz limit $j,1 ";
            //echo $q."<br>";
            $stm=$DBH->prepare($q2);
            try {
                $stm->execute();
                $data=$stm->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $th) {
                //throw $th;
                echo $th->getMessage();
            }
            //var_export($data);
            $cat=$cat_reverse[$clas];
            $line="<tr><td>$cat</td><td>$artno</td><td>$data[shade]</td><td>$data[sz]</td>";
            $auxline_central="";
            $auxline_palsana="";
            $auxline_vatva="";
            $auxline_hmt="";
            $auxline_vishnagar="";

            if(in_array('CENTRAL',$outlet_ary)){
                $c_stk="ABC";
                $op_stk=get_op_stk($DBH,'CENTRAL',$artno,$data['shade'],$data['sz'],$frmdt);
                $rcd_stk=get_rcd_stk($DBH,'CENTRAL',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $sold_stk=get_sold_stk($DBH,'CENTRAL',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $cls_stk=get_cls_stk($DBH,'CENTRAL',$artno,$data['shade'],$data['sz'],$todt);
        
                //echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
                //echo '<hr>';
                $auxline_central.="<td class='C1'>$op_stk</td><td>$rcd_stk</td>";
                $auxline_central.="<td class='C1'>$sold_stk</td>";
                $closing_stk=$op_stk+$rcd_stk-$sold_stk+$cls_stk;
                $c_stk=$closing_stk==0?null:$closing_stk;
                $auxline_central.="<td>$c_stk</td>";
            }
            
            if(in_array('PALSANA',$outlet_ary)){
                $c_stk="ABC";
                $op_stk=get_op_stk($DBH,'PALSANA',$artno,$data['shade'],$data['sz'],$frmdt);
                $rcd_stk=get_rcd_stk($DBH,'PALSANA',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $sold_stk=get_sold_stk($DBH,'PALSANA',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $cls_stk=get_cls_stk($DBH,'PALSANA',$artno,$data['shade'],$data['sz'],$todt);
        
                //echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
                //echo '<hr>';
                $auxline_palsana.="<td class='C1'>$op_stk</td><td>$rcd_stk</td>";
                $auxline_palsana.="<td class='C1'>$sold_stk</td>";
                $closing_stk=$op_stk+$rcd_stk-$sold_stk+$cls_stk;
                $c_stk=$closing_stk==0?null:$closing_stk;
                $auxline_palsana.="<td>$c_stk</td>";
            }

            if(in_array('VATVA',$outlet_ary)){
                $c_stk="ABC";
                $op_stk=get_op_stk($DBH,'VATVA',$artno,$data['shade'],$data['sz'],$frmdt);
                $rcd_stk=get_rcd_stk($DBH,'VATVA',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $sold_stk=get_sold_stk($DBH,'VATVA',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $cls_stk=get_cls_stk($DBH,'VATVA',$artno,$data['shade'],$data['sz'],$todt);
        
                //echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
                //echo '<hr>';
                $auxline_vatva.="<td class='C1'>$op_stk</td><td>$rcd_stk</td>";
                $auxline_vatva.="<td class='C1'>$sold_stk</td>";
                $closing_stk=$op_stk+$rcd_stk-$sold_stk+$cls_stk;
                $c_stk=$closing_stk==0?null:$closing_stk;
                $auxline_vatva.="<td>$c_stk</td>";
            }

            if(in_array('HMT',$outlet_ary)){
                $c_stk="ABC";
                $op_stk=get_op_stk($DBH,'HMT',$artno,$data['shade'],$data['sz'],$frmdt);
                $rcd_stk=get_rcd_stk($DBH,'HMT',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $sold_stk=get_sold_stk($DBH,'HMT',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $cls_stk=get_cls_stk($DBH,'HMT',$artno,$data['shade'],$data['sz'],$todt);
        
                //echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
                //echo '<hr>';
                $auxline_hmt.="<td class='C1'>$op_stk</td><td>$rcd_stk</td>";
                $auxline_hmt.="<td class='C1'>$sold_stk</td>";
                $closing_stk=$op_stk+$rcd_stk-$sold_stk+$cls_stk;
                $c_stk=$closing_stk==0?null:$closing_stk;
                $auxline_hmt.="<td>$c_stk</td>";
            }

            if(in_array('VISHNAGAR',$outlet_ary)){
                $c_stk="ABC";
                $op_stk=get_op_stk($DBH,'VISHNAGAR',$artno,$data['shade'],$data['sz'],$frmdt);
                $rcd_stk=get_rcd_stk($DBH,'VISHNAGAR',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $sold_stk=get_sold_stk($DBH,'VISHNAGAR',$artno,$data['shade'],$data['sz'],$frmdt,$todt);
                $cls_stk=get_cls_stk($DBH,'VISHNAGAR',$artno,$data['shade'],$data['sz'],$todt);
        
                //echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
                //echo '<hr>';
                $auxline_vishnagar.="<td class='C1'>$op_stk</td><td>$rcd_stk</td>";
                $auxline_vishnagar.="<td class='C1'>$sold_stk</td>";
                $closing_stk=$op_stk+$rcd_stk-$sold_stk+$cls_stk;
                $c_stk=$closing_stk==0?null:$closing_stk;
                $auxline_vishnagar.="<td>$c_stk</td>";
            }

            $line.=$auxline_central.$auxline_palsana.$auxline_vatva.$auxline_hmt.$auxline_vishnagar;
            echo $line;
            
    
        }
}
    

$count=0;
while($count<$maincount){
    display_line($DBH,$artnoary[$count]['art'],$outlet_ary,$frmdt,$todt,$cat_reverse,$artnoary[$count]['clas']);
    $count++;
}






/*

for($i=0;$i<$maincount;$i++){
    $q="select * from `Q__artno__sz` where artno='".$artnoary[$i]['art']."'";
    //echo $q."<br>";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $rc=$stm->rowCount();
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    echo $artnoary[$i]['art']."---$rc";
    for($j=0;$j<$rc;$j++){
        $q2="select shade,sz from `Q__artno__sz` where artno='".$artnoary[$i]['art']."' order by shade,sz limit $j,1 ";
        //echo $q."<br>";
        $stm=$DBH->prepare($q2);
        try {
            $stm->execute();
            $data=$stm->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        }
        var_export($data);
        if(in_array('PALSANA',$outlet_ary)){
            $op_stk=get_op_stk($DBH,'PALSANA',$artnoary[$i]['art'],$data['shade'],$data['sz'],$frmdt);
            $rcd_stk=get_rcd_stk($DBH,'PALSANA',$artnoary[$i]['art'],$data['shade'],$data['sz'],$frmdt,$todt);
            $sold_stk=get_sold_stk($DBH,'PALSANA',$artnoary[$i]['art'],$data['shade'],$data['sz'],$frmdt,$todt);
            $cls_stk=get_cls_stk($DBH,'PALSANA',$artnoary[$i]['art'],$data['shade'],$data['sz'],$todt);
    
            echo "$op_stk==$rcd_stk==$sold_stk==$cls_stk<br>";
            echo '<hr>';
        }
        

    }
}

*/








/*
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

*/


?>