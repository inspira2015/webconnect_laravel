<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EnterBailController;
use Illuminate\Http\Request;
use App\Models\JailImport;
use App\Models\Courts;
use App\Models\BailMaster;
use App\Models\BailTransactions;
use App\Events\ValidateTransactionBalance;
use Event;
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
        if ($request->isMethod('post')) {
            $userInput = $request->all();
            $bailMaster = BailMaster::find(array('m_id' => $userInput['m_id']))->first();
            $bailTransactions = new BailTransactions();
            $balance = Event::fire(new ValidateTransactionBalance($bailMaster));

            if ($balance[0] <= 0) {
                // Return Error
            }


            print_r($balance );

            echo "post";
        }
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