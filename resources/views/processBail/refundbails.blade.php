@extends('layouts.app')

@section('content')

<div class="body-content">
	<h1>Process Bail Refund</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Edit Info</button>
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
                    <input type="text" class="form-control" disabled id="m_posted_date" name="m_posted_date" value="{{ old('m_posted_date') }}" placeholder="MM/DD/YYY">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bailMaster->BailTransactions as  $key => $item)
                        <tr>    
                            <th scope="row">{{ $item->t_created_at }}</th>
                            <th scope="row">{{ $item->t_type }}</th>
                            <th scope="row">{{ $item->t_numis_doc_id }}</th>
                            <th scope="row">{{ $item->t_amount }}</th>
                            <th scope="row">{{ $item->t_check_number }}</th>

                        </tr>
                    @endforeach
              </tbody>
            </table>
    </div>
</div>
<script type="text/javascript">




$('#exampleModal').on('show.bs.modal', function (event) {
    var recipient = button.data('whatever'); // Extract info from data-* attributes
    console.log('button:' + button);
    var button = $(event.click); // Button that triggered the modal

    console.log('button' + button);


  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this);
  modal.find('.modal-title').text('New message to ' + recipient);
  modal.find('.modal-body input').val(recipient);
});
		



</script>

@endsection