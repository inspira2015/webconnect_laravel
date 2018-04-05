@extends('layouts.app')

@section('content')

<div style=" background-position:top left; background-repeat:no-repeat;  padding:10px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td valign="top"><h1>Enter Bail By Jail Check Number</h1></td>
    </tr>
  </table>
  <div style="margin-top: .5em; margin-left: 5em;">
    <form action="{{ route('searchchecknumber') }}" method="post" name="form1" class="reduce-input form-inline content">
      {{ csrf_field() }}
      <div class="input-group">
        <label for="check_no" style="padding-right: 5px;"><strong>Enter Check Number:</strong></label>
        <input type="text" name="check_no" class="form-control" id="check_no" placeholder="Check Number">
        <span class="input-group-btn">
          <button class="btn btn-primary" type="submit">Submit!</button>
        </span>
      </div>
    </form>
    <hr>
  </div>
  <form name="bails" id="form-bails" method="post" action="{{ route('processbails') }}" class="reduce-input form-inline content">
    {{ csrf_field() }}
    @if($processBail)
    <div style="margin-top: .5em; margin-left: 5em; width: 100%;">
      <div class="form-group">
        <div class="form-group">
          <label for="docno"><strong>Document Number: </strong></label>
          <div class="col-sm-4">
            <input type="text" name="docno" required class="form-control form-control-sm" id="docno" placeholder="Document Number">
          </div>
        </div>
        <br><br>
        <div class="form-group ">
          <label for="court_number"><strong>Court Number: </strong></label>
            <div class="col-sm-4">
              {!! Form::select('court_number', $courtList, null, array('class' => 'form-control form-control-sm')) !!}
            </div>
        </div>
        <div class="form-group"> <!-- Date input -->
          <label class="control-label" for="date_of_record"><strong>Date of Record: </strong></label>
          <div class="col-sm-4">
            <input class="form-control form-control-sm" id="date_of_record" name="date_of_record" placeholder="MM/DD/YYY" type="text"/>
          </div>
        </div>
          <p align="right">&nbsp;</p>
        </div>
    </div>
    <br><br>
    <hr style="width: 100%;">
    @endif

    @if(!empty($jailRecords))
        @if($processBail)
          <div style="width: 100%; padding: 8px; text-align: right;">
            <button type="submit" class="btn btn-warning ">Process Bail</button>
          </div>
        @endif

        @include('enterbail.jailImportResultTable')

        @if($processBail)
          <div style="width: 100%; padding: 8px; text-align: right; margin-top: 20px;">
            <button type="submit" class="btn btn-warning ">Process Bail</button>
          </div>
        @endif
    @endif
    <br><br>
  </form> 
</div>

<script>
    $(document).ready(function() {
        src = "{{ route('searchcheckajax') }}";
         $("#check_no").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: src,
                    dataType: "json",
                    data: {
                        term : request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 2,
        });
    });
</script>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="date_of_record"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options).datepicker("setDate",'now');

        $('.phone').text(function(i, text) {
            return text.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, '$1-$2-$3');
        });
        $(".dollar-amount").currency();
    });

    $("#form-bails").validate({
     
    });
</script>
@endsection