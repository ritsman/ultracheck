<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=json_decode($_POST['data'],true);
unset($dataM['goahead']);

//var_export($dataM);
//echo '<hr>';

//return false;

foreach($dataM as $data2){
    foreach($data2 as $k=>$v){
        $keys[]=$k;
        $values[]=$v;
        $subquery.=" `$k`,";
        $subquery2.=" ?,";
        $data[$k]=$v;
    }
}



//var_export($keys);
//echo '<hr>';
//var_export($values);
//echo '<hr>';
//var_export($data);
//echo '<hr>';

$query="create table if not exists `Q__artno__sz`(";
$query.="`id` int primary key AUTO_INCREMENT,";

foreach($keys as $key){
    $query.="`$key` varchar(120) not null default '0',";
}
$query.="`tname` varchar(255) not null default '0',";
$query.=" CONSTRAINT artszsh UNIQUE(artno,sz,shade));";
$subquery=rtrim($subquery,",");
$subquery2=rtrim($subquery2,",");
//echo $query;

$stm=$DBH->prepare($query);
try {
    $stm->execute();
    //echo 'done';
    
} catch (PDOException $th) {
    echo "<br>ERROR 1:".$th->getMessage();
    echo $query;
}
// check if the artno-sz combo exists

$q3="select tname from `Q__artno__sz` where artno='$data[artno]' and sz='$data[sz]' and shade='$data[shade]'";
$stm=$DBH->prepare($q3);
try {
    $stm->execute();
    $tname2=$stm->fetch(PDO::FETCH_ASSOC);
    $tname=$tname2['tname'];
    
} catch (PDOException $th) {
    //throw $th;
    echo "<br>ERROR 2:".$th->getMessage();

}


if(is_null($tname)){
    
    // now insert the data
    $q="insert ignore into `Q__artno__sz`( $subquery) values($subquery2)";
    $stm=$DBH->prepare($q);
    try {
        $stm->execute($values);
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>ERROR 3:".$th->getMessage();
    }

    // get id

    $q3="select id from `Q__artno__sz` where artno='$data[artno]' and sz='$data[sz]' and shade='$data[shade]'";
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
    $q6="update `Q__artno__sz` set tname='$tname' where artno='$data[artno]' and sz='$data[sz]' and shade='$data[shade]'";
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
$pkdm=$data['pkdmonth'].substr($data['pkd'],2);
// insert into it the required copies
$co=intval($data['copies']);
for($i=0;$i<$co;$i++){
    $q="insert into $tname (barcode,szcm,inseam,pkd,story) values('$bc_start','$data[szcm]','$data[inseam]','$pkdm','PRINT')";
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
$q8="select copies from `Q__artno__sz` where artno='$data[artno]' and sz='$data[sz]' and shade='$data[shade]'";
    $stm=$DBH->prepare($q8);
    try {
        $stm->execute();
        $copy2=$stm->fetch(PDO::FETCH_ASSOC);
        $copy=$copy2['copies'];
        
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>ERROR 11:".$th->getMessage();

    }
    $copy33=intval($copy)+intval($data['copies']);

    // update copies
    $q8b="update `Q__artno__sz` set copies='$copy33' where artno='$data[artno]' and sz='$data[sz]' and shade='$data[shade]'";
    $stm=$DBH->prepare($q8b);
    try {
        $stm->execute();
       
        
    } catch (PDOException $th) {
        //throw $th;
        echo "<br>ERROR 7:".$th->getMessage();

    }

$fit=[
    'S'=>'SLIM',
    'C'=>'COMFORT',
    'R'=>'REGULAR'
];

$series1=[
    'A'=>'ANTHAM',
    'B'=>'BERLIN',
    'C'=>'CAIRO',
    'D'=>'DURBAN',
    'E'=>'EPIC',
    'F'=>'FLY',
    'U'=>'UBER',
    'H'=>'HOST',
    'I'=>'INOX',
    'J'=> 'JOR',
    'K'=>'KEVIN',
    'L'=>'LUCAS',
    'M'=>'MOON',
    'O'=>'OPUS',
    'P'=>'PLUS',
    'Q'=>'QUARK',
    'V'=>'VOLT',
    'W'=>'WINE',
    'N'=>'NENO',
    'T'=>'TRACK',
    'Z'=>'ZOOM'
    

];
$series2=[
    
    'A'=>'ALEXA',
    'B'=>'BELLY',
    'C'=>'CHAMU',
    'D'=>'DIVA',
    'E'=>'ERA',
    'U'=>'UBER F',
    'F'=>'FURRY',
    'G'=>'GAMA',
    'H'=>'HEXA',
    'P'=>'PLAZZO',
    'I'=>'IKIA',
    'J'=>'JAZZ',
    'L'=>'LOWER',
    'K'=>'KENVA',
    'R'=>'RIVA',
    'M'=>'MEVA',
    'N'=>'NOVA',
    'O'=>'ORRA',
    'P'=>'PEARL',
    'Q'=>'QUEEN',
    'S'=>'SKY'

];

$series_boys=[
    'M'=>'MOON JUNIOR',
    'O'=>'OPUS JUNIOR',
    'P'=>'PLUS JUNIOR',
    'Q'=>'QUARK JUNIOR',
    'A'=>'ANTHAM JUNIOR',
    'B'=>'BERLIN JUNIOR',
    'C'=>'CAIRO JUNIOR',
    'D'=>'DURBAN JUNIOR',
    'E'=>'EPIC JUNIOR',
    'J'=>'JOR JUNIOR',
    'V'=>'VOLT JUNIOR',
    'W'=>'WINE JUNIOR',
    'N'=>'NENO JUNIOR',
    'T'=>'TRACK JUNIOR',
    'Z'=>'ZOOM JUNIOR'
];
$series_girls=[
    'K'=>'KENVA JUNIOR',
    'R'=>'RIVA JUNIOR',
    'M'=>'MEVA JUNIOR',
    'N'=>'NOVA JUNIOR',
    'A'=>'ALEXA JUNIOR',
    'B'=>'BELLY JUNIOR',
    'C'=>'CHAMU JUNIOR',
    'D'=>'DIVA JUNIOR',
    'I'=>'IKIA JUNIOR',
    'E'=>'ERA JUNIOR',
];
$series_little=[
    'K'=>'KENVA KIDS',
    'R'=>'RIVA KIDS',
    'M'=>'MEVA KIDS',
    'N'=>'NOVA KIDS',
    'A'=>'ALEXA KIDS',
    'B'=>'BELLY KIDS',
    'C'=>'CHAMU KIDS',
    'D'=>'DIVA KIDS',
    'G'=>'GAMA KIDS',
    'J'=>'JAZZ KIDS',
    'E'=>'ERA KIDS',
    'I'=>'IKIA KIDS',
    'J'=>'JAZZ KIDS'
];
$series_kids=[
    'M'=>'MOON KIDS',
    'O'=>'OPUS KIDS',
    'P'=>'PLUS KIDS',
    'Q'=>'QUARK KIDS',
    'A'=>'ANTHAM KIDS',
    'B'=>'BERLIN KIDS',
    'C'=>'CAIRO KIDS',
    'D'=>'DURBAN KIDS',
    'E'=>'EPIC KIDS',
    'J'=>'JOR KIDS',
    'V'=>'VOLT KIDS',
    'W'=>'WINE KIDS',
    'N'=>'NENO KIDS',
    'T'=>'TRACK KIDS',
    'Z'=>'ZOOM KIDS'
];
$series_acc=[
    'A'=>'APRON',
    'B'=>'BAGS'
];
if($data['artno'][1]==='M'){
    $sseries=$series1;
}else if($data['artno'][1]==='W'){
    $sseries=$series2;
}else if($data['artno'][1]==='B'){
    $sseries=$series_boys;
}else if($data['artno'][1]==='G'){
    $sseries=$series_girls;
}else if($data['artno'][1]==='L'){
    $sseries=$series_little;
}else if($data['artno'][1]==='K'){
    $sseries=$series_kids;
}else if($data['artno'][1]==='A'){
    $sseries=$series_acc;
}

// Get mrp

$q5="select mrp from Q__seriesmrp where series ='".$sseries[$data['artno'][2]]."'";
$stm=$DBH->prepare($q5);
try {
    
    $stm->execute();
    $mrp=$stm->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}

// get return data information to display in barcode table in centeral.php
$q5="select * from $tname where barcode > $bcentry";
$stm=$DBH->prepare($q5);
try {
    $stm->execute();
    while($r=$stm->fetch(PDO::FETCH_ASSOC)){
        $ret_data[$r['barcode']]=[
            'artno'=>$data['artno'],
            'sz'=>$data['sz'],
            'szcm'=>$r['szcm'],
            'inseam'=>$r['inseam'],
            'color'=>$data['shade'],
            'qty'=>1,
            'pkd'=>$pkdm,
            'series'=>$sseries[$data['artno'][2]],
            'mrp'=>$mrp['mrp'],
            'fit'=>$fit[$data['artno'][6]]
            
        ];
    }
    
} catch (PDOException $th) {
    //throw $th;
    echo "<br>ERROR 10:".$th->getMessage();
}



//var_export($ret_data);

$ret_data=json_encode($ret_data);
echo $ret_data;
?>