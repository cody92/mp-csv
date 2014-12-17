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

//print_r($arrayData);
//die();
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
            $arrayData[$activityInfo[0]]["total"] = 0;
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]]["end"] = $endDate->format("d.m.Y");
            break;

        case 2:
            $arrayData[$activityInfo[0]][$activityInfo[1]]["name"] = $rowInfo[1];
            $arrayData[$activityInfo[0]][$activityInfo[1]]["total"] = 0;
            $arrayData[$activityInfo[0]]["total"]++;
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 2 ? 2 : $maxDepth;
            break;
        case 3:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["name"] = $rowInfo[1];
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["total"] = 0;
            $arrayData[$activityInfo[0]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]]["total"]++;
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 3 ? 3 : $maxDepth;
            break;
        case 4:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["name"] = $rowInfo[1];
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["total"] = 0;
            $arrayData[$activityInfo[0]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["total"]++;
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 4 ? 4 : $maxDepth;
            break;
        case 5:
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["name"] = $rowInfo[1];
            $arrayData[$activityInfo[0]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]]["total"]++;
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]]["total"]++;
            $startDate = new DateTime($rowInfo[2]);
            $endDate = new DateTime($rowInfo[3]);
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["start"] = $startDate->format("d.m.Y");
            $arrayData[$activityInfo[0]][$activityInfo[1]][$activityInfo[2]][$activityInfo[3]][$activityInfo[4]]["end"] = $endDate->format("d.m.Y");
            $maxDepth = $maxDepth < 5 ? 5 : $maxDepth;
            break;
    }
}

function displayRow($row, $depth, $number = 0)
{
    global $arrayData;
    printf("<tr>");
    if ($depth == 1) {
        printf("<td>%d</td>", $number);
        printf("<td>%s</td>", $row['name']);

    } else {
        printf(
            "<td>&nbsp;</td><td>&nbsp;</td>"
        );
    }
    if ($depth == 2) {
        printf("<td>%s</td>", $number . '. ' . $row['name']);
    } else {
        printf("<td>&nbsp;</td>");
    }

    if ($depth == 3) {
        printf("<td>%s</td>", $number . '. ' . $row['name']);
    } else {
        printf("<td>&nbsp;</td>");
    }

    if ($depth == 4) {
        printf("<td>%s</td>", $number . '. ' . $row['name']);
    } else {
        printf("<td>&nbsp;</td>");
    }

    if ($depth == 5) {
        printf("<td>%s</td>", $number . '. ' . $row['name']);
    } else {
        printf("<td>&nbsp;</td>");
    }


    printf("<td>%s</td><td>%s</td></tr>", $row['start'], $row['end']);
    $childs = count($row) - 4;
    if ($childs > 0) {
        for ($iterator = 1; $iterator <= $childs; $iterator++) {
            if (is_array($row)) {
                displayRow($row[$iterator], $depth + 1, $iterator);
            }

        }
    }

}


require_once 'template.php';