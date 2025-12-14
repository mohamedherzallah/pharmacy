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
    <meta name="keywords" content="pharmacy, management, laravel, admin" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Pharmacy Management System" />
    <meta property="og:url" content="{{asset('https://keenthemes.com/metronic')}}" />
    <meta property="og:site_name" content="Pharmacy System" />
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
                                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Pharmacies</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my -0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
{{--                                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">Home</a>--}}
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">Management</li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">Pharmacies</li>
                                    <!--end::Item-->
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                <!--begin::Filter menu-->
                                <div class="m-0">
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Filter</a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_673c0cc2ee796">
                                        <!--begin::Header-->
                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                        </div>
                                        <!--end::Header-->
                                        <!--begin::Menu separator-->
                                        <div class="separator border-gray-200"></div>
                                        <!--end::Menu separator-->
                                        <!--begin::Form-->
                                        <div class="px-7 py-5">
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold">Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <div>
                                                    <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_673c0cc2ee796" data-allow-clear="true">
                                                        <option></option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Input group-->
                                            <div class="mb-10">
                                                <!--begin::Label-->
                                                <label class="form-label fw-semibold">Approval Status:</label>
                                                <!--end::Label-->
                                                <!--begin::Options-->
                                                <div class="d-flex">
                                                    <!--begin::Options-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                        <input class="form-check-input" type="checkbox" value="1" />
                                                        <span class="form-check-label">Approved</span>
                                                    </label>
                                                    <!--end::Options-->
                                                    <!--begin::Options-->
                                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="0" />
                                                        <span class="form-check-label">Pending</span>
                                                    </label>
                                                    <!--end::Options-->
                                                </div>
                                                <!--end::Options-->
                                            </div>
                                            <!--end::Input group-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end">
                                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Menu 1-->
                                </div>
                                <!--end::Filter menu-->
                                <!--begin::Primary button-->
                                <a href="{{ route('pharmacies.create') }}" class="btn btn-sm fw-bold btn-primary">Add Pharmacy</a>
                                <!--end::Primary button-->
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Toolbar container-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            <!--begin::Pharmacies Table-->
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" id="searchInput" class="form-control form-control-solid w-250px ps-12" placeholder="Search Pharmacy..." />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar">
                                        <!--begin::Add pharmacy-->
                                        <a href="{{ route('pharmacies.create') }}" class="btn btn-primary">Add Pharmacy</a>
                                        <!--end::Add pharmacy-->
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_pharmacies_table">
                                        <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px pe-2">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                           data-kt-check-target="#kt_pharmacies_table .form-check-input" />
                                                </div>
                                            </th>
                                            <th class="min-w-200px">Pharmacy</th>
                                            <th class="min-w-150px">Owner</th>
                                            <th class="min-w-200px">Address</th>
                                            <th class="min-w-100px">Status</th>
                                            <th class="min-w-100px">Approval</th>
                                            <th class="min-w-100px">Medicines</th>
                                            <th class="min-w-100px">Orders</th>
                                            <th class="text-end min-w-70px">Actions</th>
                                        </tr>
                                        </thead>

                                        <tbody class="fw-semibold text-gray-600">
                                        @foreach ($pharmacies as $pharmacy)
                                            <tr>
                                                <td>
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="{{ $pharmacy->id }}" />
                                                    </div>
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Logo -->
                                                        @if($pharmacy->logo)
                                                            <div class="symbol symbol-50px me-5">
                                                                <img src="{{ asset('storage/' . $pharmacy->logo) }}"
                                                                     class="rounded" alt="{{ $pharmacy->pharmacy_name }}"
                                                                     style="object-fit: cover; width: 50px; height: 50px;" />
                                                            </div>
                                                        @else
                                                            <div class="symbol symbol-50px me-5 bg-light-primary">
                                                                <div class="symbol-label fs-3 text-primary">
                                                                    <i class="ki-duotone ki-hospital"></i>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <!-- Pharmacy Info -->
                                                        <div class="d-flex flex-column">
                                                            <a href="{{ route('pharmacies.show', $pharmacy->id) }}"
                                                               class="text-gray-800 text-hover-primary fw-bold mb-1">
                                                                {{ $pharmacy->pharmacy_name ?? 'No Name' }}
                                                            </a>
                                                            <span class="text-muted">ID: {{ $pharmacy->id }}</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    @if($pharmacy->user)
                                                        <div class="d-flex flex-column">
                                                            <span class="fw-bold">{{ $pharmacy->user->name ?? 'N/A' }}</span>
                                                            <span class="text-muted">{{ $pharmacy->user->email ?? '' }}</span>
                                                            <span class="text-muted fs-7">{{ $pharmacy->user->phone ?? '' }}</span>
                                                        </div>
                                                    @else
                                                        <span class="text-muted">No Owner</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-gray-800 mb-1">{{ $pharmacy->address ?? 'No Address' }}</span>
                                                        @if($pharmacy->latitude && $pharmacy->longitude)
                                                            <span class="text-muted fs-7">
                                                                        <i class="ki-duotone ki-geolocation fs-4 text-primary me-1"></i>
                                                                        {{ $pharmacy->latitude }}, {{ $pharmacy->longitude }}
                                                                    </span>
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>
                                                    @if($pharmacy->user && $pharmacy->user->status == 'active')
                                                        <span class="badge badge-light-success">Active</span>
                                                    @else
                                                        <span class="badge badge-light-danger">Inactive</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if($pharmacy->is_approved)
                                                        <span class="badge badge-light-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <span class="badge badge-light-info">{{ $pharmacy->medicines_count ?? 0 }} Items</span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-light-primary">{{ $pharmacy->orders_count ?? 0 }} Orders</span>
                                                </td>

                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center"
                                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                    </a>

                                                    <!-- Dropdown Menu -->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                                                menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">

                                                        <!-- View -->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('pharmacies.show', $pharmacy->id) }}" class="menu-link px-3">
                                                                <i class="ki-duotone ki-eye fs-4 me-2"></i>
                                                                View
                                                            </a>
                                                        </div>

                                                        <!-- Edit -->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('pharmacies.edit', $pharmacy->id) }}" class="menu-link px-3">
                                                                <i class="ki-duotone ki-pencil fs-4 me-2"></i>
                                                                Edit
                                                            </a>
                                                        </div>

                                                        <!-- Delete -->
                                                        <div class="menu-item px-3">
                                                            <form method="POST" action="{{ route('pharmacies.destroy', $pharmacy->id) }}" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="menu-link px-3 bg-transparent border-0 p-0 text-start w-100"
                                                                        onclick="return confirm('Are you sure you want to delete this pharmacy?')">
                                                                    <i class="ki-duotone ki-trash fs-4 me-2"></i>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--end::Table-->

                                    <!--begin::Pagination-->
                                    @if($pharmacies->hasPages())
                                        <div class="d-flex justify-content-between align-items-center pt-5">
                                            <div class="text-muted fs-7">
                                                Showing
                                                <span class="fw-bold">{{ $pharmacies->firstItem() }}</span>
                                                to
                                                <span class="fw-bold">{{ $pharmacies->lastItem() }}</span>
                                                of
                                                <span class="fw-bold">{{ $pharmacies->total() }}</span>
                                                entries
                                            </div>
                                            <div>
                                                {{ $pharmacies->links() }}
                                            </div>
                                        </div>
                                    @endif
                                    <!--end::Pagination-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Pharmacies Table-->
                        </div>
                        <!--end::Content container-->
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
                        <!--begin::Menu-->
                        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                            <li class="menu-item">
                                <a href="https://keenthemes.com" target="_blank" class="menu-link px-2">About</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://devs.keenthemes.com" target="_blank" class="menu-link px-2">Support</a>
                            </li>
                            <li class="menu-item">
                                <a href="https://1.envato.market/Vm7VRE" target="_blank" class="menu-link px-2">Purchase</a>
                            </li>
                        </ul>
                        <!--end::Menu-->
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

<!-- Scrolltop and other drawers remain the same... -->

<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script>
    // Simple search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("kt_pharmacies_table");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    }
                }
            }
        }
    });

    // Bulk actions
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.querySelector('[data-kt-check="true"]');
        const checkboxes = document.querySelectorAll('#kt_pharmacies_table .form-check-input:not([data-kt-check="true"])');

        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });
</script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
