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

     
    </head>
    <body>
        <!-- Header -->
         <div id="admin-header">
            <div id="nav-wrapper"> 
                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li><a href="{{URL::route('admin.home.index')}}">Home</a></li>
                        <li><a href="{{URL::route('admin.blog.index')}}">Blog</a></li>
                        <li><a href="no-sidebar.html">No Sidebar</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    <!-- Main -->
    <div id="main">
        <div class="container">
            @yield('content')
        </div>
    </div> 

    <!-- Copyright -->
        <div id="copyright">
            <div class="container">
                Design: <a href="http://lara.com">TEMPLATED</a> Images: <a href="http://lara.com">LARA</a> (<a href="http:///">CC0</a>)
            </div>
        </div>

         <script src="{{ URL::asset('js/skel.min.js') }}"></script>
         <script src="{{ URL::asset('js/skel-panels.min.js') }}"></script>
         <script src="{{ URL::asset('js/init.js') }}"></script>

    </body>
</html>
