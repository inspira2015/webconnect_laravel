@extends('layouts.app')

@section('content')

<div style="background-image:url(images/back_orange_21.jpg); background-position:top left; background-repeat:no-repeat;  padding:10px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td valign="top"><h1>Process Bail Orders</h1></td>
            <td valign="top"><div align="right"><span class="content"><a href="{{ route('home') }}" >Main Menu </a></span></div></td>
        </tr>
    </table>
</div>


<div class="container-800 center-screen">
    <div class="row">    
        <div class="col-8">
            <div class="input-group">
                <div class="input-group-btn search-panel">
                    <button type="button" class="btn-lg dropdown-toggle" data-toggle="dropdown">
                        <span id="search_concept">Filter by</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#contains">Index Number</a></li>
                      <li><a href="#its_equal">Defendant Name</a></li>
                      <li class="divider"></li>
                    </ul>
                </div>
                <input type="hidden" name="search_param" value="all" id="search_param">         
                <input type="text" class="form-control " name="x" placeholder="Search term...">
                <span class="input-group-btn">
                    <button class="btn btn-lg" type="button"><span class="glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });
});
</script>
@endsection