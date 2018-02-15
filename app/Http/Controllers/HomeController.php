<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAllow;
use App\Models\BatchGenerate;
use App\Models\BatchApprovals;
use View;
use Auth;
use Session;
use DB;

class HomeController extends Controller
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
        $user = Session::get('userClearance');

        $currentDate = date('Y-m-d');
        $batchGenerate = new BatchGenerate();
        $batchJobs = $batchGenerate->GetBatchJobByDate($currentDate);
        $batchJobsNumber = $batchJobs->count();

        if ($batchJobsNumber > 0) {
            //get todays batch number
            $batno = $batchJobs[0]->bg_id;
        } else {
            $batchGenerate = new BatchGenerate();
            $batchGenerate->bg_create_at = date('Y-m-d G:i:s');
            $batchGenerate->save();
            $batno = DB::getPdo()->lastInsertId();
        }

        $batchApprovals = new BatchApprovals();
        $batchRow = $batchApprovals->GetApprovalsByBatchId($batno);
        $totalRows_approvals = $batchRow->count();

        $mydir = $this->myDirectory();
        $homeArray = [
                        'totalRows_approvals' => (int) $totalRows_approvals,
                        'batno' => (int) $batno,
                        'user_lev' => (int) $user->ua_level,
                        'curbox' => 'B2',
                        'bodwidth' => '830px',
                        'LNfilename' => 'webconnect/navs/' . $mydir . '.php',
                        'thisbox' => $this->getThisBox('B2'),
                    ];
        return view('home')->with($homeArray);
    }

    /**
     * [myDirectory Return a directory path]
     * @return [type] [description]
     */
    private function myDirectory()
    {
        $result = explode('/', dirname($_SERVER['PHP_SELF']));
        return end($result);
    }

    /**
     * [getThisBox Returns some styles]
     * @param  [type] $curbox [description]
     * @return [type]         [description]
     */
    private function getThisBox($curbox)
    {
        return ".topleft".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "TL.jpg);
            background-position:bottom right;
            background-repeat:no-repeat;}
        .top".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "T.jpg);
            background-position:bottom left;
            background-repeat:repeat-x;}
        .topright".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "TR.jpg);
            background-position:bottom left;
            background-repeat:no-repeat;}
        .left".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "L.jpg);
            background-position:top right;
            background-repeat:repeat-y;}
        .right".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "R.jpg);
            background-position:top left;
            background-repeat:repeat-y;}
        .botleft".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "BL.jpg);
            background-position:top right;
            background-repeat:no-repeat;}
        .bot".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "B.jpg);
            background-position:top left;
            background-repeat:repeat-x;}
        .botright".$curbox."{
            background-image:url(/public/images/v2/". $curbox . "S/". $curbox . "BR.jpg);
            background-position:top left;
            background-repeat:no-repeat;};";
    }

    /**
     * [downloadCashBailManual Method to download CashBail Manual]
     * @return [pdf file] [returns a pdf file]
     */
    public function downloadCashBailManual()
    {
        $pathPublic = public_path('pdf/cashbailmanual.pdf');
        return response()->download($pathPublic);
    }
}
