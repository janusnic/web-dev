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
                        <li class="active"><a href="index.html">Homepage</a></li>
                        <li><a href="left-sidebar.html">Left Sidebar</a></li>
                        <li><a href="right-sidebar.html">Right Sidebar</a></li>
                        <li><a href="no-sidebar.html">No Sidebar</a></li>
                    </ul>
                </nav>
            </div>
            <div class="container"> 
                
                <!-- Logo -->
                <div id="logo">
                    <h1><a href="#">Linear</a></h1>
                    <span class="tag">By TEMPLATED</span>
                </div>
            </div>
        </div>
    <!-- Featured -->
        <div id="featured">
            <div class="container">
                <header>
                    <h2>Welcome to Lara</h2>
                </header>
                <p>This is <strong>Linear</strong>, a responsive HTML5 site template freebie by <a href="http://lara.com">TEMPLATED</a>. Released for free under the <a href="http://lara.com">Creative Commons Attribution</a> license, so use it for whatever (personal or commercial) &ndash; just give us credit! Check out more of our stuff at <a href="http://lara.com">our site</a> or follow us on <a href="http://twitter.com/janusnic">Twitter</a>.</p>
                <hr />
                <div class="row">
                    <section class="4u">
                        <span class="pennant"><span class="fa fa-briefcase"></span></span>
                        <h3>Maecenas luctus lectus</h3>
                        <p>Curabitur sit amet nulla. Nam in massa. Sed vel tellus. Curabitur sem urna, consequat vel, suscipit in, mattis placerat, nulla. Sed ac leo.</p>
                        <a href="#" class="button button-style1">Read More</a>
                    </section>
                    <section class="4u">
                        <span class="pennant"><span class="fa fa-lock"></span></span>
                        <h3>Maecenas luctus lectus</h3>
                        <p>Donec ornare neque ac sem. Mauris aliquet. Aliquam sem leo, vulputate sed, convallis at, ultricies quis, justo. Donec magna.</p>
                        <a href="#" class="button button-style1">Read More</a>
                    </section>
                    <section class="4u">
                        <span class="pennant"><span class="fa fa-globe"></span></span>
                        <h3>Maecenas luctus lectus</h3>
                        <p>Curabitur sit amet nulla. Nam in massa. Sed vel tellus. Curabitur sem urna, consequat vel, suscipit in, mattis placerat, nulla. Sed ac leo.</p>
                        <a href="#" class="button button-style1">Read More</a>
                    </section>

                </div>
            </div>
        </div>

    <!-- Main -->
        <div id="main">
        <div class="container">
            @yield('content', 'Default Content')
        </div>
 
    <!-- Tweet -->
        <div id="tweet">
            <div class="container">
                <section>
                    <blockquote>&ldquo;In posuere eleifend odio. Quisque semper augue mattis wisi. Maecenas ligula. Pellentesque viverra vulputate enim. Aliquam erat volutpat.&rdquo;</blockquote>
                </section>
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