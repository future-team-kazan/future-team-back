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


class CStatistic
{
    private static $ciblock = 57;//ID инфоблока Статистики
    private static $diblock = 59;//ID инфоблока Статистики
    private static $biblock = 60;//ID инфоблока Рождаемость



    public function getDDataByYear($year)
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$diblock, "ACTIVE" => "Y","PROPERTY_YEAR"=>$year);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {
             ;
            $props = $fld->GetProperties();

            $res[] = array(
                 $props['RID']['VALUE'],
                $props['DPOK']['VALUE'],
            );

        }
        return $res;
    }

    public function getPrenatalDate( )
    {


        $arFilter = Array("IBLOCK_ID" => 57, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());


        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();
pr($props);die();

            $arFilter2 = Array("IBLOCK_ID" => 58, "ACTIVE" => "Y","PROPERTY_MAPNAME"=>  $props['RID']['VALUE']);
            $qrating2 = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter2, false, Array(), Array());

            $f=0;
            if ($fld = $qrating2->GetNextElement()) {
                $f=1;
            }

            $res[] = array(
                $props['RID']['VALUE'],
                $f,
            );

        }
        return $res;
    }
    function getNameByRID($rid){


        $arFilter2 = Array("IBLOCK_ID" => 58, "ACTIVE" => "Y","PROPERTY_MAPNAME"=>  $rid);
        $qrating2 = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter2, false, Array(), Array());

        if ($fld2 = $qrating2->GetNextElement()) {


            $fields2 = $fld2->GetFields();

        }
        return $fields2['NAME'];
    }

    function getPSByRID($rid){


        $arFilter2 = Array("IBLOCK_ID" => 58, "ACTIVE" => "Y","PROPERTY_MAPNAME"=>  $rid);
        $qrating2 = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter2, false, Array(), Array());

        if ($fld2 = $qrating2->GetNextElement()) {


            $fields2 = $fld2->GetFields();

            $arFilter = Array("IBLOCK_ID" => 57, "ACTIVE" => "Y","PROPERTY_REGION"=>   $fields2['ID']);
            $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());
            $res = false;
            if ($fld = $qrating->GetNextElement()) {
                $res = true;
            }

        }
        return $res;
    }

    public function getBDataByYear($year)
    {
         

        $arFilter = Array("IBLOCK_ID" => self::$biblock, "ACTIVE" => "Y","PROPERTY_YEAR"=>$year);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();

            $res[] = array(
                $props['RID']['VALUE'],
                $props['BPOK']['VALUE'],
            );

        }
        return $res;
    }

    public function getDeath($region)
    {
        $arFilter = Array("IBLOCK_ID" => self::$diblock,  "PROPERTY_RID"=>$region);
        $qrating = CIBlockElement::GetList(Array('property_YEAR'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();

            $res[] = $props['DPOK']['VALUE'];


        }
        return $res;
    }

    public function getPStatus($region)
    {
        $arFilter = Array("IBLOCK_ID" => self::$diblock,  "PROPERTY_RID"=>$region);
        $qrating = CIBlockElement::GetList(Array('property_YEAR'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();

            $res[] = $props['DPOK']['VALUE'];


        }
        return $res;
    }

    public function getuniqreg()
    {
        $arFilter = Array("IBLOCK_ID" => self::$diblock, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {
            $props = $fld->GetProperties();
            $res[] = $props['RID']['VALUE'];
        }

        return array_unique($res);
    }


    public function getDData($year,$ibid)
    {

        pr($year);

        $arFilter = Array("IBLOCK_ID" => $ibid, "PROPERTY_YEAR"=>$year);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();

            $res[] = array(
                $props['RID']['VALUE'],
                $props['VALUE']['VALUE'],

            );

        }
        return $res;
    }


    public function getPTDataByYear($year)
    {
        $arFilter = Array("IBLOCK_ID" => 65, "PROPERTY_YEAR"=>$year);
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {

            $props = $fld->GetProperties();

            $res[] = array(
                $props['RID']['VALUE'],
                $props['VALUE']['VALUE'],
            );

        }
        return $res;
    }

    public function getCentersData()
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$ciblock, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {
            $fields = $fld->GetFields();
            $props = $fld->GetProperties();
            $region = getElementByID();
            $res[] = array(
                'region'=>$props['RID']['VALUE'],

            );

        }
        return $res;
    }

    public function getGrDataForRegions()
    {
        global $USER;

        $arFilter = Array("IBLOCK_ID" => self::$giblock, "ACTIVE" => "Y");
        $qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

        while ($fld = $qrating->GetNextElement()) {
            $fields = $fld->GetFields();
            $props = $fld->GetProperties();
            $region = getElementByID();
            $res[] = array(
                'region'=>$props['RID']['VALUE'],

            );

        }
        return $res;
    }



}