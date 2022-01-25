<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$artnoM=json_decode($_POST['data'],true);
unset($artnoM['goahead']);

//var_export($artnoM);
//echo '<hr>';


/*
* make new article no;;
*/

$article_master['brand']=[
    'FLIVEZ'=>'F',
    'MADOO'=>'M'
];
$article_master['gender']=[
    'W'=>'W',
    'M'=>'M',
    'B'=>'B',
    'G'=>'G',
    'L'=>'L',
    'K'=>'K',
    'A'=>'A'
];
$article_master['catagory']=[
    'A1'=>'A1',
    'A2'=>'A2',
    'A3'=>'A3',
    'A4'=>'A4',
    'A5'=>'A5',
    'A6'=>'A6',
    'A7'=>'A7',
    'A8'=>'A8',
    'A9'=>'A9',
    'B1'=>'B1',
    'B2'=>'B2',
    'B3'=>'B3',
    'B4'=>'B4',
    'B5'=>'B5',
    'B6'=>'B6',
    'C1'=>'C1',
    'C2'=>'C2',
    'C3'=>'C3',
    'C4'=>'C4',
    'D1'=>'D1',
    'D2'=>'D2',
    'D3'=>'D3',
    'D4'=>'D4',
    'E1'=>'E1',
    'E2'=>'E2',
    'E3'=>'E3',
    'E4'=>'E4',
    'E5'=>'E5',
    'F1'=>'F1',
    'F2'=>'F2',
    'F3'=>'F3',
    'F4'=>'F4',
    'F5'=>'F5',
    'G1'=>'G1'
    
];
$article_master['series']=[
    'ANTHAM'=>'A',
    'BERLIN'=>'B',
    'CAIRO'=>'C',
    'DURBAN'=>'D',
    'EPIC'=>'E',
    'FLY'=>'F',
    'UBER'=>'U',
    'HOST'=>'H',
    'INOX'=>'I',
    'JOR'=>'J',
    'KEVIN'=>'K',
    'LUCAS'=>'L',
    'MOON'=>'M',
    'OPUS'=>'O',
    'PLUS'=>'P',
    'QUARK'=>'Q',
    'VOLT'=>'V',
    'WINE'=>'W',
    'NENO'=>'N',
    'TRACK'=>'T',
    'ZOOM'=>'Z',
    'ALEXA'=>'A',
    'BELLY'=>'B',
    'CHAMU'=>'C',
    'DIVA'=>'D',
    'ERA'=>'E',
    'UBER F'=>'U',
    'FURRY'=>'F',
    'GAMA'=>'G',
    'HEXA'=>'H',
    'PLAZZO'=>'P',
    'IKIA'=>'I',
    'JAZZ'=>'J',
    'LOWER'=>'L',
    'KENVA'=>'K',
    'RIVA'=>'R',
    'MEVA'=>'M',
    'NOVA'=>'N',
    'MOON JUNIOR'=>'M',
    'OPUS JUNIOR'=>'O',
    'PLUS JUNIOR'=>'P',
    'QUARK JUNIOR'=>'Q',
    'KENVA JUNIOR'=>'K',
    'RIVA JUNIOR'=>'R',
    'MEVA JUNIOR'=>'M',
    'NOVA JUNIOR'=>'N',
    'KENVA KIDS'=>'K',
    'RIVA KIDS'=>'R',
    'MEVA KIDS'=>'M',
    'NOVA KIDS'=>'N',
    'MOON KIDS'=>'M',
    'OPUS KIDS'=>'O',
    'PLUS KIDS'=>'P',
    'QUARK KIDS'=>'Q',
    'APRON'=>'A',
    'BAGS'=>'B',
    'ALEXA KIDS'=>'A',
    'BELLY KIDS'=>'B',
    'CHAMU KIDS'=>'C',
    'GAMA KIDS'=>'G',
    'IKIA KIDS'=>'I',
    'ANTHAM JUNIOR'=>'A',
    'BERLIN JUNIOR'=>'B',
    'CAIRO JUNIOR'=>'C',
    'DURBAN JUNIOR'=>'D',
    'EPIC JUNIOR'=>'E',
    'JOR JUNIOR'=>'J',
    'ANTHAM KIDS'=>'A',
    'BERLIN KIDS'=>'B',
    'CAIRO KIDS'=>'C',
    'DURBAN KIDS'=>'D',
    'EPIC KIDS'=>'E',
    'ORRA'=>'O',
    'PEARL'=>'P',
    'QUEEN'=>'Q',
    'VOLT JUNIOR'=>'V',
    'WINE JUNIOR'=>'W',
    'JAZZ KIDS'=>'J',
    'JOR KIDS'=>'J',
    'ERA KIDS'=>'E',
    'VOLT KIDS'=>'V',
    'WINE KIDS'=>'W',
    'ALEXA JUNIOR'=>'A',
    'BELLY JUNIOR'=>'B',
    'CHAMU JUNIOR'=>'C',
    'DIVA JUNIOR'=>'D',
    'ERA JUNIOR'=>'E',
    'IKIA JUNIOR'=>'I',
    'SKY'=>'S',
    'ERA JUNIOR'=>'E'

    

];



$article_master['fab']=[
    'A-COTTON KNIT'=>'A',
    'B-POLY KNIT'=>'B',
    'C-3/1 RING'=>'C',
    'D-3/1 OE'=>'D',
    'E-3/1 POLY'=>'E',
    'F-SATIN'=>'F',
    'G-3/1 SATIN'=>'G',
    'H-DOBBY'=>'H',
    'I-2/1'=>'I',
    'J-SHIRTING PRINT'=>'J',
    'K-SHIRTING PLAIN'=>'K',
    'L-SHIRTING CHECKS'=>'L',
    'M-RIGID'=>'M',
    'N-CORDUROY'=>'N'
];

$article_master['wash']=[
        '1-RAW ONLY'=>'01',
        '2-RAW RESIN'=>'02',
        '3-RAW RESIN 3D'=>'03',
        '4-RAW TOWEL'=>'04',
        '5-RAW TINT'=>'05',
        '6-RAW + MANUAL DRY PROCESS'=>'06',
        '7-RAW RESIN+ MANUAL DRY PROCESS'=>'07',
        '8-RAW RESIN 3D + MANUAL DRY PROCESS'=>'08',
        '9-RAW TOWEL + MANUAL DRY PROCESS'=>'09',
        '10-RAW TINT+ MANUAL DRY PROCESS'=>'10',
        '11-RAW + LASER DRY PROCESS'=>'11',
        '12-RAW RESIN+ LASER DRY PROCESS'=>'12',
        '13-RAW RESIN 3D + LASER DRY PROCESS'=>'13',
        '14-RAW TOWEL +LASERL DRY PROCESS'=>'14',
        '15-RAW TINT+ LASER DRY PROCESS'=>'15',
        '16-ENZYME ONLY'=>'16',
        '17-ENZYME + MANUAL DRY PROCESS'=>'17',
        '18-ENZYME + LASER DRY PROCESS'=>'18',
        '19-ENZYME + TINT + LASER DRY PROCESS'=>'19',
        '20-ENZYME + TINT + MANUAL DRY PROCESS'=>'20',
        '21-ENZYME + TOWEL + LASER DRY PROCESS'=>'21',
        '22-ENZYME + TOWEL + MANUAL DRY PROCESS'=>'22',
        '23-ENZYME + BLEACH WASH ONLY'=>'23',
        '24-ENZYME + BLEACH + MANUAL DRY PROCESS'=>'24',
        '25-ENZYME + BLEACH + LASER DRY PROCESS'=>'25',
        '26-ENZYME + BLEACH +TOWEL + LASER DRY PROCESS'=>'26',
        '27-ENZYME + BLEACH +TOWEL + MANUAL DRY PROCESS'=>'27',
        '28-ENZYME + BLEACH +TINT + TOWEL + LASER DRY PROCESS'=>'28',
        '29-ENZYME + BLEACH +TINT + TOWEL + MANUAL DRY PROCESS'=>'29',
        '30-BLEACH WASH ONLY'=>'30',
        '31-BLEACH + MANUAL DRY PROCESS'=>'31',
        '32-BLEACH + LASER DRY PROCESS'=>'32',
        '33-BLEACH + TOWEL + LASER DRY PROCESS'=>'33',
        '34-BLEACH + TOWEL + MANUAL DRY PROCESS'=>'34',
        '35-BLEACH + TINT + LASER DRY PROCESS'=>'35',
        '36-BLEACH + TINT + MANUAL DRY PROCESS'=>'36',
        '37-OD-BLACK'=>'37',
        '38-OD-KHAKI'=>'38',
        '39-ENZYME +TINT + TOWEL + MANUAL DRY PROCESS'=>'39',
        '40-ENZYME +TINT + TOWEL + LASER DRY PROCESS'=>'40',
        '41-ENXYME + BLEACH +TINT + TOWEL + MANUAL DRY PROCESS'=>'41',
        '42-ENXYME + BLEACH +TINT + TOWEL + LASER DRY PROCESS'=>'42',
        '43-RAW + TOWEL +TINT + MANUAL DRY PROCESS'=>'43',
        '44-RAW + TOWEL +TINT + LASER DRY PROCESS'=>'44',
        '45-RAW + RESIN +TINT + MANUAL DRY PROCESS'=>'45',
        '46-OD GRAY'=>'46',
        '47-OD PISTA GREEN'=>'47',
        '48-OD RAMA'=>'48',
        '49-OD GREEN'=>'49',
        '50-OD BROWN'=>'50',
        '51-SOFTENER'=>'51',
        '52-OD MILITARY OLIVE + DRY PROCESS'=>'52'
];


$article_master['fit']=[
    'SLIM'=>'S',
    'COMFORT'=>'C',
    'REGULAR'=>'R'
];


$subquery="`artno`,";
foreach($artnoM as $artno2){
    foreach($artno2 as $key=>$val){
        $artno[$key]=$val;
        $subquery.=" `$key`,";
        $subquery2.=" ?,";
        $values[]=$val;

        
    }
};
//var_export($article_master);

//echo '<hr>';

//echo '----------------';
//echo $article_master['fab']['F-SATIN'];
//echo '------------';
foreach($artno as $key=>$value){
    //echo $key."--".$value."<br>";
    if($key=='sono'){
        $article_no[]=$value;
    }else if($key!='catagory'){
        $article_no[]=$article_master[$key][$value];
    }
    
}
//echo 'ART:---';
//var_export($article_no);
$art_no=trim(implode('',$article_no));
echo $art_no;
//




$query="create table if not exists `Q__artno`(";
$query.="`id` int primary key AUTO_INCREMENT,";
$query.="`artno` varchar(150) unique key,";
foreach($artno as $key=>$value){
    $query.="`$key` varchar(120) not null default '0',";
}
$query=rtrim($query,",").")";
$subquery=rtrim($subquery,",");
$subquery2=rtrim($subquery2,",");
//echo $query;

$stm=$DBH->prepare($query);
try {
    $stm->execute();
    //echo 'done';
    
} catch (PDOException $th) {
    echo "<br>ERROR:".$th->getMessage();
}
// now insert the data
$q="insert ignore into `Q__artno`( $subquery ) values('$art_no',$subquery2)";
$stm=$DBH->prepare($q);
try {
    $stm->execute($values);
} catch (PDOException $th) {
    //throw $th;
    echo "<br>ERROR:".$th->getMessage();
}

?>