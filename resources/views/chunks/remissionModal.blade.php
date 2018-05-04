<div class="modal fade" id="Remit-Balance" tabindex="-1" role="dialog" aria-labelledby="exampleRemit-Balance">
  <form name="bails" id="manual-bail-entry" method="post" action="{{ route('remitbalance') }}" >
    {{ csrf_field() }}
    <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
    <input type="hidden" id="refund_amount" name="remit_amount" value="">
    <input type="hidden" id="remit_check" name="remit_check" value="">

    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="m_def_first_name">Do you want to proceed with this transaction?</label>
          </div>
          <div class="form-group">
            Remit Balance: <strong>$ <span id="remitAmount"> </span></strong>
          </div>
          <div class="form-group">
            Check Number: <strong><span id="check-number-html"> </span></strong>
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