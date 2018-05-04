<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Models\BailConfiguration;
use App\Facades\CreateTransaction;
use Redirect;
use Auth;
use Input;
use Form;
use Session;
use View;
use DB;

class EnterBailController extends Controller
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
        return view('enterBail.index')->with($indexArray);
    }

    public function searchcheckajax(Request $request)
    {
        $query = $request->get('term', '');
        $jailImport = new JailImport();
        $jailRecords = $jailImport->GetCheckNumbersLikeInput($query);
        $data = array();

        foreach ($jailRecords as $dummykey => $currentRecord) {
                $data[] = ['value'=> $currentRecord->j_check_number, 'id'=> $currentRecord->j_id];
        }

        if (count($data)) {
             return $data;
        }
        return ['value'=>'No Result Found','id'=>''];
    }

    protected function addBailMasterRecord(array $bailMasterData)
    {
        $bailMaster = BailMaster::firstOrNew([
                                                "m_id" => $bailMasterData['m_id'],
                                             ]);

        foreach ($bailMasterData as $key => $value) {
            $bailMaster->$key = $value;
        }

        $bailMaster->save();
        return $bailMaster->m_id;
    }

    protected function convertDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    protected function getCorrectCourtNumber($courtValues)
    {
        if ($courtValues['defualtValue'] !== $courtValues['globalValue']) {

            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {
                return $courtValues['globalValue'];
            }
            return $courtValues['rowValue'];
        } else {

            if ($courtValues['defualtValue'] == $courtValues['rowValue']) {
                return $courtValues['defualtValue'];
            }
            return $courtValues['rowValue'];
        }
    }
}