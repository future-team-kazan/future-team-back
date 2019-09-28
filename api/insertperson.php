<?php 
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Headers: X-Requested-With, Content-type');
?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");


$error='';
?>



<?
require($_SERVER["DOCUMENT_ROOT"]."/api/tools.php");  

//http://iminister.site/api/insertperson.php?fio=Иванов Иван Иванович&price=200&age=3

$fio = $_REQUEST['fio'];//$tid - год
$price = $_REQUEST['price'];// доход
$age = $_REQUEST['age'];// расход



if($fio == ''){//check if user id is
    $error = 'Error! fio is empty!';
    echo json_encode(array('error' => $error));
    die();
}

if($price == ''){//check if user id is
    $error = 'Error! price is empty!';
    echo json_encode(array('error' => $error));
    die();
}

if($age == ''){//check if user id is
    $error = 'Error! age is empty!';
    echo json_encode(array('error' => $error));
    die();
} 

$dbid = CPersonal::insertInformation($fio,$price,$age);//insert data

if($dbid>0){ //throw exeption if there is no prescribe treatment for UID
    $success = 'Person is successfully add!';
    echo json_encode(array('success' => $success,'pid'=>$dbid));
}else{
    $error='Error while adding person! '.$activitytid->LAST_ERROR;
    echo json_encode(array('error' => $error));
}
?>