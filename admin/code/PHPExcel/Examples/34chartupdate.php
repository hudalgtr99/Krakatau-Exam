<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');


/** PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

if (!file_exists("33chartcreate-bar.xlsx")) {
	exit("Please run 33chartcreate-bar.php first." . EOL);
}

echo date('H:i:s') , " Load from Excel2007 file" , EOL;
$objReader = PHPExcel_IOFactory::createReader("Excel2007");
$objReader->setIncludeCharts(TRUE);
$objPHPExcel = $objReader->load("33chartcreate-bar.xlsx");


echo date('H:i:s') , " Update cell data values that are displayed in the chart" , EOL;
$objWorksheet = $objPHPExcel->getActiveSheet();
$objWorksheet->fromArray(
	array(
		array(50-12,   50-15,		50-21),
		array(50-56,   50-73,		50-86),
		array(50-52,   50-61,		50-69),
		array(50-30,   50-32,		50),
	),
	NULL,
	'B2'
);

// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->setIncludeCharts(TRUE);
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;
