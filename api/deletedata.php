<?
$delimiter = ';';

$csv = file_get_contents($_SERVER["DOCUMENT_ROOT"]."/upload/kill.csv");
$rows = explode(PHP_EOL, $csv);
$data = [];

foreach ($rows as $row)
{
$data[] = explode($delimiter, $row);
}

print_r($data);