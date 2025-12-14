<!DOCTYPE html>
<html lang="en">
<head>
    <base href="../../" />
    <title>@yield('title', 'Admin Panel')</title>
    <meta charset="utf-8" />
    <meta name="description" content="Pharmacy Management System" />
    <meta name="keywords" content="pharmacy, management, laravel, admin" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body id="kt_app_body"
      data-kt-app-layout="light-sidebar"
      data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true"
      data-kt-app-sidebar-fixed="true"
      data-kt-app-sidebar-hoverable="true"
      data-kt-app-sidebar-push-header="true"
      data-kt-app-sidebar-push-toolbar="true"
      data-kt-app-sidebar-push-footer="true"
      data-kt-app-toolbar-enabled="true"
      class="app-default">

<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')

            {{-- Main --}}
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <div class="d-flex flex-column flex-column-fluid">

                    {{-- Header --}}
                    @include('layouts.partials.header')

                    {{-- Content --}}
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            @yield('content')
                        </div>
                    </div>

                </div>

                {{-- Footer --}}


            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

@stack('scripts')
</body>
</html>
