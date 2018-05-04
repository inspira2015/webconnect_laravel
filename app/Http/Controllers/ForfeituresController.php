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
use App\Facades\ExcelHelper;
use App\Facades\CreateTransaction;
use App\Events\ValidateTransactionBalance;
use App\Libraries\TransactionValidations;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Facades\BailMasterData;
use App\Libraries\Services\BuildCorrectState;
use Redirect;
use Event;
use DB;

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

    public function searchresults(Request $request, BuildCorrectState $stateValidate)
    {
        $termToSearch          = $request->get('search_term', '');
        $module                = 'forfeitures';
        $resultArray           = PostedData::getTermFromUserInput($termToSearch);
        $termToSearch          = $resultArray['search_term'];

        if (is_numeric($resultArray['m_id']) == false) {
            $messages = [
                            "\"{$resultArray['m_id']}\" was not found",
                        ];
            return redirect()->route('forfeitures')->withErrors($messages);
        }
        $indexArray = BailMasterData::createViewArray($resultArray['m_id'], $module, $stateValidate);
        return view('forfeitures.forfeituresMark')->with($indexArray);
    }

    public function createReport(Request $request)
    {
        $reportDate = date("Y-m-d");

        if ($request->isMethod('post')) {
            $reportDate = date("Y-m-d", strtotime($request->input('report_date')));
        }
        $bailForfeiture = BailForfeitures::GetForfeitureReportByDate($reportDate);
        $dt             = new Carbon($reportDate);
        $reportDate     = $dt->format("m/d/Y");
        $indexArray = [
                        'report_date' => $reportDate,
                      ];
        return view('forfeitures.Report', compact('bailForfeiture'))->with($indexArray);
    }

    public function createExcelReport(Request $request)
    {
        $titles = [
                    'Defendant Full Name',
                    'Address',
                    'City, State Zip',
                    'Surety Full Name',
                    'Forfeit Date',
                    'Forfeit Do After Date'
                  ];
        $bailForfeiture = BailForfeitures::GetForfeitureReport();
        $spreadsheet    = new Spreadsheet();
        $sheet          = $spreadsheet->getActiveSheet();

        $optionData = [
                        'Column' => [
                                      'start' => 'B',
                                    ],
                        'Row'    => [
                                      'start' => 2,
                                    ],
                        'Values'    => $titles,
                        'Bold'      => true,
                        'Font_Size' => 11,
                      ];

        ExcelHelper::CreateHeader($sheet, $optionData);
        $preparedArray = $this->prepareDataArray($bailForfeiture);

        $optionData = [
                        'Column' => [
                                      'start' => 'B',
                                    ],
                        'Row' => [
                                    'start' => 3,
                                 ],
                        'Values' => $preparedArray,
                        'Bold' => false,
                        'Font_Size' => 10,
                      ];
        ExcelHelper::CreateBody($sheet, $optionData);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="file.xlsx"');
        $writer->save("php://output");
    }

    public function processForfeitures(Request $request)
    {
        if ($request->isMethod('post')) {
            $processForm         = $request->all();
            $bailForfeitureArray = $request->input('bf_id');

            foreach ($bailForfeitureArray as $key => $value) {
                $formDetails['amount']         = $processForm['amount'][$value];
                $formDetails['t_check_number'] = $processForm['t_check_number'];
                CreateTransaction::AddForfeiture($formDetails, $value);
            }
        }

        $bailForfeiture     = BailForfeitures::GetForfeitureReport();
        $stateList          = BailConfiguration::where('bc_category', 'states')->pluck('bc_value', 'bc_id')->toArray();
        $forfeituresDetails = $this->prepareForfeitureProcess($bailForfeiture);
        $formDetails        = [];
        $indexArray = [
                        'stateList'      => $stateList,
                        'ffdetails'      => $forfeituresDetails,
                        'forfeitureForm' => empty($forfeituresDetails),
                      ];
        return view('forfeitures.Process')->with($indexArray);
    }

    public function postReport(Request $request)
    {
        $reportDate = date("Y-m-d");

        if ($request->isMethod('post')) {
            $reportDate = date("Y-m-d", strtotime($request->input('report_date')));
        }
        $bailForfeiture = BailForfeitures::GetProcessedForfeitureReportByDate($reportDate);

        $dt         = new Carbon($reportDate);
        $reportDate = $dt->format("m/d/Y");
        $indexArray = [
                        'report_date' => $reportDate,
                      ];
        return view('forfeitures.PostReport', compact('bailForfeiture'))->with($indexArray);
    }

    private function prepareDataArray($bailForfeiture)
    {
        $resultArray = [];
        foreach ($bailForfeiture as $key => $item) {
            $resultArray[$key][] = $item->BailMaster->m_def_first_name . ', ' . $item->BailMaster->m_def_last_name;
            $resultArray[$key][] = $item->BailMaster->m_surety_address;
            $resultArray[$key][] = $item->BailMaster->m_surety_city . ", {$item->BailMaster->m_surety_state} {$item->BailMaster->m_surety_zip}";
            $resultArray[$key][] = $item->BailMaster->m_surety_first_name . ', ' . $item->BailMaster->m_surety_last_name;
            $resultArray[$key][] = $item->bf_updated_at;
            $resultArray[$key][] = $item->getReportDate();
        }
        return $resultArray;
    }

    private function prepareForfeitureProcess($bailForfeiture)
    {
        $resultArray = [];
        $count = 0;

        foreach ($bailForfeiture as $key => $value) {
            $resultArray[$count]['bf_id'] = $value->bf_id;
            $resultArray[$count]['m_def_first_name'] = $value->BailMaster->m_def_first_name;
            $resultArray[$count]['m_def_last_name'] = $value->BailMaster->m_def_last_name;
            $resultArray[$count]['bf_updated_at'] = $value->bf_updated_at;
            $resultBalance = Event::fire(new ValidateTransactionBalance($value->BailMaster));
            $resultArray[$count]['amount'] = $resultBalance[0];
            $resultArray[$count]['m_surety_first_name'] = $value->BailMaster->m_surety_first_name;
            $resultArray[$count]['m_surety_last_name'] = $value->BailMaster->m_surety_last_name;
            $resultArray[$count]['m_surety_address'] = $value->BailMaster->m_surety_address;
            $resultArray[$count]['m_surety_city'] = $value->BailMaster->m_surety_city;
            $resultArray[$count]['m_surety_state'] = $value->BailMaster->m_surety_state;
            $resultArray[$count]['m_surety_zip'] = $value->BailMaster->m_surety_zip;
            $count++;
        }
        return $resultArray;
    }
}