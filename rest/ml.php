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
$yeararray = array(1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010);


//Собираем данные для Графика
$data = array();
foreach ($yeararray as  $year){
    $data[] = array(
        "year" => $year,
        "deathrate" => CStatistic::getDDataByYear($year),
        "birthrate" => CStatistic::getBDataByYear($year),
        "perinat.transport" => CStatistic::getDData($year,65),
    );

}


if(strlen($error)==0){
    echo json_encode($data);
}else{
    echo json_encode(array('error' => $error));

}
?>

