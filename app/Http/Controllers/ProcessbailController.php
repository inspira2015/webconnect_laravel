<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;


class ProcessbailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indexArray = [
                        'message' => 'Sub Menu',
                      ];


        return view('processbail.index')->with($indexArray);
    }

    /**
     * [ajaxfindbail Ajax Method for autocomplete]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxfindbail(Request $request)
    {
        $termToSearch = $request->get('term','');
        $termType = $request->get('search_term','');
        $resultArray = $this->getResultsFromUserInput($termType, $termToSearch);
        $data = $this->builtSelectResponse($resultArray);
        
        if (count($data)) {
             return $data;
        }
        return ['value'=>'No Result Found','id'=>''];    
    }


    public function searchresults(Request $request)
    {
    	$termType = $request->get('term','');
        $termToSearch = $request->get('search_term','');
        $resultArray = $this->getTermFromUserInput($termToSearch);
		$bailMaster = BailMaster::find($resultArray['m_id']);
        $courtList = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $balance = $bailMaster->m_receipt_amount - (
        											 $bailMaster->m_forfeit_amount + 
        											 $bailMaster->m_payment_amount + 
        											 $bailMaster->m_city_fee_amount
        										    );
        $indexArray = [
                        'jailRecords' => array(),
                        'balance' => round($balance, 2),
                        'stateList'      => $stateList,
                        'courtList' => $courtList,
                        'processBail' => true,
                      ];
        return view('processbail.refundbails', compact('bailMaster'))->with($indexArray);
    }

 	private function getTermFromUserInput($find)
    {
    	$splitArray = explode(" ", $find);
    	return [
    			 'm_id' 		  => $splitArray[0],
    			 'index_year'     => $splitArray[1],
    			 'defendant_name' => $splitArray[2]
    	];
    }


    private function getCollectionResults(array $queryValues)
    {
       

    }

    /**
     * [getResultsFromUserInput Returns a Result Array depends on the term to find]
     * @param  [type] $findType [description]
     * @param  [type] $find     [description]
     * @return [type]           [description]
     */
    private function getResultsFromUserInput($findType, $find)
    {
        $bailMaster = new BailMaster();

        if ($findType == 'Index_Number') {
        	return array('Index' => $bailMaster->GetArrayIndexNumberLike($find));
        } else if ($findType == 'Defendant_name') {
			return array('Defendant' => $bailMaster->GetArrayDefendantNameLike($find));
        } else if ($findType == 'Surety_name') {
        	return array('Surety' => $bailMaster->GetArraySuretyNameLike($find));
        }

        return array_merge(
							array('Index' => $bailMaster->GetArrayIndexNumberLike($find)),
							array('Defendant' => $bailMaster->GetArrayDefendantNameLike($find)),
							array('Surety' => $bailMaster->GetArraySuretyNameLike($find))
        				  );
    }

    private function builtSelectResponse($resultArray)
    {
    	$data = [];
        foreach ($resultArray as $key => $currentResult) {

        	foreach ($currentResult as $dummykey => $currentRecord) {
        		        $value = $currentRecord['m_id'] . ' ' .
        		        $key . ' ' .
        				$currentRecord['m_index_number'] . '/' . 
        				$currentRecord['m_index_year'] . " " .
        				$this->builtNameForAjaxControl($currentRecord, $key);
                $data[] = ['value'=> $value, 'id'=> $currentRecord['m_id']];
        	}


        }
        return $data;
    }

    private function builtNameForAjaxControl($currentDbRecord, $key)
    {
    	if ($key == 'Defendant') {
    		return trim($currentDbRecord['m_def_first_name']) . " " .
        		   trim($currentDbRecord['m_def_last_name']);
    	}

    	return trim($currentDbRecord['m_surety_first_name']) . " " .
               trim($currentDbRecord['m_surety_last_name']);
    }

}
