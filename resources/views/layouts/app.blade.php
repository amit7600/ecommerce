<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>@lang('language.appName')</title>
    <!-- Favicon-->
    <link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon">

    @include('includes.styleSRC')
    @include('includes.javascripts')
</head>

<body class="theme-red">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>@lang('language.please_wait')</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">@lang('language.search')</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
        @include('includes.header')
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        @include('includes.sidebar')
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        @include('includes.right_sidebar')
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div id="errorAlertMessage"></div>
        @yield('content')
    </section>

   
</body>

</html>
