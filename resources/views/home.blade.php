@extends('layouts.app')

@section('content')



<div id="content">


    <h1>Nassau County Cash Bail</h1>
    <div style="width:100%; background-image:url({{ asset('img/cashbail/menu_right_25.jpg') }}); background-position:top right; background-repeat:no-repeat">
        <p class="content"><span style="font-weight: bold">Todays Batch Number Is</span>: <?php echo $batno; ?></p>
        <table width="498" border="0" cellpadding="0" cellspacing="5">
            <?php 
            if ($user_lev == 3) { ?>

            <?php 
                if ($totalRows_approvals <= 0) : ?>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_03.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="{{ route('enterbail') }}" class="content">Enter Bail</a> -</span> <span class="content">process checks from jail or manually enter bails</span>
                </td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_06.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="{{ route('processbailsearch') }}" class="content">Process Bail</a>  -</span> <span class="content">process court orders for bail refunds </span>
                </td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_08.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="forfmenu.php" class="content">Forfeitures</a> -</span> <span class="content">process forfeiture orders </span>
                </td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_10.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="remBail1.php" class="content">Remissions</a> -</span> <span class="content">process remissions of forfeitures or purges </span>
                </td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_12.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="stopmenu.php" class="content">Stop Payments  -</a></span> <span class="content">stop payments / reissue checks </span>
                </td>
            </tr>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_14.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="purgemenu.php" class="content">Purge Bails -</a></span> <span class="content">run purge reports </span>
                </td>
            </tr>
            <?php if ($totalRows_approvals <= 0) : ?>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_16.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span style="font-weight: bold; padding-left:30px;"><a href="checkstoday.php" class="content">Send For Approval</a></span>  -<span class="content">check todays bails and submit for approval </span>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_16.jpg') }}); background-position: left top; background-repeat:no-repeat">
                    <span  style="font-weight: bold; padding-left:30px;"><a href="enterchecks.php" class="content">Enter Check Numbers</a></span> <span class="content"> - input previous days checks </span>
                </td>
            </tr>
            <?php endif; ?>
            <?php   
                if ($totalRows_approvals > 0) {
                    $appr = $fa_approvals['sent_user'];
                    if ($appr != $_SESSION['samaccountname']) {
                        if (empty($fa_approvals['appr_user'])) { ?>
            <tr>
            <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_18.jpg') }}); background-position: left top; background-repeat:no-repeat"><span style="font-weight: bold; padding-left:30px;"><a class="content" href="apprchecks.php">Approve Bails</a>  -</span> <span class="content">approve todays bails and send to NIFS </span></td>
            </tr>
            <?php 
                        }
                    }
                }
} 
?>
            <tr>
              <td height="21" style="background-image:url({{ asset('img/cashbail/cashbailbuttons_18.jpg') }}); background-position: left top; background-repeat:no-repeat"><span style="font-weight: bold; padding-left:30px;"><a href="lookBail1.php" class="content">Bail Lookup </a>-</span> <span class="content">Search bails by defendant, index # or surety </span></td>
            </tr>
          </table>
          <p class="content"><a href="<?php echo url('/home/cashBailManual'); ?>">CLICK HERE FOR THE CASH BAIL MANUAL (.pdf) </a></p>
    </div>

    
<!--Content Goes Below this line -->

@endsection
