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

<form name="bails" id="manual-bail-entry" method="post" style="background-color: lightgray; padding-bottom: 5px;" action="{{ route('processmanualentry') }}" >
    {{ csrf_field() }}
    <div class="col-md-10 " style="margin-bottom: 10px;">
       <hr class="my-3">
        <!-- form complex example -->
        @foreach ($bailForfeiture as  $key => $item)
        <div class="form-row mt-4">
            <div class="col-sm-12 pb-3 row">
                <div class="col-sm-2 pb-3">
                    <label for="exampleAccount"><strong>Check Number:</strong></label>
                    <input type="text" class="form-control" required id="m_posted_date" name="m_posted_date" value="MANUAL">
                </div>
                <div class="col-sm-3 pb-3">
                    <label for="exampleAccount">Defendant First Name:</label>
                    <input type="text" class="form-control" required id="m_def_first_name" name="m_def_first_name" value="{{ old('m_def_first_name',  $item->BailMaster->m_def_first_name) }}">
                </div>
                <div class="col-sm-3 pb-3">
                    <label for="exampleCtrl">Defendant Last Name:</label>
                    <input type="text" class="form-control" required id="m_def_last_name" name="m_def_last_name" value="{{ old('m_def_last_name',  $item->BailMaster->m_def_last_name) }}">
                </div>
            </div>

            <div class="col-sm-2 pb-3">
                <label for="exampleAccount">Surety First Name:</label>
                <input type="text" class="form-control" required id="m_surety_first_name" name="m_surety_first_name" value="{{ old('m_surety_first_name',  $item->BailMaster->m_surety_first_name) }}">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="exampleCtrl">Surety Last Name:</label>
                <input type="text" class="form-control" required id="m_surety_last_name" name="m_surety_last_name" value="{{ old('m_surety_last_name',  $item->BailMaster->m_surety_last_name) }}">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="m_surety_address">Adress:</label>
                <input type="text" class="form-control" id="m_surety_address" name="m_surety_address" value="{{ old('m_surety_address',  $item->BailMaster->m_surety_address) }}">
            </div>
            <div class="col-sm-2 pb-3">
                <label for="m_surety_city">City:</label>
                <input type="text" class="form-control" id="m_surety_city" name="m_surety_city" value="{{ old('m_surety_city',  $item->BailMaster->m_surety_city) }}"  required>
            </div>
            <div class="col-sm-2 pb-3">
                <label for="m_def_last_name">State</label>
                {!! Form::select('m_surety_state', $stateList, $item->BailMaster->m_surety_state, array('class' => 'form-control')) !!}            </div>
            <div class="col-sm-1 pb-3">
                <label for="m_surety_zip">Zip: </label>
                <input type="text" class="form-control" id="m_surety_zip" name="m_surety_zip" placeholder="" value="{{ old('m_surety_zip',  $item->BailMaster->m_surety_zip) }}" required>
                <div id="indexyear_message" class="" style="padding-top: 0px; overflow: hidden; font-size: 11px; font-weight: bold;"></div>
            </div>
        </div>
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