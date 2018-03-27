<?php

namespace App\Listeners;

use App\Events\ImportJailRecord;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\JailImport;
use App\Models\BailMaster;

class ValidateUniqueJailRecord
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImportJailRecord  $event
     * @return void
     */
    public function handle(ImportJailRecord $event)
    {
        $importDetails = $event->importArray;
        $jId = $event->jailId;
        $jailImport = JailImport::find($jId);

        $event->bailMaster =  BailMaster::firstOrNew([
                                                "m_index_number" => $importDetails['index_no'][$jId],
                                                "m_index_year" => $importDetails['index_year'][$jId],
                                                "m_def_last_name" => $jailImport->j_def_last_name,
                                                "m_def_first_name" => $jailImport->j_def_first_name,
                                                "m_receipt_amount" => $jailImport->j_bail_amount/100,
                                             ]);
        return $event->bailMaster;
    }
}
