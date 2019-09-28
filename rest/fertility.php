<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");


$arFilter = Array("IBLOCK_ID" => 57, "ACTIVE" => "Y");
$qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

while ($fld = $qrating->GetNextElement()) {

    $props = $fld->GetProperties();




        $arFilter2 = Array("IBLOCK_ID" => 58, "ACTIVE" => "Y","ID"=>  $props['REGION']['VALUE']);
        $qrating2 = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter2, false, Array(), Array());

        while ($fld2 = $qrating2->GetNextElement()) {

            $fields2 = $fld2->GetFields();
            $props22 = $fld2->GetProperties();

            pa($props22['MAPNAME']['VALUE'] .'='.$fields2['NAME']);
        }
}


if(strlen($error)==0){
    echo json_encode($data);
}else{
    echo json_encode(array('error' => $error));

}
?>

