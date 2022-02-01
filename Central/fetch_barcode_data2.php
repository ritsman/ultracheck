<?php
session_start();
include '../inc/dbclass.inc.php';
include '../methods/fun.php';
include 'class_barcode_present.php';
$DBH2=new dbconnect();
$DBH=$DBH2->con('ultrainv');
//-----------------------------------------------
$inventory_table="Q__stk__CENTRAL";
$dataM=$_POST['data'];// the barcode recieved from scanner from addInventory.php
$token=$_POST['token']; //token to check if its outward or inwards
$inventory_table=$_POST['invtab'];

echo "Token:$token;;;invtab:$inventory_table";
return false;

$b=new BarcodeCheck($dataM,$inventory_table);
$ret_data=[];
if($token=='inw'){
    $ret_data=$b->check_barcode();
}else if($token=='outw'){
    $ret_data=$b->check_barcode_out();
}

$ret_data=json_encode($ret_data);
echo $ret_data;


?>