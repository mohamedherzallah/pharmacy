<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة الطلبات</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --success-color: #1cc88a;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --info-color: #36b9cc;
        }
        body {
            background-color: #f8f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }
        .table th {
            font-weight: 600;
            border-top: none;
        }
        .status-badge {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.35rem;
        }
        .status-pending { background-color: #f6c23e; color: #000; }
        .status-accepted { background-color: #1cc88a; color: #fff; }
        .status-rejected { background-color: #e74a3b; color: #fff; }
        .status-delivering { background-color: #4e73df; color: #fff; }
        .status-completed { background-color: #36b9cc; color: #fff; }
        .action-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">إدارة الطلبات</h1>
            <p class="mb-0 text-muted">عرض وإدارة جميع طلبات الأدوية</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Filters -->
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-funnel"></i> فلترة حسب الحالة
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}">جميع الحالات</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}">قيد الانتظار</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'accepted']) }}">مقبولة</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}">مرفوضة</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'delivering']) }}">قيد التوصيل</a></li>
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}">مكتملة</a></li>
                </ul>
            </div>

            <!-- Export Button -->
            <button class="btn btn-outline-primary">
                <i class="bi bi-download"></i> تصدير
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                إجمالي الطلبات
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-cart fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                قيد الانتظار
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $pendingOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                مقبولة
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $acceptedOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                قيد التوصيل
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $deliveringOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-truck fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-secondary text-uppercase mb-1">
                                مكتملة
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $completedOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check2-all fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-danger text-uppercase mb-1">
                                مرفوضة
                            </div>
                            <div class="h5 mb-0 fw-bold text-gray-800">{{ $rejectedOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-x-circle fs-1 text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>رقم الطلب</th>
                        <th>المستخدم</th>
                        <th>الصيدلية</th>
                        <th>الأدوية</th>
                        <th>المبلغ الإجمالي</th>
                        <th>الحالة</th>
                        <th>تاريخ الطلب</th>
                        <th>الإجراءات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>#{{ $order->id }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <div class="fw-bold">{{ $order->user->name ?? 'مستخدم غير معروف' }}</div>
                                        <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $order->pharmacy->name ?? 'صيدلية غير معروفة' }}</div>
                                <small class="text-muted">{{ $order->pharmacy->address ?? '' }}</small>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="popover"
                                        data-bs-html="true"
                                        data-bs-content="
                                                <div class='p-2'>
                                                    <h6 class='mb-2'>الأدوية المطلوبة:</h6>
                                                    <ul class='list-unstyled mb-0'>
                                                        @foreach($order->items as $item)
                                                        <li class='mb-1'>
                                                            <strong>{{ $item->medicine->name ?? 'دواء غير معروف' }}</strong><br>
                                                            <small>الكمية: {{ $item->quantity }} | السعر: {{ number_format($item->price, 2) }} د.ك</small>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            ">
                                    <i class="bi bi-eye"></i> عرض ({{ $order->items->count() }})
                                </button>
                            </td>
                            <td>
                                <strong>{{ number_format($order->total_amount, 2) }} د.ك</strong>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'status-pending',
                                        'accepted' => 'status-accepted',
                                        'rejected' => 'status-rejected',
                                        'delivering' => 'status-delivering',
                                        'completed' => 'status-completed'
                                    ];
                                    $statusTexts = [
                                        'pending' => 'قيد الانتظار',
                                        'accepted' => 'مقبولة',
                                        'rejected' => 'مرفوضة',
                                        'delivering' => 'قيد التوصيل',
                                        'completed' => 'مكتملة'
                                    ];
                                @endphp
                                <span class="status-badge {{ $statusColors[$order->status] }}">
                                        {{ $statusTexts[$order->status] }}
                                    </span>
                            </td>
                            <td>
                                <div>{{ $order->created_at->format('Y-m-d') }}</div>
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- View Button -->
                                    <button type="button" class="btn btn-sm btn-outline-primary action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#orderModal{{ $order->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Status Actions -->
                                    @if($order->status == 'pending')
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                            <button type="submit" class="btn btn-sm btn-success action-btn"
                                                    onclick="return confirm('هل تريد قبول هذا الطلب؟')">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger action-btn"
                                                    onclick="return confirm('هل تريد رفض هذا الطلب؟')">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    @elseif($order->status == 'accepted')
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="delivering">
                                            <button type="submit" class="btn btn-sm btn-info action-btn"
                                                    onclick="return confirm('بدء عملية التوصيل؟')">
                                                <i class="bi bi-truck"></i>
                                            </button>
                                        </form>
                                    @elseif($order->status == 'delivering')
                                        <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-success action-btn"
                                                    onclick="return confirm('تأكيد اكتمال الطلب؟')">
                                                <i class="bi bi-check2-all"></i>
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger action-btn"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Order Details Modal -->
                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تفاصيل الطلب #{{ $order->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <h6>معلومات المستخدم:</h6>
                                                <p class="mb-1"><strong>الاسم:</strong> {{ $order->user->name ?? 'غير معروف' }}</p>
                                                <p class="mb-1"><strong>البريد الإلكتروني:</strong> {{ $order->user->email ?? 'غير معروف' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>معلومات الصيدلية:</h6>
                                                <p class="mb-1"><strong>اسم الصيدلية:</strong> {{ $order->pharmacy->name ?? 'غير معروفة' }}</p>
                                                <p class="mb-1"><strong>العنوان:</strong> {{ $order->pharmacy->address ?? 'غير معروف' }}</p>
                                            </div>
                                        </div>

                                        <h6>الأدوية المطلوبة:</h6>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                <tr>
                                                    <th>اسم الدواء</th>
                                                    <th>الكمية</th>
                                                    <th>السعر</th>
                                                    <th>الإجمالي</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->items as $item)
                                                    <tr>
                                                        <td>{{ $item->medicine->name ?? 'غير معروف' }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ number_format($item->price, 2) }} د.ك</td>
                                                        <td>{{ number_format($item->quantity * $item->price, 2) }} د.ك</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-end">المبلغ الإجمالي:</th>
                                                    <th>{{ number_format($order->total_amount, 2) }} د.ك</th>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        @if($order->notes)
                                            <div class="mt-3">
                                                <h6>ملاحظات:</h6>
                                                <div class="alert alert-light">
                                                    {{ $order->notes }}
                                                </div>
                                            </div>
                                        @endif

                                        @if($order->prescription_file)
                                            <div class="mt-3">
                                                <h6>الوصفة الطبية:</h6>
                                                <a href="{{ asset('storage/' . $order->prescription_file) }}"
                                                   target="_blank"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="bi bi-file-earmark-medical"></i> عرض الوصفة
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        عرض {{ $orders->firstItem() }} إلى {{ $orders->lastItem() }} من أصل {{ $orders->total() }} طلب
                    </div>
                    <nav>
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize popovers
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'hover',
                placement: 'left'
            })
        })
    });
</script>
</body>
</html>
