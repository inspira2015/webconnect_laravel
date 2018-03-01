@extends('layouts.app')

@section('content')

<div class="body-content">
    <h1>Enter Bail Manually</h1>
    
    <form name="bails" id="form-bails" method="post" action="{{ route('processbails') }}" >
        <div class="col-md-10 offset-md-1">
            <span class="anchor" id="formComplex"></span>
            <hr class="my-5">

            <!-- form complex example -->
            <div class="form-row mt-4">

                <div class="col-sm-3 pb-3">
                    <label for="exampleAccount">Date Posted:</label>
                    <input type="text" class="form-control" id="posted_date" name="posted_date" placeholder="MM/DD/YYY">
                </div>

                <div class="col-sm-3 pb-3">
                    <label for="exampleCtrl">Date of Record:</label>
                    <input type="text" class="form-control" id="date_of_record" name="date_of_record" placeholder="MM/DD/YYY">
                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="exampleAmount">Validation Number:</label>
                    <input type="text" class="form-control" id="validation_number" name="validation_number" placeholder="">
                </div>

                <hr class="my-5">

                <div class="col-sm-6 pb-3">
                    <label for="exampleFirst">Defendant First Name</label>
                    <input type="text" class="form-control" id="exampleFirst">
                </div>
                
                <div class="col-sm-6 pb-3">
                    <label for="exampleLast">Defendant Last Name</label>
                    <input type="text" class="form-control" id="exampleLast">
                </div>
                

                <div class="col-sm-2 pb-3">
                    <label for="exampleAccount">Index Number: </label>
                    <input type="text" class="form-control" id="posted_date" name="posted_date" placeholder="MM/DD/YYY">
                </div>

                <div class="col-sm-2 pb-3">
                    <label for="exampleCtrl">Index Year:</label>
                    <input type="text" class="form-control" id="date_of_record" name="date_of_record" placeholder="MM/DD/YYY">
                </div>
                
               <div class="col-sm-3 pb-3">
                    <label for="exampleAmount">Bail Amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="text" class="form-control" id="exampleAmount" placeholder="Amount">
                    </div>
                </div>

                <div class="col-sm-3 pb-3">
                    <label for="court_number"><strong>Court Number: </strong></label>
                        {!! Form::select('court_number', $courtList, null, array('class' => 'form-control')) !!}
                </div>


                <div class="col-sm-4 pb-3">
                    <label for="exampleFirst">Surety First Name</label>
                    <input type="text" class="form-control" id="exampleFirst">
                </div>
                
                <div class="col-sm-4 pb-3">
                    <label for="exampleLast">Surety Last Name</label>
                    <input type="text" class="form-control" id="exampleLast">
                </div>
                
                <div class="form-check" style="padding-top: 30px; margin-left: 40px;">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">
                        Defendant Comments
                    </label>
                </div>


                <div class="col-sm-6 pb-3">
                    <label for="exampleCity">Address</label>
                    <input type="text" class="form-control" id="exampleCity">
                </div>

                <div class="col-sm-3 pb-3">
                    <label for="exampleCity">City</label>
                    <input type="text" class="form-control" id="exampleCity">
                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="exampleSt">State</label>
                    <select class="form-control" id="exampleSt">
                     <option>Pick a state</option>
                    </select>
                </div>
                
                <div class="col-sm-3 pb-3">
                    <label for="exampleZip">Zip Code</label>
                    <input type="text" class="form-control" id="exampleZip">
                </div>
 
                        <div class="col-md-6 pb-3">
                            <label for="exampleMessage">Message</label>
                            <textarea class="form-control" id="exampleMessage"></textarea>
                            <small class="text-info">
                              Add the packaging note here.
                            </small>
                        </div>

                    </div>

                </div>


    </form>
</div>
<script>
    $(document).ready(function(){
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

    });

    $("#form-bails").validate({
     
    });
</script>

@endsection