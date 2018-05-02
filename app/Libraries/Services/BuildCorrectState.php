<?php
namespace App\Libraries\Services;
use App\Models\BailConfiguration;


class BuildCorrectState
{

	public function getStateArray($bailMasterState)
    {
    	$non_us_state_string = '';
    	$bailConf = BailConfiguration::GetStateIdByAbv($bailMasterState);

    	if (!isset($bailConf->bc_id)) {
    		$bailConf = BailConfiguration::GetStateIdByAbv('OTHER');
    		$non_us_state_string = $bailMasterState;
    	}

      	return [
      			  'us_state_id'         => $bailConf->bc_id,
      			  'non_us_state_string' => $non_us_state_string
      		   ];
    }

}