<?php

/** Error reporting */
error_reporting(E_ALL);

if (PHP_SAPI != 'cli') {
	die ('This script executes all tests, and should only be run from the command line');
}

// List of tests
$aTests = array(
	  '01simple.php'
	, '01simplePCLZip.php'
	, '02types.php'
	, '02types-xls.php'
	, '03formulas.php'
	, '04printing.php'
	, '05featuredemo.php'
	, '06largescale.php'
	, '06largescale-with-cellcaching.php'
	, '06largescale-with-cellcaching-sqlite.php'
	, '06largescale-with-cellcaching-sqlite3.php'
	, '06largescale-xls.php'
	, '07reader.php'
	, '07readerPCLZip.php'
	, '08conditionalformatting.php'
	, '08conditionalformatting2.php'
	, '09pagebreaks.php'
	, '10autofilter.php'
	, '10autofilter-selection-1.php'
	, '10autofilter-selection-2.php'
	, '10autofilter-selection-display.php'
	, '11documentsecurity.php'
	, '11documentsecurity-xls.php'
	, '12cellProtection.php'
	, '13calculation.php'
    , '13calculationCyclicFormulae.php'
	, '14excel5.php'
	, '15datavalidation.php'
	, '15datavalidation-xls.php'
	, '16csv.php'
	, '17html.php'
	, '18extendedcalculation.php'
	, '19namedrange.php'
	, '20readexcel5.php'
	, '21pdf.php'
	, '22heavilyformatted.php'
	, '23sharedstyles.php'
	, '24readfilter.php'
	, '25inmemoryimage.php'
	, '26utf8.php'
	, '27imagesexcel5.php'
	, '28iterator.php'
	, '29advancedvaluebinder.php'
	, '30template.php'
	, '31docproperties_write.php'
	, '31docproperties_write-xls.php'
	, '32chartreadwrite.php'
	, '33chartcreate-area.php'
	, '33chartcreate-bar.php'
	, '33chartcreate-bar-stacked.php'
	, '33chartcreate-column.php'
	, '33chartcreate-column-2.php'
	, '33chartcreate-line.php'
	, '33chartcreate-pie.php'
	, '33chartcreate-radar.php'
	, '33chartcreate-stock.php'
	, '33chartcreate-multiple-charts.php'
	, '33chartcreate-composite.php'
	, '34chartupdate.php'
	, '35chartrender.php'
	, '36chartreadwriteHTML.php'
	, '36chartreadwritePDF.php'
	, '37page_layout_view.php'
	, '38cloneWorksheet.php'
    , '39dropdown.php'
	, '40duplicateStyle.php'
	, '41password.php'
	, '42richText.php'
    , '43mergeWorkbooks.php'
    , '44worksheetInfo.php'
	, 'OOCalcReader.php'
	, 'OOCalcReaderPCLZip.php'
	, 'SylkReader.php'
	, 'Excel2003XMLReader.php'
	, 'XMLReader.php'
	, 'GnumericReader.php'
);

// First, clear all previous run results
foreach ($aTests as $sTest) {
	@unlink( str_replace('.php', '.xls', 	$sTest) );
	@unlink( str_replace('.php', '.xlsx', 	$sTest) );
	@unlink( str_replace('.php', '.csv',	$sTest) );
	@unlink( str_replace('.php', '.htm',	$sTest) );
	@unlink( str_replace('.php', '.pdf',	$sTest) );
}

// Run all tests
foreach ($aTests as $sTest) {
	echo '============== TEST ==============' . "\r\n";
	echo 'Test name: ' . $sTest . "\r\n";
	echo "\r\n";
	echo shell_exec('php ' . $sTest);
	echo "\r\n";
	echo "\r\n";
}