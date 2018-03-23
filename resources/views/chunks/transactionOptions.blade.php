<div class="modal fade" id="Refund-balance" tabindex="-1" role="dialog" aria-labelledby="Refund-balance">
    <form name="bails" id="manual-bail-entry" method="post" action="{{ route('refundbalance') }}" >
        {{ csrf_field() }}
        <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
        <input type="hidden" id="refund_type" name="refund_type" value="full">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="m_def_first_name">Do you want to proceed with Full Refund?</label>
                    </div>
                    <div class="form-group">
                        <strong>$ {{ $balance }}</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close and Cancel</button>
                    <button type="type" id="update-info" class="btn btn-primary">Reund Now</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="Refund-balance-with-fee" tabindex="-1" role="dialog" aria-labelledby="Refund-balance-with-fee">
    <form name="bails" id="manual-bail-entry" method="post" action="{{ route('refundbalance') }}" >
        {{ csrf_field() }}
        <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
        <input type="hidden" id="refund_type" name="refund_type" value="fee">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="m_def_first_name">Do you want to proceed with this Refund?</label>
                    </div>
                    <div class="form-group">
                        Fee Amount: <strong>$ {{ $bailDetails['fee_amount'] }}</strong>
                    </div>
                    <div class="form-group">
                        Amount after Fee: <strong>$ {{ $bailDetails['remain_amount'] }}</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close and Cancel</button>
                    <button type="type" id="update-info" class="btn btn-primary">Reund Now</button>
                </div>
            </div>
        </div>
    </form>
</div>


<div class="modal fade" id="Partial-payment" tabindex="-1" role="dialog" aria-labelledby="examplePartial-payment">
    <form name="bails" id="manual-bail-entry" method="post" action="{{ route('partialrefund') }}" >
        {{ csrf_field() }}
        <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
        <input type="hidden" id="refund_amount" name="refund_amount" value="">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="m_def_first_name">Do you want to proceed with this Partial Payment?</label>
                    </div>
                    <div class="form-group">
                        Partial Payment Amount: <strong>$ <span id="partialAmount"> </span></strong>
                    </div>
                    <div class="form-group">
                        Partial Payment Fee: <strong>$ <span id="partial_amount_fee"> </span></strong>
                    </div>
                    <div class="form-group">
                        Remaining Balace After Payment: <strong>$ <span id="remaining_balance"> </span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close and Cancel</button>
                    <button type="type" id="refund-manual" class="btn btn-primary">Refund Now</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="Multi-Check-payment" tabindex="-1" role="dialog" aria-labelledby="exampleMulti-Check-payment">
    <form name="bails" id="manual-bail-entry" method="post" action="{{ route('multicheck') }}" >
                {{ csrf_field() }}
        <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="m_def_first_name">Do you want to proceed with this Multi Check Payment?</label>
                    </div>
                    <div class="form-group">
                        MultiCheck Amount: <strong>$ <span id="multicheck-payment_modal"> </span></strong>
                    </div>
                    <div class="form-group">
                        Pays to: <strong> <span id="check_court"> </span></strong>
                    </div>
                    <div class="form-group">
                        Payment Fee: <strong>$ <span id="multicheck_amount_fee"> </span></strong>
                    </div>
                    <div class="form-group">
                        Surety Payment: <strong>$ <span id="muticheck_balance"> </span></strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close and Cancel</button>
                    <button type="type" id="refund-manual" class="btn btn-primary">Refund Now</button>
                </div>
            </div>
        </div>
    </form>
</div>