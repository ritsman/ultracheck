<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
echo 'R_addInventory';
$dataM2=json_decode($_POST['holder1'],true);
unset($dataM2['goahead']);
var_export($dataM2);
echo '<hr>';
$rack=$_POST['holder2'];
$location="CENTRAL";


$qw="create table if not exists `Q__stk__$location` (";
$qw.=" `id` int primary key AUTO_INCREMENT not null,";
$qw.=" `sono2` varchar(255) not null default '0',";
$qw.=" `artno` varchar(255) not null default '0',";
$qw.=" `sz` varchar(255) not null default '0',";
$qw.=" `shade` varchar(255) not null default '0',";
$qw.=" `szcm` varchar(255) not null default '0',";
$qw.=" `pkd` varchar(255) not null default '0',";
$qw.=" `barcode`bigint not null default 0,";
$qw.=" `inseam` varchar(255) not null default '0',";
$qw.=" `cat` varchar(255) not null default '0',";
$qw.=" `series` varchar(255) not null default '0',";
$qw.=" `tname` varchar(255) not null default '0',";
$qw.=" `qty` varchar(255) not null default '0',";
$qw.=" `location` varchar(255) not null default '0',";
$qw.=" `mrp` varchar(255) not null default '0',";
$qw.=" `status` varchar(255) not null default 'START',";
$qw.=" `created` timestamp not null default CURRENT_TIMESTAMP,";
$qw.=" unique key(barcode))";

$stm=$DBH->prepare($qw);
try {
    
    $stm->execute();
} catch (PDOException $th) {
    //throw $th;
    echo $th->getMessage();
}
$DBH->beginTransaction();

// insert data into new table
foreach($dataM2 as $kx){
    $dataM=$kx['bc'];
    $tname=$kx['id'];

$ret_data=[];
//$tname=intval(substr($dataM,1,5))."_stk";
//echo $tname;

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

$ret_data['location']=$rack;

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



var_export($ret_data);
echo '<hr>';

// insert into inventory table;
    $q="insert ignore into Q__stk__$location";
    $q.="(`sono2`,`artno`,`sz`,`shade`,`szcm`,`pkd`,`barcode`,`inseam`,`cat`,`series`,`tname`,`qty`,`location`,`mrp`)";
    $q.="values(:sono2,:artno,:sz,:shade,:szcm,:pkd,:barcode,:inseam,:cat,:series,:tname,:qty,:location,:mrp)";

    $stm=$DBH->prepare($q);
    try {
        $stm->execute($ret_data);
        
    } catch (PDOException $th) {
        //throw $th;
        echo $th->getMessage();
        $msg.="1@";
    }
    // update the story of barcode in tname
    $dtd2=new DateTime();
    $dtd=$dtd2->format("Y-m-d");
    $story="@CENTRAL-$dtd";
    $tb=$ret_data['tname'];
    $w="update `$tb` set story='$story' where barcode=".$ret_data['barcode'];
    $stm=$DBH->prepare($w);
    try {
        
        $stm->execute();
    } catch (PDOException $th) {
        //throw $th;
        $msg.="2@";
    }

}
echo $msg;
echo '<br>';
$kk=strpos($msg,"@");
$msg2="";
if($kk===false){
        $DBH->commit();
        $msg2="<img src=\"../img88/rt.png\"/>";
        
}else{
               $DBH->rollBack();
        $msg2="##ERROR:DATA NOT CAPTURED";
}
echo $msg2;

?>
<script>
    <link rel="stylesheet" href="../jquery-ui-1.11.4.custom/jquery-ui.css"/>
</script>
    <script src="../JQ/jquery-1.12.0.js"></script>
    <script src="../jquery-ui-1.11.4.custom/jquery-ui.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        var msg=<?php print json_encode($msg2);?>;
        
        parent.$("#response").html(msg);
        
        
        
    });
   
  </script>


