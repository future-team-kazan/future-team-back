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

//http://iminister.site/api/inserdata.php?year=2018&income=200&outcome=321

$year = $_REQUEST['year'];//$tid - год
$income = $_REQUEST['income'];// доход
$outcome = $_REQUEST['outcome'];// расход



if($year == ''){//check if user id is
    $error = 'Error! Year is empty!';
    echo json_encode(array('error' => $error));
    die();
}

if($income == ''){//check if user id is
    $error = 'Error! Income is empty!';
    echo json_encode(array('error' => $error));
    die();
}

if($outcome == ''){//check if user id is
    $error = 'Error! Outcome is empty!';
    echo json_encode(array('error' => $error));
    die();
} 

$dbid = TempDataBase::insertInformation($year,$income,$outcome);//insert data

if($dbid>0){ //throw exeption if there is no prescribe treatment for UID
    $success = 'Data is successfully added!';
    echo json_encode(array('success' => $success,'aid'=>$activitytid));
}else{
    $error='Error while adding data! '.$activitytid->LAST_ERROR;
    echo json_encode(array('error' => $error));
}
?>