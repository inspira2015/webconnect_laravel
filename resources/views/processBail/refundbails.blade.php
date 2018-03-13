@extends('layouts.app')

@section('content')

<div class="body-content">
	<h1>Process Bail Refund</h1>
	<form name="bails" id="manual-bail-entry" method="post" action="{{ route('processmanualentry') }}" >
        {{ csrf_field() }}
        <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
        	<hr class="my-3">
            <div class="form-row mt-4">
            	<div style="width: 100%; text-align: left;">
					<h2>Defendant Data</h2>
				</div>
				<div class="col-sm-4 pb-3">
                    <label for="m_def_first_name">Defendant First Name</label>
                    <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $bailMaster->m_def_first_name) }}"  required>
                </div>
                <div class="col-sm-4 pb-3">
                    <label for="m_def_last_name">Defendant Last Name</label>
                    <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name', $bailMaster->m_def_last_name) }}" required>
                </div>
                <div class="col-sm-1 pb-3">
                    <label for="m_index_number">Indx Number: </label>
                    <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="{{ old('m_index_number', $bailMaster->m_index_number) }}" required>
                    <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
                    </div>
                </div>
                <div class="col-sm-1 pb-3">
                    <label for="m_index_year">Index Year:</label>
                    <input type="text" class="form-control" maxlength="2" id="m_index_year" name="m_index_year" placeholder="" value="{{ old('m_index_year', $bailMaster->m_index_year) }}" required>
                </div>
                <div class="col-sm-2 pb-3">
                    <label for="exampleAccount">Date Posted:</label>
                    <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="{{ old('m_posted_date') }}" placeholder="MM/DD/YYY">
                </div>
				<hr class="my-5">
				<div style="width: 100%; text-align: left;">
					<h2>Surety Data</h2>
				</div>
 				<div class="col-sm-4 pb-3">
                    <label for="m_surety_first_name">Surety First Name</label>
                    <input type="text" class="form-control" id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name', $bailMaster->m_surety_first_name) }}" required>
                </div>
                <div class="col-sm-4 pb-3">
                    <label for="m_surety_last_name">Surety Last Name</label>
                    <input type="text" class="form-control" id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name', $bailMaster->m_surety_last_name) }}" required>
                </div>
 				<div class="col-sm-5 pb-3">
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
                <div class="col-sm-2 pb-3">
                    <label for="m_surety_zip">Zip Code</label>
                    <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" value="{{ old('m_surety_zip', $bailMaster->m_surety_zip) }}" required>
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

			
        </div>
    </form>
</div>
@endsection