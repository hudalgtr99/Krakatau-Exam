<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

date_default_timezone_set('Europe/London');

/** PHPExcel_IOFactory */
require_once dirname(__FILE__) . '/../Classes/PHPExcel/IOFactory.php';



echo date('H:i:s') , " Load from Excel5 template" , EOL;
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("templates/30template.xls");




echo date('H:i:s') , " Add new data to the template" , EOL;
$data = array(array('title'		=> 'Excel for dummies',
					'price'		=> 17.99,
					'quantity'	=> 2
				   ),
			  array('title'		=> 'PHP for dummies',
					'price'		=> 15.99,
					'quantity'	=> 1
				   ),
			  array('title'		=> 'Inside OOP',
					'price'		=> 12.95,
					'quantity'	=> 1
				   )
			 );

$objPHPExcel->getActiveSheet()->setCellValue('D1', PHPExcel_Shared_Date::PHPToExcel(time()));

$baseRow = 5;
foreach($data as $r => $dataRow) {
	$row = $baseRow + $r;
	$objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $r+1)
	                              ->setCellValue('B'.$row, $dataRow['title'])
	                              ->setCellValue('C'.$row, $dataRow['price'])
	                              ->setCellValue('D'.$row, $dataRow['quantity'])
	                              ->setCellValue('E'.$row, '=C'.$row.'*D'.$row);
}
$objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);


echo date('H:i:s') , " Write to Excel5 format" , EOL;
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing file" , EOL;
echo 'File has been created in ' , getcwd() , EOL;
