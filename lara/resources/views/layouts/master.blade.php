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
        <div id="header">
            <div id="nav-wrapper"> 
                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li class="active"><a href="/">Homepage</a></li>
                        <li><a href="blog">Blog</a></li>
                        <li><a href="right-sidebar.html">Right Sidebar</a></li>
                        <li><a href="no-sidebar.html">No Sidebar</a></li>
                    </ul>
                </nav>
            </div>
            <div class="container"> 
                
                <!-- Logo -->
                <div id="logo">
                    <h1><a href="#">Lara</a></h1>
                    <span class="tag">Janus Site</span>
                </div>
            </div>
        </div>

    <!-- Main -->
    <div id="main">
        <div class="container">
            @yield('content')
        </div>
 
    <!-- Tweet -->
        <div id="tweet">
            <div class="container">
                <section>
                    <blockquote>&ldquo;In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat.&rdquo;</blockquote>
                </section>
            </div>
        </div>
    </div>
    <!-- Footer -->
        <div id="footer">
            <div class="container">
                <section>
                    <header>
                        <h2>Get in touch</h2>
                        <span class="byline">Integer sit amet pede vel arcu aliquet pretium</span>
                    </header>
                    <ul class="contact">
                        <li><a href="#" class="fa fa-twitter"><span>Twitter</span></a></li>
                        <li class="active"><a href="#" class="fa fa-facebook"><span>Facebook</span></a></li>
                        <li><a href="#" class="fa fa-dribbble"><span>Pinterest</span></a></li>
                        <li><a href="#" class="fa fa-tumblr"><span>Google+</span></a></li>
                    </ul>
                </section>
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