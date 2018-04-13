<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BailMaster;
use App\Models\Courts;
use App\Models\BailConfiguration;
use App\Models\BailForfeitures;
use App\Models\BailComments;
use App\Facades\CountyFee;
use App\Events\ValidateTransactionBalance;
use Redirect;
use Event;
use Auth;

class CommentController extends Controller
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
     * [ajaxfindbail Ajax Method for autocomplete]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function addComment(Request $request)
    {
        $formData = $request->all();
        $user = Auth::user();
        $tableName = $this->getTableName($formData['type']);

        $newComment = new BailComments();
        $newComment->foreign_table = $tableName;
        $newComment->foreign_id = (int) $formData['id'];
        $newComment->comment = (string) $formData['newComment'];
        $newComment->user_id = $user->id;
        $newComment->created_at = date('Y-m-d H:i:s');
        $newComment->save();

        return response()->json([
                                  'comment'  => $newComment->comment,
                                  'added_at' => $newComment->getDateForComment(),
                                ]);
    }

    private function getTableName($commentType)
    {
        if ($commentType == 'bailmaster') {
            return 'bail_master';
        }
    }

}