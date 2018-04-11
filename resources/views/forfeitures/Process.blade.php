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

@if(!$forfeitureForm)
  @include('forfeitures.ProcessForm')
@endif

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