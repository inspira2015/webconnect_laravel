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
use App\Facades\BailMasterData;
use App\Libraries\TransactionDetails;
use App\Events\RefundTransaction;
use App\Libraries\Services\BuildCorrectState;
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

    public function searchresults(Request $request, BuildCorrectState $stateValidate)
    {
        $termToSearch   = $request->get('search_term','');
        $module         = 'remission';
        $resultArray    = PostedData::getTermFromUserInput($termToSearch);
        $termToSearch   = $resultArray['search_term'];

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$termToSearch}\" was not found",
                        ];
            $returnRoute = PostedData::getErrorRedirectRoute($module);
            return redirect()->route($returnRoute)->withErrors($messages);
        }
        session(['search_term' => $termToSearch]);
        $indexArray = BailMasterData::createViewArray($resultArray['m_id'], $module, $stateValidate);

        return view('remission.searchresults')->with($indexArray);
    }

    /**
     * [remitbalance Add a new transaction with the remaining balance and creates a record into Payee BD table]
     * @param  Request $request [Post Variables]
     * @return [type]           [Redirect to Remission]
     */
    public function remitbalance(Request $request)
    {
        $postData = $request->all();
        $m_id = $postData['m_id'];
        $amount = $postData['remit_amount'];
        $checkNumber = $postData['remit_check'];

        if ($request->isMethod('post')) {
            $bailMaster = BailMaster::find(array('m_id' => $m_id))->first();
            $balance = Event::fire(new ValidateTransactionBalance($bailMaster));

            if ($balance[0] <= 0) {
                echo "no Balance";
                exit;
            }
            $transactionDetails = new TransactionDetails();
            $transactionDetails->setTransactionDetails('t_debit_credit_index', 'O');
            $transactionDetails->setTransactionDetails('m_id', $m_id);
            $transactionDetails->setTransactionDetails('t_type', 'M');
            $transactionDetails->setTransactionDetails('t_total_refund', $amount);
            $transactionDetails->setTransactionDetails('t_check_number', $checkNumber);

            $transactionDetails = $transactionDetails->getTransactionArray();
            $transactionErrors = Event::fire(new RefundTransaction(array($transactionDetails)));

            if (!empty($transactionErrors)) {
                echo "Transaction Error";
                exit;
            }
        }
        return redirect()->route('remissionsearch');
    }

}