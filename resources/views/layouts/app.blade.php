<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nassau County - Webconnect</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link href="{{ asset('css/cashbailcss.css')}}" rel="stylesheet" type="text/css"/>
    <link href="http://webconnect/NC_Stylesheets/clean.css" rel="stylesheet" type="text/css" />
    <link href="http://webconnect/NC_Stylesheets/intranet.css" rel="stylesheet" type="text/css">
    

    
    <link href="http://demo.expertphp.in/css/jquery.ui.autocomplete.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
    
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
   <!--  <link href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('css/pure/0.6.0/pure.css') }}" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="http://demo.expertphp.in/js/jquery.js"></script>
    <script src="http://demo.expertphp.in/js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/jquery.currency.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>


    <?php 
        $B1 = '#1a3972';
        $B2 = '#0973c5';
        $B3 = '#97c4e1';
        $B4 = '#cadae7';
        $OW = '#eff3f7';
        $OR = '#fb6510';
        $Y  = '#faeb31';
        $W  = '#ffffff';
    ?>
</head>
<body>
<div id="container">
    <table width="100%" height="121" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td> 
                <div id="header">
                    <div class="wclogo"></div>
                    <div class="weather" align="left"> <?php /* 
                        ini_set("default_socket_timeout", "05");
                        set_time_limit(5);
                        $f=fopen("http://www.weather.com/weather/local/USNY0926","r");
                        $r=fread($f,1000);
                        fclose($f);
                        if(strlen($r)>1){       
                        include ('http://webconnect/weather2/zfeed/zfeeder.php'); 
                        }      */ ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div id="navbar">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top" class="navleft">
                    <table height="30" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="48"><div align="center"><a href="<?php echo $current_url; ?>index.php"class="navlink">Home</a></div></td>
                            <td width="48"><div align="center"><a href="<?php echo $current_url; ?>myapps.php"class="navlink">Apps</a></div></td>
                            <!-- <td width="48"><div align="center"><a href="http://webconnect/News/index.php"class="navlink">News</a></div></td> -->
                            <td width="90"><div align="center"><a href="<?php echo $current_url; ?>agencies/index.php"class="navlink">Departments</a></div></td>
                            <td width="90"><div align="center"><a href="<?php echo $current_url; ?>prefs/index.php"class="navlink">Preferences</a></div></td>
                            <td width="48"><div align="center"><a href="https://outlook.office365.com/owa/nassaucountyny.gov/" target="_blank"class="navlink">Email</a></div></td>
                            <td width="80"><div align="center"><a href="<?php echo $current_url; ?>Docs/index.php"class="navlink">Documents</a></div></td>
                            <!-- <td width="60"><div align="center"><a href="http://webconnect/directory.php"class="navlink">Directory</a></div></td> -->
                            <td width="48"><div align="center"><a href="<?php echo $current_url; ?>links.php"class="navlink">Links</a></div></td>
                            <td width="48"><div align="center"><a href="<?php echo $current_url; ?>help.php"class="navlink">Help</a></div></td>
                        </tr>
                    </table>
                </td>
                <td align="center" valign="top" class="navright">
                    <table height="30" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="48">
                                <div align="center">
                                <?php   
                                     if (Auth::user()) { ?>
                                        <a href="{{ route('logout') }}" onclick='event.preventDefault(); document.getElementById("logout-form").submit();''>Logout</a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"">{{ csrf_field() }}</form>

                                   <?php  } else { ?>
                                        <a href="{{ route('login') }}" >Login</a>
                                <?php } ?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

        @yield('content')
    </div>

  

    <!-- Scripts -->

</body>
</html>
