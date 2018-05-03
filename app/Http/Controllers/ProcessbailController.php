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
use App\Facades\BailMasterData;
use App\Events\ValidateTransactionBalance;
use App\Libraries\Services\BuildCorrectState;
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
        $formData['m_posted_date'] = $this->convertDateToMysqlFormat($formData['m_posted_date']);
        $redirectModule = $formData['module'];
        $this->removePostIdData($formData);
    	$bailMaster = BailMaster::find($formData['m_id']);

        foreach ($formData as $key => $value) {
            $bailMaster->$key = trim($value);
        }
    	$bailMaster->save();
        $searchTerm = "{$bailMaster->m_id} {$bailMaster->m_index_number}";
        session(['search_term' => $searchTerm]);

        if ($redirectModule == 'remission') {
            return redirect()->route('remissionsearch');
        } else {
            return redirect()->route('processbailresults');
        }
    }


    public function searchresults(Request $request, BuildCorrectState $stateValidate)
    {
        $termToSearch   = $request->get('search_term', '');
        $module         = 'processbail';
        $resultArray    = PostedData::getTermFromUserInput($termToSearch);
        $termToSearch   = $resultArray['search_term'];

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$resultArray['m_id']}\" was not found",
                        ];
            $returnRoute = PostedData::getErrorRedirectRoute($module);
            return redirect()->route($returnRoute)->withErrors($messages);
        }
        Session(['search_term' => $termToSearch]);
        $indexArray = BailMasterData::createViewArray($resultArray['m_id'], $module, $stateValidate);
        return view('processbail.refundbails')->with($indexArray);
    }

    private function removePostIdData(&$formData)
    {
        unset($formData['_token']);
        unset($formData['module']);
        unset($formData['non_us_state']);
    }

    private function convertDateToMysqlFormat($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}