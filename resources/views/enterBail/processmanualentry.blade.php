@extends('layouts.app')

@section('content')

<div class="center-screen container-800 space-top">
 <div class="text-center">
  <h1 class="success-font">Bail Record Succesfully Saved</h1>
 </div>
</div>
 <!-- Stack the columns on mobile by making one full-width and the other half-width -->
 <div class="center-screen row text-center container-800 space-top">
  <div class="col-xs-6 col-md-6">Date Posted:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_posted_date }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Validation Number:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $transaction->t_numis_doc_id }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Defendant First Name:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_def_first_name }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Defendant Last Name:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_def_last_name }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Index Number:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_index_number }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Index Year:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_index_year }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Bail Amount:</div>
  <div class="col-xs-6 col-md-6"><strong>$ {{ $bailMaster->m_receipt_amount }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Court Number:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->Courts->c_name }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Surety First Name:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_first_name }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Surety Last Name:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_last_name }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Defendant Comments:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_comments_ind }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Address:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_address }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">City:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_city }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">State:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_state }}</strong></div>
 </div>
 <div class="center-screen row text-center container-800">
  <div class="col-xs-6 col-md-6">Zip Code:</div>
  <div class="col-xs-6 col-md-6"><strong>{{ $bailMaster->m_surety_zip }}</strong></div>
 </div>
 <div class="center-screen text-center container-800">
  <form name="edit_bails" id="manual-bail-edit" method="post" action="{{ route('editmanualentry') }}" >
   {{ csrf_field() }}
   <input type="hidden" name="master_id" value="{{ $bailMaster->m_id }}">
    <button type="submit" class="btn btn-warning ">Edit Record</button>

    <a href="{{ route('home') }}">
     <button type="button" id="done" class="btn btn-success">Return to Menu</button>
    </a>
  </form>
 </div>
@endsection