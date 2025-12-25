<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic
Product Version: 8.2.9
-->
<html lang="ar" dir="rtl">
<head>
    <base href="../../../" />
    <title>{{ config('app.name') }} - إنشاء طلب جديد</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="ar_SA" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <style>
        .product-quantity {
            width: 80px;
        }
        .selected-products-container {
            max-height: 300px;
            overflow-y: auto;
        }
        .medicine-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .medicine-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true"
      data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true"
      class="app-default">

<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <!--begin::Page-->
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        <!--begin::Wrapper-->
        <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
            <!--begin::Main-->
            {{-- Sidebar --}}
            @include('layouts.partials.sidebar')
            <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                <!--begin::Content wrapper-->
                <div class="d-flex flex-column flex-column-fluid">
                    <!--begin::Toolbar-->
                    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                                    إنشاء طلب جديد
                                </h1>
                                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                    <li class="breadcrumb-item text-muted">
                                        <a href="" class="text-muted text-hover-primary">الرئيسية</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">
                                        <a href="{{ route('orders.index') }}" class="text-muted text-hover-primary">الطلبات</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                                    </li>
                                    <li class="breadcrumb-item text-muted">إنشاء طلب</li>
                                </ul>
                            </div>
                            <!--end::Page title-->
                        </div>
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Content-->
                    <div id="kt_app_content" class="app-content flex-column-fluid">
                        <div id="kt_app_content_container" class="app-container container-xxl">
                            <!--begin::Form-->
                            <form id="kt_ecommerce_add_order_form" class="form d-flex flex-column flex-lg-row"
                                  method="POST" action="{{ route('orders.store') }}" enctype="multipart/form-data">
                                @csrf

                                <!--begin::Aside column-->
                                <div class="w-100 flex-lg-row-auto w-lg-300px mb-7 me-7 me-lg-10">
                                    <!--begin::Order details-->
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>معلومات الطلب</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="d-flex flex-column gap-10">
                                                <!--begin::Pharmacy Selection-->
                                                <div class="fv-row">
                                                    <label class="required form-label">الصيدلية</label>
                                                    <select class="form-select mb-2" data-control="select2"
                                                            name="pharmacy_id" required>
                                                        <option value="">اختر الصيدلية</option>
                                                        @foreach($pharmacies as $pharmacy)
                                                            <option value="{{ $pharmacy->id }}">
                                                                {{ $pharmacy->pharmacy_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-muted fs-7">اختر الصيدلية التي تريد الطلب منها</div>
                                                </div>
                                                <!--end::Pharmacy Selection-->

                                                <!--begin::Status-->
                                                <div class="fv-row">
                                                    <label class="required form-label">حالة الطلب</label>
                                                    <select class="form-select mb-2" name="status" required>
                                                        <option value="pending">قيد الانتظار</option>
                                                        <option value="accepted">مقبول</option>
                                                        <option value="rejected">مرفوض</option>
                                                        <option value="delivering">قيد التوصيل</option>
                                                        <option value="completed">مكتمل</option>
                                                    </select>
                                                </div>
                                                <!--end::Status-->

                                                <!--begin::Notes-->
                                                <div class="fv-row">
                                                    <label class="form-label">ملاحظات</label>
                                                    <textarea class="form-control" name="notes" rows="3"
                                                              placeholder="أضف أي ملاحظات خاصة بالطلب"></textarea>
                                                </div>
                                                <!--end::Notes-->

                                                <!--begin::Prescription Upload-->
                                                <div class="fv-row">
                                                    <label class="form-label">رفع الوصفة الطبية</label>
                                                    <input type="file" class="form-control" name="prescription_file"
                                                           accept=".pdf,.jpg,.jpeg,.png">
                                                    <div class="text-muted fs-7">يمكنك رفع الوصفة الطبية بصيغة PDF أو صورة</div>
                                                </div>
                                                <!--end::Prescription Upload-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Order details-->
                                </div>
                                <!--end::Aside column-->

                                <!--begin::Main column-->
                                <div class="d-flex flex-column flex-lg-row-fluid gap-7 gap-lg-10">
                                    <!--begin::Products selection-->
                                    <div class="card card-flush py-4">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h2>اختيار الأدوية</h2>
                                            </div>
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="d-flex flex-column gap-10">
                                                <!--begin::Selected products-->
                                                <div>
                                                    <label class="form-label">الأدوية المختارة</label>
                                                    <div class="border border-dashed rounded pt-3 pb-1 px-2 mb-5 selected-products-container"
                                                         id="kt_ecommerce_selected_products">
                                                        <!--begin::Empty message-->
                                                        <span class="w-100 text-muted text-center d-block">
                                                                لم يتم اختيار أي أدوية بعد
                                                            </span>
                                                        <!--end::Empty message-->
                                                    </div>
                                                    <!--begin::Total price-->
                                                    <div class="fw-bold fs-4 text-primary">المبلغ الإجمالي:
                                                        <span id="kt_ecommerce_total_price">0.00</span> ر.س
                                                    </div>
                                                    <!--end::Total price-->
                                                    <!-- Hidden input for total amount -->
                                                    <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                                                </div>
                                                <!--end::Selected products-->

                                                <!--begin::Separator-->
                                                <div class="separator"></div>
                                                <!--end::Separator-->

                                                <!--begin::Search medicines-->
                                                <div class="d-flex align-items-center position-relative mb-7">
                                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="text" id="medicine_search"
                                                           class="form-control form-control-solid w-100 ps-12"
                                                           placeholder="ابحث عن دواء بالاسم أو الرمز" />
                                                </div>
                                                <!--end::Search medicines-->

                                                <!--begin::Medicines list-->
                                                <div class="row g-5" id="medicines_list">
                                                    @foreach($medicines as $medicine)
                                                        <div class="col-md-4 col-sm-6 medicine-item"
                                                             data-name="{{ strtolower($medicine->name) }}"
                                                             data-code="{{ strtolower($medicine->code) }}">
                                                            <div class="card card-bordered">
                                                                <div class="card-body">
                                                                    <div class="d-flex align-items-center mb-3">
                                                                        <div class="symbol symbol-50px me-3">
                                                                                <span class="symbol-label"
                                                                                      style="background-image:url('{{ $medicine->image_url ?? 'assets/media/stock/ecommerce/1.png' }}');">
                                                                                </span>
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="card-title mb-1">
                                                                                {{ $medicine->name }}
                                                                            </h5>
                                                                            <div class="text-muted fs-7">
                                                                                الرمز: {{ $medicine->code }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="fw-semibold fs-6">
                                                                            السعر: <span class="medicine-price">{{ number_format($medicine->price, 2) }}</span> ر.س
                                                                        </div>
                                                                        <div class="text-muted fs-7">
                                                                            الكمية المتاحة: <span class="text-primary">{{ $medicine->quantity }}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <input type="number"
                                                                               class="form-control form-control-solid product-quantity me-2"
                                                                               value="1" min="1" max="{{ $medicine->quantity }}"
                                                                               data-medicine-id="{{ $medicine->id }}"
                                                                               data-price="{{ $medicine->price }}">
                                                                        <button type="button"
                                                                                class="btn btn-primary btn-sm add-to-order-btn"
                                                                                data-medicine-id="{{ $medicine->id }}"
                                                                                data-medicine-name="{{ $medicine->name }}"
                                                                                data-medicine-price="{{ $medicine->price }}"
                                                                                data-max-quantity="{{ $medicine->quantity }}">
                                                                            <i class="ki-duotone ki-plus fs-2"></i> إضافة
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!--end::Medicines list-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Products selection-->

                                    <!--begin::Form actions-->
                                    <div class="card card-flush py-4">
                                        <div class="card-footer d-flex justify-content-end">
                                            <a href="{{ route('orders.index') }}" class="btn btn-light me-3">إلغاء</a>
                                            <button type="submit" class="btn btn-primary" id="submit_order_btn">
                                                <span class="indicator-label">إنشاء الطلب</span>
                                                <span class="indicator-progress">
                                                        جاري الإنشاء... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                            </button>
                                        </div>
                                    </div>
                                    <!--end::Form actions-->
                                </div>
                                <!--end::Main column-->
                            </form>
                            <!--end::Form-->
                        </div>
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
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Javascript-->

<script>
    $(document).ready(function() {
        let selectedMedicines = [];
        let totalAmount = 0;

        // Search functionality
        $('#medicine_search').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.medicine-item').each(function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                if (name.includes(searchTerm) || code.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Add medicine to order
        $(document).on('click', '.add-to-order-btn', function() {
            const medicineId = $(this).data('medicine-id');
            const medicineName = $(this).data('medicine-name');
            const medicinePrice = parseFloat($(this).data('medicine-price'));
            const maxQuantity = parseInt($(this).data('max-quantity'));
            const quantityInput = $(this).siblings('.product-quantity');
            let quantity = parseInt(quantityInput.val());

            // Validate quantity
            if (quantity < 1) {
                quantity = 1;
                quantityInput.val(1);
            }

            if (quantity > maxQuantity) {
                alert(`الكمية المتاحة فقط ${maxQuantity}`);
                quantity = maxQuantity;
                quantityInput.val(maxQuantity);
            }

            // Check if medicine already exists in order
            const existingIndex = selectedMedicines.findIndex(item => item.id === medicineId);

            if (existingIndex > -1) {
                // Update existing item
                selectedMedicines[existingIndex].quantity += quantity;
                selectedMedicines[existingIndex].total = selectedMedicines[existingIndex].quantity * medicinePrice;

                // Update quantity in input
                $(`input[name="medicines[${medicineId}][quantity]"]`).val(selectedMedicines[existingIndex].quantity);
            } else {
                // Add new item
                const medicineItem = {
                    id: medicineId,
                    name: medicineName,
                    price: medicinePrice,
                    quantity: quantity,
                    total: quantity * medicinePrice
                };
                selectedMedicines.push(medicineItem);
            }

            updateSelectedProducts();
            updateTotalAmount();
        });

        // Remove medicine from order
        $(document).on('click', '.remove-medicine-btn', function() {
            const medicineId = parseInt($(this).data('medicine-id'));
            selectedMedicines = selectedMedicines.filter(item => item.id !== medicineId);
            updateSelectedProducts();
            updateTotalAmount();
        });

        // Update quantity in order
        $(document).on('change', '.order-item-quantity', function() {
            const medicineId = parseInt($(this).data('medicine-id'));
            const newQuantity = parseInt($(this).val());
            const medicine = selectedMedicines.find(item => item.id === medicineId);

            if (medicine && newQuantity > 0) {
                medicine.quantity = newQuantity;
                medicine.total = medicine.quantity * medicine.price;
                updateSelectedProducts();
                updateTotalAmount();
            }
        });

        // Function to update selected products display
        function updateSelectedProducts() {
            const container = $('#kt_ecommerce_selected_products');
            container.empty();

            if (selectedMedicines.length === 0) {
                container.html('<span class="w-100 text-muted text-center d-block">لم يتم اختيار أي أدوية بعد</span>');
                return;
            }

            selectedMedicines.forEach(medicine => {
                const itemHtml = `
                        <div class="d-flex align-items-center justify-content-between mb-3 selected-medicine-item"
                             data-medicine-id="${medicine.id}">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <h6 class="mb-1">${medicine.name}</h6>
                                    <div class="text-muted fs-7">السعر: ${medicine.price.toFixed(2)} ر.س</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <input type="number"
                                       class="form-control form-control-sm order-item-quantity me-2"
                                       value="${medicine.quantity}"
                                       min="1"
                                       data-medicine-id="${medicine.id}"
                                       style="width: 80px;">
                                <div class="fw-bold me-3" style="min-width: 80px;">
                                    ${medicine.total.toFixed(2)} ر.س
                                </div>
                                <button type="button"
                                        class="btn btn-icon btn-sm btn-light-danger remove-medicine-btn"
                                        data-medicine-id="${medicine.id}">
                                    <i class="ki-duotone ki-trash fs-2"></i>
                                </button>
                            </div>
                        </div>
                    `;
                container.append(itemHtml);
            });
        }

        // Function to update total amount
        function updateTotalAmount() {
            totalAmount = selectedMedicines.reduce((sum, medicine) => sum + medicine.total, 0);
            $('#kt_ecommerce_total_price').text(totalAmount.toFixed(2));
            $('#total_amount_input').val(totalAmount);
        }

        // Form submission
        $('#kt_ecommerce_add_order_form').on('submit', function(e) {
            if (selectedMedicines.length === 0) {
                e.preventDefault();
                alert('يرجى اختيار دواء واحد على الأقل');
                return false;
            }

            // Add hidden inputs for selected medicines
            selectedMedicines.forEach(medicine => {
                $(this).append(`
                        <input type="hidden" name="medicines[${medicine.id}][medicine_id]" value="${medicine.id}">
                        <input type="hidden" name="medicines[${medicine.id}][quantity]" value="${medicine.quantity}">
                        <input type="hidden" name="medicines[${medicine.id}][price]" value="${medicine.price}">
                    `);
            });

            // Show loading indicator
            $('#submit_order_btn').attr('data-kt-indicator', 'on');
        });
    });
</script>
</body>
</html>
