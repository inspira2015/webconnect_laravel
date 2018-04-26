<hr class="my-4">
<div style="width: 100%; text-align: left;">
 <h2>Transaction History</h2>
</div>

<table class="table table-striped">
 <thead>
  <tr>
   <th scope="col">Date of Record</th>
   <th scope="col">Transaction</th>
   <th scope="col">Document</th>
   <th scope="col">Transaction Amount </th>
   <th scope="col">Check Number</th>
   <th scope="col">Options</th>
  </tr>
 </thead>
 <tbody>
  @foreach ($bailMaster->BailTransactions as  $key => $item)
   <tr>
    <th scope="row">{{ $item->t_created_at }}</th>
    <th scope="row">{{ $item->t_type }}</th>
    <th scope="row">{{ $item->t_numis_doc_id }}</th>
    @php
        $transactionValidation->setTransactionModel($item);
    @endphp
    <th scope="row">$ {{ $transactionValidation->getAmount() }}</th>
    <input type="hidden" name="t-amount" id="t-amount-{{ $item->t_id }}" value="{{ $transactionValidation->getAmount() }}">

    <th scope="row">{{ $item->t_check_number }}</th>
    <th scope="row">

     @if ($transactionValidation->checkIfReverseIsAllow())
      <button type="button" class="btn btn-primary btn-lg btn-warning button-reverse"
      data-toggle="modal"
      data-target="#Reverse-transaction"
      data-transaction-type="{{$item->t_type}}"
      data-transaction="{{ $item->t_id }}" >Reverse</button>
     @endif
    </th>
   </tr>
  @endforeach
 </tbody>
</table>


<div class="modal fade" id="Reverse-transaction" tabindex="-1" role="dialog" aria-labelledby="Reverse-transactionExample">
 <form name="reverse-payment" id="reverse-payment" method="post" action="{{ route('reversetransaction') }}" >
  {{ csrf_field() }}
  <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
  <input type="hidden" id="t_id" name="t_id" value="">
  <input type="hidden" id="module_name" name="module_name" value="">

  <div class="modal-dialog" role="document">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title" id="exampleModalLabel">Close this Dialog Box</h4>
    </div>
    <div class="modal-body">
     <div class="form-group">
      <label for="m_def_first_name">Do you want to Reversal this Transaction?</label>
     </div>
     <div class="form-group">
      <span id="transaction-type" class="bold-font">Payment</span>
     </div>
     <div class="form-group">
      <span id="transaction-amount" class="bold-font"></span>
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