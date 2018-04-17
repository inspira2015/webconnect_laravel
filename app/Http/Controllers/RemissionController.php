<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Models\BailConfiguration;
use App\Models\BailComments;
use App\Facades\CreateTransaction;
use App\Facades\PostedData;
use App\Facades\CountyFee;
use App\Events\ValidateTransactionBalance;
use Carbon\Carbon;
use Event;
use Redirect;
use Auth;
use Input;
use Form;
use Session;
use View;
use DB;

class RemissionController extends Controller
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
        return view('remission.index')->with($indexArray);
    }

    public function searchresults33(Request $request)
    {
        $formData = $request->all();
        dd($formData);
        exit;

    }

    public function searchresults(Request $request)
    {
        $termToSearch   = $request->get('search_term','');
        $module         = 'remission';
        $resultArray    = PostedData::getTermFromUserInput($termToSearch);

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$termToSearch}\" was not found",
                        ];
            $returnRoute = PostedData::getErrorRedirectRoute($module);
            return redirect()->route($returnRoute)->withErrors($messages);
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
                        'module'         => $module,
                        'm_posted_date'  => $m_posted_date,
                        'bailDetails'    => [
                                             'total_balance'  => $balance,
                                             'fee_percentaje' => CountyFee::getFeePercentaje(),
                                             'fee_amount'     => CountyFee::getAmountFee($balance),
                                             'remain_amount'  => CountyFee::getRemainAmountAfterFee($balance),
                                            ],
                      ];
        return view('remission.searchresults', compact('bailMaster', 'bailMaterComments'))->with($indexArray);
    }

}