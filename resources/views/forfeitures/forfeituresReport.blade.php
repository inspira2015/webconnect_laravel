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
            <td valign="top"><h1>Forfeiture Report</h1></td>
        </tr>
    </table>
</div>


<div class="container-800 center-screen">

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