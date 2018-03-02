@extends('layouts.app')

@section('content')
<style type="text/css">
    
.error {
    color: #FF0000!important;
}

.green {
    color: #008000!important;
}

</style>


<div class="body-content">
    <h1>Enter Bail Manually</h1>
    
    <form name="bails" id="manual-bail-entry" method="post" action="{{ route('processmanualentry') }}" >
        {{ csrf_field() }}
        <div class="col-md-10 offset-md-1" style="margin-bottom: 50px;">
            <hr class="my-5">

            <!-- form complex example -->
            <div class="form-row mt-4">

                <div class="col-sm-3 pb-3">
                    <label for="exampleAccount">Date Posted:</label>
                    <input type="text" class="form-control form-control-sm" required id="posted_date" name="posted_date" placeholder="MM/DD/YYY">
                </div>

                <div class="col-sm-3 pb-3">
                    <label for="exampleCtrl">Date of Record:</label>
                    <input type="text" class="form-control form-control-sm" required id="date_of_record" name="date_of_record" placeholder="MM/DD/YYY">
                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="exampleAmount">Validation Number:</label>
                    <input type="text" class="form-control form-control-sm" id="validation_number" name="validation_number" placeholder="">
                </div>

                <hr class="my-5">

                <div class="col-sm-6 pb-3">
                    <label for="defendant_first_name">Defendant First Name</label>
                    <input type="text" class="form-control form-control-sm" id="defendant_first_name" name="defendant_first_name" required>
                </div>
                
                <div class="col-sm-6 pb-3">
                    <label for="defendant_last_name">Defendant Last Name</label>
                    <input type="text" class="form-control form-control-sm" id="defendant_last_name" name="defendant_last_name" required>
                </div>
                
   
                    <div class="col-sm-2 pb-3">
                        <label for="index_number">Index Number: </label>
                        <input type="text" class="form-control form-control-sm" id="index_number" name="index_number" placeholder="" required>
                        <div id="indexyear_message" class="" style="padding-top: 5px; overflow: hidden; font-size: 11px; font-weight: bold;">
                        <input type="hidden" id="valid_indexyear" name="valid_indexyear" value="">
                        </div>
                    </div>


                    <div class="col-sm-2 pb-3">
                        <label for="index_year">Index Year:</label>
                        <input type="text" class="form-control form-control-sm" maxlength="2" id="index_year" name="index_year" placeholder="" required>
                    </div>


               <div class="col-sm-2 pb-3">
                    <label for="bail_amount">Bail Amount</label>
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="text" class="form-control form-control-sm" id="bail_amount" name="bail_amount" placeholder="Amount">
                    </div>
                </div>


                <div class="col-sm-3 pb-3">
                    <label for="court_number"><strong>Court Number: </strong></label>
                        {!! Form::select('court_number', $courtList, null, array('class' => 'form-control form-control-sm')) !!}
                </div>


                <div class="col-sm-4 pb-3">
                    <label for="surety_first_name">Surety First Name</label>
                    <input type="text" class="form-control form-control-sm" id="surety_first_name" name="surety_first_name" required>
                </div>
                
                <div class="col-sm-4 pb-3">
                    <label for="surety_last_name">Surety Last Name</label>
                    <input type="text" class="form-control form-control-sm" id="surety_last_name" name="surety_last_name" required>
                </div>
                
                <div class="form-check" style="padding-top: 30px; margin-left: 40px;">
                    <input type="checkbox" class="form-check-input" id="defendant_comments" name="defendant_comments">
                    <label class="form-check-label" for="defendant_comments">
                        Defendant Comments
                    </label>
                </div>


                <div class="col-sm-6 pb-3">
                    <label for="surety_address">Address</label>
                    <input type="text" class="form-control form-control-sm" id="surety_address" name="surety_address" required>
                </div>

                <div class="col-sm-3 pb-3">
                    <label for="surety_city">City</label>
                    <input type="text" class="form-control form-control-sm" id="surety_city" name="surety_city" required>
                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="surety_state">State</label>
                    {!! Form::select('surety_state', $stateList, null, array('class' => 'form-control form-control-sm')) !!}

                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="surety_zip">Zip Code</label>
                    <input type="text" class="form-control form-control-sm" id="surety_zip" name="surety_zip" required>
                </div>
 
  
            </div>
            <button type="submit" class="btn btn-primary">Insert Bail Record</button>
        </div>


    </form>
</div>
<script>
    $(document).ready(function() {
        var src = "{{ route('validateindexyear') }}";
 


        $.validator.addMethod(
            "uniqueNumberYear",
                function(value, element) {
                    var index_number = $('#index_number').val();
                    var index_year = $('#index_year').val();
                    var result = false;

                    $.ajax({
                        type: "GET",
                        url: src,
                                        async:false,

                        data: { number : index_number, year : index_year },
                        dataType:"json",
                        success: function (data) {
                           if (data.result == 'empty') {
                                result = true;
                            } 
        
                        }
                    });

                    return result;


        },
        "Index Number/Year are duplicate"
    );


        var date_input=$('input[name="posted_date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options).datepicker("setDate",'now');
    
        var date_input=$('input[name="date_of_record"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options).datepicker("setDate",'now');
        
       // var validateIndexYear = $(function(){
       // });



        $("#index_number").change(function(){
            var index_number = $(this).val();
            var index_year = $('#index_year').val();

            if (index_year && index_number) {
                console.log('validate');
                $.ajax({
                    url: src,
                    dataType: "json",
                    data : { number : index_number, year : index_year },
                    success: function(data) {

                        if (data.result == 'empty') {
                            $('#indexyear_message').removeClass("error");
                            $('#indexyear_message').addClass("green");
                            $('#indexyear_message').html('Index Number/Year are unique');
                            $('#valid_indexyear').val(0);                            
                        } else {
                            $('#indexyear_message').removeClass("green");
                            $('#indexyear_message').addClass("error");
                            $('#indexyear_message').html('Index Number/Year are duplicate');
                            $('#valid_indexyear').val(1);
                        }                        
                    }
                });
            } 

        });

        $("#index_year").change(function(){
           // alert("year The text has been changed.");
        });

    });

    $( "#manual-bail-entry" ).validate({
        debug: true,
        success: function(label,element) {
                label.hide();
                //var parent = $('.success').parent().get(0); // This would be the <a>'s parent <li>.
                //$(parent).addClass('has-success');    
        },

        rules: {
            validation_number: {
                required: true,
                number: true
            },
            bail_amount: {
                required: true,
                number: true
            },
            index_year: {
                required: true,
                uniqueNumberYear: true
            },

        }
    });


</script>

@endsection