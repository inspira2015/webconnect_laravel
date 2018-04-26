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
        $termToSearch   = $resultArray['search_term'];

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$termToSearch}\" was not found",
                        ];
            $returnRoute = PostedData::getErrorRedirectRoute($module);
            return redirect()->route($returnRoute)->withErrors($messages);
        }
        echo $termToSearch;
        session(['search_term' => $termToSearch]);
        $indexArray = BailMasterData::createViewArray($resultArray['m_id'], $module);

        return view('remission.searchresults')->with($indexArray);
    }

}