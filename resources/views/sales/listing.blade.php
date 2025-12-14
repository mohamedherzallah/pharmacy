<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.9
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
    <base href="../../../" />
    <title>Metronic - Admin Dashboard</title>
    <meta charset="utf-8" />
    <meta name="description" content="Admin Dashboard" />
    <meta name="keywords" content="admin, dashboard, laravel" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Admin Dashboard" />
    <link rel="canonical" href="#" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "light";
    var themeMode;
    if ( document.documentElement ) {
        if ( document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if ( localStorage.getItem("data-bs-theme") !== null ) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Sidebar-->
            {{-- Sidebar --}}
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
                                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">Orders Listing</h1>
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
                                    <li class="breadcrumb-item text-muted">Orders</li>
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
                                        </i>Filter
                                    </a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_filter">
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
                                                    <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select status" data-dropdown-parent="#kt_menu_filter" data-allow-clear="true">
                                                        <option></option>
                                                        <option value="pending">Pending</option>
                                                        <option value="accepted">Accepted</option>
                                                        <option value="rejected">Rejected</option>
                                                        <option value="delivering">Delivering</option>
                                                        <option value="completed">Completed</option>
                                                    </select>
                                                </div>
                                                <!--end::Input-->
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
                            <!--begin::Orders-->
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
                                            <input type="text" data-kt-order-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search Order" />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Card title-->
                                    <!--begin::Card toolbar-->
                                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                        <!--begin::Flatpickr-->
                                        <div class="input-group w-250px">
                                            <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Pick date range" id="kt_orders_date_range" />
                                            <button class="btn btn-icon btn-light" id="kt_orders_date_clear">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </button>
                                        </div>
                                        <!--end::Flatpickr-->
                                        <div class="w-100 mw-150px">
                                            <!--begin::Select2-->
                                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-order-filter="status">
                                                <option></option>
                                                <option value="all">All</option>
                                                <option value="pending">Pending</option>
                                                <option value="accepted">Accepted</option>
                                                <option value="rejected">Rejected</option>
                                                <option value="delivering">Delivering</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                            <!--end::Select2-->
                                        </div>
                                    </div>
                                    <!--end::Card toolbar-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_orders_table">
                                        <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="text-start w-10px pe-2">
                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_orders_table .form-check-input" value="1" />
                                                </div>
                                            </th>
                                            <th class="min-w-100px">Order ID</th>
                                            <th class="min-w-150px">User</th>
                                            <th class="min-w-150px">Pharmacy</th>
                                            <th class="text-end min-w-100px">Status</th>
                                            <th class="text-end min-w-100px">Total Amount</th>
                                            <th class="text-end min-w-100px">Created At</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="text-start">
                                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="{{ $order->id }}" />
                                                    </div>
                                                </td>
                                                <td class="text-start">
                                                    <a href="{{ route('orders.show', $order->id) }}" class="text-gray-800 text-hover-primary fw-bold">#{{ $order->id }}</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Avatar-->
                                                        <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                            <div class="symbol-label bg-light-primary">
                                                                <span class="fs-4 text-primary">{{ substr($order->user->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <!--end::Avatar-->
                                                        <div class="ms-5">
                                                            <!--begin::Title-->
                                                            <a href="#" class="text-gray-800 text-hover-primary fs-6 fw-bold">{{ $order->user->name }}</a>
                                                            <!--end::Title-->
                                                            <!--begin::Email-->
                                                            <div class="text-muted fs-7">{{ $order->user->email }}</div>
                                                            <!--end::Email-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-gray-800 fw-bold">{{ $order->pharmacy->name ?? 'N/A' }}</span>
                                                </td>
                                                <td class="text-end pe-0">
                                                    <!--begin::Badges-->
                                                    @php
                                                        $statusColors = [
                                                            'pending' => 'warning',
                                                            'accepted' => 'primary',
                                                            'rejected' => 'danger',
                                                            'delivering' => 'info',
                                                            'completed' => 'success'
                                                        ];
                                                        $color = $statusColors[$order->status] ?? 'secondary';
                                                    @endphp
                                                    <div class="badge badge-light-{{ $color }}">{{ ucfirst($order->status) }}</div>
                                                    <!--end::Badges-->
                                                </td>
                                                <td class="text-end pe-0">
                                                    <span class="fw-bold">${{ number_format($order->total_amount, 2) }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <span class="fw-bold">{{ $order->created_at->format('d/m/Y') }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        Actions
                                                        <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('orders.show', $order->id) }}" class="menu-link px-3">View</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('orders.edit', $order->id) }}" class="menu-link px-3">Edit</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="menu-link px-3 bg-transparent border-0 text-start w-100" onclick="return confirm('Are you sure?')">Delete</button>
                                                            </form>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <!--end::Table-->

                                    <!--begin::Pagination-->
                                    @if($orders->hasPages())
                                        <div class="d-flex flex-stack flex-wrap pt-10">
                                            <div class="fs-6 fw-semibold text-gray-700">
                                                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                                            </div>
                                            <ul class="pagination">
                                                {{-- Previous Page Link --}}
                                                @if($orders->onFirstPage())
                                                    <li class="page-item previous disabled">
                                                        <a href="#" class="page-link"><i class="previous"></i></a>
                                                    </li>
                                                @else
                                                    <li class="page-item previous">
                                                        <a href="{{ $orders->previousPageUrl() }}" class="page-link"><i class="previous"></i></a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                                    @if($page == $orders->currentPage())
                                                        <li class="page-item active">
                                                            <a href="#" class="page-link">{{ $page }}</a>
                                                        </li>
                                                    @else
                                                        <li class="page-item">
                                                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach

                                                {{-- Next Page Link --}}
                                                @if($orders->hasMorePages())
                                                    <li class="page-item next">
                                                        <a href="{{ $orders->nextPageUrl() }}" class="page-link"><i class="next"></i></a>
                                                    </li>
                                                @else
                                                    <li class="page-item next disabled">
                                                        <a href="#" class="page-link"><i class="next"></i></a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    @endif
                                    <!--end::Pagination-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Orders-->
                        </div>
                        <!--end::Content container-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Content wrapper-->
            </div>
            <!--end::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::App-->

<!--begin::Javascript-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Javascript-->

<!--begin::Custom Javascript for this page-->
<script>
    // Initialize date picker
    flatpickr("#kt_orders_date_range", {
        mode: "range",
        dateFormat: "Y-m-d",
    });

    // Clear date range
    document.getElementById('kt_orders_date_clear').addEventListener('click', function() {
        document.getElementById('kt_orders_date_range').value = '';
    });

    // Search functionality
    document.querySelector('[data-kt-order-filter="search"]').addEventListener('keyup', function(e) {
        const searchValue = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('#kt_orders_table tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Status filter functionality
    document.querySelector('[data-kt-order-filter="status"]').addEventListener('change', function(e) {
        const status = e.target.value;
        const rows = document.querySelectorAll('#kt_orders_table tbody tr');

        rows.forEach(row => {
            if (status === 'all' || status === '') {
                row.style.display = '';
            } else {
                const statusCell = row.querySelector('.badge');
                const rowStatus = statusCell.textContent.trim().toLowerCase();
                row.style.display = rowStatus === status ? '' : 'none';
            }
        });
    });
</script>
<!--end::Custom Javascript for this page-->
</body>
<!--end::Body-->
</html>
