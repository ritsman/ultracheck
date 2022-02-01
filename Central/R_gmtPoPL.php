<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include '../inc/itemclass.inc.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//========================================================================
echo 'R_gmtPoPL.php';
$so=$_POST['sono'];
$poMain2=json_decode($_POST['holderMain2'],true);
unset($poMain2['goahead']);
var_export($poMain2);
echo '<hr>';

foreach ($poMain2 as $valarr){
    foreach ($valarr as $key=>$val){
        $poMain[$key]=$val;
    }
}

print_r($poMain);
echo '<hr/>';
$longmsg="";
/*
       **********************generate new purchase order number 
*/
$newpono=get_new_pono($DBH,'gmtpo');
$pono="GPO/".$newpono;
echo $newpono;
//echo '<hr>';
//return false;
echo $so;
$rcdfiles=array();
$rcdfiles=$_FILES['fabFile'];
$imp=$_POST['holderImpno'];
$msg="";
$go1='no';
$go='no';
$gonext='no';
$gonext2='no';
$maker=$_SESSION['usr'];
echo '<tt><pre>'. var_export($rcdfiles,true).'</pre></tt>';
$go1=check_frmt($rcdfiles['name']);
function check_frmt($filename){
    $msg="";
    $ext=pathinfo($filename,PATHINFO_EXTENSION);
    //echo $ext;
    if($ext!=='csv'){
        $msg="INCORRECT FORMAT<br>ONLY 'CSV' FILES ACCEPTED";
    }else{
        $msg='yes';
    }
    return $msg;
}
echo "GO1:".$go1;
echo '<hr>';
//===================================================generate move file in directory===================
//==================give new file name
function change_file_name($filename){
    //echo basename($filename);
    //echo '<hr>';
    $newname='';
    $ft='';
    $i=0;
    $ext=pathinfo($filename,PATHINFO_EXTENSION);
    $f=pathinfo($filename)['filename'];
    echo "F(Rcd File):".$f;
    $y=0;
    if(file_exists("../outSourcePL/$filename")){
        
        echo '<br>INHERE ';
        $t=pathinfo($filename)['filename'];
        $k= strpos($t,"__");
        if($k){
         $r=explode("__",$t);
         $ft=$r[0];
         $i=intval($r[1]);
        }else{
            $ft=$t;
            $i=0;
        }
        ++$i;
        echo "I".$i;
        $newname=$ft."__$i".".".$ext;
        //$fg="$ft__$i".$ext;
        echo "<br>newname:".$newname."<br>";
        $y++;
        change_file_name($newname);
        
        
    }else{
        echo "<br>LOOP OUT:";
        $newname=pathinfo($filename)['filename'].".".pathinfo($filename)['extension'];
        //$newname=$ft."__$i".".".$ext;
        echo $newname;
        echo '<br><br>LOOP NO:'.$y;
       
    }
    echo "return:".$newname;
    return $newname;
}

echo "<br>OLD NAME:".$rcdfiles['name']."<br>";
$f=change_file_name($rcdfiles['name']);
echo "<br>NEW NAME:".$f;
echo '<hr>';

$directory="outSourcePL";
$error=$rcdfiles['error'];
// var_export(pathinfo($rcdfiles['name']));
//$ext= pathinfo($rcdfiles['name'])[extension];
// var_export($ext);

if(($error===0)&&($go1==='yes')){
    
    echo "MOVING FILE";
    
    
        $k=move_uploaded_file($rcdfiles['tmp_name'],"../outSourcePL/$f");
            chmod("../outSourcePL/$f",0777);
            var_dump($k);
            if($k){
                echo 'done';
                $go='yes';
                $msg.="CAS";
            }else{
                $msg.= "<br>#ERROR:$f :THIS FILE NAME ALREADY EXISTS";
                $msg.="@<br>";

            }
    
           

}else{
    echo '<br>NOT MOVING';
    $msg.= "<br>#ERROR: FILE NOT UPLOADED CORRECTLY IN SERVER!";
    $msg.="@<br>";
    
    
}
echo "GO:".$go;
echo "MSG:".$msg;

if($go==='yes'){
##############################
//$DBH->beginTransaction();
##############################
                    $q="insert into B_file_import_os (filename,sono,maker) values(:dir,:sono,:maker)";
                    echo $q;
                    $stm=$DBH->prepare($q);
                    
                    $stm->bindParam(':dir',$f);
                    
                    $stm->bindParam(':sono',$so);
                    $stm->bindParam(':maker',$maker);
                    try {
                        $stm->execute();
                        echo 'doine_file_import_table';
                        $gonext='yes';
                        
                    } catch (PDOException $exc) {
                        $msg.="<br>1.".$exc->getMessage();
                        $msg.="@TT<br>";
                        echo $msg;
                    }

                   
                   
    
}


// create table for madeups
$Qsortno="Q__os__madeups";
$query="create table if not exists `$Qsortno`(";
$query.="`id` int primary key AUTO_INCREMENT,";
$query.="`pono` varchar(255) not null default '0',";
$query.="`brand` varchar(255) not null default '0',";
$query.="`cat` varchar(255) not null default '0',";
$query.="`subcat` varchar(255) not null default '0',";
$query.="`series` varchar(255) not null default '0',";

$query.="`sz` varchar(255) not null default '0',";
$query.="`pillow` varchar(255) not null default '0',";
$query.="`tc` varchar(255) not null default '0',";
$query.="`fabric` varchar(255) not null default '0',";
$query.="`rate` varchar(255) not null default '0',";
$query.="`qty` varchar(255) not null default '0',";
$query.="`amt` varchar(255) not null default '0',";
$query.="`dtd` date not null default '2121-01-01',";
$query.="`mrp` varchar(255) not null default '0',";
$query.="`artno` varchar(255) not null default '0')";

          


$stm=$DBH->prepare($query);
try {
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo "OO:<br>".$th->getMessage();
    echo "<br>".$query;
}


// enter the values
$totalqty22=0;
// insert into Q--sortno
$msg44="";
$dtd2=new DateTime();
$dtd=$dtd2->format("Y-m-d");
echo "DATE:".$dtd;
echo "GONEXT:".$gonext;

//get the madeup catagory
$cat_series_val=[
    "QUEEN BED SHEET"=>'Q',
    "KING BED SHEET"=>'K',
    "SINGLE BED SHEET"=>'S',
    "TOWEL"=>'T',
    "NAPKIN"=>'N',
    "HANDKERCHIEF"=>'H'
    
   
    
    
    
   
];



if($gonext==='yes'){
    $flt="../outSourcePL/$f";
    if( ! $fh = fopen($flt, 'r') ) {
        $msg.="<br>#ERROR:Could not open $flt for reading.<br>";
    }else{
        fgetcsv($fh,10000,",");//up the counter once to get rid of headers...
        echo "<br>going indatabase now<br>";
        //$q="insert into `B_fab_pl` values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";//correct the number of ??//
        $q="insert into `$Qsortno`(id,pono,brand,cat,subcat,series,sz,pillow,tc,fabric,rate,qty,amt,dtd,mrp,artno)";
        $q.="values(null,'$pono',?,?,?,?,?,?,?,?,?,?,?,'$dtd',?,?)";
        echo "<br>$q<br>";
        $stm=$DBH->prepare($q);
        try {
            
            //fgetcsv($fh,10000,",");
            //fgetcsv($fh,10000,",");
            while($params= fgetcsv($fh)){
                var_export($params);
                echo '<hr>';//
                $params[12]=substr($params[0],0,1).substr($params[1],2,1).$cat_series_val[strtoupper($params[2])].substr($params[3],0,2).'OS'.$newpono;
                $totalqty22=$totalqty22+$params[9];
                $totalamt=$totalamt+$params[10];
                $stm->execute($params);
                $gonext2='yes';
            }

        } catch (PDOException $exc) {
            echo $exc->getMessage();

            $msg.="<br>2.".$exc->getMessage();
            $msg.="@TT";
            $msg44.="1@";
        }
        fclose($fh);
        $fh = fopen($flt, 'r');
       
        // insert into Q__artno
        // now insert the data
        $q="insert ignore into `Q__artno`(artno,brand,gender,catagory,series,fab,wash,fit,sono ) ";
        $q.="values(?,?,?,?,?,?,?,?,?)";
        echo $q;
        $stm=$DBH->prepare($q);
        try {
            fgetcsv($fh,10000,",");//up the counter once to get rid of headers...
            while($param= fgetcsv($fh)){
                var_export($param);
                echo '<hr>';
                $d[0]=substr($param[0],0,1).substr($param[1],2,1).$cat_series_val[strtoupper($param[2])].substr($param[3],0,2).'OS'.$newpono;
                $d[1]=$param[0];
                $d[2]=$param[1];
                $d[3]=$cat_series_val[strtoupper($param[2])];
                $d[4]=$param[3];
                $d[5]=$param[7];
                $d[6]='NA';
                $d[7]='REGULAR';
                $d[8]=$pono;
               
                var_export($d);
                echo '<hr>';
                $stm->execute($d);
                $gonext2='yes';
                echo $q;
            }
        } catch (PDOException $th) {
            //throw $th;
            echo "<br>ERROR1:".$th->getMessage();
        }
        // get into q_artno_sz
        
        fclose($fh);
        $fh = fopen($flt, 'r');
        fgetcsv($fh,10000,",");//up the counter once to get rid of headers...
        //================================
        echo 'START OF ARTNO_SZ';
        echo '<hr>';
        // check if the artno-sz combo exists
        while($param= fgetcsv($fh)){
            var_export($param);
            echo '<hr>';
            $newdata2[0]=substr($param[0],0,1).substr($param[1],2,1).$cat_series_val[strtoupper($param[2])].substr($param[3],0,2).'OS'.$newpono;
            $newdata2[1]=$param[0];
            $newdata2[2]=$param[1];
            $newdata2[3]=$cat_series_val[strtoupper($param[2])];
            $newdata2[4]=$param[3];
            $newdata2[5]=$param[7];
            $newdata2[6]='NA';
            $newdata2[7]='REGULAR';
            $newdata2[8]=$pono;
            $newdata2[9]=$param[4];//enter size here to use in artno_sz;
            $newdata2[10]=$param[9];//qty per artno-sz
            var_export($newdata2);
            echo '<hr>';
            $q3 ="select tname from `Q__artno__sz` where artno='".$newdata2[0]."'";
            $q3.=" and sz='".$newdata2[9]."' and shade='".$newdata2[2]."'";
            $stm=$DBH->prepare($q3);
            try {
                $stm->execute();
                $tname2=$stm->fetch(PDO::FETCH_ASSOC);
                $tname=$tname2['tname'];
                
            } catch (PDOException $th) {
                //throw $th;
                echo "<br>ERROR 2:".$th->getMessage();

            }

            $pkd=Date('Y');
            $pkdmonth=Date('M');

            if(is_null($tname)){
                
                // now insert the data
                $q="insert ignore into `Q__artno__sz`( sono2,artno,sz,shade,pkd,pkdmonth,copies) ";
                $q.="values('$pono','$newdata2[0]','$newdata2[9]','MADEUPS','$pkd','$pkdmonth','$newdata2[10]')";
                $stm=$DBH->prepare($q);
                try {
                    $stm->execute($values);
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 3:".$th->getMessage();
                }

                // get id

                $q3="select id from `Q__artno__sz` where artno='$newdata2[0]' and sz='$newdata2[9]' and shade='MADEUPS'";
                $stm=$DBH->prepare($q3);
                try {
                    $stm->execute();
                    $id2=$stm->fetch(PDO::FETCH_ASSOC);
                    $id=$id2['id'];
                    
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 4:".$th->getMessage();

                }

                $tname=$id."_stk";

                // get prefix for barcode
                $bc='1'.get_bc_prefix($id).$id;
                
                $start_barcode=$bc.'000000';
                
                $sbc=intval($start_barcode);
                // create new inventory table for this
                //echo 'SBC:';
                //var_dump($sbc);
                //echo '<hr>';
                $query2="create table if not exists `$tname`(";
                $query2.="`id` int primary key AUTO_INCREMENT,";
                $query2.="`barcode` bigint not null default $sbc,";
                $query2.="`szcm` varchar(120) not null default '0',";
                $query2.="`inseam` varchar(120) not null default '0',";
                $query2.="`pkd` varchar(120) not null default '0',";
                $query2.="`status` varchar(120) not null default 'ACTIVE',";
                $query2.="`created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,";
                $query2.="`story` varchar(255) not null default 'PRINT',";
                
                $query2.=" UNIQUE KEY(barcode));";
            

                $stm=$DBH->prepare($query2);
                try {
                    $stm->execute();
                    //echo 'done';
                    
                } catch (PDOException $th) {
                    echo "<br>ERROR 5:".$th->getMessage();
                }
                // insert the default value at the beginning of the table

                $q7="insert into $tname (barcode,status,story) values('$sbc','BEGIN','0')";
                $stm=$DBH->prepare($q7);
                try {
                    $stm->execute();
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 6:".$th->getMessage();
                }
                // update tname
                $q6="update `Q__artno__sz` set tname='$tname' where artno='$newdata2[0]' and sz='$newdata2[9]' and shade='MADEUPS'";
                $stm=$DBH->prepare($q6);
                try {
                    $stm->execute();
                
                    
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 7:".$th->getMessage();

                }


            }

            //var_dump($tname);
            //echo '<hr>';

            // get the last barcode for this combo
            $q4="select max(barcode) as maxbc from $tname";
            $stm=$DBH->prepare($q4);
            try {
                
                $stm->execute();
                $bc_start2=$stm->fetch(PDO::FETCH_ASSOC);
                $bc_start=$bc_start2['maxbc'];
            } catch (PDOException $th) {
                //throw $th;
                echo "<br>ERROR 8:".$th->getMessage();
            }
            //entry pt reg for return data
            $bcentry=$bc_start;
            // increase for new entry
            $bc_start++;
            // get pkd 
            $pkdm22=$pkdmonth.Date('y');
            // insert into it the required copies
            $co=$newdata2[10];
            for($i=0;$i<$co;$i++){
                $q="insert into $tname (barcode,szcm,inseam,pkd,story) values('$bc_start','$newdata2[9]','0','$pkdm22','PRINT')";
                $stm=$DBH->prepare($q);
                try {
                    $stm->execute();
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 9:".$th->getMessage();
                }
                $bc_start++;
                

            }
            // update the no of copies or total count of barcode in Q__artno__sz
            $q8="select copies from `Q__artno__sz` where artno='$newdata2[0]' and sz='$newdata2[9]' and shade='MADEUPS'";
                $stm=$DBH->prepare($q8);
                try {
                    $stm->execute();
                    $copy2=$stm->fetch(PDO::FETCH_ASSOC);
                    $copy=$copy2['copies'];
                    
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 11:".$th->getMessage();

                }
                $copy33=intval($copy)+intval($newdata2[10]);

                // update copies
                $q8b="update `Q__artno__sz` set copies='$copy33' where artno='$newdata2[0]' and sz='$newdata2[9]' and shade='MADEUPS'";
                $stm=$DBH->prepare($q8b);
                try {
                    $stm->execute();
                
                    
                } catch (PDOException $th) {
                    //throw $th;
                    echo "<br>ERROR 7:".$th->getMessage();

                }
            }

        //=================================
    }
    
    

    
}
echo "TTQ:".$totalqty22;
echo "TAMT:".$totalamt;


return false;
// enter the main fab details
$oldstock=get_FABRIC_stock($poMain['sortno'],$DBH);
$stock=$oldstock+$totalqty;
$status2="INWARDS";
 $q2="insert into `Q__fabric_stock`(fabno,sortno,challan,qty,status,stock,dtd,pklist,hsn,pono,supp,rate,unit)";
 $q2.="values(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m)";
 $stm = $DBH->prepare($q2);
   
    $stm->bindParam(':a', $poMain['fabname']);
    $stm->bindParam(':b', $poMain['sortno']);
    $stm->bindParam(':c', $ponew);
    $stm->bindParam(':d', $totalqty22);
    $stm->bindParam(':e', $status2);
    $stm->bindParam(':f', $stock);
    $stm->bindParam(':g', $poMain['t_dt']);
    $stm->bindParam(':h', $poMain['pklist']);
    $stm->bindParam(':i', $poMain['hsn']);
    $stm->bindParam(':j', $poMain['pono']);
    $stm->bindParam(':k', $poMain['supp2']);
    $stm->bindParam(':l', $poMain['rate']);
    $stm->bindParam(':m', $poMain['unit']);
    try {
        $stm->execute();
    
} catch (PDOException $exc) {
    echo $exc->getMessage();
    $msg.="4@";
    $longmsg.=$exc->getMessage();
}

//===============================================up pono
up_pono('fabinw',$newpono,$DBH);

//=========================================================================



echo "<br>msg:".$msg44."==========";



$kk=strpos($msg44,"@");
$msg2="";
if($kk===false){
        $DBH->commit();
        $msg2="<img src=\"../img88/rt.png\"/>";
        
}else{
        
    $sr22=strpos($msg,'CAS');
        if($sr22!==false){
         echo "<br>KKKK<br>______________________________"; 
         unlink("../fabPL/$f");
        }

    $msg2="<br>##ERROR:DATA NOT CAPTURED";
    $msg2.="<br>$msg<br>";
    $sr23=strpos($msg,'TT');
        if($sr23!==false){
         echo "<br>ROLLBACK<br>______________________________"; 
         $DBH->rollBack();
        }
    
        //check to delete file
        

        
}
echo "MSG2:".$msg2;


                    
?>
<!DOCTYPE html>
<head><title>::New Sales Order::</title>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css">
    <script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function(){
            var msg=<?php print json_encode($msg2);?>;
            console.log(msg);
            parent.$("#respo").html(msg)
            
            });
    </script>
