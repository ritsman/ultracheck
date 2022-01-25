<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$dataM=$_POST['data'];
//var_dump($dataM);
$ret_data=[];
$tname=intval(substr($dataM,1,5))."_stk";
//echo $tname;
// check if the barcode is already in inventory of central;;;

    $q="select * from `Q__stk__CENTRAL` where barcode='$dataM'";
    
    $stm=$DBH->prepare($q);
    try {
        $stm->execute();
        if($stm->rowCount()>0){
            $reject_data['barcode']='';
            $reject_data['sono2']="<span style=\"color:red;\">BARCODE: $dataM ALREADY IN CENTRAL WAREHOUSE!</span>";
            $reject_data=json_encode($reject_data);
            echo $reject_data;
            return false;
        }
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $msg.="1@";
    }



// check if the barcode exists

$q2="select * from $tname where barcode='$dataM'";
$stm=$DBH->prepare($q2);
try {
    
    $stm->execute();
    if($stm->rowCount()>0){
        $bar_data=$stm->fetch(PDO::FETCH_ASSOC);
    }else{
        $bar_data=null;
        
    }
} catch (PDOException $th) {
    //throw $th;
    //echo $th->getMessage();
}
// get barmain data
$q="select * from `Q__artno__sz` where `tname`='$tname'";
$stm=$DBH->prepare($q);
try {
    $stm->execute();
    $data=$stm->fetch(PDO::FETCH_ASSOC);
    
} catch (PDOException $th) {
    echo $th->getMessage();
}
if(is_null($bar_data)){
    $ret_data['barcode']='';
    $ret_data['sono2']="NO BARCODE FOUND";
    //echo 'NONO';
}else{
    //var_export($bar_data);
    //echo '<hr>';

    //var_export($data);
    //echo '<hr>';


$series1=[
    'A'=>'ANTHAM',
    'B'=>'BERLIN',
    'C'=>'CAIRO',
    'D'=>'DURBAN',
    'E'=>'EPIC',
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
    

];
$series2=[
    
    'A'=>'ALEXA',
    'B'=>'BELLY',
    'C'=>'CHAMU',
    'D'=>'DIVA',
    'E'=>'ERA',
    'F'=>'FURRY',
    'G'=>'GAMA',
    'H'=>'HEXA',
    'P'=>'PLAZZO',
    'I'=>'IKIA',
    'J'=>'JAZZ'

];

$men_cat=[
    'A'=>"MEN'S JEANS",
    'B'=>"MEN'S JEANS",
    'C'=>"MEN'S JEANS",
    'D'=>"MEN'S JEANS",
    'E'=>"MEN'S JEANS",
    'U'=>"MEN'S JEANS",
    'H'=>"MEN'S SHIRT",
    'I'=>"MEN'S SHIRT",
    'J'=>"MEN'S SHIRT",
    'K'=>"MEN'S SHIRT",
    'L'=>"MEN'S SHIRT",
    'M'=>"MEN'S T-SHIRT",
    'O'=>"MEN'S T-SHIRT",
    'P'=>"MEN'S T-SHIRT",
    'Q'=>"MEN'S T-SHIRT",
    'V'=>"MEN'S SHORTS",
    'W'=>"MEN'S SHORTS",
    'N'=>"MEN'S SHORTS",
   
];
$women_cat=[
    'A'=>"WOMEN'S JEANS",
    'B'=>"WOMEN'S JEANS",
    'C'=>"WOMEN'S JEANS",
    'D'=>"WOMEN'S JEANS",
    'E'=>"WOMEN'S KURTI DRESS",
    'F'=>"WOMEN'S KURTI DRESS",
    'G'=>"WOMEN'S KURTI DRESS",
    'H'=>"WOMEN'S KURTI DRESS",
    'P'=>"WOMEN'S PLAZO",
    'I'=>"WOMEN'S SHORTS",
    'J'=>"WOMEN'S SHORTS",

];
//var_export($data);
//echo '<hr>';
//return false;
// fill the blanks
if($data['artno'][1]==='M'){
    $sseries=$series1;
    $cat=$men_cat;
}else{
    $sseries=$series2;
    $cat=$women_cat;
}
//var_export($sseries);
//echo '<hr>';
//echo $data['artno'][2];
//echo $cat['A'];

$ret_data['sono2']=$data['sono2'];
$ret_data['artno']=$data['artno'];
$ret_data['sz']=$data['sz'];
$ret_data['shade']=$data['shade'];
$ret_data['szcm']=$bar_data['szcm'];
$ret_data['pkd']=$bar_data['pkd'];
$ret_data['barcode']=$bar_data['barcode'];
$ret_data['inseam']=$bar_data['inseam'];
$ret_data['cat']=$cat[$data['artno'][2]];
$ret_data['series']=$sseries[$data['artno'][2]];
$ret_data['tname']=$tname;
$ret_data['qty']=1;

$ret_data['location']='CENTRAL';

// Get mrp

$q5="select mrp from Q__seriesmrp where series ='".$ret_data['series']."'";
$stm=$DBH->prepare($q5);
try {
    
    $stm->execute();
    $mrp=$stm->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$ret_data['mrp']=$mrp['mrp'];

}


$ret_data=json_encode($ret_data);
echo $ret_data;
return false;


?>