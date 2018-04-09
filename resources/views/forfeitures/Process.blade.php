@extends('layouts.app')

@section('content')

<div style="background-image:url(images/back_orange_21.jpg); background-position:top left; background-repeat:no-repeat;  padding:10px;">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
   <td valign="top"><h1>Process Forfeitures</h1></td>
  </tr>
 </table>
</div>

<div class="container-800" style ="padding-left: 25px;">
  <div style="text-align: left; width: 400px;">
    <form name="search-process-forfeitures" id="search-process-forfeitures" method="post" action="{{ route('processforfeitures') }}">
      {{ csrf_field() }}
      <div class="input-group">
        <input type="text" name="search_term" id="search_term" class="form-control"  placeholder="Search term...">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button">Run Batch</button>
        </span>
      </div>
    </form>
  </div>
  <div style="margin-top: 15px; margin-left: 15px;">
    <strong>Forfeitures for 45 Days Prior to Today</strong>
  </div>
</div>

<form name="bails" id="manual-bail-entry" method="post" style="background-color: lightgray; padding-bottom: 5px;" action="{{ route('processforfeitures') }}" >
 {{ csrf_field() }}
  <div class="col-md-10 " style="margin-bottom: 10px;">
    <!-- form complex example -->
    <div class="form-row mt-4">
      <div class="col-sm-12 pb-3 row">
        <div class="col-sm-2 pb-3">
          <label for="exampleAccount"><strong>Check Number:</strong></label>
          <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="MANUAL">
        </div>
      </div>
    </div>
    @foreach ($ffdetails as  $key => $item)
    <input  name="bf_id[]" type="hidden" value="{{ $item['bf_id'] }}">
    <div class="form-row mt-4">
      <div class="col-sm-12 pb-3 row">
        <div class="col-sm-2 pb-3">
          <label for="exampleAccount">Defendant First Name:</label>
          <input type="text" class="form-control" required id="m_def_first_name" name="m_def_first_name[{{$item['bf_id']}}]" value="{{ old('m_def_first_name',  $item['m_def_first_name']) }}">
        </div>
        <div class="col-sm-2 pb-3">
          <label for="exampleCtrl">Defendant Last Name:</label>
          <input type="text" class="form-control" required id="m_def_last_name" name="m_def_last_name[{{$item['bf_id']}}]" value="{{ old('m_def_last_name',  $item['m_def_last_name']) }}">
        </div>
        <div class="col-sm-2 pb-3">
          <label for="exampleCtrl">Date:</label>
          <div style="width: 100%;">
            {{ date('m/d/Y', strtotime($item['bf_updated_at'])) }}
          </div>
        </div>
        <div class="col-sm-2 pb-3">
          <label for="exampleCtrl">Do After:</label>
            <div style="width: 100%;">
              {{ date('m/d/Y', strtotime('45 day', strtotime($item['bf_updated_at']))) }}
            </div>
        </div>
        <div class="col-sm-1 pb-3">
          <label for="exampleCtrl">Amount:</label>
          <div style="width: 100%;">
            $ {{ $item['amount'] }}
            <input  name="amount[{{ $item['bf_id'] }}]" type="hidden" value="{{ $item['amount'] }}">
          </div>
        </div>
        <div class="form-group">
          <label for="exampleCtrl">Forfeit Bail:</label>
            <div style="margin-left: 35px;">
              <input type="checkbox" class="form-check-input checkBoxClass"  name="forfeit_selected[{{$item['bf_id']}}]" id="">
            </div>
        </div>
      </div>
      <div class="col-sm-2 pb-3">
        <label for="exampleAccount">Surety First Name:</label>
        <input type="text" class="form-control" required id="m_surety_first_name" name="m_surety_first_name[{{$item['bf_id']}}]" value="{{ old('m_surety_first_name',  $item['m_surety_first_name']) }}">
      </div>
      <div class="col-sm-2 pb-3">
        <label for="exampleCtrl">Surety Last Name:</label>
        <input type="text" class="form-control" required id="m_surety_last_name" name="m_surety_last_name[{{$item['bf_id']}}]" value="{{ old('m_surety_last_name',  $item['m_surety_last_name']) }}">
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_surety_address">Adress:</label>
        <input type="text" class="form-control" id="m_surety_address" name="m_surety_address[{{$item['bf_id']}}]" value="{{ old('m_surety_address',  $item['m_surety_address']) }}">
      </div>
      <div class="col-sm-2 pb-3">
        <label for="m_surety_city">City:</label>
        <input type="text" class="form-control" id="m_surety_city" name="m_surety_city[{{$item['bf_id']}}]" value="{{ old('m_surety_city',  $item['m_surety_city']) }}"  required>
      </div>
      <div class="col-sm-1 pb-3">
        <label for="m_def_last_name">State</label>
        {!! Form::select('m_surety_state[' . $item['bf_id'] . ']', $stateList, $item['m_surety_state'], array('class' => 'form-control')) !!}
      </div>
      <div class="col-sm-1 pb-3">
        <label for="m_surety_zip">Zip: </label>
        <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip[{{$item['bf_id']}}]" placeholder="" value="{{ old('m_surety_zip',  $item['m_surety_zip']) }}" required>
        <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;">
        </div>
      </div>
    </div>
    <hr class="my-3">
    @endforeach
  </div>

  <button type="submit" class="btn btn-lg btn-primary">Process Forfeitures</button>
</form>

<script type="text/javascript">
 $(document).ready(function(e){
  $('.search-panel .dropdown-menu').find('a').click(function(e) {
   e.preventDefault();
   var param = $(this).attr("href").replace("#","");
   $('#search_param').attr('value', param);
   var concept = $(this).text();
   $('.search-panel span#search_concept').text(concept);
  });

  $('.ui-autocomplete-input').click( function() {
   console.log('yes');
  });

  src = "{{ route('searchBailMaster') }}";
   $("#search_term").autocomplete({
    change: function (event, ui) {
     if (!ui.item) {
      $("#search_term").val("");
     }
   },
   source: function(request, response) {
    var search_param = $('#search_param').attr('value');
    $.ajax({
     url: src,
     dataType: "json",
     data: {
      term : request.term,
      search_term : search_param
     },
     success: function(data) {
      response(data);
     }
    });
   },
   minLength: 3,
  });
 });

 $( "#processbails" ).validate({
  success: function(label,element) {
   label.hide();
  },

  rules: {
   search_term: {
    required: true,
   }
  }
 });
</script>
@endsection