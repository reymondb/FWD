<!DOCTYPE html>
<!--  This site was created in Webflow. http://www.webflow.com  -->
<!--  Last Published: Wed May 20 2020 16:50:31 GMT+0000 (Coordinated Universal Time)  -->
<html data-wf-page="5ec29d102100e50acf8345d8" data-wf-site="5ec29d102100e54eaf8345d7">
    <head>
    <meta content="@yield('og')" property="og:title">
    <meta content="@yield('twitter')" property="twitter:title">  
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Webflow" name="generator">
    
    <link href="/css/fwd.webflow.css" rel="stylesheet" type="text/css">
    <script src="https://use.typekit.net/cmh4dsx.js" type="text/javascript"></script>
    <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
    <!-- [if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script><![endif] -->
    <script type="text/javascript">!function(o,c){var n=c.documentElement,t=" w-mod-";n.className+=t+"js",("ontouchstart"in o||o.DocumentTouch&&c instanceof DocumentTouch)&&(n.className+=t+"touch")}(window,document);</script>
    <link href="/images/favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="/images/webclip.png" rel="apple-touch-icon">
    
    <link href="/css/styles.css" rel="stylesheet" />
    <link href="/css/custom.css" rel="stylesheet" />
    <script src="//code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    
    @yield('css')
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark" style="background-color: #f28438 !important;">
            <a class="navbar-brand" href="/">FWD</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button
            ><!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                  <!--  <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>!-->
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <!--<a class="dropdown-item" href="#">Settings</a><a class="dropdown-item" href="#">Activity Log</a>!-->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="/logout">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
            <div id="layoutSidenav">
                <div id="layoutSidenav_nav">
                    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background-color: #6748af;">
                        <div class="sb-sidenav-menu">
                            <div class="nav">
                                <a class="nav-link" href="/dashboard"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>
                                <a class="nav-link" href="/import"><div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                                    Migrate Leads
                                </a>
                                <a class="nav-link" href="/campaigns"><div class="sb-nav-link-icon"><i class="fas fa-headset"></i></div>
                                    Campaigns
                                </a>
                            </div>
                        </div>
                        <div class="sb-sidenav-footer">
                            
                        </div>
                    </nav>
                </div>
                <div id="layoutSidenav_content">
            @yield('content')
                    
        </div>
        </div>
        
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/js/scripts.js"></script>
            
        <link rel="stylesheet" href="{{ asset('/css/loader.css') }}">
        

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <!-- #region datatables files -->
    
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css " />
        
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    
        <script src="//cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
        <script src="//cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js "></script>
    
        <!-- #endregion -->

        
        <script src="/js/webflow.js" type="text/javascript"></script>
        <script src="/js/custom.js" type="text/javascript"></script>
        
        <!-- include timepickers !-->
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script src="/js/custom.js"></script>
        
        <script src='/js/spectrum.js'></script>
        <link rel='stylesheet' href='/css/spectrum.css' />
        <!-- [if lte IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif] -->
        
        <script>
            $(document).ready(function(){
                $( "input.date-picker" ).datepicker({changeMonth: true,changeYear: true    });
                $('input.timepicker').timepicker({});
            });

        </script> 
        @yield('js')
    </body>
</html>