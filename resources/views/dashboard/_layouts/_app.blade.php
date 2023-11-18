<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        {{ ((@$title != null) ? $title : "null" ) . " | " . env('APP_NAME') }}
    </title>
    <link rel="icon" href="/favicon.ico">
    <link href="/style.css" rel="stylesheet">

    <!-- BEGIN: CSS-->
    @stack('styles')
    <!-- END: CSS-->
</head>

<body x-data="{ page: '{{ ((@$title != null) ? $title : " null" ) }}', 'loaded' : true, 'darkMode' : true, 'stickyMenu'
    : false, 'sidebarToggle' : false, 'scrollTop' : false }" x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark text-bodydark bg-boxdark-2': darkMode === true}">
    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent">
        </div>
    </div>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
        <!-- ===== Sidebar Start ===== -->
        {{-- check user role --}}
        @if (session('role') == 'admin')
        @include('dashboard._layouts._sidebar_admin')
        @else
        @include('dashboard._layouts._sidebar')
        @endif
        <!-- ===== Sidebar End ===== -->

        <!-- ===== Content Area Start ===== -->
        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
            <!-- ===== Header Start ===== -->
            @include('dashboard._layouts._header')
            <!-- ===== Header End ===== -->

            <!-- ===== Main Content Start ===== -->
            @yield('content')
            <!-- ===== Main Content End ===== -->
        </div>
        <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
    <script defer src="/bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- BEGIN: JS-->
    <script>
        'use strict';
        $.ajaxSetup({
            beforeSend: function(xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer {{ session('auth_token') }}');
            }
        });
        console.log('Bearer {{ session('auth_token') }}');
    </script>
    @stack('scripts')
    <!-- END: JS-->
</body>

</html>