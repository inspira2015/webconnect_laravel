@extends('layouts.app')

@section('content')

<div style="background-image:url(images/back_orange_21.jpg); background-position:top left; background-repeat:no-repeat;  padding:10px;">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
   <td valign="top"><h1>Forfeiture Report</h1></td>
  </tr>
 </table>
</div>

<div class="container-800" style ="padding-left: 25px;">
 <div style="text-align: left; width: 400px;">
  <form name="forfeituresReport" id="forfeituresReport" method="post" action="{{ route('forfeituresreport') }}" >
    <div class="input-group">
      <input type="text" name="report_date" id="report_date" class="form-control"  placeholder="Search Date...">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="button">Run Batch</button>
        </span>
   </div>
  </form>
 </div>
 <div style="margin-top: 15px; margin-left: 15px;">
   Forfeitures for 45 Days Prior to Today
 </div>
</div>

<div class="container-800" style ="padding-top: 25px; padding-left: 25px;">
 <table class="table table-bordered">
  <thead>
   <tr>
    <th>Defendant</th>
    <th>Address</th>
    <th>City, State Zip</th>
    <th>Surety</th>
    <th>Date</th>
    <th>Do After</th>
   </tr>
  </thead>
  <tbody>
   @foreach ($bailForfeiture as  $key => $item)
   <tr>
    <td>{{ $item->BailMaster->m_def_first_name }}, {{ $item->BailMaster->m_def_last_name }}</td>
    <td>{{ $item->BailMaster->m_surety_address }}</td>
    <td>{{ $item->BailMaster->m_surety_city }}, {{ $item->BailMaster->m_surety_state }} {{ $item->BailMaster->m_surety_zip }}</td>
    <td>{{ $item->BailMaster->m_surety_first_name }}, {{ $item->BailMaster->m_surety_last_name }}</td>
    <td>{{ date('Y-m-d', strtotime($item->bf_updated_at)) }}</td>
    <td>{{ date('Y-m-d', strtotime($item->bf_updated_at . ' + 45 days')) }}</td>
   </tr>
   @endforeach
  </tbody>
 </table>
</div>

<div class="container-800" style ="padding-top: 25px; padding-left: 25px;">
 <a href="{{ route('forfeituresExcel') }}">Download Forfeitures Excel Report</a>
</div>

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
  /*debug: true,*/
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