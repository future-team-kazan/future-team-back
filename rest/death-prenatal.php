<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");


$yeararray = array();
for ($i=1990;$i<=2014;$i++) {
    $yeararray[]=$i;
}

$reg_array = array('ru-cl','ru-sa','ru-2509','ru-kg','ru-st','ru-tt','ru-bl');

$error='';

//Собираем данные для Графика
$data = array();
$regions = array();

$regions = CStatistic::getuniqreg();

$datasets = array();

foreach ($regions as $region) {
    $isP = CStatistic::getPSByRID($region);
    if(!$isP) continue;
    if(!in_array($region,$reg_array)) continue;
    $data = CStatistic::getDeath($region);
if(count($data)<25) continue;

     $rname=CStatistic::getNameByRID($region);

    $datasets[]=array(
        "label"=>$rname,
        "data"=>$data
    );
}

$data=array(
    "labels"=>$yeararray,
    "datasets"=> $datasets
);

if(strlen($error)==0){
    echo json_encode($data);
}else{
    echo json_encode(array('error' => $error));

}
?>

