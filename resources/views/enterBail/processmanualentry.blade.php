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
	  	<div class="col-xs-6 col-md-6"><strong>03/07/2018</strong></div>
	</div>

	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Validation Number:</div>
	  	<div class="col-xs-6 col-md-6"><strong>12345</strong></div>
	</div>

	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Defendant First Name:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Daniel</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Defendant Last Name:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Gomez</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Index Number:</div>
	  	<div class="col-xs-6 col-md-6"><strong>3190</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Index Year:</div>
	  	<div class="col-xs-6 col-md-6"><strong>18</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Bail Amount:</div>
	  	<div class="col-xs-6 col-md-6"><strong>$ 1000.00</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Court Number:</div>
	  	<div class="col-xs-6 col-md-6"><strong>District</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Surety First Name:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Daniel</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Surety Last Name:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Gomez</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Defendant Comments:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Yes/NO</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Address:</div>
	  	<div class="col-xs-6 col-md-6"><strong>2502 Vista View</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">City:</div>
	  	<div class="col-xs-6 col-md-6"><strong>Farmingville</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">State:</div>
	  	<div class="col-xs-6 col-md-6"><strong>New York</strong></div>
	</div>
	<div class="center-screen row text-center container-800">
	  	<div class="col-xs-6 col-md-6">Zip Code:</div>
	  	<div class="col-xs-6 col-md-6"><strong>11738</strong></div>
	</div>
	<div class="center-screen text-center container-800">
    	<form name="edit_bails" id="manual-bail-edit" method="post" action="{{ route('processmanualentry') }}" >
                <button type="submit" class="btn btn-warning ">Edit Record</button>
    	</form>
    </div>


@endsection