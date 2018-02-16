@extends('layouts.app')

@section('content')

<div style="background-image:url({{ asset('images/cashbail/back_red_21.jpg') }}); background-position:top left; background-repeat:no-repeat;  padding:10px;">

    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td valign="top"><h1>Enter Bail By Jail Check Number</h1></td>
            <td valign="top"><div align="right"><span class="content"><a href="index.php" >Main Menu </a></span></div></td>
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


    <form action="{{ route('searchchecknumber') }}" method="post" name="form1" class="content">
        {{ csrf_field() }}
        <strong>Enter Check Number:</strong>
        <input name="check_no" type="text" id="check_no">
        <input type="submit" name="Submit" value="Submit">
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

@endsection