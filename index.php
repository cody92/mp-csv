<?php
error_reporting(-1);
ini_set('display_errors', 1);
use League\Csv\Reader;

require 'vendor/autoload.php';
date_default_timezone_set("Europe/Bucharest");
$inputCsv = Reader::createFromPath('data/fabrica_catina_nou.csv');
$inputCsv->setDelimiter(',');
$inputCsv->setEncodingFrom("iso-8859-15");

$data = $inputCsv->query();

$arrayData = array();
$maxDepth = 1;
foreach ($data as $line_index => $row) {
    if ($line_index > 0 && count($row)) {
//        print_r($row);
        addData($row);

    }
}

print_r($arrayData);

function parseActivity($activityWBS)
{
    return explode('.', $activityWBS);
}

function addData($rowInfo)
{
    global $arrayData;
    global $maxDepth;
    $activityInfo = parseActivity($rowInfo[4]);
    switch (count($activityInfo)) {
        case 1:
            $arrayData[$activityInfo[0]]["name"] = $rowInfo[1];
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]]["end"] = $endDate->format("d.m.Y");
            break;

        case 2:
            $arrayData[$activityInfo[0]][$activityInfo[1]]["name"] = $rowInfo[1];
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 2 ? 2 : $maxDepth;
            break;
        case 3:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["name"] = $rowInfo[1];
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 3 ? 3 : $maxDepth;
            break;
        case 4:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["name"] = $rowInfo[1];
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 4 ? 4 : $maxDepth;
            break;
        case 5:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["name"] = $rowInfo[1];
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 5 ? 5 : $maxDepth;
            break;
    }
}