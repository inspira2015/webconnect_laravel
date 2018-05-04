@extends('layouts.app')

@section('content')
<hr class="bail-forfeiture">

<div style="background-image:url(images/back_orange_21.jpg); background-position:top left; background-repeat:no-repeat;  padding:10px;">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
   <td valign="top"><h1>Forfeiture Post Report</h1></td>
  </tr>
 </table>
</div>

<div class="container-800" style ="padding-left: 25px;">
 <div style="text-align: left; width: 400px;">
  <form name="forfeituresReport" id="forfeituresReport" method="post" action="{{ route('forfeituresreport') }}" >
    {{ csrf_field() }}
    <div class="input-group">
      <input type="text" name="report_date" id="report_date" class="form-control"  placeholder="MM/DD/YYY">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit">Run Batch</button>
        </span>
   </div>
  </form>
 </div>
 <div style="margin-top: 15px; margin-left: 15px;">
   Forfeitures for 45 Days Prior to Today
 </div>
</div>

<div class="container-nine" style ="padding-top: 25px; padding-left: 25px;">
 <table class="table table-bordered" style="width: auto !important;">
  <thead>
   <tr>
    <th>Defendant Name</th>
    <th>Index/Year</th>
    <th>Posted Document</th>
    <th>Date of Record</th>
    <th>Amount  Reversal</th>
    <th>Check Number</th>
    <th>Date Check</th>
    <th>Paid</th>
   </tr>
  </thead>
  <tbody>
   @foreach ($bailForfeiture as  $key => $item)
    @php
      $defendantName = $item->BailMaster->m_def_first_name . ', ' . $item->BailMaster->m_def_last_name;
      $indexYear = $item->BailMaster->m_index_number . '/' . $item->BailMaster->m_index_year;
    @endphp

    @foreach ($item->BailMaster->BailTransactions as $transaction)
      @if ($transaction->t_type == 'F' || $transaction->t_type == 'A')
        @php
          $amount = 0;
          if ($transaction->t_type == 'F') {
            $amount = $transaction->t_total_refund;
          }

          if ($transaction->t_type == 'A') {
            $amount = $transaction->t_fee_percentage;
          }
        @endphp
        <tr>
          <td>{{ $defendantName }}</td>
          <td>{{ $indexYear }}</td>
          <td>{{ $transaction->t_numis_doc_id }}</td>
          <td>{{ date('m/d/Y', strtotime($transaction->t_created_at)) }}</td>
          <td>{{ $amount }}</td>
          <td>{{ $transaction->t_check_number }}</td>
          <td></td>
          <td>{{ $transaction->t_type }}</td>
        </tr>
      @endif
    @endforeach
   @endforeach
  </tbody>
 </table>
</div>



<script type="text/javascript">

  $(document).ready(function(e) {
    var old_posted_date       = '{{ $report_date }}';
    DatePickerObj.posted_date = old_posted_date;
    DatePickerObj.date_input  = $('input[name="report_date"]'); //our date input has the name "date"
    DatePickerObj.container   = $('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    DatePickerObj.writeDate();


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
          //http://api.jqueryui.com/autocomplete/#event-change -
          // The item selected from the menu, if any. Otherwise the property is null
          //so clear the item for force selection
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