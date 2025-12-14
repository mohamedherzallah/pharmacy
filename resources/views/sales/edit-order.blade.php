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
    <base href="../../../" />
    <title>Metronic - تعديل الطلب</title>
    <meta charset="utf-8" />
    <meta name="description" content="The most advanced Tailwind CSS & Bootstrap 5 Admin Theme with 40 unique prebuilt layouts on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel versions. Grab your copy now and get life-time updates for free." />
    <meta name="keywords" content="tailwind, tailwindcss, metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Express.js, Node.js, Flask, Symfony & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Metronic - The World's #1 Selling Tailwind CSS & Bootstrap Admin Template by KeenThemes" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Metronic by Keenthemes" />
    <link rel="canonical" href="http://preview.keenthemes.comapps/ecommerce/sales/edit-order.html" />
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
    <script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Header-->
        >
        <!--end::Header-->
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
                                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">تعديل الطلب</h1>
                                <!--end::Title-->
                                <!--begin::Breadcrumb-->
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">
                                        <a href="index.html" class="text-muted text-hover-primary">الرئيسية</a>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">الطلبات</li>
                                    <!--end::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">تعديل الطلب</li>
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
                        <!--begin::Content container-->
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            <!--begin::Form-->
                            <form id="kt_ecommerce_edit_order_form" class="form d-flex flex-column flex-lg-row" action="{{ route('orders.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!--begin::Aside column-->
                                <div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">
                                    <!--begin::Order details-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>تفاصيل الطلب</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <div class="d-flex flex-column gap-10">
                                                <!--begin::Input group-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">رقم الطلب</label>
                                                    <!--end::Label-->
                                                    <!--begin::Auto-generated ID-->
                                                    <div class="fw-bold fs-3">#{{ $order->id }}</div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="required form-label">الحالة</label>
                                                    <!--end::Label-->
                                                    <!--begin::Select2-->
                                                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" name="status" id="status">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                                        <option value="accepted" {{ $order->status == 'accepted' ? 'selected' : '' }}>مقبول</option>
                                                        <option value="rejected" {{ $order->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                                        <option value="delivering" {{ $order->status == 'delivering' ? 'selected' : '' }}>قيد التوصيل</option>
                                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                    </select>
                                                    <!--end::Select2-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">إجمالي المبلغ</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fw-bold fs-4">{{ number_format($order->total_amount, 2) }} ريال</div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">تاريخ الطلب</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="fw-bold fs-6">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Input group-->
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label">الملاحظات</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <textarea class="form-control" name="notes" rows="3" placeholder="أضف ملاحظات هنا">{{ $order->notes }}</textarea>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                @if($order->prescription_file)
                                                    <!--begin::Input group-->
                                                    <div class="fv-row">
                                                        <!--begin::Label-->
                                                        <label class="form-label">الوصفة الطبية</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <a href="{{ asset('storage/' . $order->prescription_file) }}" target="_blank" class="btn btn-light-primary btn-sm">
                                                            <i class="ki-duotone ki-download fs-2 me-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            عرض الوصفة
                                                        </a>
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--end::Input group-->
                                                @endif
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Order details-->
                                </div>
                                <!--end::Aside column-->
                                <!--begin::Main column-->
                                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
                                    <!--begin::Order details-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>الأدوية المطلوبة</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Table-->
                                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_edit_order_product_table">
                                                <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="w-25px pe-2">#</th>
                                                    <th class="min-w-200px">الدواء</th>
                                                    <th class="min-w-100px text-center">الكمية</th>
                                                    <th class="min-w-100px text-center">السعر</th>
                                                    <th class="min-w-100px text-center">الإجمالي</th>
                                                </tr>
                                                </thead>
                                                <tbody class="fw-semibold text-gray-600">
                                                @foreach($order->items as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Thumbnail-->
                                                                <a href="#" class="symbol symbol-50px">
                                                                    <span class="symbol-label" style="background-image:url(assets/media//stock/ecommerce/{{ ($index % 30) + 1 }}.png);"></span>
                                                                </a>
                                                                <!--end::Thumbnail-->
                                                                <div class="ms-5">
                                                                    <!--begin::Title-->
                                                                    <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $item->medicine->name ?? 'دواء محذوف' }}</a>
                                                                    <!--end::Title-->
                                                                    <!--begin::SKU-->
                                                                    <div class="text-muted fs-7">الكود: {{ $item->medicine->code ?? 'N/A' }}</div>
                                                                    <!--end::SKU-->
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="number" name="items[{{ $item->id }}][quantity]" value="{{ $item->quantity }}" min="1" class="form-control form-control-solid w-100px text-center" data-price="{{ $item->price }}" onchange="updateItemTotal(this)">
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="fw-bold">{{ number_format($item->price, 2) }} ريال</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="fw-bold item-total">{{ number_format($item->quantity * $item->price, 2) }} ريال</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end fw-bold fs-5">المجموع الكلي:</td>
                                                    <td class="text-center fw-bold fs-5" id="total-amount">{{ number_format($order->total_amount, 2) }} ريال</td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            <!--end::Table-->
                                            <!--begin::Actions-->
                                            <div class="d-flex justify-content-end mt-5">
                                                <button type="button" onclick="calculateTotal()" class="btn btn-light me-3">إعادة حساب</button>
                                                <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                                            </div>
                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Order details-->
                                    <!--begin::Order details-->
                                    <div class="card card-flush py-4">
                                        <!--begin::Card header-->
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>معلومات العميل</h2>
                                            </div>
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body pt-0">
                                            <!--begin::Info-->
                                            <div class="d-flex flex-column gap-5">
                                                <!--begin::User info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
																<span class="symbol-label bg-light-primary">
																	<span class="fs-2 fw-bold text-primary">{{ substr($order->user->name, 0, 1) }}</span>
																</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column">
                                                        <span class="fs-4 fw-bold text-gray-900">{{ $order->user->name }}</span>
                                                        <span class="fs-6 text-muted">{{ $order->user->email }}</span>
                                                        <span class="fs-6 text-muted">{{ $order->user->phone ?? 'لا يوجد رقم هاتف' }}</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::User info-->
                                                <!--begin::Pharmacy info-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px me-5">
																<span class="symbol-label bg-light-success">
																	<span class="fs-2 fw-bold text-success">ص</span>
																</span>
                                                    </div>
                                                    <!--end::Avatar-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-column">
                                                        <span class="fs-4 fw-bold text-gray-900">{{ $order->pharmacy->name ?? 'صيدلية غير محددة' }}</span>
                                                        <span class="fs-6 text-muted">{{ $order->pharmacy->address ?? 'لا يوجد عنوان' }}</span>
                                                        <span class="fs-6 text-muted">{{ $order->pharmacy->phone ?? 'لا يوجد رقم هاتف' }}</span>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Pharmacy info-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Card header-->
                                    </div>
                                    <!--end::Order details-->
                                </div>
                                <!--end::Main column-->
                            </form>
                            <!--end::Form-->
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
<script>
    // Function to update item total
    function updateItemTotal(input) {
        const price = parseFloat(input.getAttribute('data-price'));
        const quantity = parseInt(input.value);
        const total = price * quantity;

        const row = input.closest('tr');
        const totalCell = row.querySelector('.item-total');
        totalCell.textContent = total.toFixed(2) + ' ريال';

        calculateTotal();
    }

    // Function to calculate total amount
    function calculateTotal() {
        let total = 0;
        const itemTotals = document.querySelectorAll('.item-total');

        itemTotals.forEach(item => {
            const itemTotal = parseFloat(item.textContent.replace(' ريال', ''));
            total += itemTotal;
        });

        document.getElementById('total-amount').textContent = total.toFixed(2) + ' ريال';
        document.querySelector('input[name="total_amount"]').value = total.toFixed(2);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
    });
</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Vendors Javascript(used for this page only)-->
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="assets/js/custom/apps/ecommerce/sales/save-order.js"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
