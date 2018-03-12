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

    private function getResultsFromUserInput($findType, $find)
    {
        $bailMaster = new BailMaster();

        if ($findType == 'Index_Number') {
        	return $bailMaster->GetIndexNumberLike($find);
        } else if ($findType == 'Defendant_name') {
			return $bailMaster->GetDefendantNameLike($find);
        }

        return array_merge(
							$bailMaster->GetIndexNumberLike($find),
							$bailMaster->GetDefendantNameLike($find)
        				  );
    }

    private function builtSelectResponse($resultArray)
    {
    	$data = [];
        foreach ($resultArray as $dummykey => $currentRecord) {
        		$value = $currentRecord['m_index_number'] . '/' . 
        				 $currentRecord['m_index_year'] . " " .
        				 $currentRecord['m_def_first_name'] . " " . $currentRecord['m_def_last_name'];
                $data[] = ['value'=> $value, 'id'=> $currentRecord['m_id']];
        }
        return $data;
    }


}
