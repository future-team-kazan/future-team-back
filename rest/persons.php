<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");

/**
    *
    GET http://iminister.site/rest/persons/ - показать все элементы
    GET http://iminister.site/rest/persons/#ID#/   - показать элемент ID
    GET http://iminister.site/rest/persons/#ID#/delete - удалить элемент ID
    POST http://iminister.site/rest/persons/  - добавить элемент новый через json [{"fio":"фамилия имя отчество","age":20,"price":3000}]
    все поля обязательные
    POST http://iminister.site/rest/persons/#ID#/  - изменить элемент новый через json [{"fio":"фамилия имя отчество","age":20,"price":3000}] не все поля обязательные
    *
 **/

$input = file_get_contents('php://input');
$_POST = json_decode($input, true);
//$_POST=$_POST[0];

$error='';
if(empty($_POST)){
    if(empty($_GET)) {//http://iminister.site/rest/persons/
        $data = CPersonal::getAllPersonal();
    }else{
        if(!$_GET['del']){
            $id=(int)$_GET['id'];
            $data = CPersonal::getPersonById($id);
        }else{
            $id=(int)$_GET['id'];
            $data = CPersonal::deleteData($id);
        }
    }
}else{
    if(empty($_GET)) {//http://iminister.site/rest/persons/
        $user=$_POST;
        if(empty($user['fio']))  $error.='укажите ФИО ';
        if(empty($user['age']))  $error.='укажите Возраст ';
        if(empty($user['price']))  $error.='укажите Зарплату ';
        if(strlen($error)==0) {
            $data=CPersonal::insertPerson($user['fio'], $user['age'], $user['price']);
        }
    }else{
        $user=$_POST;
        $id=(int)$_GET['id'];
        if(empty($user['fio'])and(empty($user['age']))and(empty($user['price'])))  $error.='вы не указали никаких параметров. ';
        if(strlen($error)==0) {
            $data=CPersonal::updatePerson($id,$user['fio'], $user['age'], $user['price']);
        }
    }
}

if(strlen($error)==0){
    echo json_encode($data);
}else{
    echo json_encode(array('error' => $error));

}
?>

