<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Facades\CountyFee;
use App\Events\ValidateTransactionBalance;
use Redirect;
use Event;

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

    public function editbailmaster(Request $request)
    {
    	$formData = $request->all();
    	$bailMaster = BailMaster::find($formData['m_id']);
    	$bailMaster->m_def_first_name = trim($formData['m_def_first_name']);
    	$bailMaster->m_def_last_name = trim($formData['m_def_last_name']);
    	$bailMaster->m_index_number = trim($formData['m_index_number']);
    	$bailMaster->m_index_year = trim($formData['m_index_year']);
    	$bailMaster->m_posted_date = trim($formData['m_posted_date']);
    	$bailMaster->m_surety_first_name = trim($formData['m_surety_first_name']);
    	$bailMaster->m_surety_last_name = trim($formData['m_surety_last_name']);
    	$bailMaster->m_surety_address = trim($formData['m_surety_address']);
    	$bailMaster->m_surety_city = trim($formData['m_surety_city']);
    	$bailMaster->m_surety_state = trim($formData['m_surety_state']);
    	$bailMaster->m_surety_zip = trim($formData['m_surety_zip']);
    	$bailMaster->save();
    	$searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
		return redirect()->route('processbailresults', ['search_term' => $searchTerm]);
    }


    public function searchresults(Request $request)
    {
        $termToSearch   = $request->get('search_term','');
        $resultArray    = $this->getTermFromUserInput($termToSearch);

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$resultArray['m_id']}\" was not found",
                        ];
            return redirect()->route('processbailsearch')->withErrors($messages);
        }
		$bailMaster     = BailMaster::find($resultArray['m_id']);
        $courtList      = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList      = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $courtCheckList = BailConfiguration::where('bc_category', 'check_court')->pluck('bc_value', 'bc_id')->toArray();
        $dt = new Carbon($bailMaster->m_posted_date);
		$m_posted_date =  $dt->format("m/d/Y"); 

        $resultBalance = Event::fire(new ValidateTransactionBalance($bailMaster));
        $balance = round($resultBalance[0], 2);

        $indexArray = [
                        'jailRecords'    => array(),
                        'balance'        => $balance,
                        'stateList'      => $stateList,
                        'courtList'      => $courtList,
                        'courtCheckList' => $courtCheckList,
                        'm_posted_date'  => $m_posted_date,
                        'bailDetails'    => [
                                             'total_balance'  => $balance,
                                             'fee_percentaje' => CountyFee::getFeePercentaje(),
                                             'fee_amount'     => $this->calculateFeeAmount($balance),
                                             'remain_amount'  => $this->calculateAmountAfterFee($balance),
                                            ],
                      ];
        return view('processbail.refundbails', compact('bailMaster'))->with($indexArray);
    }

 	private function getTermFromUserInput($find)
    {
    	$splitArray = explode(" ", $find);
    	return [
    			 'm_id' 		  => $splitArray[0],
    		   ];
    }


    private function calculateAmountAfterFee($amount)
    {
        $amount = (float) $amount;
        if ($amount <= 0) {
            return 0;
        }
        return $amount * (1 - CountyFee::getFeePercentaje());
    }

    private function calculateFeeAmount($amount)
    {
        $amount = (float) $amount;
        if ($amount <= 0) {
            return 0;
        }
        return $amount * CountyFee::getFeePercentaje();
    }



}
