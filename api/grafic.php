<
$arFilter = Array("IBLOCK_ID" => self::$biblock, "ACTIVE" => "Y","PROPERTY_YEAR"=>$year);
$qrating = CIBlockElement::GetList(Array('ID'=>'ASC'), $arFilter, false, Array(), Array());

while ($fld = $qrating->GetNextElement()) {

$props = $fld->GetProperties();

$res[] = array(
$props['RID']['VALUE'],
$props['BPOK']['VALUE'],
);