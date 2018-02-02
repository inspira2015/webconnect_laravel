<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/wc2-css.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome-4.5.0/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pure/0.6.0/pure.css') }}" rel="stylesheet">

</head>
<body>
    <div id="banner" align="center" style="padding-top:5px;"></div>
    <div id="app">
        <nav id="nav_bar">
            <ul>
                <li>
                    <a href="wc2-index.php">
                        <i class="fa fa-home"></i>&nbsp;Home</a>
                </li>
                <li>
                    <a href="wc2-applications.php">
                        <i class="fa fa-laptop"></i>&nbsp;Applications</a>
                </li>
                <li>
                    <a href="wc2-departments.php">
                        <i class="fa fa-group"></i>&nbsp;Departments</a>
                </li>
                <li>
                    <a href="wc2-preferences.php">
                        <i class="fa fa-cogs"></i>&nbsp;Preferences</a>
                </li>
                <li>
                    <a href="https://webmail.nassaucountyny.gov/owa/auth/logon.aspx?replaceCurrent=1&url=https%3a%2f%2fwebmail.nassaucountyny.gov%2fowa%2f" target="_blank">
                        <i class="fa fa-envelope"></i>&nbsp;Email</a>
                </li>
                <li>
                    <a href="wc2-documents.php">
                        <i class="fa fa-file"></i>&nbsp;Documents</a>
                </li>
                <li>
                    <a href="wc2-links.php">
                        <i class="fa fa-list"></i>&nbsp;Links</a>
                </li>
                <li>
                    <a href="wc2-help.php"><i class="fa fa-info-circle"></i>&nbsp;Help</a>
                </li>

                <li style="float:right"><a href="{{ route('login') }}"><i class="fa fa-power-off"></i>&nbsp;Login</a></li>

            </ul>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
