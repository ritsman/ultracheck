<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------

$artno=$_POST['artno'];
$cat_code=get_cat($DBH,$artno);


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

$cat_code=get_cat($DBH,$artno);
$cat=$cat_reverse[$cat_code];
$data['code']=$cat_code;
$data['cat']=$cat;
echo json_encode($data);



?>