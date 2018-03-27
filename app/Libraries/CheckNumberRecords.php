<?php

namespace App\Libraries;

use App\Models\BailConfiguration;
use App\Models\JailImport;
use App\Models\BailMaster;

class CheckNumberRecords
{

	public function validateRecordsBetweenJailAndMaster($checkNumber)
	{
		$checkNumber = (string) $checkNumber;
		$jailImportCheckCount = (int) JailImport::where('j_check_number', '=', $checkNumber)->count();
		$bailMasterCheckCount = (int) BailMaster::where('j_check_number', '=', $checkNumber)->count();
		
		if ($jailImportCheckCount == $bailMasterCheckCount) {
			return false;
		}
		return true;
	}


}