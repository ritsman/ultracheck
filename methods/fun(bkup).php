<?php
include '../inc/db.inc.php';
/*===========================
 *this function returns style of so;;
 * takes database pdo and sono as parameter
 *===========================
 *///=======================get style for this so
function get_style($DBH,$sono){
    $tt=$sono."_buyer";
    $q4="select style_name from $tt";
    $stm=$DBH->prepare($q4);
		try{
			$stm->execute();
			$res3=$stm->fetch(PDO::FETCH_ASSOC);
			$style=$res3['style_name'];
		}catch(PDOException $e){
			$style= $e->getMessage();
                        
                        
		}
                return $style;
    
}
		
/*
 * this function returns size of the sono 
 */
function get_size($DBH,$sono){
    
    //==================================================get sizes for this so;;
        $q1="select size from soSizeRatio where soNo='$sono' order by seq";
        //echo $q1;
        $sz=[];
        $stm=$DBH->prepare($q1);
        try{
                $stm->execute();
                while($res=$stm->fetch(PDO::FETCH_ASSOC)){
                        $sz[]=$res['size'];
                }
        }catch(PDOException $e){
            $sz[0]= $e->getMessage();
        }

return $sz;

    
}
/*
 * this function returns size and raatio of the sono 
 */
function get_size_ratio($DBH,$sono){
    
    //==================================================get sizes for this so;;
        $q1="select size,ratio from soSizeRatio where soNo='$sono' order by seq";
        $sz=[];
        $stm=$DBH->prepare($q1);
        try{
                $stm->execute();
                while($res=$stm->fetch(PDO::FETCH_ASSOC)){
                        $sz[$res['size']]=$res['ratio'];
                }
        }catch(PDOException $e){
            $sz[0]= $e->getMessage();
        }

return $sz;

    
}
/*
 * get buyer ======
 */
function get_buyer($sono,$DBH){
    $tt=$sono."_buyer";
    $q4="select buyer from $tt";
    $stm=$DBH->prepare($q4);
		try{
			$stm->execute();
			$res3=$stm->fetch(PDO::FETCH_ASSOC);
			$style=$res3['buyer'];
		}catch(PDOException $e){
			$style= $e->getMessage();
                        
                        
		}
                return $style;
    
}
/*
 * this functions returns the collection of database tables matchin the name
 * creiteria given
 */
function get_tables($DBH,$table_string){
    $ttt=[];
    $q1="SELECT table_name FROM information_schema.tables where table_schema='pepcon'";
    $q1.="and table_name LIKE '%_$table_string'";
    //echo $q1;
    $stm=$DBH->prepare($q1);
    $ttt=[];
    try{
            $stm->execute();
            while($res=$stm->fetch(PDO::FETCH_ASSOC)){
                    $ttt[]=$res['table_name'];
            }
    }catch(PDOException $e){
            echo $e->getMessage();
    }
    return $ttt;
}

/*
 * gets distinct shades of sono;
 */
function get_shade($DBH,$sono){
    $shade=[];
    $table=$sono."_odrQty";
    $q="select distinct `Shade` from `$table`";
    //echo $q;
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $shade[]=$r['Shade'];
        }
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $shade;
}
/*

// get all the shades available
*/
function get_shade_all($DBH){
    $q6="select distinct name from B_shade_master";
    $supp=[];
     
     
             try
            {
                    
                $stm=$DBH->prepare($q6);
                $stm->execute();
                if($stm->rowCount()>0)
                {
                    while($result2=$stm->fetch(PDO::FETCH_ASSOC))
                    {
                        $supp[]=$result2['name'];
                   
                    }
                //echo "<hr/>";
                //print_r($supp);
                        
                            }else{$supp=null;}
            }
             catch (PDOException $e)
            {
              echo $e->getMessage();
                        $supp=null;
            }
            return $supp;
}

// get all article no available

function get_articleno($DBH){
    $q6="select distinct artno from Q__artno";
    $supp=[];
     
     
             try
            {
                    
                $stm=$DBH->prepare($q6);
                $stm->execute();
                if($stm->rowCount()>0)
                {
                    while($result2=$stm->fetch(PDO::FETCH_ASSOC))
                    {
                        $supp[]=$result2['artno'];
                   
                    }
                //echo "<hr/>";
                //print_r($supp);
                        
                            }else{$supp=null;}
            }
             catch (PDOException $e)
            {
              echo $e->getMessage();
                        $supp=null;
            }
            return $supp;
}
/*
 * gets distinct washes of sono;
 */
function get_wash($DBH,$sono){
    $shade=[];
    $table=$sono."_odrQty";
    $q="select distinct `Swatch Picture` from `$table`";
    //echo $q;
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $shade[]=$r['Swatch Picture'];
        }
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $shade;
}
//---------------------------------get shade wise qty
function get_qty_shade($DBH,$sono,$shade){
    $qty=0;
    $table=$sono."_odrQty";
    $q="select sum(`Code`) as cc from `$table` where`Shade` ='$shade'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        $r=$stm->fetch(PDO::FETCH_ASSOC);
        $qty=intval($r['cc']);
         
        
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $qty;
    
}
//--------------------------------------get xtra qty
function get_xtra_qty_shade($DBH,$sono,$shade){
    $qty=0;
    $table=$sono."_odrQty";
    $q="select CUT from $table where Shade='$shade'";
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        $r=$stm->fetch(PDO::FETCH_ASSOC);
        $qty=intval($r['CUT']);
         
        
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $qty;
    
}
//=========================================================get unit
function get_unit($DBH){
    $unit=[];
    $q="select itemname from B_unit";
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $unit[]=$r['itemname'];
        }
        
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $unit;
}

function get_available_qty($itemname,$artno,$shadeno,$sz,$DBH){
    $table="inv_".$itemname;
//================================================================grnqty
$q="select sum(`rqty`) as avqty from `$table` where `item`='$itemname' ";
$q.="and artno='$artno' and `shadeno`='$shadeno' and `size`='$sz' and pono!='issue'";
//$q.="group by unit,rate";

//echo $q;
$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data[0]=null;
        }
        
        //echo var_export($data);
        
//================================================================issueqty
$q="select sum(`rqty`) as avqty2 from `$table` where `item`='$itemname' ";
$q.="and artno='$artno' and `shadeno`='$shadeno' and `size`='$sz' and pono='issue'";
//$q.="group by unit,rate";

//echo $q;
$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data2=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data2[0]=null;
        }
        
        //echo var_export($data2);
        
        $aq=$data['avqty']-$data2['avqty2'];
        return $aq;
    
}
//================================
function get_available_qty_gen($itemname,$artno,$shadeno,$sz,$DBH){
    $table="inv_".$itemname;
//================================================================grnqty
$q="select sum(`rqty`) as avqty from `$table` where `item`='$itemname' ";
$q.="and artno='$artno' and `shade`='$shadeno' and `sz`='$sz' and pono!='issue'";
//$q.="group by unit,rate";

//echo $q;
$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data[0]=null;
        }
        
        //echo var_export($data);
        
//================================================================issueqty
$q="select sum(`rqty`) as avqty2 from `$table` where `item`='$itemname' ";
$q.="and artno='$artno' and `shade`='$shadeno' and `sz`='$sz' and pono='issue'";
//$q.="group by unit,rate";

//echo $q;
$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data2=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data2[0]=null;
        }
        
        //echo var_export($data2);
        
        $aq=$data['avqty']-$data2['avqty2'];
        return $aq;
    
}

function get_trims_availqty($itemname,$query,$DBH){
            $table="inv_".$itemname;
//================================================================grnqty
$q="select sum(`rqty`) as avqty from `$table` where `item`='$itemname'  and pono!='issue' ";
$q.=" $query";
//$q.="group by unit,rate";

//echo $q;

$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data[0]=null;
        }
        
        //echo var_export($data);
        
//================================================================issueqty
$q="select sum(`rqty`) as avqty2 from `$table` where `item`='$itemname' and pono='issue' ";
$q.=" $query ";
//$q.="group by unit,rate";

//echo $q;
$stm=$DBH->prepare($q);
 try
        {
                $stm->execute();
                
                $data2=$stm->fetch(PDO::FETCH_ASSOC);
                
        }
        catch(PDOException $e)
        {
                echo $e->getMessage();
                $data2[0]=null;
        }
        
        //echo var_export($data2);
        
        $aq=intval($data['avqty'])-intval($data2['avqty2']);
        return $aq;
    

    }

/*
 * ============================list of sono in B_salesorder;
 */
function get_sono_list($DBH){
    $q="select sono from `B_salesorder` where sotype!='JOBWORK'";
    //echo $q;
    $stm=$DBH->prepare($q);
    $sono=[];
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $sono[]=$r['sono'];
        }
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
    return $sono;
}

/*
 * ============================list of sono in B_salesorder;
 */
function get_gpo_list($DBH){
    $q="select distinct sono2 from `Q__artno__sz` ";
    //echo $q;
    $stm=$DBH->prepare($q);
    $sono=[];
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $sono[]=$r['sono2'];
        }
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
    return $sono;
}

/*
 * return unit,rate, required qty form _soTrims table;;
 * 
 */
function get_unit_rate_qty($DBH,$so,$itemname,$artno,$artshade,$artsz){
    $tab=$so."_soTrims";
    $q="select unit,rate,treqty from `$tab` where `itemname`='$itemname' and `artno`='$artno' ";
    $q.="and `artshade`='$artshade' and `artsz`='$artsz'";
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        $uk=$stm->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e){
        echo $e->getMessage();
        $uk['unit']='NA';
        $uk['rate']='NA';
        $uk['treqty']='NA';
    }
    
    
    
    return $uk;
}
//====================================get buyer-style-deldt-merchandiser
function get_buyer_style($DBH,$sono){
    $t=$sono."_buyer";
    $q="select buyer,style_name,del_dt,merchandiser from $t";
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data=$r;
        }
        
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    //-------------------------------------------added exe no in this 03/07/2020
    $q2="select exeno from B_salesorder where sono='$sono'";
    $stm=$DBH->prepare($q2);
    try{
        $stm->execute();
        $d=$stm->fetch(PDO::FETCH_ASSOC);
        $data['exeno']=$d['exeno'];
    } catch (PDOException $e){
        echo $e->getMessage();
    }
    return $data;
}
//===========================================get consumption
function get_cons($DBH,$sono,$sortno){
    $t=$sono."_odrQty";
    $cons=0;
    $q="select `Total Qty` from $t where Shade='$sortno'";
    $stm=$DBH->prepare($q);
    try{
        $stm->execute();
        $uk=$stm->fetch(PDO::FETCH_ASSOC);
        $cons=floatval($uk['Total Qty']);
        
    } catch (PDOException $e){
        echo $e->getMessage();
        $cons=$e->getMessage();
    }
    
    return $cons;
    
}
// new function for franchise billing only
function get_new_pono_frn($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    $month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_po_new_gen where month='$month' and year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
    //echo $year.$month.$prefix.$pono;
    //increment the pono here only////=======fingers crossed this will work!!!!!!!!!!!!!!!
            $qi = "insert into B_po_new_gen (`year`,`month`,`$pono_field`)values('$year','$month','$pono')";
            $stm = $DBH->prepare($qi);
            try {
                $stm->execute();
                ///echo '<br>doneponumber insert<br>';
            } catch (PDOException $e) {
                echo "<br>6A." . $e->getMessage();
                
            }
        return $year.$month.$prefix.$pono;
}

//=======================generate new purchaseorder nubmer;;//

function get_new_pono($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    $month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_po_new_gen where month='$month' and year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
    // //echo $year.$month.$prefix.$pono;
    // //increment the pono here only////=======fingers crossed this will work!!!!!!!!!!!!!!!
    //         $qi = "insert into B_po_new_gen (`year`,`month`,`$pono_field`)values('$year','$month','$pono')";
    //         $stm = $DBH->prepare($qi);
    //         try {
    //             $stm->execute();
    //             ///echo '<br>doneponumber insert<br>';
    //         } catch (PDOException $e) {
    //             echo "<br>6A." . $e->getMessage();
                
    //         }
        return $year.$month.$prefix.$pono;
}
//=========================backup
function get_new_pono22($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    $month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_po_new_gen where month='$month' and year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
    //echo $year.$month.$prefix.$pono;
    
        return $year.$month.$prefix.$pono;
}


//=======================generate new transferchallan;;

function get_new_challan($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    $month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_new_chllan_gen where month='$month' and year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
        //echo $year.$month.$prefix.$pono;
        return $year.$month.$prefix.$pono;
}
//=======================generate new purchaseorder nubmer without month;;

function get_new_pono2($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    //$month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_po_new_gen where  year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
        return $year.$prefix.$pono;
}

//----------------------support function to check for month's first entry
function get_prefix($pono){
 $char= strlen($pono);
 //echo $char;
 switch($char){
     case 1:
         return '000';
         break;
     case 2:
         return '00';
         break;
     case 3:
         return '0';
         break;
     case 4:
         return '';
         break;
     default :
         return 'NA';
         
 }
}

//----------------------support function to get barcode prefix from id
function get_bc_prefix($pono){
    $char= strlen($pono);
    //echo $char;
    switch($char){
        case 1:
            return '0000';
            break;
        case 2:
            return '000';
            break;
        case 3:
            return '00';
            break;
        case 4:
            return '0';
            break;
        case 5:
            return '';
            break;
        default :
            return 'NA';
            
    }
   }
//================================================get sum of po qty done;;;
function get_po_qty($sono,$artno,$itemname,$DBH){
    $tt2=$sono."_trimsQty";
    $q="select sum(poQty) as pq from `$tt2` where `Item Name`='$itemname' and `Catagory`='$artno'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $poqty2= $stm->fetch(PDO::FETCH_ASSOC);
        $poQty=floatval($poqty2['pq']);
        
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
    return $poQty;

}
//-----------------------------get cut stock
function get_WIP_stock($dept,$DBH){
    $dept_table="";
    switch($dept){
        case "CUT":
            $dept_table='Q__cutting';
            break;
        case "SEW":
            $dept_table='Q__sewing';
            break;
        
        default:
            $dept_table="NOT FOUND";
            
            
    }
    $q="select stock from `$dept_table` order by id desc limit 1";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $cutstock=$stm->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
    return intval($cutstock['stock']);

}
//-----------------------------get fabric
function get_FABRIC_stock($sortno,$DBH){
    $dept_table="Q__fabric_stock";
    
    $q="select stock from `$dept_table` where sortno='$sortno' order by id desc limit 1";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $cutstock=$stm->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $exc) {
        echo $exc->getMessage();
    }
    return intval($cutstock['stock']);

}

//--------------------------up pono
function up_pono($field,$newpono,$DBH){
    $year = substr($newpono, 0, 2);
    $month = substr($newpono, 2, 2);
    $pono = substr($newpono, 4, 4);
    $qi2 = "insert into B_po_new_gen (`year`,`month`,`$field`)values('$year','$month','$pono')";
    $stm = $DBH->prepare($qi2);
    try {
        $stm->execute();
        //echo 'donepomaxincrease';
    } catch (PDOException $e) {
        echo "<br>10." . $e->getMessage();
        //$msg .= "6@";
    }


}
//-----------------------------get supplier list
function get_supp_list($DBH) {
    $supp = [];
    $query = "select name from B_sup_master";
    $stm = $DBH->prepare($query);
    try {
        $stm->execute();
        if ($stm->rowCount() > 0) {
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                $supp[] = $result['name'];
            }
            //print_r($so);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $supp = null;
    }
    return $supp;
}
//---------------------------------------
//-----------------------------get supplier list
function get_customer_list($DBH) {
    $supp = [];
    $query = "select name from B_cust_master";
    $stm = $DBH->prepare($query);
    try {
        $stm->execute();
        if ($stm->rowCount() > 0) {
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                $supp[] = $result['name'];
            }
            //print_r($so);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        $supp = null;
    }
    return $supp;
}

//-----------------------------get sortno list
function get_sortno_list($DBH) {
    $supp = [];
    $query = "select distinct fabno from D_trimsMaster_cutting";
    $stm = $DBH->prepare($query);
    try {
        $stm->execute();
      
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                $supp[] = $result['fabno'];
            }
            //print_r($so);
       
    } catch (PDOException $e) {
        echo $e->getMessage();
        $supp = null;
    }
    return $supp;
}
//-----------------------------get fabric itemname list
function get_fabitemname_list($DBH) {
    $supp = [];
    $query = "select distinct itemname from D_trimsMaster_cutting";
    $stm = $DBH->prepare($query);
    try {
        $stm->execute();
        
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                $supp[] = $result['itemname'];
            }
            //print_r($so);
      
    } catch (PDOException $e) {
        echo $e->getMessage();
        $supp = null;
    }
    return $supp;
}

/*
* this function is used in printing gatepass in pdf:: gatepass2pdf.php in WRH module
*/
function get_dis_qty($DBH,$id){
    $q="select totalcut from Q__dispatch where id='$id'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $qty2=$stm->fetch(PDO::FETCH_ASSOC);
        $qty=intval($qty2['totalcut']);
    } catch (PDOException $th) {
        echo $th->getMessage();
        $qty=0;
    }
    return $qty;
}

function get_bar_cat($DBH,$barcode){

    $tname=intval(substr($barcode,1,5))."_stk";

}

function get_bill_prefix($DBH,$bill_field){
    
    $q="select `billprefix` from `Q__bill__prefix` where billfield='$bill_field'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $b=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $b['billprefix']='NA';
        
    }
    return $b['billprefix'];

}
//=======================generate new purchaseorder nubmer;;

function get_new_pono_rt($DBH,$pono_field){
    $d=new DateTime();
   // var_export($d);
    //echo date("y").date('m').date('d');
    $year=date('y');
    $date=date('d');
    $month=date('m');
    $q="select max(cast((`$pono_field`) as unsigned)) as tmax from B_po_new_gen_rt where month='$month' and year='$year'";
    //select max(cast((substring(asno,6)) as unsigned)) as asnmax
    //echo $q;
        $stm=$DBH->prepare($q);
        try {
            $stm->execute();
            $pono2=$stm->fetch(PDO::FETCH_ASSOC);
            $pono=intval($pono2['tmax']);
            
        } catch (PDOException $exc) {
            echo $exc->getMessage();
            
        }
        
        //var_export($pono);
        $pono++;
        $prefix=get_prefix($pono);
        //echo $year.$month.$prefix.$pono;
        return $year.$month.$prefix.$pono;
}
// get prefix for return sales
function get_bill_prefix_rt($DBH,$bill_field){
    
    $q="select `billprefix` from `Q__bill__prefix_rt` where billfield='$bill_field'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $b=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $b['billprefix']='NA';
        
    }
    return $b['billprefix'];

}

// new addition on 21/03/21

// get order qty for shade
// get odr qty;
function get_odr_qty_pershade($DBH,$sono,$sortno){
    $tab=$sono."_odrQty";
    $w="select Code from $tab where Shade='$sortno'";
    $stm=$DBH->prepare($w);
    try {
        $stm->execute();
        $d=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $d['Code']='NA';
    }
    return $d['Code'];
}

function get_sono_wip_status_inwds($DBH,$dept,$sono,$sortno,$washno){
    //get pcs available for transfer from cutting to sewing
    if($washno==0){
        $aq='';
    }else{
        $aq=" and stock='$washno' ";
    }
    
    $q="select * from `Q__$dept` where sono='$sono' and sortno='$sortno' $aq and (status='INWARDS')";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data[]=$r;
        }
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }

    //var_export($data);
    //echo '<hr>';
    //$head_line="<table><tr><td>SO NO<td>SIZE</td><td>AVAILABLE PCS</td><td>Transfer Pc</td>";
    //echo $head_line;
    //cut pcs per size3 $name[size]=pcs;
    $name=0;
    foreach ($data as $d){
        $cut= json_decode($d['sizpcs'],true);
        //var_export($cut);
        //echo '<hr>';
        foreach ($cut as $sz => $value) {
            $name+=$value;
        }
        
        
    }
    return $name;
    //var_export($name);
    //echo '<hr>';
}

function get_sono_wip_status_outwds($DBH,$dept,$sono,$sortno,$washno){
    //get pcs available for transfer from cutting to sewing
    if($washno==0){
        $aq='';
    }else{
        $aq=" and stock='$washno' ";
    }
    
    $q="select * from `Q__$dept` where sono='$sono' and sortno='$sortno' $aq and (status='OUTWARDS' or status='OUTWARDS-P')";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
            $data2[]=$r;
        }
        
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    //var_export($data2);
    //echo '<hr>';
    $name2=0;
    foreach ($data2 as $d){
        $cut2= json_decode($d['sizpcs'],true);
        //var_export($cut);
        //echo '<hr>';
        foreach ($cut2 as $sz => $value) {
            $name2+=$value;
        }
        
        
    }
    return $name2;
}
// get all shades of artno
function get_artno_shades_n_sz($DBH,$artno){
    $df=['XS','S','M','L','XL','XXL','XXXL','2XL','3XL','4XL'];
    $q="select distinct shade from `Q__artno__sz` where artno='$artno'";
    //echo $q;
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
      
            while ($result = $stm->fetch(PDO::FETCH_ASSOC)) {
                $data['shade'][] = $result['shade'];
            }
            //print_r($so);
       
    } catch (PDOException $e) {
        echo $e->getMessage();
        $data['shade']=null;
    }
    // get sz
    $q2="select distinct sz from `Q__artno__sz` where artno='$artno'";
    $stm=$DBH->prepare($q2);
    try {
        $stm->execute();
      
            while ($result2 = $stm->fetch(PDO::FETCH_ASSOC)) {
                $d2[] = $result2['sz'];
            }
            if(in_array('S',$d2)){
                $data['sz']=array_intersect($df,$d2);// this is to arrange the order 's','m','l',etc
            }else{
                $data['sz']=$d2;
            }
            
            //print_r($data['sz']);
       
    } catch (PDOException $e) {
        echo $e->getMessage();
        $data['sz']=null;
    }
    //print_r($data);
    return $data;
}

// show so list on receiveing the challan
function get_so($DBH,$tab,$challan){
    $q="select sono from `$tab` where challan='$challan'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $sono=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $sono['sono']='NA';
    }
    return $sono['sono'];
}
// get cat code from Q__artno__sz
function get_cat($DBH,$artno){
    $q="select catagory from `Q__artno` where artno='$artno'";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        $cat=$stm->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
    }
    return $cat['catagory'];

}

// new function for the offer module in central retail
// get series
function get_gen_series($DBH,$gen){
    $q="select distinct series from `Q__seriesmrp` where catagory like '$gen%'" ;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['series'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
}
//----------------------------------------------------------------
function get_gen_series_os($DBH,$gen){
    // get catagory
    
      $q="select distinct series from `Q__os__madeups` where cat='MADEUPS'" ;
      $stm=$DBH->prepare($q);
      try {
        $stm->execute();
        while($r=$stm->fetch(PDO::FETCH_ASSOC)){
          $data[]=$r['series'];
        }
      } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $data[]='NA';
      }  
    
      return $data;
}
?>

