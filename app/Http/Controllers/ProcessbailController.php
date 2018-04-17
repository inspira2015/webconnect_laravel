<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Models\BailComments;
use App\Facades\CountyFee;
use App\Facades\PostedData;
use App\Events\ValidateTransactionBalance;
use Redirect;
use Event;
use Session;

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
        $redirectModule = $formData['module'];

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

        if ($redirectModule == 'remission') {
            return redirect()->route('remissionsearch');
        } else {
            return redirect()->route('processbailresults');
        }
    }


    public function searchresults(Request $request)
    {
        $termToSearch   = $request->get('search_term','');
        $resultArray    = PostedData::getTermFromUserInput($termToSearch);

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$resultArray['m_id']}\" was not found",
                        ];
            return redirect()->route('processbailsearch')->withErrors($messages);
        }
        $bailMasterId      = (int) $resultArray['m_id'];
		$bailMaster        = BailMaster::find($bailMasterId);
        $courtList         = Courts::pluck('c_name', 'c_id')->toArray();
        $stateList         = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $courtCheckList    = BailConfiguration::where('bc_category', 'check_court')->pluck('bc_value', 'bc_id')->toArray();
        $bailMaterComments = BailComments::GetBailMasterComments($bailMasterId);
        session(['search_term' => $termToSearch]);

        $dt = new Carbon($bailMaster->m_posted_date);
		$m_posted_date =  $dt->format("m/d/Y");

        $resultBalance = Event::fire(new ValidateTransactionBalance($bailMaster));
        $balance = round($resultBalance[0], 2);

        $indexArray = [
                        'jailRecords'    => array(),
                        'bailMasterId'   => $bailMasterId,
                        'balance'        => $balance,
                        'stateList'      => $stateList,
                        'courtList'      => $courtList,
                        'courtCheckList' => $courtCheckList,
                        'm_posted_date'  => $m_posted_date,
                        'module'         => 'processbail',
                        'bailDetails'    => [
                                             'total_balance'  => $balance,
                                             'fee_percentaje' => CountyFee::getFeePercentaje(),
                                             'fee_amount'     => CountyFee::getAmountFee($balance),
                                             'remain_amount'  => CountyFee::getRemainAmountAfterFee($balance),
                                            ],
                      ];
        return view('processbail.refundbails', compact('bailMaster', 'bailMaterComments'))->with($indexArray);
    }
}
