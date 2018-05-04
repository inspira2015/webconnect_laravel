<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Models\BailForfeitures;
use App\Facades\CountyFee;
use App\Events\ValidateTransactionBalance;
use Redirect;
use Event;

class AjaxSearchController extends Controller
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

       /**
     * [ajaxfindbail Ajax Method for autocomplete]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function searchBailMaster(Request $request)
    {
        $termToSearch = $request->get('term','');
        $termType     = $request->get('search_term','');
        $resultArray  = $this->getResultsFromUserInput($termType, $termToSearch);
        $data         = $this->builtSelectResponse($resultArray);

        if (count($data)) {
             return $data;
        }
        return ['value'=>'No Result Found','id'=>''];
    }

    public function ajaxForfeituresAddRemove(Request $request)
    {
        $checkBoxAction = $request->get('checkbox');
        $bailMasterId   = $request->get('bailMaster_id');
        $bailForfeiture = BailForfeitures::firstOrNew([
                                                        'm_id' => $bailMasterId
                                                     ]);
        if ($checkBoxAction == 'false') {
            $bailForfeiture->bf_active = 1;
            $bailForfeiture->save();
        } else {
            $bailForfeiture->bf_active = 0;
            $bailForfeiture->save();
        }

        return response()->json([
                                  'bf_active' => $bailForfeiture->bf_active,
                                  'bf_updated_at' => $bailForfeiture->bf_updated_at,
                                  'user' => $bailForfeiture->User->name,
                                ]);
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
            return array('Index' => $bailMaster->GetArrayIndexNumberLike($find));
        } else if ($findType == 'Defendant_name') {
            return array('Defendant' => $bailMaster->GetArrayDefendantNameLike($find));
        } else if ($findType == 'Surety_name') {
            return array('Surety' => $bailMaster->GetArraySuretyNameLike($find));
        }

        return array_merge(
                            array('Index'     => $bailMaster->GetArrayIndexNumberLike($find)),
                            array('Defendant' => $bailMaster->GetArrayDefendantNameLike($find)),
                            array('Surety'    => $bailMaster->GetArraySuretyNameLike($find))
                          );
    }

    private function builtSelectResponse($resultArray)
    {
        $data = [];
        foreach ($resultArray as $key => $currentResult) {

            foreach ($currentResult as $dummykey => $currentRecord) {
                        $value = $currentRecord['m_id'] . ' ' .
                        $key . ' ' .
                        $currentRecord['m_index_number'] . '/' .
                        $currentRecord['m_index_year'] . " " .
                        $this->builtNameForAjaxControl($currentRecord, $key);
                $data[] = ['value'=> $value, 'id'=> $currentRecord['m_id']];
            }
        }
        return $data;
    }

    private function builtNameForAjaxControl($currentDbRecord, $key)
    {
        if ($key == 'Defendant') {
            return trim($currentDbRecord['m_def_first_name']) . " " .
                   trim($currentDbRecord['m_def_last_name']);
        }

        return trim($currentDbRecord['m_surety_first_name']) . " " .
               trim($currentDbRecord['m_surety_last_name']);
    }
}