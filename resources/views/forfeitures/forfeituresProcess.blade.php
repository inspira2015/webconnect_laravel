@extends('layouts.app')

@section('content')
<style type="text/css">
    .error {
        color :#7F0000;
    }
</style>

<div style="background-image:url(images/back_orange_21.jpg); background-position:top left; background-repeat:no-repeat;  padding:10px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td valign="top"><h1>Process Forfeitures</h1></td>
        </tr>
    </table>
</div>

<div class="container-800" style ="padding-left: 25px;">
    <div style="text-align: left; width: 400px;">
        <form name="forfeituresReport" id="forfeituresReport" method="post" action="" >
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

<form name="bails" id="manual-bail-entry" method="post" action="{{ route('processmanualentry') }}" >
    {{ csrf_field() }}
    <div class="col-md-10 " style="margin-bottom: 50px;">
       <hr class="my-3">
        <!-- form complex example -->
        <div class="form-row mt-4">
            <div class="col-sm-12 pb-3 row">
                <div class="col-sm-2 pb-3">
                    <label for="exampleAccount"><strong>Check Number:</strong></label>
                    <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="">
                </div>
                <div class="col-sm-3 pb-3">
                    <label for="exampleAccount">Defendant First Name:</label>
                    <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="">
                </div>
                <div class="col-sm-3 pb-3">
                    <label for="exampleCtrl">Defendant Last Name:</label>
                    <input type="text" class="form-control" required id="date_of_record" name="date_of_record" value="">
                </div>
            </div>

            <div class="col-sm-2 pb-3">
                <label for="exampleAccount">Surety First Name:</label>
                <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="exampleCtrl">Surety Last Name:</label>
                <input type="text" class="form-control" required id="date_of_record" name="date_of_record" value="">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="t_numis_doc_id">Adress:</label>
                <input type="text" class="form-control" id="t_numis_doc_id" name="t_numis_doc_id" value="" placeholder="">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="m_def_first_name">City:</label>
                <input type="text" class="form-control" id="m_def_first_name" name="m_def_first_name" value=""  required>
            </div>
            <div class="col-sm-2 pb-3">
                <label for="m_def_last_name">State</label>
                <input type="text" class="form-control" id="m_def_last_name" name="m_def_last_name" value="" required>
            </div>
            <div class="col-sm-1 pb-3">
                <label for="m_index_number">Zip: </label>
                <input type="text" class="form-control" id="m_index_number" name="m_index_number" placeholder="" value="" required>
                <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;"></div>
            </div>
        </div>
        <button type="submit" class="btn btn-lg btn-primary">Insert Bail Record</button>
    </div>
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