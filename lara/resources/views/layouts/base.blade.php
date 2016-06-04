<!DOCTYPE html>
<!-- Stored in resources/views/layouts/master.blade.php -->

<html>
    <head>
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <title>App Name - @yield('title')</title>
        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
                <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

         <link rel="stylesheet" href="{{ URL::asset('/') }}css/skel-noscript.css" />.
         <link rel="stylesheet" href="{{ URL::asset('/') }}css/style.css" />.
         <link rel="stylesheet" href="{{ URL::asset('/') }}css/style-desktop.css" />.
         <style type="text/css">
         #login {
            width: 30%;
            display: block;
            margin: 0 auto;
                
            
         }
         </style>
     
    </head>
    <body>
 
    <!-- Main -->
    <div id="login">
        <div class="container">
            @yield('content')
        </div>
    </div>

    </body>
</html>