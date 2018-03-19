<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;

use Session;


class BailRefundProcessController extends EnterBailController
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


    public function refundbalance(Request $request)
    {
        $userInput = $request->all();
        $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']));

        dd($userInput);
        exit;

    }

    public function partialrefund(Request $request)
    {
        $userInput = $request->all();
        $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']));

        dd($userInput);
        exit;
    }
    
    public function multicheck(Request $request)
    {
        $userInput = $request->all();
        $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']));

        dd($userInput);
        exit;
    }
}