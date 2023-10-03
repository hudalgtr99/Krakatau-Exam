<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';


if (!file_exists("05featuredemo.xlsx")) {
	exit("Please run 05featuredemo.php first." . EOL);
}

$inputFileName = "05featuredemo.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$sheetList = $objReader->listWorksheetNames($inputFileName);
$sheetInfo = $objReader->listWorksheetInfo($inputFileName);

echo 'File Type:', PHP_EOL;
var_dump($inputFileType);

echo 'Worksheet Names:', PHP_EOL;
var_dump($sheetList);

echo 'Worksheet Names:', PHP_EOL;
var_dump($sheetInfo);

