<?php

namespace App\Libraries;

class ExcelHelper
{
	public function CreateHeader(&$sheet, array $optionData)
	{
		$columnStart    = $optionData['Column']['start'];
		$currentColumn  = $columnStart;
		$rowStart       = $optionData['Row']['start'];
		$titles         = $optionData['Values'];
		$startingColumn = 'B';
        $startingRow    = 2;

        foreach ($titles as $key => $currentTitle) {
            $sheet->setCellValue($currentColumn . $rowStart, $currentTitle);
            $sheet->getColumnDimension($currentColumn)->setAutoSize(true);
            $currentColumn++;
        }
        $cellRange = "{$columnStart}{$rowStart}:{$currentColumn}{$rowStart}";

        if (!isset($optionData['Bold'])) {
        	$optionData['Bold'] = false;
        }

        if (!isset($optionData['Font_Size'])) {
        	$optionData['Font_Size'] = 11;
        }

        $sheet->getStyle($cellRange)->getFont()->setBold($optionData['Bold']);
        $sheet->getStyle($cellRange)->getFont()->setSize($optionData['Font_Size']);
	}

	public function CreateBody(&$sheet, array $optionData)
	{
		$columnStart   = $optionData['Column']['start'];
		$currentColumn = $columnStart;
		$rowStart      = $optionData['Row']['start'];
		$values        = $optionData['Values'];

        foreach ($values as $key => $currentValue) {
        	$currentColumn = $columnStart;
        	if (!is_array($currentValue)) {
        		continue;
        	}
        	foreach ($currentValue as $dummyKey => $cellValue) {
            	$sheet->setCellValue($currentColumn . $rowStart, $cellValue);
            	$sheet->getColumnDimension($currentColumn)->setAutoSize(true);

        	    $currentColumn++;
        	}
        	$cellRange = "{$columnStart}{$rowStart}:{$currentColumn}{$rowStart}";
 			if (!isset($optionData['Bold'])) {
        		$optionData['Bold'] = false;
        	}

        	if (!isset($optionData['Font_Size'])) {
        		$optionData['Font_Size'] = 11;
        	}

        	$sheet->getStyle($cellRange)->getFont()->setBold($optionData['Bold']);
       	 	$sheet->getStyle($cellRange)->getFont()->setSize($optionData['Font_Size']);
            $rowStart++;
        }
	}
}