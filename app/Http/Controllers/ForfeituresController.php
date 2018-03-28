<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Facades\CountyFee;
use App\Facades\PostedData;
use App\Events\ValidateTransactionBalance;
use Redirect;
use Event;

class ForfeituresController extends Controller
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


        return view('forfeitures.index')->with($indexArray);
    }

    public function searchresults(Request $request)
    {
        $termToSearch   = $request->get('search_term','');
        $resultArray    = PostedData::getTermFromUserInput($termToSearch);

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$resultArray['m_id']}\" was not found",
                        ];
            return redirect()->route('forfeitures')->withErrors($messages);
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
                                             'fee_amount'     => CountyFee::getAmountFee($balance),
                                             'remain_amount'  => CountyFee::getRemainAmountAfterFee($balance),
                                            ],
                      ];
        return view('processbail.refundbails', compact('bailMaster'))->with($indexArray);
    }

}