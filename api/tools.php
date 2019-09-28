<?
CModule::IncludeModule("iblock");
 


function pr($item, $show_for = false)
{
    global $USER;
    if ($USER->IsAdmin() || $show_for == 'all') {
        if (!$item) echo ' <br />empty <br />'; elseif (is_array($item) && empty($item)) echo '<br />array is ampty  <br />';
        else echo ' <pre>' . print_r($item, true) . ' </pre>';
    }
}


function pa($item, $show_for = false)
{
    if (!$item)
        echo ' <br />empty <br />';
    elseif (is_array($item) && empty($item))
        echo '<br />array is ampty  <br />';
    else
        echo ' <pre>' . print_r($item, true) . ' </pre>';

}


class TempDataBase
{
    private static $tiblock = 22;//temp data
 
 
	 
     public function getAllData()
    {
        $arFilter = Array("IBLOCK_ID" => self::$tiblock, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('property_YEAR'=>'ASC'), $arFilter, false, Array(), Array());
        
        $lables=array();
        $income=array();
        $outcome=array();
        
		while ($fld = $qrating->GetNextElement()) {
         	$fields = $fld->GetFields();
            $props = $fld->GetProperties();
            $lables[] = $props['YEAR']['VALUE'];
            $income[] = $props['INCOME']['VALUE'];
            $outcome[] = $props['OUTCOME']['VALUE'];
        }
		$res=array('labels'=>$lables,
					'dataset'=>array(
						array(
							'label'=>'income',
							'data'=>$income,
						),
						array(
							'label'=>'outcome',
							'data'=>$outcome,
						)
					)					
					);
        return $res;
    }
	
     public function getDataByYear($year)
    {
        $arFilter = Array("IBLOCK_ID" => self::$tiblock, "ACTIVE" => "Y", "PROPERTY_YEAR" => $year);
        $qrating = CIBlockElement::GetList(Array(), $arFilter, false, Array(), Array());
        $res=array();
        while ($fld = $qrating->GetNextElement()) {
			$fields = $fld->GetFields();
            $props = $fld->GetProperties();
            $res[] = array(
					array('label' => 'Доходы','data' =>$props['INCOME']['VALUE']),
					array('label' => 'Расходы','data' =>$props['OUTCOME']['VALUE'])
				);
        }
        return $res;
    }
		
     public function deleteData($id)
    {
		return CIBlockElement::Delete($id);
    }
	
    public function insertInformation(
        $year, // 
        $income,//  
        $outcome// 
    ) //Добавить новые данные
    {
        $tempdb = new CIBlockElement;
		$name = 'Temp name';
        $arFields = array(
            'IBLOCK_ID' =>  self::$tiblock,
            'ACTIVE' => 'Y',
            'NAME' => $name,
            'PROPERTY_VALUES' => array(
                'INCOME' => $income, //$tid - treatment ID
                'OUTCOME' => $outcome,// Дозировка препарата - строковое значение
                'YEAR' => $year,// начало выполнения лечебного мероприятия например начало курса приема витаминов
            ),
        );

        if($res = $tempdb->Add($arFields)){
            return $res;
        }else{
           //pa(array('error'=>$tempdb->LAST_ERROR));
            echo $tempdb->LAST_ERROR;
        }

    }

}

class CPersonal
{
    private static $piblock = 21;//ID инфоблока Cотрудники
 
 
	 
     public function getAllPersonal()
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$piblock, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

		while ($fld = $qrating->GetNextElement()) {
         	$fields = $fld->GetFields();
            $props = $fld->GetProperties();

            $rsUser = CUser::GetByID($props['USER']);
            $arUser = $rsUser->Fetch();

			$res[] = array(
				'id' => (int)$fields['ID'],
				'fio' => $fields['NAME'],
				//'fio' => $arUser['NAME'].' '.$arUser['SECOND_NAME'].' '.$arUser['LAST_NAME'],
				'price' => (int)$props['PRICE']['VALUE'],
				'age' => (int)$props['AGE']['VALUE'],
			);
         
        }
        return $res;
    }

     public function getPersonById($id)
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$piblock, "ACTIVE" => "Y","ID"=>$id);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

		if ($fld = $qrating->GetNextElement()) {
         	$fields = $fld->GetFields();
            $props = $fld->GetProperties();

            $rsUser = CUser::GetByID($props['USER']);
            $arUser = $rsUser->Fetch();

			$res = array(
				'id' => (int)$fields['ID'],
				'fio' => $arUser['NAME'].' '.$arUser['SECOND_NAME'].' '.$arUser['LAST_NAME'],
				'price' => (int)$props['PRICE']['VALUE'],
				'age' => (int)$props['AGE']['VALUE'],
			);

        }
        return $res;
    }
     public function getPersonByUid($uid)
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$piblock, "ACTIVE" => "Y","PROPERTY_USER"=>$uid);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

		if ($fld = $qrating->GetNextElement()) {
         	$fields = $fld->GetFields();
            $props = $fld->GetProperties();

            $rsUser = CUser::GetByID($props['USER']);
            $arUser = $rsUser->Fetch();

			$res[] = array(
				'id' => (int)$fields['ID'],
				'fio' => $arUser['NAME'].' '.$arUser['SECOND_NAME'].' '.$arUser['LAST_NAME'],
				'price' => (int)$props['PRICE']['VALUE'],
				'age' => (int)$props['AGE']['VALUE'],
			);

        }
        return $res;
    }
	 
     public function deleteData($id)
    {
		return CIBlockElement::Delete($id);
    }
	
    public function insertPerson(
        $fio, // 
        $age,//  
        $price// 
    ) //Добавить новые данные
    {
        $tempdb = new CIBlockElement;
		$name = $fio;
        $arFields = array(
            'IBLOCK_ID' =>  self::$piblock,
            'ACTIVE' => 'Y',
            'NAME' => $name,
            'PROPERTY_VALUES' => array(
                'FIO' => $fio, //$
                'PRICE' => $price,//
                'AGE' => $age,// 
            ),
        ); 
        if($res = $tempdb->Add($arFields)){
            return $res;
        }else{
            return array('error'=>$tempdb->LAST_ERROR);
        }

    }

    public function updatePerson($id,//id элемента, которому обновляем данные
        $fio, //
        $age,//
        $price//
    ) //Добавить новые данные
    {
        global $USER;
        $tempdb = new CIBlockElement;

        $props = array(
            'FIO' => $fio, //$
            'PRICE' => $price,//
            'AGE' => $age,//
        );
		if($fio=='') unset($props['FIO']);
		if($price=='') unset($props['PRICE']);
		if($age=='') unset($props['AGE']);

        $arFields = array(
            'IBLOCK_ID' =>  self::$piblock,
            "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
            'PROPERTY_VALUES' => $props
        );
        if($res = $tempdb->Update($id,$arFields)){
            return $res;
        }else{
            return array('error'=>$tempdb->LAST_ERROR);
        }

    }

}