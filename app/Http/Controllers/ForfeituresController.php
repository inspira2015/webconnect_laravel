<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Models\BailForfeitures;
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
        $forfeitureStatus = 0;
        $updatedAt = false;
        $userName = false;

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

        if (isset($bailMaster->BailForfeitures->bf_id)) {
            $forfeitureStatus = $bailMaster->BailForfeitures->bf_active;
            $carbonDate = new Carbon($bailMaster->BailForfeitures->bf_updated_at);
            $updatedAt = $carbonDate->toDayDateTimeString();
            $userName = $bailMaster->BailForfeitures->User->name;
        }

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
                        'bailForfeiture' => [
                                             'bf_active' => $forfeitureStatus,
                                             'bf_updated_at' => $updatedAt,
                                             'user' => $userName,
                                            ],
                      ];
        return view('forfeitures.forfeituresMark', compact('bailMaster'))->with($indexArray);
    }

    public function createReport(Request $request)
    {
        $bailForfeiture = BailForfeitures::GetForfeitureReport();
        //dd($bailForfeiture->BailMaster);
        //exit;

        $indexArray = [];
        return view('forfeitures.forfeituresReport', compact('bailForfeiture'))->with($indexArray);
    }

    public function processForfeitures(Request $request)
    {
        $indexArray = [];
        return view('forfeitures.forfeituresProcess')->with($indexArray);
    }

}