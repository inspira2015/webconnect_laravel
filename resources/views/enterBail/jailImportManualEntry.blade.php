@extends('layouts.app')

@section('content')
<hr class="bail-entry">

<div class="body-content">
  <h1>Enter Bail Manually</h1>
  <form name="bails" id="manual-bail-entry" method="post" action="{{ route('processmanualentry') }}" >
    {{ csrf_field() }}
    <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
      <hr class="my-3">
      <!-- form complex example -->
      <div class="form-row mt-4">
        <div class="col-sm-1 pb-3">
          <label for="exampleAccount">Date Posted:</label>
          <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="{{ old('m_posted_date') }}" placeholder="MM/DD/YYY">
        </div>
        <div class="col-sm-1 pb-3">
          <label for="exampleCtrl">Date Record:</label>
          <input type="text" class="form-control" required id="date_of_record" name="date_of_record" value="{{ old('date_of_record') }}" placeholder="MM/DD/YYY">
        </div>
        <div class="col-sm-2 pb-2">
          <label for="t_numis_doc_id">Validation Number:</label>
          <input type="text" class="form-control" id="t_numis_doc_id" name="t_numis_doc_id" value="{{ old('t_numis_doc_id', $t_numis_doc_id) }}" placeholder="">
        </div>
        <div class="col-sm-3 pb-3">
          <label for="m_def_first_name">Defendant First Name</label>
          <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  required>
        </div>
        <div class="col-sm-3 pb-3">
          <label for="m_def_last_name">Defendant Last Name</label>
          <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" required>
        </div>
        <div class="col-sm-1 pb-3">
          <label for="m_index_number">Ind Number: </label>
          <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" required>
          <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
          </div>
        </div>
        <div class="col-sm-1 pb-3">
          <label for="m_index_year">Index Year:</label>
          <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" required>
        </div>
        <div class="col-sm-2 pb-3">
          <label for="m_receipt_amount">Bail Amount</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend"><span class="input-group-text">$</span></div>
            <input type="text" class="form-control" id="m_receipt_amount" name="m_receipt_amount" placeholder="Amount" value="{{ old('m_receipt_amount', $bailMaster->m_receipt_amount) }}">
          </div>
        </div>
        <div class="col-sm-2 pb-3">
          <label for="m_court_number"><strong>Court Number: </strong></label>
            {!! Form::select('m_court_number', $courtList, $bailMaster->m_court_number, array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-3 pb-3">
          <label for="m_surety_first_name">Surety First Name</label>
          <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" required>
        </div>
        <div class="col-sm-3 pb-3">
          <label for="m_surety_last_name">Surety Last Name</label>
          <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" required>
        </div>
        <div class="form-check" style="padding-top: 30px; margin-left: 40px;">
          <input type="checkbox" class="form-check-input" id="m_comments_ind"
           @if (old('m_comments_ind',  $bailMaster->m_comments_ind)) checked @endif name="m_comments_ind">
          <label class="form-check-label" for="m_comments_ind">
            Defendant Comments
          </label>
        </div>
        <div class="col-sm-4 pb-3">
          <label for="m_surety_address">Address</label>
          <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" required>
        </div>
        <div class="col-sm-2 pb-3">
          <label for="m_surety_city">City</label>
          <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" required>
        </div>
        <div class="col-sm-2 pb-3">
          <label for="m_surety_state">State</label>
          {!! Form::select('m_surety_state', $stateList, $bailMaster->m_surety_state, array('class' => 'form-control')) !!}
        </div>
        <div class="col-sm-1 pb-3">
          <label for="m_surety_zip">Zip Code</label>
          <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" required>
        </div>
        <input type="hidden" name="m_id" value="{{ $bailMaster->m_id }}">
      </div>
      <hr class="my-3">
      <button type="submit" class="btn btn-lg btn-primary">Insert Bail Record</button>
    </div>
  </form>
</div>

@if(!$edit)
  @include('enterBail.manualInputJsValidation')
@else
  @include('enterBail.manualeditJsValidation')
@endif

@endsection