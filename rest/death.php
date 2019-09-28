<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");

$yeararray = array(1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014);

$error='';

//Собираем данные для Графика
$data = array();
$regions = array();

$regions = CStatistic::getuniqreg();

$datasets = array();
pr(count($yeararray));
foreach ($regions as $region) {

    $data = CStatistic::getDeath($region);
if(count($data)<25) continue;

    $datasets[]=array(
        "label"=>$region,
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

