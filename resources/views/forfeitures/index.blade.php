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
            <td valign="top"><h1>Search Bail to mark for Forfeitures</h1></td>
        </tr>
    </table>
</div>


<div class="container-800 center-screen">
    <form name="forfeitures" id="forfeitures" method="post" action="{{ route('processbailresults') }}" >
        {{ csrf_field() }}
        <div class="row">    
            <div class="col-8">
                <div class="input-group">
                    <div class="input-group-btn search-panel">
                        <button type="button" class="btn-lg dropdown-toggle" data-toggle="dropdown">
                            <span id="search_concept">Filter by</span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#Index_Number">Index Number</a></li>
                          <li><a href="#Defendant_name">Defendant Name</a></li>
                          <li><a href="#Surety_name">Surety Name</a></li>
                          <li class="divider"></li>
                        </ul>
                    </div>
                    <input type="hidden" name="search_param" value="all" id="search_param">
                    <input type="hidden" name="autocomplete" value="" id="autocomplete">         
                    <input type="text" name="search_term" id="search_term" class="form-control"  placeholder="Search term...">


                    <span class="input-group-btn">
                        <button class="btn btn-lg" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
                <p><label id="search_term-error" class="error" for="search_term"></label></p>
            </div>
        </div>
            @if ( $errors->count() > 0 )
                <ul>
                    @foreach( $errors->all() as $message )
                        <li class="error"><strong>{{ $message }}</strong></li>
                    @endforeach
                </ul>
            @endif
    </form>
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