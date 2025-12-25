<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: MetronicProduct Version: 8.2.9
Purchase: https://1.envato.market/Vm7VRE
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../../" />
    <title>Metronic - Pharmacy Management</title>
    <meta charset="utf-8" />
    <meta name="description" content="Pharmacy Management System" />
    <meta name="keywords" content="pharmacy, management, system" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Pharmacy Management System" />
    <meta property="og:url" content="{{asset('https://keenthemes.com/metronic')}}" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="{{ asset('http://preview.keenthemes.comapps/customers/list.html') }}" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700')}}" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="light-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        <!--end::Header-->
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            @include('layouts.partials.sidebar')
            <!--end::Sidebar-->
            <!--begin::Main-->
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                        <!--begin::Toolbar container-->
                        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                <!--begin::Title-->
                                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Add Pharmacy</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="index.html" class="text-muted text-hover-primary">Home</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">Pharmacy Management</li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">Add Pharmacy</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-xxl">


                            <!-- الفورم مع الربط باللارافل -->
                            <form id="kt_pharmacy_add_form"
                                  class="form d-flex flex-column gap-10"
                                  action="{{ route('pharmacies.store') }}"
                                  method="POST"
                                  enctype="multipart/form-data">

                                @csrf

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!-- معلومات الصيدلية الأساسية -->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Pharmacy Information</h2>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-6 mb-5">
                                                <label class="required form-label">Pharmacy Name</label>
                                                <input type="text" name="pharmacy_name" class="form-control" placeholder="Enter pharmacy name" required />
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="required form-label">Address</label>
                                                <input type="text" name="address" class="form-control" placeholder="Enter full address" required />
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="form-label">Latitude</label>
                                                <input type="text" name="latitude" class="form-control" placeholder="e.g., 24.7136" />
                                                <div class="text-muted fs-7 mt-1">Optional - For map location</div>
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="form-label">Longitude</label>
                                                <input type="text" name="longitude" class="form-control" placeholder="e.g., 46.6753" />
                                                <div class="text-muted fs-7 mt-1">Optional - For map location</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- معلومات المستخدم -->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>User Account Information</h2>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-6 mb-5">
                                                <label class="required form-label">User Name</label>
                                                <input type="text" name="name" class="form-control" placeholder="Enter user's full name" required />
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="required form-label">Phone Number</label>
                                                <input type="tel" name="phone" class="form-control" placeholder="Enter phone number" required />
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" name="email" class="form-control" placeholder="Enter email address" />
                                            </div>

                                            <div class="col-md-6 mb-5">
                                                <label class="required form-label">Password</label>
                                                <input type="password" name="password" class="form-control" placeholder="Enter password" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- الصور -->
                                <div class="row">
                                    <!-- صورة الرخصة -->
                                    <div class="col-md-6">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>License Image</h2>
                                                </div>
                                            </div>

                                            <div class="card-body text-center pt-0">
                                                <style>
                                                    .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image.svg'); }
                                                    [data-bs-theme="dark"] .image-input-placeholder { background-image: url('assets/media/svg/files/blank-image-dark.svg'); }
                                                </style>

                                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                                    <div class="image-input-wrapper w-150px h-150px"></div>

                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                           data-kt-image-input-action="change">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span><span class="path2"></span>
                                                        </i>
                                                        <input type="file" name="license_image" accept=".png, .jpg, .jpeg, .pdf" />
                                                        <input type="hidden" name="license_image_remove" />
                                                    </label>

                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="cancel">
                                                                <i class="ki-duotone ki-cross fs-2">
                                                                    <span class="path1"></span><span class="path2"></span>
                                                                </i>
                                                            </span>

                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="remove">
                                                                <i class="ki-duotone ki-cross fs-2">
                                                                    <span class="path1"></span><span class="path2"></span>
                                                                </i>
                                                            </span>
                                                </div>

                                                <div class="text-muted fs-7">
                                                    Only *.png, *.jpg, *.jpeg or *.pdf files are accepted
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- شعار الصيدلية -->
                                    <div class="col-md-6">
                                        <div class="card card-flush py-4">
                                            <div class="card-header">
                                                <div class="card-title">
                                                    <h2>Pharmacy Logo</h2>
                                                </div>
                                            </div>

                                            <div class="card-body text-center pt-0">
                                                <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3" data-kt-image-input="true">
                                                    <div class="image-input-wrapper w-150px h-150px"></div>

                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                           data-kt-image-input-action="change">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span><span class="path2"></span>
                                                        </i>
                                                        <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="logo_remove" />
                                                    </label>

                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="cancel">
                                                                <i class="ki-duotone ki-cross fs-2">
                                                                    <span class="path1"></span><span class="path2"></span>
                                                                </i>
                                                            </span>

                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                          data-kt-image-input-action="remove">
                                                                <i class="ki-duotone ki-cross fs-2">
                                                                    <span class="path1"></span><span class="path2"></span>
                                                                </i>
                                                            </span>
                                                </div>

                                                <div class="text-muted fs-7">
                                                    Only *.png, *.jpg and *.jpeg files are accepted
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- حالة الموافقة -->
                                <div class="card card-flush py-4">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Approval Status</h2>
                                        </div>
                                    </div>

                                    <div class="card-body pt-0">
                                        <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" name="is_approved" value="1" id="is_approved" />
                                            <label class="form-check-label" for="is_approved">Approve this pharmacy immediately</label>
                                        </div>
                                        <div class="text-muted fs-7 mt-2">
                                            If checked, the pharmacy will be active immediately. Otherwise, it will need admin approval.
                                        </div>
                                    </div>
                                </div>

                                <!-- أزرار الإرسال -->
                                <div class="d-flex justify-content-end gap-5">
                                    <a href="{{ route('pharmacies.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="ki-duotone ki-check fs-2"></i>
                                        Save Pharmacy
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
                <!--begin::Footer-->
                <div id="kt_app_footer" class="app-footer">
                    <!--begin::Footer container-->
                    <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                        <!--begin::Copyright-->
                        <div class="text-gray-900 order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1">2024&copy;</span>
                            <a href="https://keenthemes.com" target="_blank" class="text-gray-800 text-hover-primary">Keenthemes</a>
                        </div>
                        <!--end::Copyright-->
                    </div>
                    <!--end::Footer container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->

<!--begin::Javascript-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Javascript-->
</body>
</html>
