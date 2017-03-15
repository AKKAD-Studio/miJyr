<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700|Open+Sans+Condensed:300,700|Open+Sans:300,300i,400,400i,600,600i|Roboto:100,100i,300,300i,400,400i,500,500i&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
        <!-- <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,700|Open+Sans+Condensed:300,700" rel="stylesheet" />  -->


        <meta name="csrf-token" content="{!! csrf_token() !!}">

        <script src="https://use.fontawesome.com/cae0aaab9e.js"></script>

        <link rel="stylesheet" type="text/css" href="/public/libs/hits/style.css">
        <link rel="stylesheet" type="text/css" href="/public/libs/magnific-popup/dist/magnific-popup.css">
        <link rel="stylesheet" type="text/css" href="/public/libs/select2-4.0.3/dist/css/select2.min.css">

        <link rel="stylesheet" type="text/css" href="/public/css/main.css" />

        <script src="/public/libs/jquery/dist/jquery.min.js"></script>
        <!--script src="/public/libs/scroll/jquery.nicescroll.min.js"></script-->

        <script src="/public/libs/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
        <script src="/public/libs/select2-4.0.3/dist/js/select2.full.min.js"></script>

        <script src="/public/js/common.js"></script>


        <!-- Template Basic Images Start -->
        <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
        <script src='https://www.google.com/recaptcha/api.js'></script>


        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/icomoon-social.css">
        <!--link rel="stylesheet" href="css/leaflet.css" /--> 

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>

    </head>
    <body>

        @yield('top_menu')         
        @yield('content') 

    </body>
</html>
