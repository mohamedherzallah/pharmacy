<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصيدليات المعلقة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Tahoma', sans-serif; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">الصيدليات المعلقة للموافقة</h1>
        <a href="{{ route('pharmacies.index') }}" class="btn btn-secondary">
            العودة إلى جميع الصيدليات
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-bordered text-center">
                <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>اسم الصيدلية</th>
                    <th>المالك (المستخدم)</th>
                    <th>العنوان</th>
                    <th>تاريخ التقديم</th>
                    <th>الإجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pendingPharmacies as $index => $pharmacy)
                    <tr>
                        <td>{{ $index + $pendingPharmacies->firstItem() }}</td>
                        <td>{{ $pharmacy->pharmacy_name }}</td>
                        <td>{{ $pharmacy->user->name ?? 'N/A' }}</td>
                        <td>{{ $pharmacy->address }}</td>
                        <td>{{ $pharmacy->created_at->format('Y-m-d') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                {{-- زر عرض التفاصيل --}}
                                <a href="{{ route('pharmacies.show', $pharmacy->id) }}"
                                   class="btn btn-sm btn-info text-white">
                                    عرض
                                </a>

                                {{-- نموذج الموافقة --}}
                                <form action="{{ route('pharmacies.approve', $pharmacy->id) }}"
                                      method="POST"
                                      style="display: inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="btn btn-sm btn-success"
                                            onclick="return confirm('هل أنت متأكد من الموافقة على هذه الصيدلية؟')">
                                        موافقة
                                    </button>
                                </form>

                                {{-- نموذج الرفض والحذف --}}
                                <form action="{{ route('pharmacies.reject', $pharmacy->id) }}"
                                      method="POST"
                                      style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('هل أنت متأكد من رفض وحذف هذه الصيدلية؟ لا يمكن التراجع عن هذا الإجراء.')">
                                        رفض
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger py-4">
                            لا توجد صيدليات معلقة للموافقة حالياً.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {{-- ترقيم الصفحات --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $pendingPharmacies->links() }}
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
