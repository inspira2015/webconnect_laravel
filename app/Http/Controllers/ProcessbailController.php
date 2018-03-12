<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;


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
    	$termToSearch = $request->get('term','');
        $termType = $request->get('search_term','');
        $resultArray = $this->getCollectionResults($termToSearch);

        dd($resultArray);
        exit;


    }
/*  private function getTermFromUserInput($find)
    {
    	$splitArray = explode(" ", $find);

    	s



    	return [
    			 'index_year'     => $splitArray[0];
    			 'defendant_name' => $splitArray[]
    	];
    }*/


    private function getCollectionResults($find)
    {
        $bailMaster = new BailMaster();

    	return array_merge(
							$bailMaster->GetArrayIndexNumberLike($find),
							$bailMaster->GetArrayDefendantNameLike($find)
        				  );
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
        	return $bailMaster->GetArrayIndexNumberLike($find);
        } else if ($findType == 'Defendant_name') {
			return $bailMaster->GetArrayDefendantNameLike($find);
        }

        return array_merge(
							$bailMaster->GetArrayIndexNumberLike($find),
							$bailMaster->GetArrayDefendantNameLike($find)
        				  );
    }

    private function builtSelectResponse($resultArray)
    {
    	$data = [];
        foreach ($resultArray as $dummykey => $currentRecord) {
        		$value = $currentRecord['m_index_number'] . '/' . 
        				 $currentRecord['m_index_year'] . " " .
        				 trim($currentRecord['m_def_first_name']) . " " .
        				 trim($currentRecord['m_def_last_name']);
                $data[] = ['value'=> $value, 'id'=> $currentRecord['m_id']];
        }
        return $data;
    }

}
