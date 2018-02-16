@extends('layouts.app')

@section('content')

<div style="background-image:url({{ asset('images/cashbail/back_red_21.jpg') }}); background-position:top left; background-repeat:no-repeat; padding:10px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr>
                <td><h1>Bail Entry</h1></td>
                <td><div align="right"><span class="content"><a href="index.php" >Back Main Menu </a></span></div></td>
            </tr>
        </table>
        <table border="0" align="center" cellpadding="0" cellspacing="5">
            <tr>
                <td><span class="content" style="font-weight: bold;">Select a bail entry method </span><span class="content"></span></td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('images/cashbail/cashbailbuttons_03.jpg') }}); background-position: left top; background-repeat:no-repeat"><span style="font-weight: bold; padding-left:30px;"><a href="{{ route('jailcheck') }}" class="content">Enter Bail From Jail Check</a></span></td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('images/cashbail/cashbailbuttons_03.jpg') }}); background-position: left top; background-repeat:no-repeat"><span style="font-weight: bold; padding-left:30px;"><a href="enterbail.php" class="content">Enter Bail Manually </a></span><a href="enterbail.php"><span class="content"></span></a></td>
            </tr>
        </table>
</div>

@endsection