@extends('layouts.app')

@section('content')

<style type="text/css">
    
.reduce-input input.form-control {
   height: 27px !important;
}

.reduce-input select.form-control {
   height: 27px !important;
}

.jailRecords table {
    border-collapse: collapse;
    width: 100%;
}

.jailRecords th {
    font-size: 75%;
    text-align: left;
    padding: 2px;
}

.reduce-width select.form-control {
    width: 100%;
    font-size: 11px;
}

.reduce-width input.form-control {
    width: 100%;
    padding: 0;

}

.jailRecords td {
    font-size: 75%;
    text-align: center;
    padding: 2px;
}

.jailRecords tr:nth-child(even){background-color: #ccc}


.duplicate-row {
    background-color: #8B0000!important;
    color: #FFF!important;
}

.error {
    width: 200px !important;
    color:#FF0000!important;
}

.font18 {
    font-size: 18px;
}

.blue-font {
    color: #2a4e6c;
}

.green-font {
    color: #003300;
}


</style>

<div style="background-image:url({{ asset('images/cashbail/back_red_21.jpg') }}); background-position:top left; background-repeat:no-repeat;  padding:10px;">

    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td valign="top"><h1>Enter Bail By Jail Check Number</h1></td>
            <td valign="top"><div align="right"><span class="content"><a href="{{ route('home') }}" >Main Menu </a></span></div></td>
        </tr>
    </table>

    <?php 
       /* if($totalRows_dupRecord > 0) {
            $error1 = "<div align='center'><span class='warning' style='font-weight: bold'>THERE ARE DUPLICATE INDEX NUMBERS DETECTED PLEASE CORRECT THE INDEXT NUMBERS MARKED IN RED BEFORE CONTINUING!</span></div>";
        } else {
            $error1 = "";
        }
                    
        if(!$_POST['docno']) {
            $error2 = "<div align='center'><span class='warning' style='font-weight: bold'>YOU MUST ENTER A DOCUMENT NUMBER BEFORE CONTINUING!</span></div>";
        } else {
            $error2 = "";
        }*/
    ?>

    <div style="margin-top: .5em; margin-left: 5em;">
        <form action="{{ route('searchchecknumber') }}" method="post" name="form1" class="reduce-input form-inline content">
            <div class="form-group col-sm-4">
                {{ csrf_field() }}
                <label for="check_no"><strong>Enter Check Number:</strong></label>
                <div class="col-sm-4">
                    <input type="text" name="check_no" class="form-control form-control-sm" id="check_no" aria-describedby="emailHelp" placeholder="Check Number">
                </div>
            </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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
                <br>
                <br>
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
            minLength: 3,
           
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