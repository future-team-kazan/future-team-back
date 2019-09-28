<?php
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
 
require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");  


$error='';

$year = $_REQUEST['year'];// get user id

if($year == ''){//check if user id is
    $error = 'Error! Year is empty!';
    echo json_encode(array('error' => $error));
    die();
}
$data = TempDataBase::getDataByYear($year);//get  prescribe acrivity  by treatment id

if(strlen($error)==0){
    print(json_encode($data));
}else{
    echo json_encode(array('error' => $error));
}
?>