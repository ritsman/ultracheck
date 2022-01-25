<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
// list of functions
function get_op_stk($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt){
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
    $pcs=total_sold_pcs($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt);
    $result=$qty['pcs']+$pcs['opb'];
    return intval($result)==0?null:intval($result);
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
    $pcs=total_sold_pcs($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt);
    $result=$qty['pcs']+$pcs['rcd'];
    return intval($result)==0?null:intval($result);
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
// get return pcs during this period
function get_ret_stk($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt){
    $q="select count(barcode) as pcs from `T__salesdata_rt__$outlet` where artno='$artno' and shade='$shade' ";
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

// get total sold pcs fromdt to tdy
function total_sold_pcs($DBH,$outlet,$artno,$shade,$sz,$frmdt,$todt){
    $rcd=0;
    $ops=0;
    $date=date("Y-m-d");
    $q="select barcode,location from `T__salesdata__$outlet` where artno='$artno' and shade='$shade' ";
    $q.=" and sz='$sz' and (billdate between '$frmdt' and '$date')";
    //echo $q;
    //echo $q."<br>";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
       while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $qty[$r['barcode']]=$r['location'];
       }
            
        
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        
    }
    // var_export($qty);
    // echo '<hr>';
    foreach($qty as $barcode=>$chlnstring){
        $chlno=substr($chlnstring,0,strpos($chlnstring,'@'));
        //echo $chlno;
        $qw="select chdt from Q__challan_main where pono='$chlno' and too like '$outlet%'";
        $rt=$stm=$DBH->prepare($qw);
        try {
            $stm->execute();
            $rt=$stm->fetch(PDO::FETCH_ASSOC);
            if($rt['chdt']>$frmdt&&$rt['chdt']<$todt){
                $rcd++;
            }else if($rt['chdt']<$frmdt){
                $ops++;
            }
            $result2['rcd']=$rcd;
            $result2['opb']=$ops;
        } catch (PDOException $th) {
            //throw $th;
            echo $th->getMessage();
        }
        
    }
    //var_export($result2);
    //echo '<hr>';
    return $result2;
}


$cat=json_decode($_POST['cat'],true);
$artnoary=json_decode($_POST['artno'],true);

$outlet_ary=json_decode($_POST['outlet'],true);
//var_export($outlet_ary);
//echo '<hr>';
// var_export($artnoary);
// echo '<hr>';
// echo "CAT:$cat--frmdt:$frmdt--TODT:$todt";


// get the head line
foreach($outlet_ary as $out){
    $hline.="<th>$out</th>";
    
    $h2line.="<th>DAYS</th>";
   
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
    'F4'=>"KIDS SHORTS",
    'Q'=>"QUEEN BED SHEET",
    'K'=>"KING BED SHEET",
    'S'=>"SINGLE BED SHEET",
    'T'=>"TOWEL",
    'N'=>"NAPKIN",
    'H'=>"HANDKERCHIEF"
      
];
//echo "<table><tr><th colspan='5'>";
//echo $hline;
$count=0;
echo "<table class='table'><tr><th>CATAGORY</th><th>REFERNCE</th><th>SERIES</th><th>ARTICLE NO</th><th>BARCODE<th>SHADE</th>";
echo "<th>SIZE</th><th>AGE</th><th>MRP</th><th>LOCATION</th>";
//echo $h2line;
function get_barcode($DBH,$artno,$outlet){
    $q="select * from `Q__stk__$outlet` where artno='$artno' order by barcode";
    //echo $q."<br>";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $barcode_stk[]=$r;
        }
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $barcode_stk;
    //var_export($barcode_stk);
    //echo '<hr>';
}

function get_barcode_age($datetime){
    //$date= date("Y-m-d H:i:s");
    $date=new DateTime($datetime);
    //$d=new DateTime($date->format("Y-m-d"));
    
    $tody=new DateTime();
    $interval = $date->diff($tody,$absolue=true);
    //echo $date;
    //echo $interval->format('%R%a');

    return abs($interval->format('%R%a'));
}


    foreach($artnoary as $ary){
        $i=0;
        
        
        foreach($outlet_ary as $outlet){
           
            //echo "$outlet:OUTLET<br>";
            $barcode_stk=get_barcode($DBH,$ary['art'],$outlet);
            // if(is_null($barcode_stk)){
               
            //     echo "<tr><td></td><td></td><td></td><td></td>";
            //     echo "<td></td><td></td><td></td><td></td>";
            //     echo "<td></td><td></td><td></td><td></td>";
            //     echo "<td></td><td></td></tr>";
            // }
            
            
            foreach($barcode_stk as $b){
               
                //var_export($b);
                //echo '<hr>';
                $line="<tr><td>$b[cat]</td><td>$b[sono2]</td><td>$b[series]</td><td>$b[artno]</td><td>$b[barcode]</td>";
                $line.="<td>$b[shade]</td><td>$b[sz]</td>";
                $age=get_barcode_age($b['created']);
                
                
                //$line.="$gap<td>$age--$outlet--$i--$m--$k</td>$endgap ";
                $line.="<td>$age</td><td>$b[mrp]</td><td>$outlet</td></tr> ";
                $count++;
                echo $line;
            }
            $i++;
        }
    }
   echo "TOTAL PCS:$count";           
?>