@extends('layouts.app')
@section('content')

<style type="text/css">
 .btn {
  border-radius: 1px solid transparent !important;
  border: 1px solid transparent !important;
 }
 .slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
 .black {
  color: #000;
 }
</style>
 <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<div class="body-content">
 <h1><span id="forfeiture-title" class=""><strong>Forfeitures</strong></span></h1>
 <hr class="my-3">
  <div id="forfeiture-action"></div>
  <div id="forfeiture-updated-date"></div>
  <div id="forfeiture-user"></div>
 <hr class="my-3">
 <div class="checkbox">
  <label>
   <input type="checkbox" id="forfeituresCheckbox" name="forfeituresCheckbox" data-on="Click to Add" data-off="Remove" checked data-toggle="toggle" checked data-onstyle="success" data-style="slow">
   Mark for Forfeitures
  </label>
 </div>

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <form name="bails" id="manual-bail-entry" method="post" action="{{ route('editbailmaster') }}" >
   {{ csrf_field() }}
   <input type="hidden" id="m_id" name="m_id" value="{{ old('m_id', $bailMaster->m_id) }}">
   <div class="modal-dialog" role="document">
    <div class="modal-content">
     <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="exampleModalLabel">Edit Bail Master Info</h4>
     </div>
     <div class="modal-body">
      <div class="form-group">
       <label for="m_def_first_name">Defendant First Name</label>
       <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  required>
      </div>
      <div class="form-group">
       <label for="m_def_last_name">Defendant Last Name</label>
       <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" required>
      </div>
      <div class="row">
       <div class="col-xs-8 col-sm-6">
        <label for="m_index_number">Indx Number: </label>
        <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" required>
        <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
        </div>
       </div>
       <div class="col-xs-4 col-sm-6">
        <label for="m_index_year">Index Year:</label>
        <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" required>
       </div>
      </div>
      <div class="form-group">
       <label for="exampleAccount">Date Posted:</label>
       <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="{{ old('m_posted_date') }}" placeholder="MM/DD/YYY">
      </div>
      <div class="form-group">
       <label for="m_surety_first_name">Surety First Name</label>
       <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" required>
      </div>
      <div class="form-group">
       <label for="m_surety_last_name">Surety Last Name</label>
       <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" required>
      </div>
      <div class="form-group">
       <label for="m_surety_address">Address</label>
       <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" required>
      </div>
      <div class="row">
       <div class="col-xs-8 col-sm-6">
        <label for="m_surety_city">City</label>
        <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" required>
       </div>
       <div class="col-xs-4 col-sm-6">
        <label for="m_surety_state">State</label>
        {!! Form::select('m_surety_state', $stateList, $bailMaster->m_surety_state, array('class' => 'form-control')) !!}
       </div>
      </div>
      <div class="form-group">
       <label for="m_surety_zip">Zip Code</label>
       <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" required>
      </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="type" id="update-info" class="btn btn-primary">Save Changes</button>
     </div>
    </div>
   </div>
  </form>
 </div>

 <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
  <hr class="my-3">
  <div class="form-row mt-4">
   <div style="width: 100%; text-align: left;">
    <h2>Defendant Data</h2>
   </div>
   <div class="col-sm-4 pb-3">
    <label for="m_def_first_name">Defendant First Name</label>
    <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  disabled>
   </div>
    <div class="col-sm-4 pb-3">
     <label for="m_def_last_name">Defendant Last Name</label>
     <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" disabled>
    </div>
    <div class="col-sm-1 pb-3">
     <label for="m_index_number">Indx Number: </label>
     <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" disabled>
     <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
     </div>
    </div>
    <div class="col-sm-1 pb-3">
     <label for="m_index_year">Index Year:</label>
     <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" disabled>
    </div>
    <div class="col-sm-2 pb-3">
     <label for="exampleAccount">Date Posted:</label>
     <input type="text" class="form-control" disabled id="m_posted_date2" name="m_posted_date2" placeholder="MM/DD/YYY">
    </div>
    <div class="col-sm-3 pb-3">
     <label for="m_court_number">Court Number: </label>
      {!! Form::select('m_court_number', $courtList, $bailMaster->m_court_number, array('class' => 'form-control',
       'disabled' => 'disabled')) !!}
    </div>

    <hr class="my-5">
    <div style="width: 100%; text-align: left;">
     <h2>Surety Data</h2>
    </div>
    <div class="col-sm-4 pb-3">
     <label for="m_surety_first_name">Surety First Name</label>
     <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" disabled>
    </div>
    <div class="col-sm-4 pb-3">
     <label for="m_surety_last_name">Surety Last Name</label>
     <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" disabled>
    </div>
    <div class="col-sm-5 pb-3">
     <label for="m_surety_address">Address</label>
     <input type="text" class="form-control" id="m_surety_address" name="m_surety_address"  value="{{ old('m_surety_address', $bailMaster->m_surety_address) }}" disabled>
    </div>
    <div class="col-sm-2 pb-3">
     <label for="m_surety_city">City</label>
     <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city', $bailMaster->m_surety_city) }}" disabled>
    </div>
    <div class="col-sm-2 pb-3">
     <label for="m_surety_state">State</label>
     {!! Form::select('m_surety_state', $stateList, $bailMaster->m_surety_state, array('class' => 'form-control',
                            'disabled' => 'disabled')) !!}
    </div>
    <div class="col-sm-2 pb-3">
     <label for="m_surety_zip">Zip Code</label>
     <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" disabled>
    </div>
   </div>
   <hr class="my-3">
   <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
     <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Bail Amount </div></td>
     <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Forfeit/Purge</div></td>
     <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Payment</div></td>
     <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">County Fee </div></td>
     <td bgcolor="#CCCCCC" class="content" style="font-weight: bold"><div align="center">Balance</div></td>
    </tr>
    <tr>
     <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_receipt_amount }}</div></td>
     <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_forfeit_amount }}</div></td>
     <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_payment_amount }}</div></td>
     <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $bailMaster->m_city_fee_amount }}</div></td>
     <td bgcolor="#FFFFFF" class="content"><div align="center">$ {{ $balance }}</div></td>
    </tr>
   </table>
  @include('chunks.transactionHistory')
 </div>
</div>
<script type="text/javascript">
  var old_posted_date       = '{{ old('m_posted_date', $m_posted_date) }}';
  DatePickerObj.posted_date = old_posted_date;
  DatePickerObj.date_input  = $('input[name="m_posted_date2"]'); //our date input has the name "date"
  DatePickerObj.container   = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
  DatePickerObj.writeDate();

 $(document).ready(function() {
  var balance    = parseFloat({{ $balance }});
  var county_fee = parseFloat({{ $bailDetails['fee_percentaje'] }});
  var bf_active  = '{{ $bailForfeiture['bf_active'] }}';
  var updated_at = '{{ $bailForfeiture['bf_updated_at'] }}';
  var user_name  = '{{ $bailForfeiture['user'] }}';
  var m_id       = "{{ $bailMaster->m_id }}";
  var src_url    = "{{ route('forfeituresControl') }}";

  if (checkForfeitureStatus(bf_active) == 0) {
    $('#forfeituresCheckbox').bootstrapToggle('on');
  } else {
    $('#forfeituresCheckbox').bootstrapToggle('off');
  }

  action_message(bf_active, updated_at);
  update_info(updated_at);
  username_info(user_name);
  forfeituresAddRemove(m_id, src_url);
  buttonReverse('forfeitures');
  reverseTransactionModel(county_fee, balance);
 });
</script>
@endsection