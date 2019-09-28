<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");



$input = file_get_contents('php://input');
$_POST = json_decode($input, true);
//$_POST=$_POST[0];

$error='';
$yeararray = array(2001);


//Собираем данные для Графика
$data = array();

    $data  = array(
        "year" => '2019',
        "deathrate" => CStatistic::getPrenatalDate($year),

    );



if(strlen($error)==0){
    echo json_encode($data);
}else{
    echo json_encode(array('error' => $error));

}
?>

