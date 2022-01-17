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
$minstk=$_POST['minstk'];
$maxstk=$_POST['maxstk'];
$salesrep=$_POST['sales'];

//echo "MINSTK:$minstk,,MAXSTK:$maxstk,SALESREP:$salesrep";

$cat=json_decode($_POST['cat'],true);
$artnoary=json_decode($_POST['artno'],true);
$frmdt=$_POST['frmdt'];
$todt=$_POST['todt'];
$outlet_ary=json_decode($_POST['outlet'],true);
// var_export($outlet_ary);
// echo '<hr>';
// var_export($artnoary);
// echo '<hr>';
// echo "CAT:$cat--frmdt:$frmdt--TODT:$todt";


// get the head line
foreach($outlet_ary as $out){
    $hline.="<th colspan='5'>$out</th>";
    $hBline.="<th colspan='3'>$out</th>";
    $h2line.="<th>OP STK</th><th>RCD STK</th><th>SOLD STK</th><th>RTN STK</th><th>CLS STK</th>";
    
    $h3line.="<th>SOLD STK</th><th>RTN STK</th><th>NET SALES</th>";
}
$h2line.="<th>OP TTL</th><th>RCD TTL</th><th>SOLD TTL</th><th>RTN TTL</th><th>CLS TTL</th>";
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
echo "<table class='showtab'><tr><th colspan='4'>";
if($salesrep==1){
    echo $hBline;
}else{
    echo $hline;
}
echo "<tr><th>CATAGORY</th><th>ARTICLE NO</th><th>SHADE</th>";
echo "<th>SIZE</th>";
if($salesrep==1){
    echo $h3line;
}else{
    echo $h2line;
}
// global total of artno outlet wise
$global_op=[];
$global_rcd=[];
$global_sold=[];
$global_rtn=[];
$global_cls=[];
if($salesrep==0){
    foreach($artnoary as $ary){
        //var_export($ary);
        $cat=$cat_reverse[$ary['clas']];
        //echo "$cat:CAT:<br>";
        // get shades
        $r=get_artno_shades_n_sz($DBH,$ary['art']);
        // var_export($r);
        // echo '<hr>';
        foreach($r['shade'] as $shary){
            foreach($r['sz'] as $sz){
                $line="<tr><td>$cat</td><td>$ary[art]</td><td>$shary</td><td>$sz</td>";
                $auxline="";
                $op_stk_sz_ttl=0;
                $rcd_stk_sz_ttl=0;
                $sold_stk_sz_ttl=0;
                $rtn_stk_sz_ttl=0;
                $cls_stk_sz_ttl=0;
                foreach($outlet_ary as $outlet){
                    
                    $op_stk[$outlet]=get_op_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    $rcd_stk[$outlet]=get_rcd_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    $sold_stk[$outlet]=get_sold_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    $rtn_stk[$outlet]=get_ret_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    $cls_stk[$outlet]=get_cls_stk($DBH,$outlet,$ary['art'],$shary,$sz,$todt);
                    $auxline.="<td class='C1'>$op_stk[$outlet]</td><td>$rcd_stk[$outlet]</td>";
                    $auxline.="<td class='C1'>$sold_stk[$outlet]</td><td class='C1'>$rtn_stk[$outlet]</td>";
                    
                    
                    $op_stk_sz_ttl=$op_stk_sz_ttl+$op_stk[$outlet];
                    $rcd_stk_sz_ttl=$rcd_stk_sz_ttl+$rcd_stk[$outlet];
                    $sold_stk_sz_ttl=$sold_stk_sz_ttl+$sold_stk[$outlet];
                    $rtn_stk_sz_ttl=$rtn_stk_sz_ttl+$rtn_stk[$outlet];

                    $global_op[$outlet]=$global_op[$outlet]+$op_stk[$outlet];
                    $global_rcd[$outlet]=$global_rcd[$outlet]+$rcd_stk[$outlet];
                    $global_sold[$outlet]=$global_sold[$outlet]+$sold_stk[$outlet];
                    $global_rtn[$outlet]=$global_rtn[$outlet]+$rtn_stk[$outlet];
                    
                    //$closing_stk=$op_stk[$outlet]+$rcd_stk[$outlet]-$sold_stk[$outlet]+$cls_stk[$outlet]+$rtn_stk[$outlet];
                    $closing_stk=$op_stk[$outlet]+$rcd_stk[$outlet]-$sold_stk[$outlet]+$cls_stk[$outlet];
                    
                    
                    $cls_stk_sz_ttl=$cls_stk_sz_ttl+$closing_stk;
                    $global_cls[$outlet]=$global_cls[$outlet]+$closing_stk;
                    
                    if($closing_stk<=$minstk&&$closing_stk!=0&&isset($minstk)){
                        $minmax="minom";
                    }else if($closing_stk>=$maxstk&&$closing_stk!=0&&$maxstk!=''){
                        $minmax="maxom";
                    }else if($closing_stk==0){
                        $minmax="norm";
                    }else{
                        $minmax="norm";
                    }
                    $auxline.="<td class='$minmax'>$closing_stk</td>";
                    
                }
                $line.=$auxline;
                $line.="<td>$op_stk_sz_ttl</td>";
                $line.="<td>$rcd_stk_sz_ttl</td>";
                $line.="<td>$sold_stk_sz_ttl</td>";
                $line.="<td>$rtn_stk_sz_ttl</td>";
                $line.="<td>$cls_stk_sz_ttl</td>";
                echo $line;
                // return false;
                
                
                
            }
            
    
           
        }
        
    }
    //var_export($global_op);
    //echo '<hr>';
    // add the total line here
    $last_line="<tr><td colspan='4'>TOTAL</td>";
    $ttl=0;
    foreach($global_op as $out=>$g){
        $last_line.="<td>$g</td><td>$global_rcd[$out]</td><td>$global_sold[$out]</td>";
        $last_line.="<td>$global_rtn[$out]</td><td>$global_cls[$out]</td>";
        $ttl=$ttl+$global_cls[$out];
    }
    $last_line.="<td colspan='5'>$ttl</td></tr>";
    echo $last_line;
}else{
    foreach($artnoary as $ary){
        //var_export($ary);
        $cat=$cat_reverse[$ary['clas']];
        //echo "$cat:CAT:<br>";
        // get shades
        $r=get_artno_shades_n_sz($DBH,$ary['art']);
        // var_export($r);
        // echo '<hr>';
        foreach($r['shade'] as $shary){
            foreach($r['sz'] as $sz){
                $line="<tr><td>$cat</td><td>$ary[art]</td><td>$shary</td><td>$sz</td>";
                $auxline="";
                foreach($outlet_ary as $outlet){
                    
                    
                    $sold_stk[$outlet]=get_sold_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    $rtn_stk[$outlet]=get_ret_stk($DBH,$outlet,$ary['art'],$shary,$sz,$frmdt,$todt);
                    
                    
                    $auxline.="<td class='C1'>$sold_stk[$outlet]</td><td class='C1'>$rtn_stk[$outlet]</td>";
                    
                    $closing_stk=$sold_stk[$outlet]-$rtn_stk[$outlet];
                    if($closing_stk<=$minstk&&$closing_stk!=0){
                        $minmax="minom";
                    }else if($closing_stk>=$maxstk&&$closing_stk!=0&&$maxstk!=''){
                        $minmax="maxom";
                    }else if($closing_stk==0){
                        $minmax="norm";
                    }else{
                        $minmax="norm";
                    }
                    $auxline.="<td class='$minmax'>$closing_stk</td>";
                    
                }
                $line.=$auxline;
                echo $line;
                // return false;
                
                
                
            }
            
    
           
        }
        
    }
}






?>