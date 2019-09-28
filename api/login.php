<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");  

global $USER;

extract($_REQUEST);
if($login=='') $login = "test@test.ru";
if($password=='') $password = "123123";

if (!is_object($USER)) $USER = new CUser;

$arAuthResult = $USER->Login($login, $password, "Y");

$APPLICATION->arAuthResult = $arAuthResult;

pa($arAuthResult);
pa($_COOKIE);